<?php

namespace App\Actions\Newsletter;

use App\Enums\NewsletterSubscriberStatus;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Str;

class SubscribeToNewsletterAction
{
    public function handle(string $email): NewsletterSubscriptionResult
    {
        $subscriber = NewsletterSubscriber::query()->firstOrNew(['email' => $email]);
        $shouldSendWelcomeEmail = ! $subscriber->exists
            || $subscriber->status !== NewsletterSubscriberStatus::Subscribed
            || $subscriber->welcome_email_sent_at === null
            || blank($subscriber->unsubscribe_token);

        if (! $subscriber->exists || $subscriber->status !== NewsletterSubscriberStatus::Subscribed) {
            $subscriber->status = NewsletterSubscriberStatus::Subscribed;
            $subscriber->subscribed_at = now();
            $subscriber->unsubscribed_at = null;
            $subscriber->consented_at = now();
            $subscriber->unsubscribe_token = Str::random(64);
            $subscriber->welcome_email_sent_at = null;
            $subscriber->save();
        } elseif (blank($subscriber->unsubscribe_token)) {
            // Give active subscribers created before the unsubscribe workflow a valid link.
            $subscriber->unsubscribe_token = Str::random(64);
            $subscriber->save();
        }

        return new NewsletterSubscriptionResult($subscriber, $shouldSendWelcomeEmail);
    }
}
