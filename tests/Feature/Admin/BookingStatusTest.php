<?php

use App\Models\User;
use Tests\Support\CreatesTravelRecords;

uses(CreatesTravelRecords::class);

beforeEach(function () {
    $admin = User::factory()->create();
    $admin->forceFill(['is_admin' => true])->save();
    $this->actingAs($admin);
});

test('admin can change a booking status and the action is logged', function () {
    $package = $this->createPublishedPackage();
    $booking = $package->bookings()->create([
        'reference' => 'ENH-TEST-00001',
        'customer_name' => 'Alex Traveler',
        'email' => 'alex@example.test',
        'phone' => '9812345678',
        'travel_date' => now()->addDays(60),
        'guests' => 2,
        'status' => 'new',
    ]);
    $booking->logs()->create(['event' => 'submitted', 'to_status' => 'new']);

    $this->patch(route('admin.bookings.update-status', $booking), [
        'status' => 'processing',
        'note' => 'We are checking availability.',
    ])->assertRedirect();

    $this->assertDatabaseHas('package_bookings', ['id' => $booking->id, 'status' => 'processing']);
    $this->assertDatabaseHas('package_booking_logs', [
        'package_booking_id' => $booking->id,
        'event' => 'status_changed',
        'from_status' => 'new',
        'to_status' => 'processing',
        'note' => 'We are checking availability.',
    ]);
});

test('invalid booking status transitions keep the current status and history', function () {
    $package = $this->createPublishedPackage();
    $booking = $package->bookings()->create([
        'reference' => 'ENH-TEST-00002',
        'customer_name' => 'Alex Traveler',
        'email' => 'alex@example.test',
        'phone' => '9812345678',
        'travel_date' => now()->addDays(60),
        'guests' => 2,
        'status' => 'new',
    ]);
    $booking->logs()->create(['event' => 'submitted', 'to_status' => 'new']);

    $this->from(route('admin.bookings.show', $booking))
        ->patch(route('admin.bookings.update-status', $booking), ['status' => 'confirmed'])
        ->assertSessionHasErrors('status');

    $this->assertDatabaseHas('package_bookings', ['id' => $booking->id, 'status' => 'new']);
    expect($booking->logs()->count())->toBe(1);
});
