<?php

namespace Tests\Feature\Resepsionis;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AvailabilityControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $resepsionis;
    protected Room $room1;
    protected Room $room2;

    protected function setUp(): void
    {
        parent::setUp();

        $this->resepsionis = User::factory()->create(['role' => 'resepsionis']);

        $this->room1 = Room::forceCreate([
            'room_name' => 'Deluxe Room 101',
            'room_type' => 'Deluxe',
            'price_per_night' => 150000,
            'capacity' => 2,
            'total_rooms' => 5,
            'available_rooms' => 5,
            'description' => 'A deluxe room',
            'is_active' => true,
        ]);

        $this->room2 = Room::forceCreate([
            'room_name' => 'Superior Room 202',
            'room_type' => 'Superior',
            'price_per_night' => 200000,
            'capacity' => 2,
            'total_rooms' => 5,
            'available_rooms' => 5,
            'description' => 'A superior room',
            'is_active' => true,
        ]);
    }

    public function test_resepsionis_can_view_room_availability_index()
    {
        $response = $this->actingAs($this->resepsionis)
            ->get(route('resepsionis.availability'));

        $response->assertStatus(200);
        $response->assertSee('Check Room Availability');
    }

    public function test_resepsionis_can_check_room_availability()
    {
        // Book room 1 from now until tomorrow
        $order = Order::create([
            'order_code' => 'BOOKED123',
            'check_in' => now(),
            'check_out' => now()->addDay(),
            'nights' => 1,
            'total_price' => 150000,
            'payment_status' => 'paid',
            'status' => 'confirmed',
            'guest_name' => 'John Doe',
        ]);
        OrderItem::create([
            'order_id' => $order->id,
            'room_id' => $this->room1->id,
            'price_per_night' => 150000,
            'nights' => 1,
            'subtotal' => 150000,
            'qty' => 1,
        ]);

        $response = $this->actingAs($this->resepsionis)
            ->post(route('resepsionis.availability.check'), [
                'check_in' => now()->format('Y-m-d'),
                'check_out' => now()->addDay()->format('Y-m-d'),
            ]);

        $response->assertStatus(200);
        $response->assertViewHas('rooms');
        
        // Assert English translation outputs
        $response->assertSee('Search Results');
        $response->assertSee('Occupied'); // Room 1
        $response->assertSee('Available'); // Room 2
    }
}
