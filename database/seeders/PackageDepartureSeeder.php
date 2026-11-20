<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PackageDepartureSeeder extends Seeder
{
    /**
     * Seasonal start dates are repeated yearly and limited to the next 12 months.
     *
     * @var array<string, array<array{0: int, 1: int}>>
     */
    private const SEASON_DATES = [
        'autumn' => [[10, 10], [11, 10]],
        'spring' => [[3, 10], [4, 10]],
        'winter' => [[12, 10], [1, 10], [2, 10]],
        'monsoon' => [[6, 10], [9, 10]],
    ];

    public function run(): void
    {
        $today = Carbon::today();
        $lastDate = $today->copy()->addYear();

        Package::query()
            ->with('seasons')
            ->get()
            ->each(function (Package $package) use ($today, $lastDate): void {
                $dates = $package->seasons
                    ->flatMap(function ($packageSeason) use ($today, $lastDate): array {
                        $season = $packageSeason->season;
                        $dates = [];

                        foreach (self::SEASON_DATES[$season->value] ?? [] as [$month, $day]) {
                            for ($year = $today->year; $year <= $lastDate->year; $year++) {
                                $date = Carbon::create($year, $month, $day)->startOfDay();

                                if ($date->isAfter($today) && $date->lessThanOrEqualTo($lastDate)) {
                                    $dates[] = [
                                        'season' => $season,
                                        'starts_on' => $date,
                                    ];
                                }
                            }
                        }

                        return $dates;
                    })
                    ->sortBy('starts_on')
                    ->values();

                foreach ($dates as $index => $departure) {
                    $startsOn = $departure['starts_on'];

                    $package->departures()->updateOrCreate(
                        ['starts_on' => $startsOn->toDateString()],
                        [
                            'season' => $departure['season'],
                            'ends_on' => $startsOn->copy()->addDays(max(0, (int) $package->duration_days - 1)),
                            'price' => $package->price_from,
                            'currency' => $package->currency ?: 'USD',
                            'status' => 'available_to_discuss',
                            'sort_order' => $index + 1,
                        ],
                    );
                }
            });
    }
}
