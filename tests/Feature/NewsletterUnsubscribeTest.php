<?php

use App\Enums\NewsletterSubscriberStatus;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

function createSignedNewsletterSubscriber(): NewsletterSubscriber
{
    $subscriber = NewsletterSubscriber::query()->create([
        'email' => 'alex@example.test',
        'status' => NewsletterSubscriberStatus::Subscribed,
        'subscribed_at' => now(),
        'consented_at' => now(),
    ]);
    $subscriber->unsubscribe_token = Str::random(64);
    $subscriber->save();

    return $subscriber;
}

function newsletterUnsubscribeUrl(NewsletterSubscriber $subscriber): string
{
    return URL::signedRoute('newsletter.unsubscribe.show', [
        'newsletterSubscriber' => $subscriber,
        'token' => $subscriber->unsubscribe_token,
    ]);
}

test('signed unsubscribe link shows confirmation without changing subscription', function () {
    $this->freezeTime();
    $subscriber = createSignedNewsletterSubscriber();

    $this->get(newsletterUnsubscribeUrl($subscriber))
        ->assertOk()
        ->assertViewIs('site.newsletter-unsubscribe')
        ->assertSee('Unsubscribe from travel emails?')
        ->assertSee('Unsubscribe from newsletter');

    expect($subscriber->refresh()->status)->toBe(NewsletterSubscriberStatus::Subscribed);
});

test('subscriber can unsubscribe and sees the saved preference', function () {
    $this->freezeTime();

    $subscriber = createSignedNewsletterSubscriber();
    $unsubscribeUrl = newsletterUnsubscribeUrl($subscriber);

    $this->post($unsubscribeUrl)
        ->assertRedirect($unsubscribeUrl)
        ->assertSessionHas('newsletter_unsubscribed', true);

    expect($subscriber->refresh()->status)->toBe(NewsletterSubscriberStatus::Unsubscribed)
        ->and($subscriber->unsubscribed_at?->timestamp)->toBe(now()->timestamp);

    $this->get($unsubscribeUrl)
        ->assertOk()
        ->assertSee('You are already unsubscribed')
        ->assertDontSee('Unsubscribe from newsletter');
});

test('unsigned and stale unsubscribe links cannot change the current subscription', function () {
    $this->freezeTime();
    $subscriber = createSignedNewsletterSubscriber();
    $oldUnsubscribeUrl = newsletterUnsubscribeUrl($subscriber);

    $this->post(route('newsletter.unsubscribe.destroy', [
        'newsletterSubscriber' => $subscriber,
        'token' => $subscriber->unsubscribe_token,
    ]))->assertForbidden();

    $subscriber->update([
        'status' => NewsletterSubscriberStatus::Unsubscribed,
        'unsubscribed_at' => now(),
    ]);
    $this->travelTo(now()->addSecond());

    $this->post(route('newsletter.subscriptions.store'), [
        'email' => $subscriber->email,
        'consent' => '1',
    ])->assertRedirect();

    $this->get($oldUnsubscribeUrl)->assertGone();
    expect($subscriber->refresh()->status)->toBe(NewsletterSubscriberStatus::Subscribed);
});
