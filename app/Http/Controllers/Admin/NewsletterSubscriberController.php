<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\NewsletterSubscribers\ExportNewsletterSubscribersXlsxAction;
use App\Actions\Admin\NewsletterSubscribers\QueryNewsletterSubscribersAction;
use App\Actions\Admin\NewsletterSubscribers\UpdateNewsletterSubscriberStatusAction;
use App\Enums\NewsletterSubscriberStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateNewsletterSubscriberStatusRequest;
use App\Models\NewsletterSubscriber;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class NewsletterSubscriberController extends Controller
{
    public function index(Request $request, QueryNewsletterSubscribersAction $querySubscribers): View
    {
        $selectedStatus = $this->selectedStatus($request);
        $search = $this->searchTerm($request);
        $query = $querySubscribers->handle($request);

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

    public function export(
        Request $request,
        QueryNewsletterSubscribersAction $querySubscribers,
        ExportNewsletterSubscribersXlsxAction $export,
    ): BinaryFileResponse {
        $path = $export->handle($querySubscribers->handle($request));

        return response()->download(
            $path,
            'newsletter-subscribers-'.now()->format('Ymd-His').'.xlsx',
            ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
        )->deleteFileAfterSend(true);
    }

    public function updateStatus(
        UpdateNewsletterSubscriberStatusRequest $request,
        NewsletterSubscriber $newsletterSubscriber,
        UpdateNewsletterSubscriberStatusAction $updateStatus,
    ): RedirectResponse {
        $updateStatus->handle($newsletterSubscriber, NewsletterSubscriberStatus::from($request->validated('status')));

        return back()->with('success', 'Newsletter subscription status updated.');
    }

    private function selectedStatus(Request $request): ?NewsletterSubscriberStatus
    {
        $statusValue = $request->query('status');

        return is_string($statusValue) ? NewsletterSubscriberStatus::tryFrom($statusValue) : null;
    }

    private function searchTerm(Request $request): string
    {
        $search = $request->query('search');

        return is_string($search) ? mb_substr(trim($search), 0, 100) : '';
    }
}
