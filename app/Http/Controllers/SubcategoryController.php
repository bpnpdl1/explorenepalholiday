<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Subcategory;
use Illuminate\Contracts\View\View;

class SubcategoryController extends Controller
{
    public function show(Subcategory $subcategory): View
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
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $heroImage = $packages->first()?->getFirstMediaUrl('cover', 'card')
            ?: $packages->first()?->getFirstMediaUrl('cover')
            ?: $subcategory->category->destination->getFirstMediaUrl('cover', 'card')
            ?: $subcategory->category->destination->getFirstMediaUrl('cover')
            ?: asset('site/assets/nepal-trail.jpg');

        return view('site.subcategories.show', compact(
            'subcategory',
            'packages',
            'relatedSubcategories',
            'heroImage',
        ));
    }
}
