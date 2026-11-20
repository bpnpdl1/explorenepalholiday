<?php

namespace App\Models;

use App\Enums\PackageBookingStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'reference',
    'package_id',
    'package_departure_id',
    'customer_name',
    'email',
    'phone',
    'country_of_residence',
    'travel_date',
    'guests',
    'total_amount',
    'currency',
    'status',
    'special_requests',
])]
class PackageBooking extends Model
{
    protected function casts(): array
    {
        return [
            'travel_date' => 'date',
            'guests' => 'integer',
            'total_amount' => 'decimal:2',
            'status' => PackageBookingStatus::class,
        ];
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function departure(): BelongsTo
    {
        return $this->belongsTo(PackageDeparture::class, 'package_departure_id');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(PackageBookingLog::class)->orderByDesc('created_at')->orderByDesc('id');
    }
}
