<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Room;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items.room'])
            ->latest()
            ->paginate(15);
        $rooms = Room::where('is_active', true)->get();

        return view('resepsionis.orders.index', compact('orders', 'rooms'));
    }

    public function checkIn(Order $order)
    {
        if ($order->checked_in_at) {
            return back()->with('error', 'Order has already checked in');
        }

        $order->update([
            'checked_in_at' => now(),
        ]);

        // Create notification
        if ($order->user) {
            $roomName = $order->items->first()?->room?->room_name ?? 'room';
            Notification::create([
                'user_id' => $order->user_id,
                'type' => 'checkin',
                'title' => 'Check-in Successful',
                'message' => 'You have successfully checked in to ' . $roomName,
                'order_id' => $order->id
            ]);
        }

        return back()->with('success', 'Guest successfully checked in');
    }

    public function checkOut(Order $order)
    {
        if ($order->checked_out_at) {
            return back()->with('error', 'Order has already checked out');
        }

        $order->update([
            'checked_out_at' => now(),
            'status' => 'completed',
        ]);

        // Create notification
        if ($order->user) {
            Notification::create([
                'user_id' => $order->user_id,
                'type' => 'checkout',
                'title' => 'Check-out Successful',
                'message' => 'Thank you for staying at Tarsan Homestay. We look forward to your next visit!',
                'order_id' => $order->id
            ]);
        }

        return back()->with('success', 'Guest successfully checked out');
    }

    public function create()
    {
        return view('resepsionis.orders.walkin', [
            'rooms' => Room::where('is_active', true)->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'guest_name' => 'required|string|max:100',
            'guest_phone' => 'required|string|max:20',
            'room_ids' => 'required|array|min:1',
            'room_ids.*' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date|date_format:Y-m-d',
            'check_out_date' => 'required|date|date_format:Y-m-d|after:check_in_date',
            'payment_method' => 'required|in:cash,bank_transfer',
        ]);

        $rooms = Room::whereIn('id', $request->room_ids)->get();
        $checkIn = Carbon::parse($request->check_in_date);
        $checkOut = Carbon::parse($request->check_out_date);
        $nights = max($checkIn->diffInDays($checkOut), 1);

        $total = 0;
        foreach ($rooms as $room) {
            $total += $room->price_per_night * $nights;
        }

        // Generate unique order code
        $orderCode = 'WALK-' . strtoupper(Str::random(8));

        $order = Order::create([
            'order_code' => $orderCode,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'nights' => $nights,
            'total_price' => $total,
            'gross_amount' => $total,
            'payment_status' => 'paid',
            'booking_status' => 'checked_in',
            'status' => 'confirmed',
            'payment_method' => $request->payment_method,
            'is_walkin' => true,
            'guest_name' => $request->guest_name,
            'guest_phone' => $request->guest_phone,
            'checked_in_at' => now(),
            'user_id' => null,
        ]);

        foreach ($rooms as $room) {
            OrderItem::create([
                'order_id' => $order->id,
                'room_id' => $room->id,
                'price_per_night' => $room->price_per_night,
                'nights' => $nights,
                'subtotal' => $room->price_per_night * $nights,
                'qty' => 1,
            ]);
        }

        // Create notification
        Notification::create([
            'user_id' => auth()->user()->id,
            'type' => 'booking',
            'title' => 'Walk-in Booking Created',
            'message' => 'Walk-in booking for ' . $request->guest_name . ' has been created with ' . $rooms->count() . ' room(s).',
        ]);

        return redirect()
            ->route('resepsionis.orders.index')
            ->with('success', 'Walk-in booking created successfully and guest has checked in.');
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.room', 'review']);
        return view('resepsionis.orders.show', compact('order'));
    }
}
