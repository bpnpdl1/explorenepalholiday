<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Packages\ListPackagesAction;
use App\Actions\Admin\Packages\SavePackageAction;
use App\Actions\Admin\Packages\SyncPackageMediaAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePackageRequest;
use App\Http\Requests\Admin\UpdatePackageRequest;
use App\Models\Package;
use App\Models\Subcategory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index(Request $request, ListPackagesAction $listPackages): View
    {
        return view('admin.packages.index', [
            ...$listPackages->handle($request),
            'subcategories' => $this->subcategoriesForForm(),
        ]);
    }

    public function create(): View
    {
        return view('admin.packages.create', [
            'package' => new Package([
                'currency' => 'USD',
                'sort_order' => 0,
            ]),
            'subcategories' => $this->subcategoriesForForm(),
        ]);
    }

    public function store(
        StorePackageRequest $request,
        SavePackageAction $savePackage,
        SyncPackageMediaAction $syncPackageMedia,
    ): RedirectResponse {
        $package = $savePackage->handle(
            $request->validated(),
            $request->boolean('is_published'),
            $request->boolean('is_featured'),
        );
        $this->syncMedia($request, $package, $syncPackageMedia);

        return to_route('admin.packages.show', $package)
            ->with('success', 'Package created successfully.');
    }

    public function show(Package $package): View
    {
        $package->load([
            'subcategory.category.destination',
            'seasons',
            'media',
        ]);

        return view('admin.packages.show', compact('package'));
    }

    public function edit(Package $package): View
    {
        $package->load([
            'seasons',
            'features',
            'itineraryDays',
            'elevationPoints',
            'faqs',
            'media',
        ]);

        return view('admin.packages.edit', [
            'package' => $package,
            'subcategories' => $this->subcategoriesForForm(),
        ]);
    }

    public function update(
        UpdatePackageRequest $request,
        Package $package,
        SavePackageAction $savePackage,
        SyncPackageMediaAction $syncPackageMedia,
    ): RedirectResponse {
        $package = $savePackage->handle(
            $request->validated(),
            $request->boolean('is_published'),
            $request->boolean('is_featured'),
            $package,
        );
        $this->syncMedia($request, $package, $syncPackageMedia);

        return to_route('admin.packages.show', $package)
            ->with('success', 'Package updated successfully.');
    }

    public function destroy(Package $package): RedirectResponse
    {
        $package->delete();

        return to_route('admin.packages.index')
            ->with('success', 'Package deleted successfully.');
    }

    private function syncMedia(
        StorePackageRequest|UpdatePackageRequest $request,
        Package $package,
        SyncPackageMediaAction $syncPackageMedia,
    ): void {
        $syncPackageMedia->handle(
            $package,
            $request->file('cover'),
            $request->file('gallery', []),
            $request->file('route_map_image'),
            $request->boolean('remove_route_map'),
            $request->validated('remove_gallery', []),
        );
    }

    /** @return Collection<int, Subcategory> */
    private function subcategoriesForForm(): Collection
    {
        return Subcategory::query()
            ->with(['category:id,destination_id,name', 'category.destination:id,name'])
            ->orderBy('name')
            ->get(['id', 'category_id', 'name']);
    }
}
