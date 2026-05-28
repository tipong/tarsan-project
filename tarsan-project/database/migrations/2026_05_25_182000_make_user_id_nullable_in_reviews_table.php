<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Drop existing foreign key constraint
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        // 2. Modify column user_id and add guest_name
        Schema::table('reviews', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->change();
            $table->string('guest_name')->nullable()->after('user_id');

            // 3. Add new foreign key constraint with onDelete('set null')
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });

        // 4. Populate guest_name for existing reviews
        try {
            $reviews = DB::table('reviews')
                ->join('users', 'reviews.user_id', '=', 'users.id')
                ->select('reviews.id', 'users.name')
                ->get();

            foreach ($reviews as $review) {
                DB::table('reviews')
                    ->where('id', $review->id)
                    ->update(['guest_name' => $review->name]);
            }
        } catch (\Throwable $e) {
            // Log or ignore if table is empty or joint failed
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn('guest_name');
            $table->unsignedBigInteger('user_id')->nullable(false)->change();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }
};
