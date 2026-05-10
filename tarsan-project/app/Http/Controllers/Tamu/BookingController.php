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
        $rooms = Room::withRoomRelations()
            ->where('is_active', 1)
            ->get();
        $facilities = Room::facilityOptions();

        $cart = session('cart', []);

        return view('tamu.booking.index', compact('rooms', 'cart', 'facilities'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'check_in'  => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
        ]);

        $rooms = Room::withRoomRelations()->where('is_active', 1);
        $facilities = Room::facilityOptions();

        // Filter by room search
        if ($request->filled('room_search')) {
            $search = $request->room_search;
            $rooms->where(function ($query) use ($search) {
                $query->where('room_name', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%");
            });
        }

        // Filter by facility
        if ($request->filled('facility')) {
            $rooms->filterByFacility($request->facility);
        }

        $rooms = $rooms->get();

        session([
            'booking_filter' => $request->only('check_in', 'check_out', 'room_search', 'facility')
        ]);

        return view('tamu.booking.index', [
            'rooms' => $rooms,
            'cart'  => session('cart', []),
            'facilities' => $facilities,
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
