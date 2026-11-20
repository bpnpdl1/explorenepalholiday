<?php

use App\Models\SiteInquiry;

test('visitor can submit a site inquiry with a normalized phone number', function () {
    $this->post(route('site-inquiries.store'), [
        'name' => 'Alex Traveler',
        'email' => 'alex@example.test',
        'country_code' => '+977',
        'phone' => ' 9812345678 ',
        'interest' => 'Trekking',
        'message' => 'Please send details.',
        'source' => 'contact',
    ])->assertRedirect(route('contact').'#contact-section-title')
        ->assertSessionHas('site_inquiry_submitted', true);

    $this->assertDatabaseHas('site_inquiries', [
        'name' => 'Alex Traveler',
        'email' => 'alex@example.test',
        'phone' => '+977 9812345678',
        'interest' => 'Trekking',
        'status' => 'new',
    ]);
});

test('invalid site inquiries are rejected without creating a record', function () {
    $this->from(route('contact'))->post(route('site-inquiries.store'), [
        'name' => '',
        'email' => 'not-an-email',
        'source' => 'invalid',
    ])->assertSessionHasErrors(['name', 'email', 'source']);

    expect(SiteInquiry::query()->count())->toBe(0);
});
