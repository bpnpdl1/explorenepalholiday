<?php

namespace App\Actions\Newsletter;

use App\Enums\NewsletterSubscriberStatus;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\GoneHttpException;

class UnsubscribeFromNewsletterAction
{
    public function handle(NewsletterSubscriber $subscriber, string $token): void
    {
        DB::transaction(function () use ($subscriber, $token): void {
            $lockedSubscriber = NewsletterSubscriber::query()
                ->lockForUpdate()
                ->whereKey($subscriber->getKey())
                ->firstOrFail();

            if (! is_string($lockedSubscriber->unsubscribe_token)
                || ! hash_equals($lockedSubscriber->unsubscribe_token, $token)) {
                throw new GoneHttpException('This unsubscribe link is no longer current.');
            }

            if ($lockedSubscriber->status === NewsletterSubscriberStatus::Unsubscribed) {
                return;
            }

            $lockedSubscriber->status = NewsletterSubscriberStatus::Unsubscribed;
            $lockedSubscriber->unsubscribed_at = now();
            $lockedSubscriber->save();
        });
    }
}
