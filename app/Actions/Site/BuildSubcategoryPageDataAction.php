<?php

namespace App\Actions\Site;

use App\Models\Package;
use App\Models\Subcategory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class BuildSubcategoryPageDataAction
{
    /** @return array{subcategory: Subcategory, packages: LengthAwarePaginator, relatedSubcategories: Collection<int, Subcategory>, heroImage: string} */
    public function handle(Subcategory $subcategory): array
    {
        $subcategory->load('category.destination');

        abort_unless(
            $subcategory->is_published
                && $subcategory->category->is_published
                && $subcategory->category->destination->is_published,
            404,
        );

        $packages = Package::query()
            ->where('subcategory_id', $subcategory->id)
            ->where('is_published', true)
            ->with(['seasons', 'media'])
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(9)
            ->withQueryString();

        $relatedSubcategories = Subcategory::query()
            ->where('category_id', $subcategory->category_id)
            ->whereKeyNot($subcategory->id)
            ->where('is_published', true)
            ->whereHas('packages', fn ($query) => $query->where('is_published', true))
            ->withCount(['packages as published_packages_count' => fn ($query) => $query->where('is_published', true)])
            ->with([
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

        $heroPackage = $packages->first();
        $destination = $subcategory->category->destination;
        $heroImage = $heroPackage?->getFirstMediaUrl('cover', 'card')
            ?: $heroPackage?->getFirstMediaUrl('cover')
            ?: $destination->getFirstMediaUrl('cover', 'card')
            ?: $destination->getFirstMediaUrl('cover')
            ?: asset('site/assets/nepal-trail.jpg');

        return compact('subcategory', 'packages', 'relatedSubcategories', 'heroImage');
    }
}
