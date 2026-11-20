<?php

namespace App\Actions\Admin\Subcategories;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class ListSubcategoriesAction
{
    /** @return array<string, mixed> */
    public function handle(Request $request): array
    {
        $search = trim($request->string('search')->toString());
        $status = $request->string('status')->toString();
        $categoryId = $request->integer('category_id');

        $subcategories = Subcategory::query()
            ->with('category:id,destination_id,name', 'category.destination:id,name')
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")
                        ->orWhereHas('category', fn ($categoryQuery) => $categoryQuery->where('name', 'like', "%{$search}%"));
                });
            })
            ->when($status === 'published', fn ($query) => $query->where('is_published', true))
            ->when($status === 'draft', fn ($query) => $query->where('is_published', false))
            ->when($categoryId > 0, fn ($query) => $query->where('category_id', $categoryId))
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return [
            'subcategories' => $subcategories,
            'categories' => Category::query()
                ->with('destination:id,name')
                ->orderBy('name')
                ->get(['id', 'destination_id', 'name']),
            'search' => $search,
            'status' => in_array($status, ['published', 'draft'], true) ? $status : '',
            'categoryId' => $categoryId,
            'subcategoryCount' => Subcategory::query()->count(),
            'publishedCount' => Subcategory::query()->where('is_published', true)->count(),
        ];
    }
}
