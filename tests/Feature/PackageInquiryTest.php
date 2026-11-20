<?php

use App\Models\PackageInquiry;
use Tests\Support\CreatesTravelRecords;

uses(CreatesTravelRecords::class);

test('visitor can submit an inquiry for a published package', function () {
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
});

test('package inquiry rejects invalid travel windows', function () {
    $package = $this->createPublishedPackage();

    $this->from(route('packages.show', $package))->post(route('packages.inquiries.store', $package), [
        'customer_name' => 'Alex Traveler',
        'email' => 'alex@example.test',
        'phone' => '9812345678',
        'travel_window' => 'not-a-real-option',
    ])->assertSessionHasErrors('travel_window');

    expect(PackageInquiry::query()->count())->toBe(0);
});
