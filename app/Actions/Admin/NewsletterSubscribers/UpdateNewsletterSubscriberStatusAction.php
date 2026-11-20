<?php

namespace App\Actions\Admin\NewsletterSubscribers;

use App\Enums\NewsletterSubscriberStatus;
use App\Models\NewsletterSubscriber;

class UpdateNewsletterSubscriberStatusAction
{
    public function handle(NewsletterSubscriber $subscriber, NewsletterSubscriberStatus $status): void
    {
        $subscriber->status = $status;
        $subscriber->unsubscribed_at = $status === NewsletterSubscriberStatus::Unsubscribed ? now() : null;

        if ($status === NewsletterSubscriberStatus::Subscribed) {
            $subscriber->subscribed_at = now();
        }

        $subscriber->save();
    }
}
