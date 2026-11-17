<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#[Fillable([
    'reviewer_name',
    'reviewer_initials',
    'trip_name',
    'region_name',
    'review_text',
    'rating',
    'reviewed_at',
    'source_url',
])]
class GuestReview extends Model
{
    use HasFactory;

    public function getDisplayInitialsAttribute(): string
    {
        if (filled($this->reviewer_initials)) {
            return Str::upper($this->reviewer_initials);
        }

        return Str::of($this->reviewer_name)
            ->trim()
            ->explode(' ')
            ->filter()
            ->take(2)
            ->map(fn (string $part): string => Str::substr($part, 0, 1))
            ->implode('');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'reviewed_at' => 'date',
        ];
    }
}
