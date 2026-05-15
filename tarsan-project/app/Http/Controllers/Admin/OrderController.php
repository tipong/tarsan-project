<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Room;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items.room']);

        /* =====================
        | SEARCH
        ===================== */
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->whereHas('user', function ($u) use ($request) {
                    $u->where('name', 'like', '%' . $request->search . '%');
                })->orWhereHas('items.room', function ($r) use ($request) {
                    $r->where('room_name', 'like', '%' . $request->search . '%');
                })->orWhere('guest_name', 'like', '%' . $request->search . '%');
            });
        }

        /* =====================
        | STATUS FILTER
        ===================== */
        if ($request->status === 'upcoming') {
            $query->whereNull('checked_in_at')
                ->where('check_in', '>', now())
                ->where('status', '!=', 'cancelled');
        }

        if ($request->status === 'ongoing') {
            $query->whereNotNull('checked_in_at')
                ->whereNull('checked_out_at');
        }

        if ($request->status === 'completed') {
            $query->whereNotNull('checked_out_at');
        }

        if ($request->status === 'cancelled') {
            $query->where('status', 'cancelled');
        }

        if ($request->status === 'paid') {
            $query->where('payment_status', 'paid');
        }

        if ($request->status === 'unpaid') {
            $query->where('payment_status', '!=', 'paid')
                ->where('status', '!=', 'cancelled');
        }

        /* =====================
        | DATE FILTER
        ===================== */
        if ($request->filled('date')) {
            $query->whereDate('check_in_date', $request->date);
        }

        /* =====================
        | ROOM FILTER
        ===================== */
        if ($request->filled('room_id')) {
            $query->whereHas('items', function($q) use ($request) {
                $q->where('room_id', $request->room_id);
            });
        }

        $orders = $query->latest()->paginate(10)->withQueryString();
        $rooms  = Room::orderBy('room_name')->get();

        return view('admin.orders.index', compact('orders', 'rooms'));
    }


    /* =====================
     | CHECK IN
     ===================== */
    public function checkIn(Order $order)
    {
        // ❌ Already checked in
        if ($order->checked_in_at) {
            return back()->with('error', 'This order has already been checked in');
        }

        // ❌ Too early
        if ($order->check_in->isFuture()) {
            return back()->with('error', 'Check-in time has not arrived yet. Your check-in date is ' . $order->check_in->format('d M Y'));
        }

        $order->update([
            'checked_in_at' => now(),
        ]);

        return back()->with('success', 'Guest successfully checked in');
    }

    /* =====================
     | CHECK OUT
     ===================== */
    public function checkOut(Order $order)
    {
        // ❌ Not yet checked in
        if (! $order->checked_in_at) {
            return back()->with('error', 'Guest has not checked in yet');
        }

        // ❌ Already checked out
        if ($order->checked_out_at) {
            return back()->with('error', 'This order has already been checked out');
        }

        $order->update([
            'checked_out_at' => now(),
            'status' => 'completed',
        ]);

        return back()->with('success', 'Guest successfully checked out');
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.room', 'review']);
        return view('admin.orders.show', compact('order'));
    }
}
