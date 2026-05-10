<?php

namespace App\Http\Controllers\Tamu;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $rooms = Room::withRoomRelations()
            ->where('is_active', true);
        $facilities = Room::facilityOptions();

        // Filter by facility
        if ($request->filled('facility')) {
            $rooms->filterByFacility($request->facility);
        }

        // Filter by price range
        if ($request->filled('price_min')) {
            $rooms->where('price_per_night', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $rooms->where('price_per_night', '<=', $request->price_max);
        }

        // Search by name
        if ($request->filled('search')) {
            $rooms->where(function ($query) use ($request) {
                $query->where('room_name', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $rooms = $rooms->paginate(9);

        return view('kamar.index', compact('rooms', 'facilities'));
    }

    public function show(Room $room)
    {
        $room->load('images');

        if (Room::supportsFacilityRelations()) {
            $room->load('facilities');
        }

        return view('kamar.show', compact('room'));
    }
}
