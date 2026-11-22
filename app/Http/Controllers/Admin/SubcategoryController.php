<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Subcategories\ListSubcategoriesAction;
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
    public function index(Request $request, ListSubcategoriesAction $listSubcategories): View
    {
        return view('admin.subcategories.index', $listSubcategories->handle($request));
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
            'is_featured',
            'sort_order',
        ]);
        $data['is_published'] = $request->boolean('is_published');
        $data['is_featured'] = $request->boolean('is_featured');

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
            'is_featured',
            'sort_order',
        ]);
        $data['is_published'] = $request->boolean('is_published');
        $data['is_featured'] = $request->boolean('is_featured');

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
