<?php

namespace Database\Seeders;

use App\Models\GuestReview;
use Illuminate\Database\Seeder;

class GuestReviewSeeder extends Seeder
{
    public function run(): void
    {
        $sourceUrl = 'https://www.tripadvisor.in/Attraction_Review-g293890-d19900205-Reviews-Explore_Nepal_Holidays-Kathmandu_Kathmandu_Valley_Bagmati_Zone_Central_Region.html';

        $reviews = [
            [
                'reviewer_name' => 'K N',
                'reviewer_initials' => 'KN',
                'trip_name' => 'Poon Hill and Annapurna Base Camp',
                'region_name' => 'Annapurna region',
                'review_text' => 'Our trek to Poon Hill with ABC Camp was simply incredible and a true once-in-a-lifetime experience! From start to finish, everything was perfectly organized.',
                'rating' => 5,
                'reviewed_at' => '2026-09-01',
                'source_url' => $sourceUrl,
            ],
            [
                'reviewer_name' => 'Denver L',
                'reviewer_initials' => 'DL',
                'trip_name' => 'Kathmandu sightseeing and the Nagarkot trek',
                'region_name' => 'Kathmandu Valley',
                'review_text' => 'I thoroughly enjoyed my time with my guide Ram Kumar he was very knowledgeable on Nepali history and the landscape of each place we went. Ram made me feel very welcome and made my time in Nepal very easy.',
                'rating' => 5,
                'reviewed_at' => '2025-12-01',
                'source_url' => $sourceUrl,
            ],
            [
                'reviewer_name' => 'Asier',
                'reviewer_initials' => 'AS',
                'trip_name' => 'Tsum Valley and Manaslu trek',
                'region_name' => 'Manaslu and Tsum Valley',
                'review_text' => 'A friend and I completed the Tsum Valley and Manaslu trek (18 days) with them. Our guide Subarna was great, he helped us through the whole trip, providing us with interesting information. He took great care of us and showed flexibility and ability to adapt to our needs.',
                'rating' => 5,
                'reviewed_at' => '2026-03-01',
                'source_url' => $sourceUrl,
            ],
        ];

        foreach ($reviews as $review) {
            GuestReview::firstOrCreate(
                [
                    'reviewer_name' => $review['reviewer_name'],
                    'trip_name' => $review['trip_name'],
                ],
                $review,
            );
        }
    }
}
