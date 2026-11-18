<?php

namespace Database\Seeders;

use App\Models\WhyTravelReason;
use Illuminate\Database\Seeder;

class WhyTravelReasonSeeder extends Seeder
{
    public function run(): void
    {
        $reasons = [
            [
                'title' => 'Altitude-aware pacing',
                'description' => 'Higher routes need sensible acclimatization days, realistic walking hours and a plan that can flex with weather and energy.',
                'sort_order' => 1,
            ],
            [
                'title' => 'Comfort matched to route',
                'description' => 'Some journeys suit simple teahouses, others call for more comfort in the cities or a private lodge-style approach where available.',
                'sort_order' => 2,
            ],
            [
                'title' => 'Local context first',
                'description' => 'Routes make more sense when culture, festivals, transport windows and mountain conditions are considered from the start.',
                'sort_order' => 3,
            ],
            [
                'title' => 'Responsible travel cues',
                'description' => 'We make space for crew welfare, lower-impact choices and respectful encounters to be part of the conversation before booking.',
                'sort_order' => 4,
            ],
        ];

        foreach ($reasons as $data) {
            WhyTravelReason::firstOrCreate(
                ['title' => $data['title']],
                [
                    'description' => $data['description'],
                    'is_published' => false,
                    'sort_order' => $data['sort_order'],
                ],
            );
        }
    }
}
