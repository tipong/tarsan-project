<?php

namespace Tests\Feature\Resepsionis;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderControllerTest extends TestCase
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

    public function test_resepsionis_can_view_orders_index_with_pagination()
    {
        // Create 20 orders
        for ($i = 1; $i <= 20; $i++) {
            $order = Order::create([
                'order_code' => 'ORD-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'check_in' => now()->addDays($i),
                'check_out' => now()->addDays($i + 1),
                'nights' => 1,
                'total_price' => 150000,
                'payment_status' => 'paid',
                'status' => 'confirmed',
                'guest_name' => 'Guest ' . $i,
                'guest_phone' => '08123456789' . $i,
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'room_id' => $this->room1->id,
                'price_per_night' => 150000,
                'nights' => 1,
                'subtotal' => 150000,
                'qty' => 1,
            ]);
        }

        $response = $this->actingAs($this->resepsionis)
            ->get(route('resepsionis.orders.index'));

        $response->assertStatus(200);
        $response->assertViewHas('orders');

        // Check pagination: page 1 shows 15 orders
        $orders = $response->viewData('orders');
        $this->assertCount(15, $orders);
        $this->assertTrue($orders->hasMorePages());

        // Check if pagination links are rendered
        $response->assertSee('Next');
    }

    public function test_resepsionis_can_filter_orders_by_search_name()
    {
        // Create matching order
        $orderMatch = Order::create([
            'order_code' => 'MATCH123',
            'check_in' => now()->addDay(),
            'check_out' => now()->addDays(2),
            'nights' => 1,
            'total_price' => 150000,
            'payment_status' => 'paid',
            'status' => 'confirmed',
            'guest_name' => 'Special Guest Name',
            'guest_phone' => '08123456789',
        ]);
        OrderItem::create([
            'order_id' => $orderMatch->id,
            'room_id' => $this->room1->id,
            'price_per_night' => 150000,
            'nights' => 1,
            'subtotal' => 150000,
            'qty' => 1,
        ]);

        // Create non-matching order
        $orderNoMatch = Order::create([
            'order_code' => 'OTHER456',
            'check_in' => now()->addDay(),
            'check_out' => now()->addDays(2),
            'nights' => 1,
            'total_price' => 150000,
            'payment_status' => 'paid',
            'status' => 'confirmed',
            'guest_name' => 'Regular Person',
            'guest_phone' => '08123456789',
        ]);
        OrderItem::create([
            'order_id' => $orderNoMatch->id,
            'room_id' => $this->room1->id,
            'price_per_night' => 150000,
            'nights' => 1,
            'subtotal' => 150000,
            'qty' => 1,
        ]);

        $response = $this->actingAs($this->resepsionis)
            ->get(route('resepsionis.orders.index', ['search' => 'Special Guest']));

        $response->assertStatus(200);
        $orders = $response->viewData('orders');
        $this->assertCount(1, $orders);
        $this->assertEquals('Special Guest Name', $orders->first()->guest_name);
    }

    public function test_resepsionis_can_filter_orders_by_status()
    {
        // Status filter types: upcoming, ongoing, completed, cancelled, paid, unpaid
        $orderOngoing = Order::create([
            'order_code' => 'ONGOING',
            'check_in' => now()->subDay(),
            'check_out' => now()->addDay(),
            'nights' => 2,
            'total_price' => 150000,
            'payment_status' => 'paid',
            'status' => 'confirmed',
            'guest_name' => 'Ongoing Guest',
            'guest_phone' => '08123456789',
            'checked_in_at' => now()->subDay(),
        ]);
        OrderItem::create([
            'order_id' => $orderOngoing->id,
            'room_id' => $this->room1->id,
            'price_per_night' => 150000,
            'nights' => 2,
            'subtotal' => 300000,
            'qty' => 1,
        ]);

        $orderCompleted = Order::create([
            'order_code' => 'COMPLETED',
            'check_in' => now()->subDays(3),
            'check_out' => now()->subDay(),
            'nights' => 2,
            'total_price' => 150000,
            'payment_status' => 'paid',
            'status' => 'completed',
            'guest_name' => 'Completed Guest',
            'guest_phone' => '08123456789',
            'checked_in_at' => now()->subDays(3),
            'checked_out_at' => now()->subDay(),
        ]);
        OrderItem::create([
            'order_id' => $orderCompleted->id,
            'room_id' => $this->room1->id,
            'price_per_night' => 150000,
            'nights' => 2,
            'subtotal' => 300000,
            'qty' => 1,
        ]);

        // Filter: ongoing
        $response = $this->actingAs($this->resepsionis)
            ->get(route('resepsionis.orders.index', ['status' => 'ongoing']));
        $response->assertStatus(200);
        $orders = $response->viewData('orders');
        $this->assertCount(1, $orders);
        $this->assertEquals('ONGOING', $orders->first()->order_code);

        // Filter: completed
        $response = $this->actingAs($this->resepsionis)
            ->get(route('resepsionis.orders.index', ['status' => 'completed']));
        $response->assertStatus(200);
        $orders = $response->viewData('orders');
        $this->assertCount(1, $orders);
        $this->assertEquals('COMPLETED', $orders->first()->order_code);
    }

    public function test_resepsionis_can_filter_orders_by_room_type()
    {
        $orderRoom1 = Order::create([
            'order_code' => 'ROOM1',
            'check_in' => now()->addDay(),
            'check_out' => now()->addDays(2),
            'nights' => 1,
            'total_price' => 150000,
            'payment_status' => 'paid',
            'status' => 'confirmed',
            'guest_name' => 'Room 1 Guest',
        ]);
        OrderItem::create([
            'order_id' => $orderRoom1->id,
            'room_id' => $this->room1->id,
            'price_per_night' => 150000,
            'nights' => 1,
            'subtotal' => 150000,
            'qty' => 1,
        ]);

        $orderRoom2 = Order::create([
            'order_code' => 'ROOM2',
            'check_in' => now()->addDay(),
            'check_out' => now()->addDays(2),
            'nights' => 1,
            'total_price' => 200000,
            'payment_status' => 'paid',
            'status' => 'confirmed',
            'guest_name' => 'Room 2 Guest',
        ]);
        OrderItem::create([
            'order_id' => $orderRoom2->id,
            'room_id' => $this->room2->id,
            'price_per_night' => 200000,
            'nights' => 1,
            'subtotal' => 200000,
            'qty' => 1,
        ]);

        $response = $this->actingAs($this->resepsionis)
            ->get(route('resepsionis.orders.index', ['room_id' => $this->room2->id]));
        $response->assertStatus(200);
        $orders = $response->viewData('orders');
        $this->assertCount(1, $orders);
        $this->assertEquals('ROOM2', $orders->first()->order_code);
    }
}
