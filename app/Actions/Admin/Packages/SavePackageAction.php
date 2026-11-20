<?php

namespace App\Actions\Admin\Packages;

use App\Models\Package;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class SavePackageAction
{
    private const PACKAGE_ATTRIBUTES = [
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
        'sort_order',
    ];

    public function __construct(private readonly SyncPackageRelationsAction $syncPackageRelations) {}

    /**
     * @param  array<string, mixed>  $validated
     */
    public function handle(
        array $validated,
        bool $isPublished,
        bool $isFeatured,
        ?Package $package = null,
    ): Package {
        $attributes = Arr::only($validated, self::PACKAGE_ATTRIBUTES);
        $attributes['tags'] = $validated['tags'] ?? [];
        $attributes['is_published'] = $isPublished;
        $attributes['is_featured'] = $isFeatured;

        return DB::transaction(function () use ($attributes, $validated, $package): Package {
            if ($package) {
                $package->update($attributes);
            } else {
                $package = Package::create($attributes);
            }

            $this->syncPackageRelations->handle($package, $validated);

            return $package;
        });
    }
}
