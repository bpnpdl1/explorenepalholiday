<?php

use App\Models\NewsletterSubscriber;
use App\Models\User;
use ZipArchive;

beforeEach(function () {
    $admin = User::factory()->create();
    $admin->forceFill(['is_admin' => true])->save();
    $this->actingAs($admin);
});

test('admin can update subscription status and export filtered subscribers as xlsx', function () {
    $this->travelTo(now()->startOfDay()->setTime(10, 0));
    $subscriber = NewsletterSubscriber::query()->create([
        'email' => 'active@example.test',
        'status' => 'subscribed',
        'subscribed_at' => now(),
        'consented_at' => now(),
    ]);
    NewsletterSubscriber::query()->create([
        'email' => 'inactive@example.test',
        'status' => 'unsubscribed',
        'subscribed_at' => now()->subDay(),
        'unsubscribed_at' => now(),
        'consented_at' => now()->subDay(),
    ]);

    $export = $this->get(route('admin.newsletter-subscribers.export', ['status' => 'subscribed']))
        ->assertOk()
        ->assertDownload()
        ->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

    $file = $export->baseResponse->getFile()->getPathname();
    $archive = new ZipArchive;
    expect($archive->open($file))->toBeTrue();
    $worksheet = $archive->getFromName('xl/worksheets/sheet1.xml');
    $archive->close();

    expect($worksheet)->toContain('active@example.test')
        ->not->toContain('inactive@example.test');

    $this->patch(route('admin.newsletter-subscribers.update-status', $subscriber), ['status' => 'unsubscribed'])
        ->assertRedirect();
    $this->assertDatabaseHas('newsletter_subscribers', [
        'id' => $subscriber->id,
        'status' => 'unsubscribed',
    ]);
});
