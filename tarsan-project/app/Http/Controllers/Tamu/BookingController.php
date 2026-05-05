<?php

namespace App\Http\Controllers\Tamu;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index()
    {
        $rooms = Room::with('images')
            ->where('is_active', 1)
            ->get();

        $cart = session('cart', []);

        return view('tamu.booking.index', compact('rooms', 'cart'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'check_in'  => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
        ]);

        $rooms = Room::with('images')->where('is_active', 1)->get();

        session([
            'booking_filter' => $request->only('check_in', 'check_out')
        ]);

        return view('tamu.booking.index', [
            'rooms' => $rooms,
            'cart'  => session('cart', [])
        ]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
        ]);

        $room = Room::findOrFail($request->room_id);

        $checkIn  = \Carbon\Carbon::parse($request->check_in);
        $checkOut = \Carbon\Carbon::parse($request->check_out);
        $nights   = $checkIn->diffInDays($checkOut);

        $cart = session()->get('cart', []);

        $cart[$room->id] = [
            'room_id'   => $room->id,
            'room_name' => $room->room_name,
            'price'     => $room->price_per_night,
            'check_in'  => $request->check_in,
            'check_out' => $request->check_out,
            'nights'    => $nights,
            'subtotal'  => $room->price_per_night * $nights,
        ];

        session()->put('cart', $cart);

        return redirect()->route('tamu.booking.index')
            ->with('success', 'Room added to cart');
    }



    public function remove($roomId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$roomId])) {
            unset($cart[$roomId]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Room removed from cart');
    }
}
