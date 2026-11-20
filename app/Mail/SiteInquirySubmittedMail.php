<?php

namespace App\Mail;

use App\Models\SiteInquiry;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class SiteInquirySubmittedMail extends Mailable
{
    public function __construct(
        public readonly SiteInquiry $inquiry,
        public readonly bool $adminAlert = false,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->adminAlert
                ? 'New website inquiry #'.$this->inquiry->id
                : 'We received your travel inquiry',
            replyTo: $this->adminAlert
                ? [new Address($this->inquiry->email, $this->inquiry->name)]
                : [],
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.submissions.site-inquiry');
    }
}
