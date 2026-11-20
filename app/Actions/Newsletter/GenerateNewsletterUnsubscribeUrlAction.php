<?php

namespace App\Actions\Newsletter;

use App\Enums\NewsletterSubscriberStatus;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use LogicException;

class GenerateNewsletterUnsubscribeUrlAction
{
    public function handle(NewsletterSubscriber $subscriber): string
    {
        if ($subscriber->status !== NewsletterSubscriberStatus::Subscribed) {
            throw new LogicException('An unsubscribe URL can only be generated for a subscribed contact.');
        }

        if (blank($subscriber->unsubscribe_token)) {
            $subscriber->unsubscribe_token = Str::random(64);
            $subscriber->save();
        }

        return URL::signedRoute('newsletter.unsubscribe.show', [
            'newsletterSubscriber' => $subscriber,
            'token' => $subscriber->unsubscribe_token,
        ]);
    }
}
