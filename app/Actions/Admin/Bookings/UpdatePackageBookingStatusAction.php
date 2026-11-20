<?php

namespace App\Actions\Admin\Bookings;

use App\Enums\PackageBookingStatus;
use App\Enums\PackageBookingLogEvent;
use App\Models\PackageBooking;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class UpdatePackageBookingStatusAction
{
    public function handle(PackageBooking $booking, PackageBookingStatus $status, ?string $note = null): PackageBooking
    {
        return DB::transaction(function () use ($booking, $status, $note): PackageBooking {
            $lockedBooking = PackageBooking::query()
                ->lockForUpdate()
                ->findOrFail($booking->getKey());

            if (! $lockedBooking->status->canTransitionTo($status)) {
                throw ValidationException::withMessages([
                    'status' => 'That status change is not allowed from '.$lockedBooking->status->label().'.',
                ]);
            }

            $previousStatus = $lockedBooking->status;
            $lockedBooking->status = $status;
            $lockedBooking->save();

            $lockedBooking->logs()->create([
                'user_id' => auth()->id(),
                'event' => PackageBookingLogEvent::StatusChanged,
                'from_status' => $previousStatus,
                'to_status' => $status,
                'note' => $note,
            ]);

            return $lockedBooking;
        });
    }
}
