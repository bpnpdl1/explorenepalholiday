<?php

use App\Models\NewsletterSubscriber;

test('visitor subscribes with normalized email and stored consent', function () {
    $this->post(route('newsletter.subscriptions.store'), [
        'newsletter_email' => '  Alex@Example.test ',
        'consent' => '1',
    ])->assertRedirect(route('home').'#newsletter')
        ->assertSessionHas('newsletter_subscribed', true);

    $subscriber = NewsletterSubscriber::query()->firstOrFail();

    expect($subscriber->email)->toBe('alex@example.test')
        ->and($subscriber->status->value)->toBe('subscribed')
        ->and($subscriber->consented_at)->not->toBeNull();
});

test('newsletter subscription requires valid email and consent', function () {
    $this->from(route('home'))->post(route('newsletter.subscriptions.store'), [
        'email' => 'invalid',
        'consent' => '0',
    ])->assertSessionHasErrors(['email', 'consent']);

    expect(NewsletterSubscriber::query()->count())->toBe(0);
});

test('a previously unsubscribed visitor can subscribe again', function () {
    NewsletterSubscriber::query()->create([
        'email' => 'alex@example.test',
        'status' => 'unsubscribed',
        'subscribed_at' => now()->subMonth(),
        'unsubscribed_at' => now()->subDay(),
        'consented_at' => now()->subMonth(),
    ]);

    $this->post(route('newsletter.subscriptions.store'), [
        'email' => 'ALEX@example.test',
        'consent' => '1',
    ])->assertRedirect(route('home').'#newsletter');

    expect(NewsletterSubscriber::query()->count())->toBe(1)
        ->and(NewsletterSubscriber::query()->firstOrFail()->status->value)->toBe('subscribed')
        ->and(NewsletterSubscriber::query()->firstOrFail()->unsubscribed_at)->toBeNull();
});
