<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

class MidtransPaymentService
{
    protected ?array $orderColumns = null;

    public function configure(): void
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized', true);
        Config::$is3ds = config('midtrans.is_3ds', true);
    }

    public function hasReusableSnapToken(Order $order): bool
    {
        if (! $this->supportsOrderColumn('snap_token') || blank($order->snap_token)) {
            return false;
        }

        if (
            $this->supportsOrderColumn('snap_token_expires_at') &&
            $order->snap_token_expires_at &&
            $order->snap_token_expires_at->isPast()
        ) {
            return false;
        }

        return true;
    }

    public function getReusableSnapToken(Order $order): array
    {
        return [
            'snap_token' => $order->snap_token,
            'midtrans_order_id' => $this->getMidtransOrderId($order),
        ];
    }

    public function generateSnapToken(Order $order, bool $retry = false): array
    {
        $this->configure();

        $midtransOrderId = $retry
            ? $this->generateRetryOrderId($order)
            : $this->getMidtransOrderId($order);

        $response = Snap::createTransaction($this->buildSnapPayload($order, $midtransOrderId));

        $updates = [
            'payment_method' => 'bank_transfer',
        ];

        if ($this->supportsOrderColumn('midtrans_order_id')) {
            $updates['midtrans_order_id'] = $midtransOrderId;
        }

        if ($this->supportsOrderColumn('snap_token')) {
            $updates['snap_token'] = $response->token;
        }

        if ($this->supportsOrderColumn('snap_token_expires_at')) {
            $updates['snap_token_expires_at'] = now()->addDay();
        }

        $order->forceFill($updates)->save();

        return [
            'snap_token' => $response->token,
            'midtrans_order_id' => $midtransOrderId,
        ];
    }

    public function syncOrderStatus(Order $order, ?array $payload = null): Order
    {
        $transaction = $payload ?? $this->fetchTransactionStatus($order);

        if (! $transaction) {
            return $order;
        }

        $transactionStatus = $transaction['transaction_status'] ?? null;
        $fraudStatus = $transaction['fraud_status'] ?? null;
        $paymentType = $transaction['payment_type'] ?? null;
        $wasPaid = $order->payment_status === 'paid';

        if ($wasPaid && ! in_array($transactionStatus, ['refund', 'partial_refund'], true)) {
            return $order;
        }

        $updates = $this->mapTransactionToOrderUpdates(
            $transactionStatus,
            $fraudStatus,
            $paymentType
        );

        if ($this->supportsOrderColumn('midtrans_order_id') && ! empty($transaction['order_id'])) {
            $updates['midtrans_order_id'] = $transaction['order_id'];
        }

        if ($this->supportsOrderColumn('snap_token') && ($updates['payment_status'] ?? null) === 'paid') {
            $updates['snap_token'] = null;
        }

        if (
            $this->supportsOrderColumn('snap_token_expires_at') &&
            in_array($updates['payment_status'] ?? null, ['paid', 'failed', 'expired', 'refunded'], true)
        ) {
            $updates['snap_token_expires_at'] = null;
        }

        $order->fill($updates);

        if ($order->isDirty()) {
            $order->save();
        }

        if (! $wasPaid && $order->payment_status === 'paid') {
            $this->createPaidNotification($order);
        }

        return $order->fresh();
    }

    public function findOrderByGatewayReference(string $reference): ?Order
    {
        if ($this->supportsOrderColumn('midtrans_order_id')) {
            $order = Order::where('midtrans_order_id', $reference)->first();

            if ($order) {
                return $order;
            }
        }

        return Order::where('order_code', $reference)->first();
    }

    protected function fetchTransactionStatus(Order $order): ?array
    {
        $reference = $this->getMidtransOrderId($order);

        if (blank($reference)) {
            return null;
        }

        try {
            $this->configure();

            return (array) Transaction::status($reference);
        } catch (\Throwable $e) {
            Log::warning('MIDTRANS STATUS SYNC FAILED', [
                'order_id' => $order->id,
                'reference' => $reference,
                'message' => $e->getMessage(),
            ]);

            return null;
        }
    }

    protected function buildSnapPayload(Order $order, string $midtransOrderId): array
    {
        return [
            'transaction_details' => [
                'order_id' => $midtransOrderId,
                'gross_amount' => (int) round($order->gross_amount ?: $order->total_price),
            ],
            'customer_details' => [
                'first_name' => $order->guest_name ?: optional($order->user)->name ?: 'Guest',
                'phone' => $order->guest_phone,
                'email' => optional($order->user)->email,
            ],
        ];
    }

    protected function mapTransactionToOrderUpdates(
        ?string $transactionStatus,
        ?string $fraudStatus,
        ?string $paymentType
    ): array {
        $updates = [
            'payment_method' => $this->normalizePaymentMethod($paymentType),
        ];

        return match ($transactionStatus) {
            'capture' => $fraudStatus === 'challenge'
                ? $updates + ['payment_status' => 'pending', 'status' => 'pending']
                : $updates + ['payment_status' => 'paid', 'status' => 'confirmed'],
            'settlement' => $updates + ['payment_status' => 'paid', 'status' => 'confirmed'],
            'pending' => $updates + ['payment_status' => 'pending', 'status' => 'pending'],
            'expire' => $updates + ['payment_status' => 'expired', 'status' => 'pending'],
            'deny', 'cancel', 'failure' => $updates + ['payment_status' => 'failed', 'status' => 'pending'],
            'refund', 'partial_refund' => $updates + ['payment_status' => 'refunded', 'status' => 'cancelled'],
            default => $updates,
        };
    }

    protected function createPaidNotification(Order $order): void
    {
        if (! $order->user_id || ! Schema::hasTable('notifications')) {
            return;
        }

        Notification::firstOrCreate(
            [
                'user_id' => $order->user_id,
                'order_id' => $order->id,
                'type' => 'payment',
            ],
            [
                'title' => 'Pembayaran Berhasil',
                'message' => 'Pembayaran untuk pesanan ' . $order->order_code . ' telah berhasil. Total: Rp ' . number_format($order->total_price, 0, ',', '.'),
            ]
        );
    }

    protected function normalizePaymentMethod(?string $paymentType): string
    {
        return match ($paymentType) {
            'credit_card' => 'card',
            'bank_transfer', 'echannel', 'permata', 'gopay', 'qris', 'shopeepay', 'cstore' => 'bank_transfer',
            default => 'bank_transfer',
        };
    }

    protected function getMidtransOrderId(Order $order): string
    {
        if ($this->supportsOrderColumn('midtrans_order_id') && filled($order->midtrans_order_id)) {
            return $order->midtrans_order_id;
        }

        return $order->order_code;
    }

    protected function generateRetryOrderId(Order $order): string
    {
        return $order->order_code . '-R' . now()->format('YmdHis') . strtoupper(Str::random(4));
    }

    protected function supportsOrderColumn(string $column): bool
    {
        if ($this->orderColumns === null) {
            $this->orderColumns = Schema::getColumnListing('orders');
        }

        return in_array($column, $this->orderColumns, true);
    }
}
