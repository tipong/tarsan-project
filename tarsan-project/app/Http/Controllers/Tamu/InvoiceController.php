<?php

namespace App\Http\Controllers\Tamu;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function show(Order $order)
    {
        // Security: hanya pemilik order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('tamu.invoice.show', compact('order'));
    }
}
