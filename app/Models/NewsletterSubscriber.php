<?php

namespace App\Models;

use App\Enums\NewsletterSubscriberStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['email', 'status', 'subscribed_at', 'unsubscribed_at', 'consented_at'])]
class NewsletterSubscriber extends Model
{
    protected function casts(): array
    {
        return [
            'status' => NewsletterSubscriberStatus::class,
            'subscribed_at' => 'datetime',
            'unsubscribed_at' => 'datetime',
            'consented_at' => 'datetime',
        ];
    }
}
