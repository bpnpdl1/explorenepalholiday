<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Categories\ListCategoriesAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request, ListCategoriesAction $listCategories): View
    {
        return view('admin.categories.index', $listCategories->handle($request));
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
