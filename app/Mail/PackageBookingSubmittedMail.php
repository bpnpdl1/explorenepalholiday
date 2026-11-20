<?php

namespace App\Mail;

use App\Models\PackageBooking;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class PackageBookingSubmittedMail extends Mailable
{
    public function __construct(
        public readonly PackageBooking $booking,
        public readonly bool $adminAlert = false,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->adminAlert
                ? 'New booking request '.$this->booking->reference
                : 'We received your booking request '.$this->booking->reference,
            replyTo: $this->adminAlert
                ? [new Address($this->booking->email, $this->booking->customer_name)]
                : [],
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.submissions.package-booking');
    }
}
