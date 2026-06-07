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
        // Security: pemilik order, admin, resepsionis, atau owner
        $isStaff = in_array(Auth::user()->role, ['admin', 'resepsionis', 'owner']);
        $isOwnerOfOrder = $order->user_id && $order->user_id === Auth::id();

        if (!$isStaff && !$isOwnerOfOrder) {
            abort(403);
        }

        $order->load(['user', 'items.room']);

        return view('tamu.invoice.show', compact('order'));
    }

    public function print(Order $order)
    {
        // Security: pemilik order, admin, resepsionis, atau owner
        $isStaff = in_array(Auth::user()->role, ['admin', 'resepsionis', 'owner']);
        $isOwnerOfOrder = $order->user_id && $order->user_id === Auth::id();

        if (!$isStaff && !$isOwnerOfOrder) {
            abort(403);
        }

        $order->load(['user', 'items.room']);

        return view('tamu.invoice.print', compact('order'));
    }

    public function download(Order $order)
    {
        // Security: pemilik order, admin, resepsionis, atau owner
        $isStaff = in_array(Auth::user()->role, ['admin', 'resepsionis', 'owner']);
        $isOwnerOfOrder = $order->user_id && $order->user_id === Auth::id();

        if (!$isStaff && !$isOwnerOfOrder) {
            abort(403);
        }

        $order->load(['user', 'items.room']);

        $pdf = Pdf::loadView('tamu.invoice.pdf', compact('order'));

        return $pdf->download('invoice-' . ($order->invoice_number ?? $order->order_code) . '.pdf');
    }
}
