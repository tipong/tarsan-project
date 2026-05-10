<?php

namespace App\Http\Controllers\Tamu;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function show(Order $order)
    {
        // Security: hanya pemilik order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['user', 'items.room']);

        return view('tamu.invoice.show', compact('order'));
    }

    public function download(Order $order)
    {
        // Security: hanya pemilik order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['user', 'items.room']);

        $pdf = Pdf::loadView('tamu.invoice.pdf', compact('order'));

        return $pdf->download('invoice-' . ($order->invoice_number ?? $order->order_code) . '.pdf');
    }
}
