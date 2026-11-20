<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Season;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePackageDepartureRequest;
use App\Http\Requests\Admin\UpdatePackageDepartureRequest;
use App\Models\Package;
use App\Models\PackageDeparture;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PackageDepartureController extends Controller
{
    public function index(Request $request): View
    {
        return view('admin.package-departures.index', $this->departureListData($request));
    }

    public function forPackage(Request $request, Package $package): View
    {
        return view('admin.package-departures.index', $this->departureListData($request, $package));
    }

    /**
     * @return array<string, mixed>
     */
    private function departureListData(Request $request, ?Package $package = null): array
    {
        $search = trim($request->string('search')->toString());
        $season = $request->string('season')->toString();
        $status = $request->string('status')->toString();
        $period = $request->string('period')->toString();

        if (! in_array($period, ['upcoming', 'past', 'all'], true)) {
            $period = 'upcoming';
        }

        $departures = PackageDeparture::query()
            ->when($package, fn ($query) => $query->where('package_id', $package->id))
            ->with('package:id,name,slug')
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->whereHas('package', fn ($packageQuery) => $packageQuery->where('name', 'like', "%{$search}%"))
                        ->orWhere('status', 'like', "%{$search}%");
                });
            })
            ->when(Season::tryFrom($season), fn ($query, $season) => $query->where('season', $season->value))
            ->when($status !== '', fn ($query) => $query->where('status', $status))
            ->when($period === 'upcoming', fn ($query) => $query->whereDate('starts_on', '>=', today()))
            ->when($period === 'past', fn ($query) => $query->whereDate('starts_on', '<', today()))
            ->orderByRaw('CASE WHEN starts_on >= ? THEN starts_on END ASC', [today()->toDateString()])
            ->orderByDesc('starts_on')
            ->orderBy('sort_order')
            ->paginate(15)
            ->withQueryString();
        $scopedDepartures = PackageDeparture::query()
            ->when($package, fn ($query) => $query->where('package_id', $package->id));

        return [
            'departures' => $departures,
            'package' => $package,
            'search' => $search,
            'season' => Season::tryFrom($season)?->value ?? '',
            'status' => $status,
            'period' => $period,
            'departureCount' => (clone $scopedDepartures)->count(),
            'upcomingCount' => (clone $scopedDepartures)->whereDate('starts_on', '>=', today())->count(),
            'pastCount' => (clone $scopedDepartures)->whereDate('starts_on', '<', today())->count(),
            'availableCount' => (clone $scopedDepartures)->where('status', 'available_to_discuss')->count(),
            'statuses' => (clone $scopedDepartures)->select('status')->distinct()->orderBy('status')->pluck('status'),
        ];
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

    public function store(StorePackageDepartureRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $package = Package::findOrFail($validated['package_id']);
        $departures = array_map(
            fn (array $departure, int $sortOrder): array => [
                ...$departure,
                'season' => $validated['season'],
                'currency' => $package->currency ?: 'USD',
                'status' => 'available_to_discuss',
                'sort_order' => $sortOrder,
            ],
            $validated['departures'],
            array_keys($validated['departures']),
        );

        DB::transaction(fn () => $package->departures()->createMany($departures));

        return to_route('admin.package-departures.index')
            ->with('success', count($departures).' package departures created successfully.');
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
