<?php

namespace App\Actions\Admin\NewsletterSubscribers;

use App\Enums\NewsletterSubscriberStatus;
use App\Models\NewsletterSubscriber;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class QueryNewsletterSubscribersAction
{
    public function handle(Request $request): Builder
    {
        $query = NewsletterSubscriber::query()->latest('subscribed_at');
        $statusValue = $request->query('status');
        $searchValue = $request->query('search');

        if (is_string($statusValue) && $status = NewsletterSubscriberStatus::tryFrom($statusValue)) {
            $query->where('status', $status->value);
        }

        if (is_string($searchValue) && ($search = mb_substr(trim($searchValue), 0, 100)) !== '') {
            $query->where('email', 'like', "%{$search}%");
        }

        return $query;
    }
}
