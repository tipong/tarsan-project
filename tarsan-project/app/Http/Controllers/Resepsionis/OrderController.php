<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'room'])
            ->latest()
            ->paginate(10);

        return view('resepsionis.orders.index', compact('orders'));
    }

    public function checkIn(Order $order)
    {
        if ($order->checked_in_at) {
            return back()->with('error', 'Order sudah check-in');
        }

        $order->update([
            'checked_in_at' => now(),
        ]);

        return back()->with('success', 'Tamu berhasil check-in');
    }

    public function checkOut(Order $order)
    {
        if ($order->checked_out_at) {
            return back()->with('error', 'Order sudah check-out');
        }

        $order->update([
            'checked_out_at' => now(),
            'status' => 'completed',
        ]);

        return back()->with('success', 'Tamu berhasil check-out');
    }

    public function create()
    {
        return view('resepsionis.orders.walkin', [
            'rooms' => Room::where('available_rooms', '>', 0)->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'guest_name' => 'required|string|max:100',
            'guest_phone' => 'required|string|max:20',
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
        ]);

        $room = Room::findOrFail($request->room_id);

        // Hitung malam
        $nights = Carbon::parse($request->check_in_date)
            ->diffInDays(Carbon::parse($request->check_out_date));

        $total = $room->price_per_night * max($nights, 1);

        Order::create([
            'room_id' => $request->room_id,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'total_price' => $total,
            'status' => 'confirmed',
            'is_walkin' => true,
            'guest_name' => $request->guest_name,
            'guest_phone' => $request->guest_phone,
            'checked_in_at' => now(), // WALK-IN LANGSUNG CHECK-IN
        ]);

        $room->decrement('available_rooms');

        return redirect()
            ->route('resepsionis.orders.index')
            ->with('success', 'Walk-in booking berhasil dibuat');
    }

}