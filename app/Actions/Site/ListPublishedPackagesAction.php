<?php

namespace App\Actions\Site;

use App\Enums\Season;
use App\Models\Category;
use App\Models\Package;
use App\Models\PackageSeason;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ListPublishedPackagesAction
{
    /** @return array<string, mixed> */
    public function handle(Request $request): array
    {
        $filters = $request->validate([
            'region' => ['nullable', 'string', 'max:100'],
            'style' => ['nullable', 'string', 'max:100'],
            'duration' => ['nullable', 'string', 'max:20'],
            'season' => ['nullable', 'string', 'max:20'],
        ]);

        $regions = Subcategory::query()
            ->whereHas('packages', fn ($query) => $query->where('is_published', true))
            ->orderBy('name')
            ->get(['name', 'slug']);

        $styles = Category::query()
            ->whereHas('subcategories.packages', fn ($query) => $query->where('is_published', true))
            ->orderBy('name')
            ->get(['name', 'slug']);

        $availableSeasons = PackageSeason::query()
            ->whereHas('package', fn ($query) => $query->where('is_published', true))
            ->distinct()
            ->pluck('season')
            ->all();

        $seasons = collect(Season::cases())
            ->filter(fn (Season $season) => in_array($season->value, $availableSeasons, true))
            ->values();

        $durationRanges = [
            ['value' => 'short', 'label' => '1-5 days', 'min' => 1, 'max' => 5],
            ['value' => 'medium', 'label' => '6-10 days', 'min' => 6, 'max' => 10],
            ['value' => 'long', 'label' => '11-18 days', 'min' => 11, 'max' => 18],
            ['value' => 'extended', 'label' => '19+ days', 'min' => 19, 'max' => null],
        ];

        $durations = collect($durationRanges)
            ->filter(function (array $range): bool {
                $query = Package::query()->where('is_published', true)->whereNotNull('duration_days');

                return $range['max'] === null
                    ? $query->where('duration_days', '>=', $range['min'])->exists()
                    : $query->whereBetween('duration_days', [$range['min'], $range['max']])->exists();
            })
            ->values();

        if (! $regions->contains('slug', $filters['region'] ?? null)) {
            unset($filters['region']);
        }

        if (! $styles->contains('slug', $filters['style'] ?? null)) {
            unset($filters['style']);
        }

        if (! $durations->contains('value', $filters['duration'] ?? null)) {
            unset($filters['duration']);
        }

        if (! $seasons->contains(fn (Season $season) => $season->value === ($filters['season'] ?? null))) {
            unset($filters['season']);
        }

        $packagesQuery = Package::query()
            ->where('is_published', true)
            ->with([
                'subcategory.category.destination',
                'seasons',
                'media',
            ]);

        if (isset($filters['region'])) {
            $packagesQuery->whereHas('subcategory', fn ($query) => $query->where('slug', $filters['region']));
        }

        if (isset($filters['style'])) {
            $packagesQuery->whereHas('subcategory.category', fn ($query) => $query->where('slug', $filters['style']));
        }

        if (isset($filters['duration'])) {
            $range = $durations->firstWhere('value', $filters['duration']);
            $range['max'] === null
                ? $packagesQuery->where('duration_days', '>=', $range['min'])
                : $packagesQuery->whereBetween('duration_days', [$range['min'], $range['max']]);
        }

        if (isset($filters['season'])) {
            $packagesQuery->whereHas('seasons', fn ($query) => $query->where('season', $filters['season']));
        }

        $packages = $packagesQuery
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        $filterLabels = collect($filters)->mapWithKeys(function (string $value, string $key) use ($regions, $styles, $durations, $seasons): array {
            $label = match ($key) {
                'region' => $regions->firstWhere('slug', $value)?->name,
                'style' => $styles->firstWhere('slug', $value)?->name,
                'duration' => $durations->firstWhere('value', $value)['label'] ?? null,
                'season' => $seasons->first(fn (Season $season) => $season->value === $value)?->label(),
            };

            return [$key => $label ?? Str::headline($value)];
        });

        return compact('packages', 'regions', 'styles', 'durations', 'seasons', 'filters', 'filterLabels');
    }
}
