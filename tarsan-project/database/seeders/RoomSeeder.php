<?php

namespace Database\Seeders;

use App\Models\Facility;
use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            [
                'room_name' => 'Superior Double Room',
                'price_per_night' => 280000,
                'capacity' => 2,
                'total_rooms' => 1,
                'description' => 'Kamar nyaman dengan 1 bed super king, shower, kamar mandi pribadi, pemandangan taman, dan WiFi.',
                'facilities' => ['1 Bed Super King', 'AC', 'Shower', 'Bathroom', 'Garden View', 'WiFi', 'Private'],
            ],
            [
                'room_name' => 'Deluxe Twin Room',
                'price_per_night' => 280000,
                'capacity' => 2,
                'total_rooms' => 1,
                'description' => 'Kamar twin yang cocok untuk dua tamu dengan 2 bed single, shower, kamar mandi pribadi, pemandangan taman, dan WiFi.',
                'facilities' => ['2 Bed Single', 'AC', 'Shower', 'Bathroom', 'Garden View', 'WiFi', 'Private'],
            ],
            [
                'room_name' => 'Deluxe Double Room',
                'price_per_night' => 320000,
                'capacity' => 2,
                'total_rooms' => 1,
                'description' => 'Kamar double premium dengan 1 bed super king, balkon, shower, kamar mandi pribadi, pemandangan taman, dan WiFi.',
                'facilities' => ['1 Bed Super King', 'AC', 'Shower', 'Balcony', 'Bathroom', 'Garden View', 'WiFi', 'Private'],
            ],
            [
                'room_name' => 'Backpacker Room',
                'price_per_night' => 180000,
                'capacity' => 1,
                'total_rooms' => 1,
                'description' => 'Kamar hemat untuk solo traveler dengan 1 bed single, AC, shower, akses WiFi, dan kamar mandi sharing.',
                'facilities' => ['1 Bed Single', 'AC', 'Shower', 'Bathroom', 'WiFi', 'Sharing'],
            ],
        ];

        foreach ($rooms as $roomData) {
            $facilityNames = $roomData['facilities'];
            unset($roomData['facilities']);

            $existingRoom = Room::where('room_name', $roomData['room_name'])->first();
            $availableRooms = $existingRoom
                ? min((int) $existingRoom->available_rooms, (int) $roomData['total_rooms'])
                : (int) $roomData['total_rooms'];

            $room = Room::updateOrCreate(
                ['room_name' => $roomData['room_name']],
                $roomData + [
                    'available_rooms' => $availableRooms,
                    'is_active' => true,
                ]
            );

            $facilityIds = Facility::whereIn(
                'slug',
                collect($facilityNames)->map(fn (string $name) => Str::slug($name))
            )->pluck('id');

            $room->facilities()->sync($facilityIds);
        }
    }
}
