<?php

namespace App\Actions\Admin\Dashboard;

use App\Enums\NewsletterSubscriberStatus;
use App\Enums\PackageBookingStatus;
use App\Enums\PackageInquiryStatus;
use App\Models\GuestReview;
use App\Models\NewsletterSubscriber;
use App\Models\Package;
use App\Models\PackageBooking;
use App\Models\PackageInquiry;
use App\Models\SiteInquiry;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class BuildAdminDashboardDataAction
{
    /** @return array<string, mixed> */
    public function handle(): array
    {
        $monthStart = now()->startOfMonth();
        $nextMonth = $monthStart->copy()->addMonth();
        $bookingCount = PackageBooking::query()->count();
        $bookingsThisMonth = PackageBooking::query()
            ->where('created_at', '>=', $monthStart)
            ->where('created_at', '<', $nextMonth)
            ->count();

        $packageInquiryCount = PackageInquiry::query()->count();
        $siteInquiryCount = SiteInquiry::query()->count();
        $inquiriesThisMonth = PackageInquiry::query()
            ->where('created_at', '>=', $monthStart)
            ->where('created_at', '<', $nextMonth)
            ->count()
            + SiteInquiry::query()
                ->where('created_at', '>=', $monthStart)
                ->where('created_at', '<', $nextMonth)
                ->count();
        $newInquiryCount = PackageInquiry::query()->where('status', PackageInquiryStatus::New)->count()
            + SiteInquiry::query()->where('status', PackageInquiryStatus::New)->count();

        $publishedPackageCount = Package::query()->where('is_published', true)->count();
        $packagesAddedThisMonth = Package::query()
            ->where('is_published', true)
            ->where('created_at', '>=', $monthStart)
            ->where('created_at', '<', $nextMonth)
            ->count();

        $activeSubscriberCount = NewsletterSubscriber::query()
            ->where('status', NewsletterSubscriberStatus::Subscribed)
            ->count();
        $subscribersThisMonth = NewsletterSubscriber::query()
            ->where('status', NewsletterSubscriberStatus::Subscribed)
            ->where('subscribed_at', '>=', $monthStart)
            ->where('subscribed_at', '<', $nextMonth)
            ->count();

        $months = collect(range(5, 0))
            ->map(fn (int $offset): CarbonInterface => $monthStart->copy()->subMonths($offset));

        $bookingsByMonth = $this->countByMonth(PackageBooking::query(), $months);
        $packageInquiriesByMonth = $this->countByMonth(PackageInquiry::query(), $months);
        $siteInquiriesByMonth = $this->countByMonth(SiteInquiry::query(), $months);

        $bookingStatusCounts = PackageBooking::query()
            ->selectRaw('status, count(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status')
            ->map(fn ($count): int => (int) $count)
            ->all();

        $recentPackageInquiries = PackageInquiry::query()
            ->with('package:id,name')
            ->latest('created_at')
            ->latest('id')
            ->limit(5)
            ->get()
            ->map(fn (PackageInquiry $inquiry): array => [
                'id' => $inquiry->id,
                'source' => 'package',
                'name' => $inquiry->customer_name,
                'email' => $inquiry->email,
                'subject' => $inquiry->package?->name ?? 'Package removed',
                'created_at' => $inquiry->created_at,
                'status' => $inquiry->status->label(),
                'status_class' => PackageInquiryStatus::badgeClasses()[$inquiry->status->value],
            ]);

        $recentSiteInquiries = SiteInquiry::query()
            ->latest('created_at')
            ->latest('id')
            ->limit(5)
            ->get()
            ->map(fn (SiteInquiry $inquiry): array => [
                'id' => $inquiry->id,
                'source' => 'website',
                'name' => $inquiry->name,
                'email' => $inquiry->email,
                'subject' => $inquiry->interest ?: 'General question',
                'created_at' => $inquiry->created_at,
                'status' => $inquiry->status->label(),
                'status_class' => PackageInquiryStatus::badgeClasses()[$inquiry->status->value],
            ]);

        return [
            'stats' => [
                'bookings' => [
                    'label' => 'Total bookings',
                    'value' => $bookingCount,
                    'change' => $bookingsThisMonth.' this month',
                    'period' => 'All recorded bookings',
                    'icon' => 'ri-calendar-check-line',
                    'tone' => 'primary',
                ],
                'inquiries' => [
                    'label' => 'New inquiries',
                    'value' => $newInquiryCount,
                    'change' => $inquiriesThisMonth.' received this month',
                    'period' => 'Awaiting follow-up',
                    'icon' => 'ri-question-answer-line',
                    'tone' => 'info',
                ],
                'packages' => [
                    'label' => 'Published packages',
                    'value' => $publishedPackageCount,
                    'change' => $packagesAddedThisMonth.' added this month',
                    'period' => 'Live on website',
                    'icon' => 'ri-map-2-line',
                    'tone' => 'success',
                ],
                'subscribers' => [
                    'label' => 'Newsletter subscribers',
                    'value' => $activeSubscriberCount,
                    'change' => $subscribersThisMonth.' joined this month',
                    'period' => 'Active subscribers',
                    'icon' => 'ri-mail-line',
                    'tone' => 'warning',
                ],
            ],
            'chart' => [
                'labels' => $months->map(fn (CarbonInterface $month): string => $month->format('M Y'))->all(),
                'bookings' => array_values($bookingsByMonth),
                'inquiries' => collect($packageInquiriesByMonth)
                    ->map(fn (int $packageCount, int $index): int => $packageCount + ($siteInquiriesByMonth[$index] ?? 0))
                    ->values()
                    ->all(),
            ],
            'bookingStatusCounts' => $bookingStatusCounts,
            'bookingStatuses' => PackageBookingStatus::cases(),
            'bookingStatusClasses' => PackageBookingStatus::badgeClasses(),
            'bookingCount' => $bookingCount,
            'inquiryCount' => $packageInquiryCount + $siteInquiryCount,
            'recentBookings' => PackageBooking::query()
                ->with('package:id,name')
                ->latest('created_at')
                ->latest('id')
                ->limit(6)
                ->get(),
            'recentInquiries' => $recentPackageInquiries
                ->concat($recentSiteInquiries)
                ->sortByDesc('created_at')
                ->take(6)
                ->values(),
            'popularPackages' => Package::query()
                ->select(['id', 'name', 'slug', 'duration_days'])
                ->withCount('bookings')
                ->whereHas('bookings')
                ->orderByDesc('bookings_count')
                ->orderBy('name')
                ->limit(5)
                ->get(),
            'averageReviewRating' => GuestReview::query()->avg('rating'),
        ];
    }

    /** @param Collection<int, CarbonInterface> $months
     * @return array<int, int>
     */
    private function countByMonth(Builder $query, Collection $months): array
    {
        $selects = [];
        $bindings = [];

        foreach ($months as $index => $month) {
            $selects[] = "SUM(CASE WHEN created_at >= ? AND created_at < ? THEN 1 ELSE 0 END) as month_{$index}";
            $bindings[] = $month->copy()->startOfMonth();
            $bindings[] = $month->copy()->addMonth()->startOfMonth();
        }

        $counts = $query
            ->where('created_at', '>=', $months->first()->copy()->startOfMonth())
            ->where('created_at', '<', $months->last()->copy()->addMonth()->startOfMonth())
            ->selectRaw(implode(', ', $selects), $bindings)
            ->first();

        return $months->mapWithKeys(fn (CarbonInterface $month, int $index): array => [
            $index => (int) ($counts?->{'month_'.$index} ?? 0),
        ])->all();
    }
}
