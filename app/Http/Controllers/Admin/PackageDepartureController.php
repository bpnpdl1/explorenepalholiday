<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\PackageDepartures\CreatePackageDeparturesAction;
use App\Actions\Admin\PackageDepartures\ListPackageDeparturesAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePackageDepartureRequest;
use App\Http\Requests\Admin\UpdatePackageDepartureRequest;
use App\Models\Package;
use App\Models\PackageDeparture;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PackageDepartureController extends Controller
{
    public function index(Request $request, ListPackageDeparturesAction $listDepartures): View
    {
        return view('admin.package-departures.index', $listDepartures->handle($request));
    }

    public function forPackage(Request $request, Package $package, ListPackageDeparturesAction $listDepartures): View
    {
        return view('admin.package-departures.index', $listDepartures->handle($request, $package));
    }

    public function create(Request $request): View
    {
        return view('admin.package-departures.create', [
            'departure' => new PackageDeparture([
                'package_id' => Package::query()->whereKey($request->integer('package_id'))->value('id'),
                'currency' => 'USD',
                'status' => 'available_to_discuss',
                'sort_order' => 0,
            ]),
            'packages' => $this->packagesForForm(),
        ]);
    }

    public function store(StorePackageDepartureRequest $request, CreatePackageDeparturesAction $createDepartures): RedirectResponse
    {
        $createdCount = $createDepartures->handle($request->validated());

        return to_route('admin.package-departures.index')
            ->with('success', $createdCount.' package departures created successfully.');
    }

    public function edit(PackageDeparture $packageDeparture): View
    {
        return view('admin.package-departures.edit', [
            'departure' => $packageDeparture,
            'packages' => $this->packagesForForm(),
        ]);
    }

    public function update(UpdatePackageDepartureRequest $request, PackageDeparture $packageDeparture): RedirectResponse
    {
        $packageDeparture->update($request->validated());

        return to_route('admin.package-departures.index')
            ->with('success', 'Departure updated successfully.');
    }

    public function destroy(PackageDeparture $packageDeparture): RedirectResponse
    {
        $packageDeparture->delete();

        return to_route('admin.package-departures.index')
            ->with('success', 'Departure deleted successfully.');
    }

    /** @return Collection<int, Package> */
    private function packagesForForm(): Collection
    {
        return Package::query()->orderBy('name')->get(['id', 'name', 'slug']);
    }
}
