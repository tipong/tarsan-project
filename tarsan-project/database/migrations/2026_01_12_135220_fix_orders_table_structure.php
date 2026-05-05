<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            // ❌ HAPUS room_id
            if (Schema::hasColumn('orders', 'room_id')) {
                $table->dropForeign(['room_id']);
                $table->dropColumn('room_id');
            }

            // ✏️ RENAME DATE
            $table->renameColumn('check_in_date', 'check_in');
            $table->renameColumn('check_out_date', 'check_out');

            // ➕ TAMBAHAN
            $table->integer('nights')->after('check_out');

            $table->enum('payment_status', [
                'pending',
                'paid',
                'failed',
                'expired',
                'refunded'
            ])->default('pending')->after('total_price');

            $table->enum('booking_status', [
                'upcoming',
                'checked_in',
                'checked_out',
                'cancelled'
            ])->default('upcoming')->after('payment_status');

            // user_id boleh null (walk-in)
            $table->foreignId('user_id')->nullable()->change();

            // walk-in default
            $table->boolean('is_walkin')->default(false)->change();
        });
    }

    public function down(): void
    {
        //
    }
};