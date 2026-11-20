<?php

namespace App\Http\Controllers;

use App\Actions\Packages\StorePackageBookingAction;
use App\Http\Requests\StorePackageBookingRequest;
use App\Models\Package;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class PackageBookingController extends Controller
{
    public function create(Package $package, Request $request): View
    {
        abort_unless($package->is_published, 404);

        $package->load(['subcategory.category.destination', 'departures']);
        $selectedDeparture = $package->departures->firstWhere('id', $request->integer('departure_id'));
        $coverUrl = $package->getFirstMediaUrl('cover', 'card')
            ?: $package->getFirstMediaUrl('cover')
            ?: asset('site/assets/nepal-trail.jpg');

        return view('site.package-booking', compact('package', 'coverUrl', 'selectedDeparture'));
    }

    public function store(
        StorePackageBookingRequest $request,
        Package $package,
        StorePackageBookingAction $storeBooking,
    ): RedirectResponse {
        $booking = $storeBooking->handle($package, $request->validated());

        return redirect()->to(URL::temporarySignedRoute(
            'packages.bookings.thank-you',
            now()->addDays(7),
            ['package' => $package, 'reference' => $booking->reference],
        ));
    }

    public function thankYou(Package $package, string $reference): View
    {
        abort_unless($package->is_published, 404);

        $booking = $package->bookings()
            ->with('departure')
            ->where('reference', $reference)
            ->firstOrFail();
        $package->load('subcategory.category.destination');
        $coverUrl = $package->getFirstMediaUrl('cover', 'card')
            ?: $package->getFirstMediaUrl('cover')
            ?: asset('site/assets/nepal-trail.jpg');

        return view('site.package-booking-thank-you', compact('booking', 'package', 'coverUrl'));
    }
}
