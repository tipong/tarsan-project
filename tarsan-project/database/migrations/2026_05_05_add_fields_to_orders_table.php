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
        Schema::table('orders', function (Blueprint $table) {
            // Menambah kolom untuk cancelled_at dan cancelled_reason
            $table->datetime('cancelled_at')->nullable()->after('checked_out_at');
            $table->text('cancelled_reason')->nullable()->after('cancelled_at');

            // Menambah kolom payment_method untuk mencatat metode pembayaran
            $table->enum('payment_method', ['cash', 'bank_transfer', 'card'])->default('bank_transfer')->after('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['cancelled_at', 'cancelled_reason', 'payment_method']);
        });
    }
};
