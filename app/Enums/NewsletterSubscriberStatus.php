<?php

namespace App\Enums;

enum NewsletterSubscriberStatus: string
{
    case Subscribed = 'subscribed';
    case Unsubscribed = 'unsubscribed';

    public function label(): string
    {
        return match ($this) {
            self::Subscribed => 'Subscribed',
            self::Unsubscribed => 'Unsubscribed',
        };
    }
}
