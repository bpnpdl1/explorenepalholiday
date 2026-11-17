<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\Destination;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request): View
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

        return view('admin.categories.index', [
            'categories' => $categories,
            'destinations' => Destination::query()->orderBy('name')->get(['id', 'name']),
            'search' => $search,
            'status' => in_array($status, ['published', 'draft'], true) ? $status : '',
            'destinationId' => $destinationId,
            'categoryCount' => Category::count(),
            'publishedCount' => Category::where('is_published', true)->count(),
        ]);
    }

    public function create(): View
    {
        return view('admin.categories.create', [
            'category' => new Category,
            'destinations' => Destination::query()->orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $data = $request->safe()->only([
            'destination_id',
            'name',
            'summary',
            'description',
            'sort_order',
        ]);
        $data['is_published'] = $request->boolean('is_published');

        Category::create($data);

        return to_route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', [
            'category' => $category,
            'destinations' => Destination::query()->orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $data = $request->safe()->only([
            'destination_id',
            'name',
            'summary',
            'description',
            'sort_order',
        ]);
        $data['is_published'] = $request->boolean('is_published');

        $category->update($data);

        return to_route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return to_route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
