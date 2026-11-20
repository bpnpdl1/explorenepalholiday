<?php

namespace App\Actions\Admin\Bookings;

use App\Enums\PackageBookingStatus;
use App\Models\PackageBooking;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class UpdatePackageBookingStatusAction
{
    public function handle(PackageBooking $booking, PackageBookingStatus $status): PackageBooking
    {
        return DB::transaction(function () use ($booking, $status): PackageBooking {
            $lockedBooking = PackageBooking::query()
                ->lockForUpdate()
                ->findOrFail($booking->getKey());

            if (! $lockedBooking->status->canTransitionTo($status)) {
                throw ValidationException::withMessages([
                    'status' => 'That status change is not allowed from '.$lockedBooking->status->label().'.',
                ]);
            }

            $lockedBooking->status = $status;
            $lockedBooking->save();

            return $lockedBooking;
        });
    }
}
