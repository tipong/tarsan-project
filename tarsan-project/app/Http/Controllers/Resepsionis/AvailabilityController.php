<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Room;
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

        $rooms = Room::all()->map(function ($room) use ($request) {
            $available = Order::isRoomAvailable(
                $room->id,
                $request->check_in,
                $request->check_out
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
