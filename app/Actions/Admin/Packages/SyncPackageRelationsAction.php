<?php

namespace App\Actions\Admin\Packages;

use App\Models\Package;
use Illuminate\Support\Arr;

class SyncPackageRelationsAction
{
    /**
     * @param  array<string, mixed>  $validated
     */
    public function handle(Package $package, array $validated): void
    {
        $this->syncSeasons($package, $validated['seasons'] ?? []);
        $this->syncFeatures($package, $validated['included_features'] ?? [], $validated['excluded_features'] ?? []);
        $this->syncItineraryDays($package, $validated['itinerary_days'] ?? []);
        $this->syncElevationPoints($package, $validated['elevation_points'] ?? []);
        $this->syncFaqs($package, $validated['faqs'] ?? []);
    }

    /** @param  array<int, string>  $seasons */
    private function syncSeasons(Package $package, array $seasons): void
    {
        $package->seasons()->delete();
        $package->seasons()->createMany(array_map(
            fn (string $season): array => ['season' => $season],
            array_values(array_unique($seasons)),
        ));
    }

    /**
     * @param  array<int, array<string, mixed>>  $included
     * @param  array<int, array<string, mixed>>  $excluded
     */
    private function syncFeatures(Package $package, array $included, array $excluded): void
    {
        $rowsByType = [
            'included' => array_values($included),
            'excluded' => array_values($excluded),
        ];
        $existingFeatures = $package->features()->get()->keyBy('id');
        $retainedIds = collect([...$rowsByType['included'], ...$rowsByType['excluded']])
            ->pluck('id')
            ->filter()
            ->map(fn ($id): int => (int) $id)
            ->all();

        $featuresToDelete = $package->features();

        if ($retainedIds !== []) {
            $featuresToDelete->whereNotIn('id', $retainedIds);
        }

        $featuresToDelete->delete();

        foreach ($rowsByType as $type => $rows) {
            foreach ($rows as $index => $row) {
                $attributes = [
                    'type' => $type,
                    'description' => $row['description'],
                    'sort_order' => $index,
                ];
                $feature = ! empty($row['id']) ? $existingFeatures->get((int) $row['id']) : null;

                if ($feature) {
                    $feature->update($attributes);

                    continue;
                }

                $package->features()->create($attributes);
            }
        }
    }

    /** @param  array<int, array<string, mixed>>  $itineraryDays */
    private function syncItineraryDays(Package $package, array $itineraryDays): void
    {
        $rows = array_values($itineraryDays);
        $existingDays = $package->itineraryDays()->get()->keyBy('id');
        $retainedIds = collect($rows)
            ->pluck('id')
            ->filter()
            ->map(fn ($id): int => (int) $id)
            ->all();

        $daysToDelete = $package->itineraryDays();

        if ($retainedIds !== []) {
            $daysToDelete->whereNotIn('id', $retainedIds);
        }

        $daysToDelete->delete();

        $retainedDays = $existingDays->only($retainedIds);
        $occupiedNumbers = $package->itineraryDays()->pluck('day_number')->all();
        $desiredNumbers = $rows === [] ? [] : range(1, count($rows));
        $blockedNumbers = array_fill_keys([...$occupiedNumbers, ...$desiredNumbers], true);
        $temporaryNumbers = [];
        $candidate = 65535;

        foreach ($retainedDays as $day) {
            while (isset($blockedNumbers[$candidate])) {
                $candidate--;
            }

            $temporaryNumbers[] = $candidate;
            $blockedNumbers[$candidate] = true;
            $candidate--;
        }

        foreach ($retainedDays->values() as $index => $day) {
            $day->update(['day_number' => $temporaryNumbers[$index]]);
        }

        foreach ($rows as $index => $row) {
            $attributes = [
                ...Arr::only($row, [
                    'title',
                    'location',
                    'altitude_meters',
                    'activity_label',
                    'meal_plan',
                    'description',
                ]),
                'day_number' => $index + 1,
                'sort_order' => $index,
            ];
            $day = ! empty($row['id']) ? $existingDays->get((int) $row['id']) : null;

            if ($day) {
                $day->update($attributes);

                continue;
            }

            $package->itineraryDays()->create($attributes);
        }
    }

    /** @param  array<int, array<string, mixed>>  $elevationPoints */
    private function syncElevationPoints(Package $package, array $elevationPoints): void
    {
        $rows = array_values($elevationPoints);
        $existingPoints = $package->elevationPoints()->get()->keyBy('id');
        $retainedIds = collect($rows)
            ->pluck('id')
            ->filter()
            ->map(fn ($id): int => (int) $id)
            ->all();

        $pointsToDelete = $package->elevationPoints();

        if ($retainedIds !== []) {
            $pointsToDelete->whereNotIn('id', $retainedIds);
        }

        $pointsToDelete->delete();

        foreach ($rows as $index => $row) {
            $attributes = [
                'stop_name' => $row['stop_name'],
                'altitude_meters' => $row['altitude_meters'],
                'sort_order' => $index,
            ];
            $point = ! empty($row['id']) ? $existingPoints->get((int) $row['id']) : null;

            if ($point) {
                $point->update($attributes);

                continue;
            }

            $package->elevationPoints()->create($attributes);
        }
    }

    /** @param  array<int, array<string, mixed>>  $faqs */
    private function syncFaqs(Package $package, array $faqs): void
    {
        $rows = array_values($faqs);
        $existingFaqs = $package->faqs()->get()->keyBy('id');
        $retainedIds = collect($rows)
            ->pluck('id')
            ->filter()
            ->map(fn ($id): int => (int) $id)
            ->all();

        $faqsToDelete = $package->faqs();

        if ($retainedIds !== []) {
            $faqsToDelete->whereNotIn('id', $retainedIds);
        }

        $faqsToDelete->delete();

        foreach ($rows as $index => $row) {
            $attributes = [
                'question' => $row['question'],
                'answer' => $row['answer'],
                'sort_order' => $index,
            ];
            $faq = ! empty($row['id']) ? $existingFaqs->get((int) $row['id']) : null;

            if ($faq) {
                $faq->update($attributes);

                continue;
            }

            $package->faqs()->create($attributes);
        }
    }
}
