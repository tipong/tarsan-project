<?php

namespace App\Http\Controllers\Tamu;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * HALAMAN PAYMENT
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

            if (empty($cart) || empty($guest) || empty($booking)) {
                return response()->json([
                    'error' => 'Session data incomplete'
                ], 422);
            }

            $subtotal   = collect($cart)->sum('subtotal');
            $finalTotal = max($subtotal - $discount, 0);

            /**
             * 🔹 MIDTRANS CONFIG
             */
            Config::$serverKey    = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized  = true;
            Config::$is3ds        = true;

            /**
             * 🔹 SIMPAN ORDER
             */
            $order = Order::create([
                'order_code'     => 'ORD-' . strtoupper(Str::random(10)),
                'user_id'        => Auth::id(),
                'check_in'       => $booking['check_in'],
                'check_out'      => $booking['check_out'],
                'nights'         => collect($cart)->sum('nights'),
                'total_price'    => $finalTotal,
                'gross_amount'   => $finalTotal,
                'guest_name'     => $guest['name'],
                'guest_phone'    => $guest['phone'],
                'payment_status' => 'pending',
                'status'         => 'pending',
            ]);

            /**
             * 🔹 SNAP PARAMS
             */
            $params = [
                'transaction_details' => [
                    'order_id'     => $order->order_code,
                    'gross_amount' => $finalTotal,
                ],
                'customer_details' => [
                    'first_name' => $guest['name'],
                    'phone'      => $guest['phone'],
                ],
            ];

            $snapToken = Snap::getSnapToken($params);

            return response()->json([
                'snap_token' => $snapToken,
                'order_id' => $order->id
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
}
