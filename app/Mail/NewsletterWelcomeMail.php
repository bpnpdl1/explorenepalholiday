<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class NewsletterWelcomeMail extends Mailable
{
    public function __construct(public readonly string $unsubscribeUrl) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Welcome to '.config('app.name').' travel updates');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.newsletter.welcome');
    }
}
