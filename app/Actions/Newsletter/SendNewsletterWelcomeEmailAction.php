<?php

namespace App\Actions\Newsletter;

use App\Mail\NewsletterWelcomeMail;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendNewsletterWelcomeEmailAction
{
    public function __construct(private readonly GenerateNewsletterUnsubscribeUrlAction $generateUnsubscribeUrl) {}

    public function handle(NewsletterSubscriber $subscriber): bool
    {
        try {
            Mail::to($subscriber->email)->send(
                new NewsletterWelcomeMail($this->generateUnsubscribeUrl->handle($subscriber)),
            );

            $subscriber->forceFill(['welcome_email_sent_at' => now()])->save();

            return true;
        } catch (Throwable $exception) {
            Log::warning('Newsletter welcome email could not be sent.', [
                'newsletter_subscriber_id' => $subscriber->id,
                'exception' => $exception,
            ]);

            return false;
        }
    }
}
