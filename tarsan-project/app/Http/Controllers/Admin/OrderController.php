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
        $query = Order::with(['user', 'room']);

        /* =====================
        | SEARCH
        ===================== */
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->whereHas('user', function ($u) use ($request) {
                    $u->where('name', 'like', '%' . $request->search . '%');
                })->orWhereHas('room', function ($r) use ($request) {
                    $r->where('room_name', 'like', '%' . $request->search . '%');
                });
            });
        }

        /* =====================
        | STATUS FILTER
        ===================== */
        if ($request->status === 'upcoming') {
            $query->whereNull('checked_in_at')
                ->where('check_in_date', '>', now());
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
            $query->where('room_id', $request->room_id);
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
        // ❌ Sudah check-in
        if ($order->checked_in_at) {
            return back()->with('error', 'Order ini sudah check-in');
        }

        // ❌ Terlalu cepat
        if (now()->lt($order->check_in_date)) {
            return back()->with('error', 'Belum waktunya check-in');
        }

        $order->update([
            'checked_in_at' => now(),
        ]);

        return back()->with('success', 'Tamu berhasil check-in');
    }

    /* =====================
     | CHECK OUT
     ===================== */
    public function checkOut(Order $order)
    {
        // ❌ Belum check-in
        if (! $order->checked_in_at) {
            return back()->with('error', 'Tamu belum check-in');
        }

        // ❌ Sudah check-out
        if ($order->checked_out_at) {
            return back()->with('error', 'Order ini sudah check-out');
        }

        $order->update([
            'checked_out_at' => now(),
            'status' => 'completed',
        ]);

        return back()->with('success', 'Tamu berhasil check-out');
    }
}
