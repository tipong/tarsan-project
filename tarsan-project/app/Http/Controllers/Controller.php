<?php

namespace App\Http\Controllers;

use App\Models\Order;

abstract class Controller
{
    public function orders()
    {
        $orders = Order::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('tamu.orders.index', compact('orders'));
    }

}
