<?php

namespace App\Actions\Admin\Bookings;

use App\Enums\PackageBookingStatus;
use App\Models\PackageBooking;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ListPackageBookingsAction
{
    /** @return array<string, mixed> */
    public function handle(Request $request): array
    {
        $statusValue = $request->query('status');
        $selectedStatus = is_string($statusValue) ? PackageBookingStatus::tryFrom($statusValue) : null;
        $searchValue = $request->query('search');
        $search = is_string($searchValue) ? mb_substr(trim($searchValue), 0, 100) : '';

        $query = PackageBooking::query()
            ->with(['package', 'departure'])
            ->latest();

        if ($selectedStatus) {
            $query->where('status', $selectedStatus->value);
        }

        if ($search !== '') {
            $query->where(function (Builder $query) use ($search): void {
                $query
                    ->where('reference', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhereHas('package', fn (Builder $packageQuery) => $packageQuery->where('name', 'like', "%{$search}%"));
            });
        }

        $statusCounts = PackageBooking::query()
            ->selectRaw('status, count(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        return [
            'bookings' => $query->paginate(20)->withQueryString(),
            'statuses' => PackageBookingStatus::cases(),
            'statusClasses' => PackageBookingStatus::badgeClasses(),
            'selectedStatus' => $selectedStatus,
            'search' => $search,
            'bookingCount' => PackageBooking::query()->count(),
            'newCount' => (int) $statusCounts->get(PackageBookingStatus::New->value, 0),
            'processingCount' => (int) $statusCounts->get(PackageBookingStatus::Processing->value, 0),
            'confirmedCount' => (int) $statusCounts->get(PackageBookingStatus::Confirmed->value, 0),
            'canceledCount' => (int) $statusCounts->get(PackageBookingStatus::Canceled->value, 0),
        ];
    }
}
