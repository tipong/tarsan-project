<?php

namespace App\Http\Controllers\Tamu;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Order;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart');

        if (!$cart || count($cart) === 0) {
            return redirect()->route('tamu.booking.index');
        }

        $total = collect($cart)->sum('subtotal');

        return view('tamu.checkout.index', compact('cart', 'total'));
    }

    public function confirm()
    {
        $cart = session('cart');

        if (!$cart) {
            return redirect()->route('tamu.booking.index');
        }

        $order = Order::create([
            'user_id' => auth()->id(),
            'check_in' => collect($cart)->first()['check_in'],
            'check_out'=> collect($cart)->first()['check_out'],
            'nights' => collect($cart)->first()['nights'],
            'total_price' => collect($cart)->sum('subtotal'),
            'payment_status' => 'pending',
            'booking_status' => 'upcoming',
            'is_walkin' => false,
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'room_id' => $item['room_id'],
                'qty' => 1,
                'price_per_night' => $item['price'],
                'nights' => $item['nights'],
                'subtotal' => $item['subtotal'],
            ]);
        }

        session()->forget('cart');

        return redirect()
            ->route('tamu.orders')
            ->with('success', 'Booking confirmed!');
    }
}