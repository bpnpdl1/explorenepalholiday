<?php

use App\Enums\PackageBookingStatus;
use App\Mail\PackageBookingSubmittedMail;
use App\Models\PackageBooking;
use Illuminate\Support\Facades\Mail;
use Tests\Support\CreatesTravelRecords;

uses(CreatesTravelRecords::class);

test('visitor can book a package and receives a signed confirmation link', function () {
    config(['admin.email' => 'operations@example.test']);
    Mail::fake();
    $package = $this->createPublishedPackage();

    $response = $this->post(route('packages.bookings.store', $package), [
        'customer_name' => 'Alex Traveler',
        'email' => 'alex@example.test',
        'phone' => '+977 9812345678',
        'country_of_residence' => 'Nepal',
        'travel_date' => now()->addDays(60)->toDateString(),
        'guests' => 2,
        'consent' => '1',
    ]);

    $booking = PackageBooking::query()->firstOrFail();
    $response->assertRedirectContains(route('packages.bookings.thank-you', [$package, $booking->reference]));
    expect($response->headers->get('Location'))->toContain('signature=');

    $this->assertDatabaseHas('package_bookings', [
        'id' => $booking->id,
        'package_id' => $package->id,
        'status' => PackageBookingStatus::New->value,
        'guests' => 2,
    ]);
    $this->assertDatabaseHas('package_booking_logs', [
        'package_booking_id' => $booking->id,
        'event' => 'submitted',
        'to_status' => PackageBookingStatus::New->value,
    ]);

    Mail::assertSent(
        PackageBookingSubmittedMail::class,
        fn (PackageBookingSubmittedMail $mail): bool => $mail->render() !== ''
            && $mail->adminAlert
            && $mail->hasTo('operations@example.test')
            && $mail->booking->is($booking),
    );
    Mail::assertSent(
        PackageBookingSubmittedMail::class,
        fn (PackageBookingSubmittedMail $mail): bool => $mail->render() !== ''
            && ! $mail->adminAlert
            && $mail->hasTo('alex@example.test'),
    );
});

test('booking validation prevents unconsented requests from being saved', function () {
    Mail::fake();
    $package = $this->createPublishedPackage();

    $this->from(route('packages.bookings.create', $package))->post(route('packages.bookings.store', $package), [
        'customer_name' => 'Alex Traveler',
        'email' => 'alex@example.test',
        'phone' => '9812345678',
        'travel_date' => now()->addDays(60)->toDateString(),
        'guests' => 2,
    ])->assertSessionHasErrors('consent');

    expect(PackageBooking::query()->count())->toBe(0);
    Mail::assertNothingOutgoing();
});
