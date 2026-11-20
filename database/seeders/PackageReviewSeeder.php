<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageReviewSeeder extends Seeder
{
    public function run(): void
    {
        $packageReviews = [
            'Annapurna Base Camp Trek' => [
                [
                    'quote' => 'Our trek to Poon Hill with ABC Camp was simply incredible and a true once-in-a-lifetime experience! From start to finish, everything was perfectly organized.',
                    'reviewer_name' => 'K N',
                    'reviewer_label' => 'TripAdvisor · Poon Hill and Annapurna Base Camp',
                ],
            ],
            'Manaslu Circuit Trek' => [
                [
                    'quote' => 'A friend and I completed the Tsum Valley and Manaslu trek (18 days) with them. Our guide Subarna was great, he helped us through the whole trip, providing us with interesting information. He took great care of us and showed flexibility and ability to adapt to our needs.',
                    'reviewer_name' => 'Asier',
                    'reviewer_label' => 'TripAdvisor · Tsum Valley and Manaslu trek',
                ],
            ],
            'Kathmandu Valley Heritage Tour' => [
                [
                    'quote' => 'I thoroughly enjoyed my time with my guide Ram Kumar he was very knowledgeable on Nepali history and the landscape of each place we went. Ram made me feel very welcome and made my time in Nepal very easy.',
                    'reviewer_name' => 'Denver L',
                    'reviewer_label' => 'TripAdvisor · Kathmandu sightseeing and the Nagarkot trek',
                ],
            ],
        ];

        foreach ($packageReviews as $packageName => $reviews) {
            $package = Package::query()->where('name', $packageName)->firstOrFail();

            if ($package->reviews()->exists()) {
                continue;
            }

            $package->reviews()->createMany(array_map(
                fn (array $review, int $sortOrder): array => [
                    ...$review,
                    'sort_order' => $sortOrder,
                ],
                $reviews,
                array_keys($reviews),
            ));
        }
    }
}
