<?php

namespace App\Http\Controllers;

use App\Actions\Newsletter\SendNewsletterWelcomeEmailAction;
use App\Actions\Newsletter\SubscribeToNewsletterAction;
use App\Actions\Newsletter\UnsubscribeFromNewsletterAction;
use App\Enums\NewsletterSubscriberStatus;
use App\Http\Requests\StoreNewsletterSubscriptionRequest;
use App\Models\NewsletterSubscriber;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class NewsletterSubscriptionController extends Controller
{
    public function store(
        StoreNewsletterSubscriptionRequest $request,
        SubscribeToNewsletterAction $subscribeToNewsletter,
        SendNewsletterWelcomeEmailAction $sendWelcomeEmail,
    ): RedirectResponse {
        $result = $subscribeToNewsletter->handle($request->validated('email'));
        $response = redirect()->to(route('home').'#newsletter')
            ->with('newsletter_subscribed', true);

        if ($result->shouldSendWelcomeEmail && ! $sendWelcomeEmail->handle($result->subscriber)) {
            $response->with('newsletter_welcome_email_failed', true);
        }

        return $response;
    }

    public function confirmUnsubscribe(NewsletterSubscriber $newsletterSubscriber, string $token, Request $request): View
    {
        abort_unless($this->isCurrentToken($newsletterSubscriber, $token), 410);

        return view('site.newsletter-unsubscribe', [
            'isSubscribed' => $newsletterSubscriber->status === NewsletterSubscriberStatus::Subscribed,
            'unsubscribeUrl' => $request->fullUrl(),
        ]);
    }

    public function unsubscribe(
        NewsletterSubscriber $newsletterSubscriber,
        string $token,
        Request $request,
        UnsubscribeFromNewsletterAction $unsubscribe,
    ): RedirectResponse {
        $unsubscribe->handle($newsletterSubscriber, $token);

        $confirmationUrl = URL::signedRoute('newsletter.unsubscribe.show', [
            'newsletterSubscriber' => $newsletterSubscriber,
            'token' => $token,
        ]);

        return redirect()->to($confirmationUrl)->with('newsletter_unsubscribed', true);
    }

    private function isCurrentToken(NewsletterSubscriber $subscriber, string $token): bool
    {
        return is_string($subscriber->unsubscribe_token)
            && hash_equals($subscriber->unsubscribe_token, $token);
    }
}
