<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function index()
    {
        return view('resepsionis.availability.index');
    }

    public function check(Request $request)
    {
        $request->validate([
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
        ]);

        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);

        $rooms = Room::all()->map(function ($room) use ($checkIn, $checkOut) {
            $available = Order::isRoomAvailable(
                $room->id,
                $checkIn,
                $checkOut
            );

            return [
                'room' => $room,
                'available' => $available,
            ];
        });

        return view('resepsionis.availability.index', [
            'rooms' => $rooms,
            'checkIn' => $request->check_in,
            'checkOut' => $request->check_out,
        ]);
    }
}
