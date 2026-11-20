<?php

namespace App\Http\Controllers;

use App\Actions\Newsletter\SubscribeToNewsletterAction;
use App\Http\Requests\StoreNewsletterSubscriptionRequest;
use Illuminate\Http\RedirectResponse;

class NewsletterSubscriptionController extends Controller
{
    public function store(
        StoreNewsletterSubscriptionRequest $request,
        SubscribeToNewsletterAction $subscribeToNewsletter,
    ): RedirectResponse {
        $subscribeToNewsletter->handle($request->validated('email'));

        return redirect()->to(route('home').'#newsletter')
            ->with('newsletter_subscribed', true);
    }
}
