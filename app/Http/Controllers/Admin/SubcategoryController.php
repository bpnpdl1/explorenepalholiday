<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSubcategoryRequest;
use App\Http\Requests\Admin\UpdateSubcategoryRequest;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function index(Request $request): View
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

        return view('admin.subcategories.index', [
            'subcategories' => $subcategories,
            'categories' => Category::query()
                ->with('destination:id,name')
                ->orderBy('name')
                ->get(['id', 'destination_id', 'name']),
            'search' => $search,
            'status' => in_array($status, ['published', 'draft'], true) ? $status : '',
            'categoryId' => $categoryId,
            'subcategoryCount' => Subcategory::count(),
            'publishedCount' => Subcategory::where('is_published', true)->count(),
        ]);
    }

    public function create(): View
    {
        return view('admin.subcategories.create', [
            'subcategory' => new Subcategory,
            'categories' => $this->categoriesForForm(),
        ]);
    }

    public function store(StoreSubcategoryRequest $request): RedirectResponse
    {
        $data = $request->safe()->only([
            'category_id',
            'name',
            'summary',
            'description',
            'sort_order',
        ]);
        $data['is_published'] = $request->boolean('is_published');

        Subcategory::create($data);

        return to_route('admin.subcategories.index')
            ->with('success', 'Subcategory created successfully.');
    }

    public function edit(Subcategory $subcategory): View
    {
        return view('admin.subcategories.edit', [
            'subcategory' => $subcategory,
            'categories' => $this->categoriesForForm(),
        ]);
    }

    public function update(UpdateSubcategoryRequest $request, Subcategory $subcategory): RedirectResponse
    {
        $data = $request->safe()->only([
            'category_id',
            'name',
            'summary',
            'description',
            'sort_order',
        ]);
        $data['is_published'] = $request->boolean('is_published');

        $subcategory->update($data);

        return to_route('admin.subcategories.index')
            ->with('success', 'Subcategory updated successfully.');
    }

    public function destroy(Subcategory $subcategory): RedirectResponse
    {
        $subcategory->delete();

        return to_route('admin.subcategories.index')
            ->with('success', 'Subcategory deleted successfully.');
    }

    private function categoriesForForm(): Collection
    {
        return Category::query()
            ->with('destination:id,name')
            ->orderBy('name')
            ->get(['id', 'destination_id', 'name']);
    }
}
