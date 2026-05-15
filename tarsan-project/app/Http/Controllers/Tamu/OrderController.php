<?php

namespace App\Http\Controllers\Tamu;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Notification;
use App\Services\MidtransPaymentService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(MidtransPaymentService $midtransPayment)
    {
        $orders = Order::with(['review', 'items.room'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $orders->setCollection(
            $orders->getCollection()->map(function (Order $order) use ($midtransPayment) {
                if ($order->status === 'pending' && $order->payment_status !== 'paid') {
                    return $midtransPayment->syncOrderStatus($order);
                }

                return $order;
            })
        );

        return view('tamu.orders', compact('orders'));
    }

    public function show(Order $order, MidtransPaymentService $midtransPayment)
    {
        // Check authorization
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->status === 'pending' && $order->payment_status !== 'paid') {
            $order = $midtransPayment->syncOrderStatus($order);
        }

        $order->load(['user', 'room', 'items.room']);

        return view('tamu.orders.show', compact('order'));
    }

    public function cancel(Order $order, Request $request)
    {
        // Check authorization
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Validate cancellation reason
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        // Check if order can be cancelled
        if (!in_array($order->status, ['pending', 'confirmed'])) {
            return redirect()->route('tamu.orders')->with('error', 'Order cannot be cancelled in this status.');
        }

        // Cancel order
        $order->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancelled_reason' => $request->reason,
            'payment_status' => 'refunded'
        ]);

        // Create notification
        Notification::create([
            'user_id' => $order->user_id,
            'type' => 'cancellation',
            'title' => 'Order Cancelled',
            'message' => 'Order ' . $order->order_code . ' has been cancelled. Reason: ' . $request->reason,
            'order_id' => $order->id
        ]);

        return redirect()->route('tamu.orders')->with('success', 'Order successfully cancelled.');
    }
}
