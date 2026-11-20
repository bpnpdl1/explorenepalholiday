<?php

namespace App\Actions\Packages;

use App\Enums\PackageBookingStatus;
use App\Models\Package;
use App\Models\PackageBooking;
use Illuminate\Support\Str;

class StorePackageBookingAction
{
    /** @param array<string, mixed> $validated */
    public function handle(Package $package, array $validated): PackageBooking
    {
        $travelDate = $validated['travel_date'];
        $departure = $package->departures()
            ->whereDate('starts_on', '<=', $travelDate)
            ->where(function ($query) use ($travelDate): void {
                $query->whereDate('ends_on', '>=', $travelDate)
                    ->orWhere(function ($query) use ($travelDate): void {
                        $query->whereNull('ends_on')
                            ->whereDate('starts_on', '=', $travelDate);
                    });
            })
            ->first();

        return $package->bookings()->create([
            'customer_name' => $validated['customer_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'country_of_residence' => $validated['country_of_residence'] ?? null,
            'travel_date' => $travelDate,
            'guests' => $validated['guests'],
            'special_requests' => $validated['special_requests'] ?? null,
            'reference' => 'ENH-'.Str::upper(Str::random(10)),
            'package_departure_id' => $departure?->id,
            'status' => PackageBookingStatus::New,
            'currency' => $departure?->currency ?: $package->currency ?: 'USD',
        ]);
    }
}
