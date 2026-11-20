<?php

namespace App\Models;

use App\Models\Concerns\HasTravelMedia;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

#[Fillable([
    'subcategory_id',
    'name',
    'summary',
    'description',
    'duration_days',
    'duration_nights',
    'difficulty',
    'max_altitude_meters',
    'min_group_size',
    'max_group_size',
    'price_from',
    'compare_at_price',
    'currency',
    'price_qualifier',
    'route_map_url',
    'accommodation',
    'fitness_guidance',
    'permit_notes',
    'safety_notes',
    'weather_notes',
    'meta_title',
    'meta_description',
    'tags',
    'is_published',
    'is_featured',
    'sort_order',
])]
class Package extends Model implements HasMedia
{
    use HasFactory;
    use HasSlug;
    use HasTravelMedia;

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->preventOverwrite();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function seasons(): HasMany
    {
        return $this->hasMany(PackageSeason::class)->orderBy('id');
    }

    public function highlights(): HasMany
    {
        return $this->hasMany(PackageHighlight::class)->orderBy('sort_order')->orderBy('id');
    }

    public function itineraryDays(): HasMany
    {
        return $this->hasMany(PackageItineraryDay::class)->orderBy('sort_order')->orderBy('day_number');
    }

    public function elevationPoints(): HasMany
    {
        return $this->hasMany(PackageElevationPoint::class)->orderBy('sort_order')->orderBy('id');
    }

    public function departures(): HasMany
    {
        return $this->hasMany(PackageDeparture::class)->orderBy('sort_order')->orderBy('starts_on')->orderBy('id');
    }

    public function features(): HasMany
    {
        return $this->hasMany(PackageFeature::class)->orderBy('type')->orderBy('sort_order')->orderBy('id');
    }

    public function faqs(): HasMany
    {
        return $this->hasMany(PackageFaq::class)->orderBy('sort_order')->orderBy('id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(PackageReview::class)->orderBy('sort_order')->orderBy('id');
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(PackageInquiry::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(PackageBooking::class);
    }

    protected function casts(): array
    {
        return [
            'duration_days' => 'integer',
            'duration_nights' => 'integer',
            'max_altitude_meters' => 'integer',
            'min_group_size' => 'integer',
            'max_group_size' => 'integer',
            'price_from' => 'decimal:2',
            'compare_at_price' => 'decimal:2',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'tags' => 'array',
            'sort_order' => 'integer',
        ];
    }
}
