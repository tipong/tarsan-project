<?php

namespace App\Http\Controllers\Tamu;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Notification;
use App\Services\MidtransPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PaymentController extends Controller
{
    /**
     * PAYMENT PAGE
     */
    public function index()
    {
        $cart     = session('cart', []);
        $guest    = session('guest'); // ⬅️ ARRAY: name & phone
        $booking  = session('booking_filter');
        $discount = session('voucher.discount', 0);

        if (empty($cart) || empty($guest) || empty($booking)) {
            return redirect()
                ->route('tamu.booking.index')
                ->with('error', 'Booking data not complete');
        }

        $subtotal   = collect($cart)->sum('subtotal');
        $finalTotal = max($subtotal - $discount, 0);

        return view('tamu.payment.index', compact(
            'cart',
            'guest',
            'subtotal',
            'discount',
            'finalTotal'
        ));
    }

    /**
     * CREATE SNAP TOKEN
     */
    public function pay(Request $request)
    {
        try {
            $cart     = session('cart', []);
            $guest    = session('guest');
            $booking  = session('booking_filter');
            $discount = session('voucher.discount', 0);
            $firstCartItem = collect($cart)->first();
            $checkIn = $booking['check_in'] ?? $firstCartItem['check_in'] ?? null;
            $checkOut = $booking['check_out'] ?? $firstCartItem['check_out'] ?? null;

            if (empty($cart) || empty($guest) || ! $checkIn || ! $checkOut) {
                return response()->json([
                    'error' => 'Session data incomplete'
                ], 422);
            }

            $subtotal   = collect($cart)->sum('subtotal');
            $finalTotal = max($subtotal - $discount, 0);

            $midtransPayment = app(MidtransPaymentService::class);
            $order = $this->findExistingPendingOrder($finalTotal, $checkIn, $checkOut);

            if ($order) {
                $order = $midtransPayment->syncOrderStatus($order);

                if ($order->payment_status === 'paid') {
                    $this->clearCheckoutSession($order);

                    return response()->json([
                        'error' => 'This order has already been paid.'
                    ], 422);
                }

                $payment = $midtransPayment->hasReusableSnapToken($order)
                    ? $midtransPayment->getReusableSnapToken($order)
                    : $midtransPayment->generateSnapToken($order, true);
            } else {
                $order = DB::transaction(function () use (
                    $cart,
                    $checkIn,
                    $checkOut,
                    $finalTotal,
                    $guest
                ) {
                    $order = Order::create([
                        'order_code'     => 'ORD-' . strtoupper(Str::random(10)),
                        'user_id'        => Auth::id(),
                        'check_in'       => $checkIn,
                        'check_out'      => $checkOut,
                        'nights'         => collect($cart)->sum('nights'),
                        'total_price'    => $finalTotal,
                        'gross_amount'   => $finalTotal,
                        'guest_name'     => $guest['name'],
                        'guest_phone'    => $guest['phone'],
                        'payment_status' => 'pending',
                        'payment_method' => 'bank_transfer',
                        'status'         => 'pending',
                    ]);

                    foreach ($cart as $item) {
                        OrderItem::createBookingItem([
                            'order_id' => $order->id,
                            'room_id' => $item['room_id'],
                            'price_per_night' => $item['price_per_night'] ?? $item['price'] ?? null,
                            'nights' => $item['nights'],
                            'subtotal' => $item['subtotal'],
                        ]);
                    }

                    if (Schema::hasTable('notifications')) {
                        Notification::create([
                            'user_id' => Auth::id(),
                            'type' => 'booking',
                            'title' => 'Order Created',
                            'message' => 'Your order with code ' . $order->order_code . ' has been created. Please complete the payment.',
                            'order_id' => $order->id
                        ]);
                    }

                    return $order;
                });

                $payment = $midtransPayment->generateSnapToken($order);
            }

            session()->put('payment.order_id', $order->id);

            return response()->json([
                'snap_token' => $payment['snap_token'],
                'order_id' => $order->id,
                'payment_status' => $order->payment_status,
            ]);

        } catch (\Throwable $e) {
            Log::error('PAYMENT ERROR', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function continuePayment(Order $order, MidtransPaymentService $midtransPayment)
    {
        $this->ensureOrderBelongsToUser($order);

        try {
            $order = $midtransPayment->syncOrderStatus($order);

            if ($order->payment_status === 'paid') {
                $this->clearCheckoutSession($order);

                return response()->json([
                    'message' => 'This order has already been paid.',
                    'payment_status' => 'paid',
                    'status' => $order->status,
                ]);
            }

            if ($order->status !== 'pending') {
                return response()->json([
                    'error' => 'This order cannot be continued for payment.'
                ], 422);
            }

            $payment = $midtransPayment->hasReusableSnapToken($order)
                ? $midtransPayment->getReusableSnapToken($order)
                : $midtransPayment->generateSnapToken($order, true);

            session()->put('payment.order_id', $order->id);

            return response()->json([
                'snap_token' => $payment['snap_token'],
                'order_id' => $order->id,
                'payment_status' => $order->payment_status,
            ]);
        } catch (\Throwable $e) {
            Log::error('CONTINUE PAYMENT ERROR', [
                'order_id' => $order->id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'error' => 'Failed to prepare payment again.'
            ], 500);
        }
    }

    public function sync(Order $order, Request $request, MidtransPaymentService $midtransPayment)
    {
        $this->ensureOrderBelongsToUser($order);

        try {
            $payload = $request->all();
            $order = $midtransPayment->syncOrderStatus($order, empty($payload) ? null : $payload);

            $this->clearCheckoutSession($order);

            return response()->json([
                'success' => true,
                'order_id' => $order->id,
                'status' => $order->status,
                'payment_status' => $order->payment_status,
            ]);
        } catch (\Throwable $e) {
            Log::error('SYNC PAYMENT ERROR', [
                'order_id' => $order->id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'error' => 'Failed to synchronize payment status.'
            ], 500);
        }
    }

    protected function findExistingPendingOrder(int $finalTotal, string $checkIn, string $checkOut): ?Order
    {
        $orderId = session('payment.order_id');

        if (! $orderId) {
            return null;
        }

        return Order::whereKey($orderId)
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->where('payment_status', '!=', 'paid')
            ->where('total_price', $finalTotal)
            ->whereDate('check_in', $checkIn)
            ->whereDate('check_out', $checkOut)
            ->first();
    }

    protected function ensureOrderBelongsToUser(Order $order): void
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
    }

    protected function clearCheckoutSession(Order $order): void
    {
        if ($order->payment_status === 'paid') {
            session()->forget([
                'cart',
                'guest',
                'booking_filter',
                'voucher',
                'payment',
            ]);

            return;
        }

        session()->put('payment.order_id', $order->id);
    }
}
