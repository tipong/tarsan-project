<?php

namespace Tests\Feature;

use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RoomControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_update_a_room_with_images()
    {
        Storage::fake('public');

        $admin = User::factory()->create(['role' => 'admin']);
        $room = Room::forceCreate([
            'room_name' => 'Original Room',
            'room_type' => 'Superior',
            'price_per_night' => 100000,
            'capacity' => 2,
            'total_rooms' => 5,
            'available_rooms' => 5,
            'description' => 'Original Description',
            'is_active' => true,
        ]);

        $file1 = UploadedFile::fake()->image('room1.jpg');
        $file2 = UploadedFile::fake()->image('room2.png');

        $response = $this->actingAs($admin)
            ->post(route('admin.rooms.update', $room), [
                'room_name' => 'Updated Room',
                'price_per_night' => 150000,
                'capacity' => 3,
                'total_rooms' => 6,
                'description' => 'Updated Description',
                'is_active' => '1',
                'images' => [$file1, $file2],
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('admin.rooms.index'));

        $room->refresh();
        $this->assertEquals('Updated Room', $room->room_name);
        $this->assertCount(2, $room->images);

        foreach ($room->images as $img) {
            $this->assertStringStartsWith('https://res.cloudinary.com/', $img->image);
        }
    }
}
