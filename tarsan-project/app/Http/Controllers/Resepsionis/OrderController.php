<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Room;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items.room'])
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

        // Create notification
        if ($order->user) {
            $roomName = $order->items->first()?->room?->room_name ?? 'kamar';
            Notification::create([
                'user_id' => $order->user_id,
                'type' => 'checkin',
                'title' => 'Check-in Berhasil',
                'message' => 'Anda telah berhasil check-in di kamar ' . $roomName,
                'order_id' => $order->id
            ]);
        }

        return back()->with('success', 'Tamu berhasil check-in');
    }

    public function checkOut(Order $order)
    {
        if ($order->checked_out_at) {
            return back()->with('error', 'Order sudah check-out');
        }

        $order->update([
            'checked_out_at' => now(),
        ]);

        // Create notification
        if ($order->user) {
            Notification::create([
                'user_id' => $order->user_id,
                'type' => 'checkout',
                'title' => 'Check-out Berhasil',
                'message' => 'Terima kasih telah menginap di Tarsan Homestay. Kami tunggu kunjungan Anda berikutnya!',
                'order_id' => $order->id
            ]);
        }

        return back()->with('success', 'Tamu berhasil check-out');
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
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'payment_method' => 'required|in:cash,bank_transfer,card',
        ]);

        $room = Room::findOrFail($request->room_id);

        // Hitung malam
        $checkIn = Carbon::parse($request->check_in_date);
        $checkOut = Carbon::parse($request->check_out_date);
        $nights = max($checkIn->diffInDays($checkOut), 1);

        $total = $room->price_per_night * $nights;

        // Generate order code
        $orderCode = 'ORD-' . now()->format('YmdHi') . '-' . strtoupper(substr($request->guest_name, 0, 2));

        $order = Order::create([
            'order_code' => $orderCode,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'nights' => $nights,
            'total_price' => $total,
            'status' => $request->payment_method === 'cash' ? 'confirmed' : 'pending',
            'payment_status' => $request->payment_method === 'cash' ? 'paid' : 'pending',
            'payment_method' => $request->payment_method,
            'is_walkin' => true,
            'guest_name' => $request->guest_name,
            'guest_phone' => $request->guest_phone,
            'checked_in_at' => now(), // WALK-IN LANGSUNG CHECK-IN
        ]);

        // Create order item
        OrderItem::createBookingItem([
            'order_id' => $order->id,
            'room_id' => $room->id,
            'price_per_night' => $room->price_per_night,
            'nights' => $nights,
            'subtotal' => $total,
        ]);

        // Create notification
        Notification::create([
            'type' => 'booking',
            'title' => 'Walk-in Booking Dibuat',
            'message' => 'Pesanan walk-in untuk ' . $request->guest_name . ' telah dibuat dengan metode pembayaran ' . ucfirst(str_replace('_', ' ', $request->payment_method)),
        ]);

        return redirect()
            ->route('resepsionis.orders.index')
            ->with('success', 'Walk-in booking berhasil dibuat. Metode pembayaran: ' . ucfirst(str_replace('_', ' ', $request->payment_method)));
    }
}
