<?php

use App\Models\User;

test('profile page is displayed', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/profile');

    $response->assertOk();
});

test('profile information can be updated', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->from('/profile')
        ->post('/profile', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $user->refresh();

    $this->assertSame('Test User', $user->name);
    $this->assertSame('test@example.com', $user->email);
    $this->assertNull($user->email_verified_at);
});

test('email verification status is unchanged when the email address is unchanged', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->from('/profile')
        ->post('/profile', [
            'name' => 'Test User',
            'email' => $user->email,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $this->assertNotNull($user->refresh()->email_verified_at);
});

test('user can delete their account', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->delete('/profile', [
            'password' => 'password',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/');

    $this->assertGuest();
    $this->assertNull($user->fresh());
});

test('correct password must be provided to delete account', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->from('/profile')
        ->delete('/profile', [
            'password' => 'wrong-password',
        ]);

    $response
        ->assertSessionHasErrorsIn('userDeletion', 'password')
        ->assertRedirect('/profile');

    $this->assertNotNull($user->fresh());
});

test('deleting user keeps paid orders and reviews', function () {
    $user = User::factory()->create();

    // Create room
    $room = \App\Models\Room::forceCreate([
        'room_name' => 'Suite Room ' . rand(1, 1000),
        'room_type' => 'Suite',
        'price_per_night' => 100000,
        'capacity' => 2,
        'total_rooms' => 5,
        'available_rooms' => 5,
        'description' => 'A nice room',
        'is_active' => true,
    ]);

    // Create a paid order for this user
    $paidOrder = \App\Models\Order::create([
        'order_code' => 'ORD-12345',
        'user_id' => $user->id,
        'check_in' => now(),
        'check_out' => now()->addDays(2),
        'nights' => 2,
        'total_price' => 200000,
        'guest_name' => $user->name,
        'payment_status' => 'paid',
        'status' => 'confirmed',
    ]);

    // Create an unpaid order for this user
    $unpaidOrder = \App\Models\Order::create([
        'order_code' => 'ORD-67890',
        'user_id' => $user->id,
        'check_in' => now(),
        'check_out' => now()->addDays(2),
        'nights' => 2,
        'total_price' => 200000,
        'guest_name' => $user->name,
        'payment_status' => 'pending',
        'status' => 'pending',
    ]);

    // Create a review for the paid order
    $review = \App\Models\Review::create([
        'user_id' => $user->id,
        'guest_name' => $user->name,
        'order_id' => $paidOrder->id,
        'rating' => 5,
        'review' => 'Excellent stay!',
    ]);

    // Act: Delete the user
    $user->delete();

    // Assert: User is deleted
    $this->assertNull($user->fresh());

    // Assert: Paid order still exists in DB but user_id is null
    $paidOrderFresh = \App\Models\Order::find($paidOrder->id);
    $this->assertNotNull($paidOrderFresh);
    $this->assertNull($paidOrderFresh->user_id);

    // Assert: Unpaid order is cascade deleted
    $unpaidOrderFresh = \App\Models\Order::find($unpaidOrder->id);
    $this->assertNull($unpaidOrderFresh);

    // Assert: Review still exists, user_id is null, and guest_name is still preserved
    $reviewFresh = \App\Models\Review::find($review->id);
    $this->assertNotNull($reviewFresh);
    $this->assertNull($reviewFresh->user_id);
    $this->assertSame($user->name, $reviewFresh->guest_name);
});
