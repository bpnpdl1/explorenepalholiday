<?php

namespace App\Mail;

use App\Models\PackageInquiry;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class PackageInquirySubmittedMail extends Mailable
{
    public function __construct(
        public readonly PackageInquiry $inquiry,
        public readonly bool $adminAlert = false,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->adminAlert
                ? 'New package inquiry #'.$this->inquiry->id
                : 'We received your package inquiry',
            replyTo: $this->adminAlert
                ? [new Address($this->inquiry->email, $this->inquiry->customer_name)]
                : [],
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.submissions.package-inquiry');
    }
}
