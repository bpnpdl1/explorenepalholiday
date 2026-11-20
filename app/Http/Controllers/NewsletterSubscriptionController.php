<?php

namespace App\Http\Controllers;

use App\Enums\NewsletterSubscriberStatus;
use App\Http\Requests\StoreNewsletterSubscriptionRequest;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\RedirectResponse;

class NewsletterSubscriptionController extends Controller
{
    public function store(StoreNewsletterSubscriptionRequest $request): RedirectResponse
    {
        $subscriber = NewsletterSubscriber::query()->firstOrNew([
            'email' => $request->validated('email'),
        ]);

        if (! $subscriber->exists || $subscriber->status !== NewsletterSubscriberStatus::Subscribed) {
            $subscriber->status = NewsletterSubscriberStatus::Subscribed;
            $subscriber->subscribed_at = now();
            $subscriber->unsubscribed_at = null;
            $subscriber->consented_at = now();
            $subscriber->save();
        }

        return redirect()->to(route('home').'#newsletter')
            ->with('newsletter_subscribed', true);
    }
}
