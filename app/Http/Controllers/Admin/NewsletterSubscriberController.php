<?php

namespace App\Http\Controllers\Admin;

use App\Enums\NewsletterSubscriberStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateNewsletterSubscriberStatusRequest;
use App\Models\NewsletterSubscriber;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NewsletterSubscriberController extends Controller
{
    public function index(Request $request): View
    {
        $statusValue = $request->query('status');
        $selectedStatus = is_string($statusValue) ? NewsletterSubscriberStatus::tryFrom($statusValue) : null;
        $search = is_string($request->query('search')) ? mb_substr(trim($request->query('search')), 0, 100) : '';

        $query = NewsletterSubscriber::query()->latest('subscribed_at');

        if ($selectedStatus) {
            $query->where('status', $selectedStatus->value);
        }

        if ($search !== '') {
            $query->where('email', 'like', "%{$search}%");
        }

        $statusCounts = NewsletterSubscriber::query()
            ->selectRaw('status, count(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        return view('admin.newsletter-subscribers.index', [
            'subscribers' => $query->paginate(25)->withQueryString(),
            'statuses' => NewsletterSubscriberStatus::cases(),
            'statusClasses' => [
                NewsletterSubscriberStatus::Subscribed->value => 'success',
                NewsletterSubscriberStatus::Unsubscribed->value => 'secondary',
            ],
            'selectedStatus' => $selectedStatus,
            'search' => $search,
            'subscriberCount' => NewsletterSubscriber::query()->count(),
            'subscribedCount' => (int) $statusCounts->get(NewsletterSubscriberStatus::Subscribed->value, 0),
            'unsubscribedCount' => (int) $statusCounts->get(NewsletterSubscriberStatus::Unsubscribed->value, 0),
        ]);
    }

    public function updateStatus(
        UpdateNewsletterSubscriberStatusRequest $request,
        NewsletterSubscriber $newsletterSubscriber,
    ): RedirectResponse {
        $status = NewsletterSubscriberStatus::from($request->validated('status'));

        $newsletterSubscriber->status = $status;
        $newsletterSubscriber->unsubscribed_at = $status === NewsletterSubscriberStatus::Unsubscribed ? now() : null;

        if ($status === NewsletterSubscriberStatus::Subscribed) {
            $newsletterSubscriber->subscribed_at = now();
        }

        $newsletterSubscriber->save();

        return back()->with('success', 'Newsletter subscription status updated.');
    }
}
