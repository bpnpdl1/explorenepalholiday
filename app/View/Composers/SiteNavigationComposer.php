<?php

namespace App\View\Composers;

use App\Models\Category;
use App\Models\Package;
use Illuminate\Contracts\View\View;

class SiteNavigationComposer
{
    public function compose(View $view): void
    {
        $navigation = [
            'climbing' => [
                'slug' => 'peak-climbing-in-nepal',
                'label' => 'Peak Climbing in Nepal',
                'heading' => 'CLIMBING REGIONS',
                'item_label' => 'peak packages',
                'intro' => 'Explore climbing packages by region.',
                'empty_message' => 'Climbing packages will be listed here when available.',
            ],
            'tours' => [
                'slug' => 'tours-in-nepal',
                'label' => 'Tours in Nepal',
                'heading' => 'TOUR STYLES',
                'item_label' => 'tour packages',
                'intro' => 'Explore tour packages by style.',
                'empty_message' => 'Tour packages will be listed here when available.',
            ],
            'trekking' => [
                'slug' => 'trekking-in-nepal',
                'label' => 'Trekking in Nepal',
                'heading' => 'TREKKING REGIONS',
                'item_label' => 'trek packages',
                'intro' => 'Explore trekking packages by region.',
                'empty_message' => 'Trek packages will be listed here when available.',
            ],
        ];

        $categories = Category::query()
            ->whereIn('slug', array_column($navigation, 'slug'))
            ->where('is_published', true)
            ->with([
                'subcategories' => fn ($query) => $query
                    ->where('is_published', true)
                    ->orderBy('sort_order')
                    ->orderBy('name')
                    ->with([
                        'packages' => fn ($packageQuery) => $packageQuery
                            ->where('is_published', true)
                            ->orderBy('sort_order')
                            ->orderBy('name'),
                    ]),
            ])
            ->get()
            ->keyBy('slug');

        $navigationCategories = [];

        foreach ($navigation as $key => $item) {
            $category = $categories->get($item['slug']);
            $item['subcategories'] = $category?->subcategories
                ->map(fn ($subcategory): array => [
                    'id' => $key.'-'.$subcategory->id,
                    'name' => $subcategory->name,
                    'url' => route('subcategories.show', $subcategory->slug),
                    'packages' => $subcategory->packages
                        ->map(fn (Package $package): array => [
                            'name' => $package->name,
                            'url' => route('packages.show', $package),
                        ])
                        ->all(),
                ])
                ->all() ?? [];
            $navigationCategories[$key] = $item;
        }

        $packageSearchItems = Package::query()
            ->where('is_published', true)
            ->with('subcategory.category.destination')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get()
            ->map(fn (Package $package): array => [
                'name' => $package->name,
                'category' => $package->subcategory->category->destination->name.' / '.$package->subcategory->category->name,
                'activity' => $package->subcategory->category->name,
                'url' => route('packages.show', $package),
            ])
            ->all();

        $view->with('navigationCategories', $navigationCategories)
            ->with('packageSearchItems', $packageSearchItems);
    }
}
