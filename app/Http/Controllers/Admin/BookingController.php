<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Bookings\ListPackageBookingsAction;
use App\Actions\Admin\Bookings\UpdatePackageBookingStatusAction;
use App\Enums\PackageBookingStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdatePackageBookingStatusRequest;
use App\Models\PackageBooking;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request, ListPackageBookingsAction $listBookings): View
    {
        return view('admin.bookings.index', $listBookings->handle($request));
    }

    public function show(PackageBooking $booking): View
    {
        $booking->load(['package', 'departure', 'logs.user']);

        return view('admin.bookings.show', [
            'booking' => $booking,
            'statusClasses' => PackageBookingStatus::badgeClasses(),
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
            $request->validated('note'),
        );

        return back()->with('success', 'Booking status updated.');
    }
}
