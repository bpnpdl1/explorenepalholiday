<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Destination;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $destination = Destination::query()->where('name', 'Nepal')->firstOrFail();

        $categories = [
            [
                'name' => 'Peak Climbing in Nepal',
                'summary' => 'Guided Himalayan peak climbing journeys across Nepal.',
                'description' => 'Explore climbing packages by region, with route planning, acclimatization, and experienced local support.',
                'sort_order' => 1,
            ],
            [
                'name' => 'Tours in Nepal',
                'summary' => 'Guided cultural, nature, and discovery tours throughout Nepal.',
                'description' => 'Explore Nepal through heritage sites, mountain towns, wildlife areas, and locally guided journeys.',
                'sort_order' => 2,
            ],
            [
                'name' => 'Trekking in Nepal',
                'summary' => 'Multi-day treks through Nepal’s mountain regions and traditional villages.',
                'description' => 'Explore Nepal on foot with routes for a range of interests and experience levels.',
                'sort_order' => 3,
            ],
            [
                'name' => 'Wildlife & Safari',
                'summary' => 'Explore Nepal’s national parks and subtropical wildlife habitats.',
                'description' => 'Experience Nepal’s lowland landscapes and wildlife with responsible local guides.',
                'sort_order' => 4,
            ],
            [
                'name' => 'Cultural Experiences',
                'summary' => 'Discover Nepal’s heritage, living traditions, and sacred places.',
                'description' => 'Meet Nepal’s diverse cultures through heritage walks, local visits, and pilgrimage journeys.',
                'sort_order' => 5,
            ],
        ];

        foreach ($categories as $data) {
            Category::firstOrCreate(
                [
                    'destination_id' => $destination->id,
                    'name' => $data['name'],
                ],
                [
                    'summary' => $data['summary'],
                    'description' => $data['description'],
                    'is_published' => true,
                    'sort_order' => $data['sort_order'],
                ],
            );
        }
    }
}
