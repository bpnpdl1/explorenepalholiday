<?php

namespace App\Actions\Newsletter;

use App\Enums\NewsletterSubscriberStatus;
use App\Models\NewsletterSubscriber;

class SubscribeToNewsletterAction
{
    public function handle(string $email): NewsletterSubscriber
    {
        $subscriber = NewsletterSubscriber::query()->firstOrNew(['email' => $email]);

        if (! $subscriber->exists || $subscriber->status !== NewsletterSubscriberStatus::Subscribed) {
            $subscriber->status = NewsletterSubscriberStatus::Subscribed;
            $subscriber->subscribed_at = now();
            $subscriber->unsubscribed_at = null;
            $subscriber->consented_at = now();
            $subscriber->save();
        }

        return $subscriber;
    }
}
