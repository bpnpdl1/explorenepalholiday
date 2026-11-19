<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['package_id', 'day_number', 'title', 'location', 'altitude_meters', 'activity_label', 'meal_plan', 'description', 'sort_order'])]
class PackageItineraryDay extends Model
{
    use HasFactory;

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    protected function casts(): array
    {
        return [
            'day_number' => 'integer',
            'altitude_meters' => 'integer',
            'sort_order' => 'integer',
        ];
    }
}
