<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Bookings\UpdatePackageBookingStatusAction;
use App\Enums\PackageBookingStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdatePackageBookingStatusRequest;
use App\Models\PackageBooking;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /** @var array<string, string> */
    private const STATUS_CLASSES = [
        'new' => 'info',
        'processing' => 'warning',
        'confirmed' => 'success',
        'canceled' => 'danger',
    ];

    public function index(Request $request): View
    {
        $statusValue = $request->query('status');
        $selectedStatus = is_string($statusValue)
            ? PackageBookingStatus::tryFrom($statusValue)
            : null;
        $search = is_string($request->query('search'))
            ? mb_substr(trim($request->query('search')), 0, 100)
            : '';

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

        return view('admin.bookings.index', [
            'bookings' => $query->paginate(20)->withQueryString(),
            'statuses' => PackageBookingStatus::cases(),
            'statusClasses' => self::STATUS_CLASSES,
            'selectedStatus' => $selectedStatus,
            'search' => $search,
            'bookingCount' => PackageBooking::query()->count(),
            'newCount' => (int) $statusCounts->get(PackageBookingStatus::New->value, 0),
            'processingCount' => (int) $statusCounts->get(PackageBookingStatus::Processing->value, 0),
            'confirmedCount' => (int) $statusCounts->get(PackageBookingStatus::Confirmed->value, 0),
            'canceledCount' => (int) $statusCounts->get(PackageBookingStatus::Canceled->value, 0),
        ]);
    }

    public function show(PackageBooking $booking): View
    {
        $booking->load(['package', 'departure']);

        return view('admin.bookings.show', [
            'booking' => $booking,
            'statusClasses' => self::STATUS_CLASSES,
        ]);
    }

    public function updateStatus(
        UpdatePackageBookingStatusRequest $request,
        PackageBooking $booking,
        UpdatePackageBookingStatusAction $updateStatus,
    ): RedirectResponse {
        $updateStatus->handle(
            $booking,
            PackageBookingStatus::from($request->validated('status')),
        );

        return back()->with('success', 'Booking status updated.');
    }
}
