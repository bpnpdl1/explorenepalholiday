<?php

namespace App\Models;

use App\Enums\PackageBookingStatus;
use App\Enums\PackageBookingLogEvent;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'package_booking_id',
    'user_id',
    'event',
    'from_status',
    'to_status',
    'note',
    'created_at',
])]
class PackageBookingLog extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'event' => PackageBookingLogEvent::class,
            'from_status' => PackageBookingStatus::class,
            'to_status' => PackageBookingStatus::class,
            'created_at' => 'datetime',
        ];
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(PackageBooking::class, 'package_booking_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
