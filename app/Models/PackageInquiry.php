<?php

namespace App\Models;

use App\Enums\PackageInquiryStatus;
use App\Enums\Season;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'package_id',
    'customer_name',
    'email',
    'phone',
    'travel_window',
    'message',
    'status',
])]
class PackageInquiry extends Model
{
    protected function casts(): array
    {
        return [
            'status' => PackageInquiryStatus::class,
        ];
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function travelWindowLabel(): string
    {
        if ($this->travel_window === 'flexible') {
            return 'Flexible dates';
        }

        if (str_starts_with((string) $this->travel_window, 'departure-')) {
            $departureId = (int) substr($this->travel_window, strlen('departure-'));
            $departure = $this->package?->departures->firstWhere('id', $departureId);

            if (! $departure) {
                return 'Previous departure';
            }

            $dates = $departure->starts_on->format('M j, Y');
            if ($departure->ends_on) {
                $dates .= ' - '.$departure->ends_on->format('M j, Y');
            }

            return $dates.' ('.$departure->season->label().')';
        }

        if (str_starts_with((string) $this->travel_window, 'season-')) {
            return Season::tryFrom(substr($this->travel_window, strlen('season-')))?->label() ?? 'Season';
        }

        return $this->travel_window ?: 'Not specified';
    }
}
