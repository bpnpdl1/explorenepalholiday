<?php

namespace App\Actions\Admin\Packages;

use App\Models\Package;
use Illuminate\Http\Request;

class ListPackagesAction
{
    /** @return array<string, mixed> */
    public function handle(Request $request): array
    {
        $search = trim($request->string('search')->toString());
        $status = $request->string('status')->toString();
        $subcategoryId = $request->integer('subcategory_id');
        $featured = $request->string('featured')->toString();

        $packages = Package::query()
            ->with([
                'subcategory:id,category_id,name',
                'subcategory.category:id,destination_id,name',
                'subcategory.category.destination:id,name',
                'media' => fn ($query) => $query->where('collection_name', 'cover'),
            ])
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")
                        ->orWhere('summary', 'like', "%{$search}%")
                        ->orWhereHas('subcategory', fn ($subcategoryQuery) => $subcategoryQuery->where('name', 'like', "%{$search}%"));
                });
            })
            ->when($status === 'published', fn ($query) => $query->where('is_published', true))
            ->when($status === 'draft', fn ($query) => $query->where('is_published', false))
            ->when($subcategoryId > 0, fn ($query) => $query->where('subcategory_id', $subcategoryId))
            ->when($featured === 'yes', fn ($query) => $query->where('is_featured', true))
            ->when($featured === 'no', fn ($query) => $query->where('is_featured', false))
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return [
            'packages' => $packages,
            'search' => $search,
            'status' => in_array($status, ['published', 'draft'], true) ? $status : '',
            'subcategoryId' => $subcategoryId,
            'featured' => in_array($featured, ['yes', 'no'], true) ? $featured : '',
            'packageCount' => Package::count(),
            'publishedCount' => Package::where('is_published', true)->count(),
            'draftCount' => Package::where('is_published', false)->count(),
            'featuredCount' => Package::where('is_featured', true)->count(),
        ];
    }
}
