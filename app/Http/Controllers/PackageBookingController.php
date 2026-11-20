<?php

namespace App\Http\Controllers;

use App\Actions\Packages\StorePackageBookingAction;
use App\Http\Requests\StorePackageBookingRequest;
use App\Models\Package;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PackageBookingController extends Controller
{
    public function create(Package $package): View
    {
        abort_unless($package->is_published, 404);

        $package->load(['subcategory.category.destination', 'departures']);
        $coverUrl = $package->getFirstMediaUrl('cover', 'card')
            ?: $package->getFirstMediaUrl('cover')
            ?: asset('site/assets/nepal-trail.jpg');
        return view('site.package-booking', compact('package', 'coverUrl'));
    }

    public function store(
        StorePackageBookingRequest $request,
        Package $package,
        StorePackageBookingAction $storeBooking,
    ): RedirectResponse {
        $booking = $storeBooking->handle($package, $request->validated());

        if ($request->input('booking_source') === 'package') {
            return redirect()
                ->route('packages.show', $package)
                ->with('booking_reference', $booking->reference);
        }

        return redirect()
            ->route('packages.bookings.create', $package)
            ->with('booking_reference', $booking->reference);
    }
}
