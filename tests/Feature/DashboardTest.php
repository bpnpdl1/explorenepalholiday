<?php

use App\Models\NewsletterSubscriber;
use App\Models\PackageInquiry;
use App\Models\SiteInquiry;
use App\Models\User;
use Tests\Support\CreatesTravelRecords;

uses(CreatesTravelRecords::class);

test('guests are redirected to the login page', function () {
    $response = $this->get(route('admin.dashboard'));
    $response->assertRedirect(route('login'));
});

test('admins can visit the dashboard', function () {
    $user = User::factory()->create();
    $user->forceFill(['is_admin' => true])->save();
    $this->actingAs($user);

    $response = $this->get(route('admin.dashboard'));
    $response->assertOk();
});

test('dashboard presents live workflow totals charts and popular packages', function () {
    $this->travelTo(now()->startOfDay()->setTime(10, 0));
    $admin = User::factory()->create();
    $admin->forceFill(['is_admin' => true])->save();
    $this->actingAs($admin);

    $package = $this->createPublishedPackage();
    $package->bookings()->create([
        'reference' => 'ENH-DASH-00001',
        'customer_name' => 'Booking Guest',
        'email' => 'booking@example.test',
        'phone' => '9812345678',
        'travel_date' => now()->addDays(60),
        'guests' => 2,
        'status' => 'new',
    ]);
    PackageInquiry::query()->create([
        'package_id' => $package->id,
        'customer_name' => 'Package Guest',
        'email' => 'package@example.test',
        'phone' => '9812345678',
        'travel_window' => 'flexible',
    ]);
    SiteInquiry::query()->create([
        'name' => 'Website Guest',
        'email' => 'website@example.test',
        'interest' => 'General question',
    ]);
    NewsletterSubscriber::query()->create([
        'email' => 'subscriber@example.test',
        'status' => 'subscribed',
        'subscribed_at' => now(),
        'consented_at' => now(),
    ]);

    $this->get(route('admin.dashboard'))
        ->assertOk()
        ->assertViewHas('stats', function (array $stats): bool {
            return $stats['bookings']['value'] === 1
                && $stats['inquiries']['value'] === 2
                && $stats['packages']['value'] === 1
                && $stats['subscribers']['value'] === 1;
        })
        ->assertViewHas('chart', function (array $chart): bool {
            return count($chart['labels']) === 6
                && count($chart['bookings']) === 6
                && count($chart['inquiries']) === 6
                && $chart['bookings'][5] === 1
                && $chart['inquiries'][5] === 2;
        })
        ->assertViewHas('popularPackages', function ($packages) use ($package): bool {
            return $packages->contains(fn ($popularPackage): bool => $popularPackage->is($package)
                && $popularPackage->bookings_count === 1);
        })
        ->assertViewHas('recentInquiries', fn ($inquiries): bool => $inquiries->count() === 2);
});
