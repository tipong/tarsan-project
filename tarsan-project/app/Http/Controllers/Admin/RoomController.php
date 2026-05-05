<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('images')->latest()->get();
        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('admin.rooms.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_name' => 'required|string|max:255',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'total_rooms' => 'required|integer|min:1',
            'facilities' => 'nullable|string',
            'description' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:51200',
        ]);

        $validated['available_rooms'] = $validated['total_rooms'];
        $validated['is_active'] = $request->boolean('is_active');

        $room = Room::create($validated);

        // SIMPAN MULTIPLE IMAGE
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('rooms', 'public');

                RoomImage::create([
                    'room_id' => $room->id,
                    'image' => $path,
                ]);
            }
        }

        return redirect()
            ->route('admin.rooms.index')
            ->with('success', 'Room berhasil ditambahkan');
    }

    public function edit(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_name' => 'required|string|max:255',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'total_rooms' => 'required|integer|min:1',
            'facilities' => 'nullable|string',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:51200', // 50MB
        ]);

        // Update available_rooms safely
        if ($room->total_rooms != $validated['total_rooms']) {
            $diff = $validated['total_rooms'] - $room->total_rooms;
            $room->available_rooms += $diff;
        }

        $validated['is_active'] = $request->boolean('is_active');

        $room->update($validated);

        // DELETE SELECTED IMAGES
        if ($request->filled('delete_images')) {
            $images = RoomImage::whereIn('id', $request->delete_images)->get();

            foreach ($images as $image) {
                Storage::disk('public')->delete($image->image);
                $image->delete();
            }
        }

        // ADD NEW IMAGES
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('rooms', 'public');

                RoomImage::create([
                    'room_id' => $room->id,
                    'image' => $path,
                ]);
            }
        }

        return redirect()
            ->route('admin.rooms.index')
            ->with('success', 'Room berhasil diperbarui');
    }

    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()
            ->route('admin.rooms.index')
            ->with('success', 'Room berhasil dihapus');
    }
}
