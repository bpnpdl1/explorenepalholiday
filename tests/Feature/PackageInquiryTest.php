<?php

use App\Mail\PackageInquirySubmittedMail;
use App\Models\PackageInquiry;
use Illuminate\Support\Facades\Mail;
use Tests\Support\CreatesTravelRecords;

uses(CreatesTravelRecords::class);

test('visitor can submit an inquiry for a published package', function () {
    config(['admin.email' => 'operations@example.test']);
    Mail::fake();
    $package = $this->createPublishedPackage();

    $this->post(route('packages.inquiries.store', $package), [
        'customer_name' => 'Alex Traveler',
        'email' => 'alex@example.test',
        'phone' => '+977 9812345678',
        'travel_window' => 'flexible',
        'message' => 'Can you customize this trip?',
    ])->assertRedirect(route('packages.show', $package).'#sidebar-enquiry-form')
        ->assertSessionHas('inquiry_submitted', true);

    $this->assertDatabaseHas('package_inquiries', [
        'package_id' => $package->id,
        'customer_name' => 'Alex Traveler',
        'travel_window' => 'flexible',
        'status' => 'new',
    ]);

    Mail::assertSent(
        PackageInquirySubmittedMail::class,
        fn (PackageInquirySubmittedMail $mail): bool => $mail->render() !== ''
            && $mail->adminAlert
            && $mail->hasTo('operations@example.test')
            && $mail->inquiry->package->is($package),
    );
    Mail::assertSent(
        PackageInquirySubmittedMail::class,
        fn (PackageInquirySubmittedMail $mail): bool => $mail->render() !== ''
            && ! $mail->adminAlert
            && $mail->hasTo('alex@example.test'),
    );
});

test('package inquiry rejects invalid travel windows', function () {
    Mail::fake();
    $package = $this->createPublishedPackage();

    $this->from(route('packages.show', $package))->post(route('packages.inquiries.store', $package), [
        'customer_name' => 'Alex Traveler',
        'email' => 'alex@example.test',
        'phone' => '9812345678',
        'travel_window' => 'not-a-real-option',
    ])->assertSessionHasErrors('travel_window');

    expect(PackageInquiry::query()->count())->toBe(0);
    Mail::assertNothingOutgoing();
});
