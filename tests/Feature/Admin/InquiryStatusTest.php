<?php

use App\Models\PackageInquiry;
use App\Models\SiteInquiry;
use App\Models\User;
use Tests\Support\CreatesTravelRecords;

uses(CreatesTravelRecords::class);

beforeEach(function () {
    $admin = User::factory()->create();
    $admin->forceFill(['is_admin' => true])->save();
    $this->actingAs($admin);
});

test('admin can update package and website inquiry statuses', function () {
    $package = $this->createPublishedPackage();
    $packageInquiry = PackageInquiry::query()->create([
        'package_id' => $package->id,
        'customer_name' => 'Alex Traveler',
        'email' => 'alex@example.test',
        'phone' => '9812345678',
        'travel_window' => 'flexible',
    ]);
    $siteInquiry = SiteInquiry::query()->create([
        'name' => 'Sam Visitor',
        'email' => 'sam@example.test',
        'interest' => 'General',
    ]);

    $this->patch(route('admin.inquiries.update-status', $packageInquiry), ['status' => 'contacted'])
        ->assertRedirect();
    $this->patch(route('admin.site-inquiries.update-status', $siteInquiry), ['status' => 'contacted'])
        ->assertRedirect();

    $this->assertDatabaseHas('package_inquiries', ['id' => $packageInquiry->id, 'status' => 'contacted']);
    $this->assertDatabaseHas('site_inquiries', ['id' => $siteInquiry->id, 'status' => 'contacted']);
});
