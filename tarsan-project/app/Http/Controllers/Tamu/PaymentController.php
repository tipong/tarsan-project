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
    public function index(Order $order = null)
    {
        try {
            // If an order is explicitly passed in the URL, use it
            if ($order && $order->exists) {
                $this->ensureOrderBelongsToUser($order);
                
                if ($order->payment_status === 'paid') {
                    return redirect()->route('tamu.orders')->with('success', 'Order is already paid.');
                }
                
                session()->put('payment.order_id', $order->id);
            }

            $orderId = session('payment.order_id');
            $order = null;

            if ($orderId) {
                $order = Order::with('items.room')->find($orderId);
            }

            // If order exists and is still pending, use its data
            if ($order && $order->status === 'pending' && $order->payment_status !== 'paid') {
                $cart = $order->items->map(function ($item) {
                    return [
                        'room_id' => $item->room_id,
                        'room_name' => $item->room->room_name,
                        'price' => $item->price_per_night,
                        'nights' => $item->nights,
                        'subtotal' => $item->subtotal,
                        'check_in' => $item->order->check_in,
                        'check_out' => $item->order->check_out,
                    ];
                });
                
                $guest = [
                    'name' => $order->guest_name,
                    'phone' => $order->guest_phone,
                ];
                
                $subtotal = $order->total_price;
                $discount = 0;
                $finalTotal = $order->total_price;
            } else {
                $cart     = session('cart', []);
                $guest    = session('guest');
                $booking  = session('booking_filter');
                $discount = session('voucher.discount', 0);

                if (empty($cart) || empty($guest)) {
                    return redirect()
                        ->route('tamu.booking.index')
                        ->with('error', 'Booking data not complete');
                }

                $subtotal   = collect($cart)->sum('subtotal');
                $finalTotal = max($subtotal - $discount, 0);

                $firstCartItem = collect($cart)->first();
                $checkIn = $booking['check_in'] ?? $firstCartItem['check_in'] ?? null;
                $checkOut = $booking['check_out'] ?? $firstCartItem['check_out'] ?? null;

                if (!$checkIn || !$checkOut) {
                    return redirect()
                        ->route('tamu.booking.index')
                        ->with('error', 'Check-in and check-out dates are missing.');
                }

                $order = DB::transaction(function () use ($cart, $checkIn, $checkOut, $finalTotal, $guest) {
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
                            'price_per_night' => $item['price'] ?? null,
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

                session()->put('payment.order_id', $order->id);
                
                // Clear cart session now that order is created
                session()->forget(['cart', 'booking_filter', 'voucher']);
            }

            return view('tamu.payment.index', compact(
                'cart',
                'guest',
                'subtotal',
                'discount',
                'finalTotal',
                'order'
            ));
        } catch (\Throwable $e) {
            Log::error('PAYMENT INDEX ERROR: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->route('tamu.booking.index')->with('error', 'Something went wrong.');
        }
    }

    /**
     * CREATE SNAP TOKEN
     */
    public function pay(Request $request, MidtransPaymentService $midtransPayment)
    {
        try {
            $orderId = session('payment.order_id');
            $order = null;

            if ($orderId) {
                $order = Order::find($orderId);
            }

            if (!$order) {
                // Fallback to original logic if order_id is missing (should not happen in new flow)
                $cart     = session('cart', []);
                $guest    = session('guest');
                $booking  = session('booking_filter');
                $discount = session('voucher.discount', 0);
                $firstCartItem = collect($cart)->first();
                $checkIn = $booking['check_in'] ?? $firstCartItem['check_in'] ?? null;
                $checkOut = $booking['check_out'] ?? $firstCartItem['check_out'] ?? null;

                if (empty($cart) || empty($guest) || ! $checkIn || ! $checkOut) {
                    return response()->json(['error' => 'Session data incomplete'], 422);
                }

                $subtotal   = collect($cart)->sum('subtotal');
                $finalTotal = max($subtotal - $discount, 0);

                $order = $this->findExistingPendingOrder($finalTotal, $checkIn, $checkOut);
            }

            if (!$order) {
                return response()->json(['error' => 'No active booking found.'], 404);
            }

            $this->ensureOrderBelongsToUser($order);

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

    protected function findExistingPendingOrder($finalTotal, $checkIn, $checkOut): ?Order
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

    public function cancel(Order $order)
    {
        $this->ensureOrderBelongsToUser($order);

        if ($order->payment_status === 'paid') {
            return redirect()->route('tamu.orders')->with('error', 'Paid orders cannot be cancelled.');
        }

        DB::transaction(function () use ($order) {
            $order->update(['status' => 'cancelled']);
        });

        session()->forget(['cart', 'guest', 'booking_filter', 'voucher', 'payment']);

        return redirect()->route('tamu.booking.index')->with('success', 'Booking has been cancelled.');
    }
}
