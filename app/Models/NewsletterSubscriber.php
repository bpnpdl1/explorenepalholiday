<?php

namespace App\Models;

use App\Enums\NewsletterSubscriberStatus;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $email
 * @property NewsletterSubscriberStatus $status
 * @property CarbonInterface|null $subscribed_at
 * @property CarbonInterface|null $unsubscribed_at
 * @property CarbonInterface $consented_at
 * @property string|null $unsubscribe_token
 * @property CarbonInterface|null $welcome_email_sent_at
 */
#[Fillable(['email', 'status', 'subscribed_at', 'unsubscribed_at', 'consented_at'])]
#[Hidden(['unsubscribe_token'])]
class NewsletterSubscriber extends Model
{
    protected function casts(): array
    {
        return [
            'status' => NewsletterSubscriberStatus::class,
            'subscribed_at' => 'datetime',
            'unsubscribed_at' => 'datetime',
            'consented_at' => 'datetime',
            'unsubscribe_token' => 'encrypted',
            'welcome_email_sent_at' => 'datetime',
        ];
    }
}
