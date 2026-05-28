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
            if (!Schema::hasColumn('orders', 'order_code')) {
                $table->string('order_code', 50)->after('id');
            }
            if (!Schema::hasColumn('orders', 'gross_amount')) {
                $table->integer('gross_amount')->default(0)->after('total_price');
            }
            if (!Schema::hasColumn('orders', 'voucher_code')) {
                $table->string('voucher_code', 50)->nullable()->after('guest_phone');
            }
            if (!Schema::hasColumn('orders', 'voucher_amount')) {
                $table->integer('voucher_amount')->default(0)->after('voucher_code');
            }
            if (!Schema::hasColumn('orders', 'payment_type')) {
                $table->string('payment_type', 50)->nullable()->after('payment_status');
            }
            if (!Schema::hasColumn('orders', 'transaction_id')) {
                $table->string('transaction_id', 100)->nullable()->after('payment_type');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $columns = [];
            if (Schema::hasColumn('orders', 'order_code')) $columns[] = 'order_code';
            if (Schema::hasColumn('orders', 'gross_amount')) $columns[] = 'gross_amount';
            if (Schema::hasColumn('orders', 'voucher_code')) $columns[] = 'voucher_code';
            if (Schema::hasColumn('orders', 'voucher_amount')) $columns[] = 'voucher_amount';
            if (Schema::hasColumn('orders', 'payment_type')) $columns[] = 'payment_type';
            if (Schema::hasColumn('orders', 'transaction_id')) $columns[] = 'transaction_id';

            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};
