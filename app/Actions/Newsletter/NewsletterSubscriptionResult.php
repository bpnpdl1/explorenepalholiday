<?php

namespace App\Actions\Newsletter;

use App\Models\NewsletterSubscriber;

final readonly class NewsletterSubscriptionResult
{
    public function __construct(
        public NewsletterSubscriber $subscriber,
        public bool $shouldSendWelcomeEmail,
    ) {}
}
