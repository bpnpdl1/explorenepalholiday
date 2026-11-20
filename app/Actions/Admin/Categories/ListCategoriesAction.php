<?php

namespace App\Actions\Admin\Categories;

use App\Models\Category;
use App\Models\Destination;
use Illuminate\Http\Request;

class ListCategoriesAction
{
    /** @return array<string, mixed> */
    public function handle(Request $request): array
    {
        $search = trim($request->string('search')->toString());
        $status = $request->string('status')->toString();
        $destinationId = $request->integer('destination_id');

        $categories = Category::query()
            ->with('destination:id,name')
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")
                        ->orWhereHas('destination', fn ($destinationQuery) => $destinationQuery->where('name', 'like', "%{$search}%"));
                });
            })
            ->when($status === 'published', fn ($query) => $query->where('is_published', true))
            ->when($status === 'draft', fn ($query) => $query->where('is_published', false))
            ->when($destinationId > 0, fn ($query) => $query->where('destination_id', $destinationId))
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return [
            'categories' => $categories,
            'destinations' => Destination::query()->orderBy('name')->get(['id', 'name']),
            'search' => $search,
            'status' => in_array($status, ['published', 'draft'], true) ? $status : '',
            'destinationId' => $destinationId,
            'categoryCount' => Category::query()->count(),
            'publishedCount' => Category::query()->where('is_published', true)->count(),
        ];
    }
}
