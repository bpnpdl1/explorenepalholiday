<?php

namespace App\Actions\Admin\PackageDepartures;

use App\Models\Package;
use Illuminate\Support\Facades\DB;

class CreatePackageDeparturesAction
{
    /** @param array<string, mixed> $validated */
    public function handle(array $validated): int
    {
        $package = Package::query()->findOrFail($validated['package_id']);

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

        return count($departures);
    }
}
