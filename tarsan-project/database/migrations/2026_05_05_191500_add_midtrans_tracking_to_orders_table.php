<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('orders', 'midtrans_order_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('midtrans_order_id')->nullable()->after('order_code');
            });
        }

        if (! Schema::hasColumn('orders', 'snap_token')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('snap_token')->nullable()->after('payment_method');
            });
        }

        if (! Schema::hasColumn('orders', 'snap_token_expires_at')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->timestamp('snap_token_expires_at')->nullable()->after('snap_token');
            });
        }
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $columns = array_filter([
                Schema::hasColumn('orders', 'midtrans_order_id') ? 'midtrans_order_id' : null,
                Schema::hasColumn('orders', 'snap_token') ? 'snap_token' : null,
                Schema::hasColumn('orders', 'snap_token_expires_at') ? 'snap_token_expires_at' : null,
            ]);

            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};
