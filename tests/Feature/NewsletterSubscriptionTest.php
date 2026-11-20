<?php

use App\Mail\NewsletterWelcomeMail;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use RuntimeException;

test('visitor subscribes with normalized email and stored consent', function () {
    Mail::fake();

    $this->post(route('newsletter.subscriptions.store'), [
        'newsletter_email' => '  Alex@Example.test ',
        'consent' => '1',
    ])->assertRedirect(route('home').'#newsletter')
        ->assertSessionHas('newsletter_subscribed', true);

    $subscriber = NewsletterSubscriber::query()->firstOrFail();

    expect($subscriber->email)->toBe('alex@example.test')
        ->and($subscriber->status->value)->toBe('subscribed')
        ->and($subscriber->consented_at)->not->toBeNull()
        ->and($subscriber->welcome_email_sent_at)->not->toBeNull();

    Mail::assertSent(
        NewsletterWelcomeMail::class,
        fn (NewsletterWelcomeMail $mail): bool => $mail->hasTo('alex@example.test')
            && str_contains($mail->unsubscribeUrl, '/newsletter/unsubscribe/'),
    );
});

test('newsletter subscription requires valid email and consent', function () {
    Mail::fake();

    $this->from(route('home'))->post(route('newsletter.subscriptions.store'), [
        'email' => 'invalid',
        'consent' => '0',
    ])->assertSessionHasErrors(['email', 'consent']);

    expect(NewsletterSubscriber::query()->count())->toBe(0);
    Mail::assertNothingOutgoing();
});

test('a previously unsubscribed visitor can subscribe again', function () {
    Mail::fake();

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
        ->and(NewsletterSubscriber::query()->firstOrFail()->unsubscribed_at)->toBeNull()
        ->and(NewsletterSubscriber::query()->firstOrFail()->welcome_email_sent_at)->not->toBeNull();

    Mail::assertSent(NewsletterWelcomeMail::class);
});

test('an already-subscribed visitor does not receive duplicate welcome emails', function () {
    Mail::fake();
    $subscriber = NewsletterSubscriber::query()->create([
        'email' => 'alex@example.test',
        'status' => 'subscribed',
        'subscribed_at' => now(),
        'consented_at' => now(),
    ]);
    $subscriber->forceFill([
        'unsubscribe_token' => Str::random(64),
        'welcome_email_sent_at' => now(),
    ])->save();

    $this->post(route('newsletter.subscriptions.store'), [
        'email' => 'alex@example.test',
        'consent' => '1',
    ])->assertRedirect(route('home').'#newsletter');

    Mail::assertNothingOutgoing();
});

test('welcome email renders the subscriber-specific unsubscribe link', function () {
    $unsubscribeUrl = 'https://explorenepalholidays.test/newsletter/unsubscribe/1/token?signature=test';

    expect((new NewsletterWelcomeMail($unsubscribeUrl))->render())
        ->toContain($unsubscribeUrl);
});

test('subscription remains saved and reports a warning when smtp delivery fails', function () {
    Mail::shouldReceive('to')
        ->once()
        ->with('alex@example.test')
        ->andThrow(new RuntimeException('SMTP is unavailable.'));

    $this->post(route('newsletter.subscriptions.store'), [
        'email' => 'alex@example.test',
        'consent' => '1',
    ])->assertRedirect(route('home').'#newsletter')
        ->assertSessionHas('newsletter_subscribed', true)
        ->assertSessionHas('newsletter_welcome_email_failed', true);

    $subscriber = NewsletterSubscriber::query()->firstOrFail();
    expect($subscriber->status->value)->toBe('subscribed')
        ->and($subscriber->consented_at)->not->toBeNull()
        ->and($subscriber->welcome_email_sent_at)->toBeNull();
});
