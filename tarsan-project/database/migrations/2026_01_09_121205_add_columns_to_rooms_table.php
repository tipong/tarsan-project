<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            if (!Schema::hasColumn('rooms', 'capacity')) {
                $table->unsignedInteger('capacity');
            }

            if (!Schema::hasColumn('rooms', 'total_rooms')) {
                $table->unsignedInteger('total_rooms');
            }

            if (!Schema::hasColumn('rooms', 'available_rooms')) {
                $table->unsignedInteger('available_rooms');
            }

            if (!Schema::hasColumn('rooms', 'description')) {
                $table->text('description')->nullable();
            }

            if (!Schema::hasColumn('rooms', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
        });
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn([
                'capacity',
                'total_rooms',
                'available_rooms',
                'description',
                'is_active',
            ]);
        });
    }


};
