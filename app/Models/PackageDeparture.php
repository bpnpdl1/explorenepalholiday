<?php

namespace App\Models;

use App\Enums\Season;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['package_id', 'season', 'starts_on', 'ends_on', 'price', 'currency', 'status', 'sort_order'])]
class PackageDeparture extends Model
{
    use HasFactory;

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    protected function casts(): array
    {
        return [
            'season' => Season::class,
            'starts_on' => 'date',
            'ends_on' => 'date',
            'price' => 'decimal:2',
            'sort_order' => 'integer',
        ];
    }
}
