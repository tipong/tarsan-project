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
        $rooms = Room::withRoomRelations()->latest()->get();

        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        $usesFacilityRelations = Room::supportsFacilityRelations();
        $facilities = Room::facilityOptions();

        return view('admin.rooms.create', compact('facilities', 'usesFacilityRelations'));
    }

    public function store(Request $request)
    {
        $usesFacilityRelations = Room::supportsFacilityRelations();

        $rules = [
            'room_name' => 'required|string|max:255',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'total_rooms' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:51200',
        ];

        if ($usesFacilityRelations) {
            $rules['facility_ids'] = 'nullable|array';
            $rules['facility_ids.*'] = 'exists:facilities,id';
        } elseif (Room::supportsLegacyFacilitiesColumn()) {
            $rules['facilities'] = 'nullable|string';
        }

        $validated = $request->validate($rules);

        $roomData = collect($validated)
            ->except(['facility_ids', 'facilities'])
            ->all();

        if (Room::supportsLegacyFacilitiesColumn()) {
            $roomData['facilities'] = $this->normalizeFacilitiesInput($validated['facilities'] ?? null);
        }

        $roomData['available_rooms'] = $roomData['total_rooms'];
        $roomData['is_active'] = $request->boolean('is_active');

        $room = Room::create($roomData);

        if ($usesFacilityRelations) {
            $room->facilities()->sync($validated['facility_ids'] ?? []);
        }

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
        $usesFacilityRelations = Room::supportsFacilityRelations();

        $room->load('images');

        if ($usesFacilityRelations) {
            $room->load('facilities');
        }

        $facilities = Room::facilityOptions();

        return view('admin.rooms.edit', compact('room', 'facilities', 'usesFacilityRelations'));
    }

    public function update(Request $request, Room $room)
    {
        $usesFacilityRelations = Room::supportsFacilityRelations();

        $rules = [
            'room_name' => 'required|string|max:255',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'total_rooms' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:51200', // 50MB
        ];

        if ($usesFacilityRelations) {
            $rules['facility_ids'] = 'nullable|array';
            $rules['facility_ids.*'] = 'exists:facilities,id';
        } elseif (Room::supportsLegacyFacilitiesColumn()) {
            $rules['facilities'] = 'nullable|string';
        }

        $validated = $request->validate($rules);

        // Update available_rooms safely
        if ($room->total_rooms != $validated['total_rooms']) {
            $diff = $validated['total_rooms'] - $room->total_rooms;
            $room->available_rooms += $diff;
        }

        $roomData = collect($validated)
            ->except(['facility_ids', 'facilities'])
            ->all();

        if (Room::supportsLegacyFacilitiesColumn()) {
            $roomData['facilities'] = $this->normalizeFacilitiesInput($validated['facilities'] ?? null);
        }

        $roomData['is_active'] = $request->boolean('is_active');

        $room->update($roomData);

        if ($usesFacilityRelations) {
            $room->facilities()->sync($validated['facility_ids'] ?? []);
        }

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

    private function normalizeFacilitiesInput(?string $facilities): ?string
    {
        $normalizedFacilities = collect(explode(',', (string) $facilities))
            ->map(fn (string $facility) => trim($facility))
            ->filter()
            ->unique()
            ->values()
            ->implode(', ');

        return $normalizedFacilities !== '' ? $normalizedFacilities : null;
    }
}
