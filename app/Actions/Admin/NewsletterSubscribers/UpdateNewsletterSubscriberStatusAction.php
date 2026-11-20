<?php

namespace App\Actions\Admin\NewsletterSubscribers;

use App\Enums\NewsletterSubscriberStatus;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Str;

class UpdateNewsletterSubscriberStatusAction
{
    public function handle(NewsletterSubscriber $subscriber, NewsletterSubscriberStatus $status): void
    {
        $subscriber->status = $status;
        $subscriber->unsubscribed_at = $status === NewsletterSubscriberStatus::Unsubscribed ? now() : null;

        if ($status === NewsletterSubscriberStatus::Subscribed) {
            $subscriber->subscribed_at = now();
            $subscriber->unsubscribe_token = Str::random(64);
            $subscriber->welcome_email_sent_at = null;
        }

        $subscriber->save();
    }
}
