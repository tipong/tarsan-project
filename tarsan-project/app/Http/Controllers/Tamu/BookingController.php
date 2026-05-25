<?php

namespace App\Http\Controllers\Tamu;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->filled('check_in') && !$request->filled('check_out')) {
            session()->forget('booking_filter');
        } else {
            $request->validate([
                'check_in'  => 'required|date|after_or_equal:today',
                'check_out' => 'required|date|after:check_in',
            ]);

            session([
                'booking_filter' => $request->only('check_in', 'check_out', 'room_search', 'facility')
            ]);
        }

        return $this->doSearch($request);
    }


    public function add(Request $request)
    {
        $request->validate([
            'room_id'   => 'required|exists:rooms,id',
            'check_in'  => 'required|date',
            'check_out' => 'required|date|after:check_in',
        ]);

        $room = Room::findOrFail($request->room_id);

        $checkIn  = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);
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

        $filter = session('booking_filter', []);
        return redirect()->route('tamu.booking.index', $filter)
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

    public function cart()
    {
        $cart = session('cart', []);
        return view('tamu.booking.cart', compact('cart'));
    }

    /**
     * Core search logic without HTTP validation – reused by search() and add()
     */
    private function doSearch(Request $request)
    {
        $rooms = Room::withRoomRelations()->where('is_active', 1);
        $facilities = Room::facilityOptions();

        // Filter by room name
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

        // Add availability status for each room
        foreach ($rooms as $room) {
            $room->is_available = $this->isRoomAvailable($room->id, $request->check_in, $request->check_out);
        }

        return view('tamu.booking.index', [
            'rooms'      => $rooms,
            'cart'       => session('cart', []),
            'facilities' => $facilities,
        ]);
    }

    /**
     * Check if a room is available for the given date range
     */
    private function isRoomAvailable($roomId, $checkIn, $checkOut)
    {
        $checkInDate  = Carbon::parse($checkIn);
        $checkOutDate = Carbon::parse($checkOut);

        // Check if any confirmed/pending order overlaps with the requested date range
        $overlappingOrders = \App\Models\Order::whereHas('items', function ($query) use ($roomId) {
                $query->where('room_id', $roomId);
            })
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($query) use ($checkInDate, $checkOutDate) {
                $query->whereBetween('check_in', [$checkInDate, $checkOutDate->subDay()])
                    ->orWhereBetween('check_out', [$checkInDate->addDay(), $checkOutDate])
                    ->orWhere(function ($q) use ($checkInDate, $checkOutDate) {
                        $q->where('check_in', '<=', $checkInDate)
                            ->where('check_out', '>=', $checkOutDate);
                    });
            })
            ->count();

        return $overlappingOrders === 0;
    }
}
