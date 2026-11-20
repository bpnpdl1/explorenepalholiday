<?php

namespace App\Actions\Admin\PackageDepartures;

use App\Enums\Season;
use App\Models\Package;
use App\Models\PackageDeparture;
use Illuminate\Http\Request;

class ListPackageDeparturesAction
{
    /** @return array<string, mixed> */
    public function handle(Request $request, ?Package $package = null): array
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
}
