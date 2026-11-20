<?php

namespace App\Actions\Site;

use App\Enums\Season;
use App\Models\Destination;
use App\Models\Faq;
use App\Models\Package;
use App\Models\Subcategory;
use App\Models\WhyTravelReason;

class BuildHomePageDataAction
{
    /** @return array<string, mixed> */
    public function handle(): array
    {
        $destinations = Destination::query()
            ->where('is_published', true)
            ->with('media')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->limit(6)
            ->get();

        $regionSubcategories = Subcategory::query()
            ->where('is_published', true)
            ->whereHas('category', fn ($query) => $query
                ->where('is_published', true)
                ->whereHas('destination', fn ($destinationQuery) => $destinationQuery->where('is_published', true)))
            ->whereHas('packages', fn ($query) => $query->where('is_published', true))
            ->withCount(['packages as published_packages_count' => fn ($query) => $query->where('is_published', true)])
            ->with([
                'category.destination.media',
                'packages' => fn ($query) => $query
                    ->where('is_published', true)
                    ->with('media')
                    ->orderByDesc('is_featured')
                    ->orderBy('sort_order')
                    ->orderBy('name')
                    ->limit(1),
            ])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $faqs = Faq::query()
            ->where('is_published', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->limit(6)
            ->get();

        $whyTravelReasons = WhyTravelReason::query()
            ->where('is_published', true)
            ->with('media')
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        $packages = Package::query()
            ->where('is_published', true)
            ->with([
                'subcategory.category.destination',
                'seasons',
                'highlights',
                'media',
            ])
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->limit(18)
            ->get();

        $featuredPackages = $packages->where('is_featured', true)->take(6)->values();

        if ($featuredPackages->isEmpty()) {
            $featuredPackages = $packages->take(6)->values();
        }

        $featuredPackageCategories = $featuredPackages
            ->groupBy(fn (Package $package): string => $package->subcategory->category->slug)
            ->map(function ($categoryPackages, string $categorySlug): array {
                /** @var Package $firstPackage */
                $firstPackage = $categoryPackages->first();

                return [
                    'value' => $categorySlug,
                    'label' => $firstPackage->subcategory->category->name,
                    'count' => $categoryPackages->count(),
                ];
            })
            ->values();

        $packageCategories = $packages
            ->map(fn (Package $package): array => [
                'value' => $package->subcategory->category->slug,
                'label' => $package->subcategory->category->name,
            ])
            ->unique('value')
            ->values();

        $packageRegions = $packages
            ->map(fn (Package $package): array => [
                'value' => $package->subcategory->slug,
                'label' => $package->subcategory->name,
            ])
            ->unique('value')
            ->values();

        $packageStyles = $packageCategories;

        $durationRanges = [
            ['value' => 'short', 'label' => '1-5 days', 'min' => 1, 'max' => 5],
            ['value' => 'medium', 'label' => '6-10 days', 'min' => 6, 'max' => 10],
            ['value' => 'long', 'label' => '11-18 days', 'min' => 11, 'max' => 18],
            ['value' => 'extended', 'label' => '19+ days', 'min' => 19, 'max' => null],
        ];

        $packageDurations = collect($durationRanges)
            ->filter(fn (array $range): bool => $packages->contains(
                fn (Package $package): bool => $package->duration_days !== null
                    && $package->duration_days >= $range['min']
                    && ($range['max'] === null || $package->duration_days <= $range['max']),
            ))
            ->values();

        $availableSeasons = $packages
            ->flatMap(fn (Package $package) => $package->seasons->pluck('season')->map(fn (Season $season): string => $season->value))
            ->unique()
            ->all();
        $packageSeasons = collect(Season::cases())
            ->filter(fn (Season $season): bool => in_array($season->value, $availableSeasons, true))
            ->values();

        return compact(
            'destinations',
            'regionSubcategories',
            'faqs',
            'whyTravelReasons',
            'packages',
            'featuredPackages',
            'featuredPackageCategories',
            'packageCategories',
            'packageRegions',
            'packageStyles',
            'packageDurations',
            'packageSeasons',
        );
    }
}
