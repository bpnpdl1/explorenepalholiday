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
                'name' => 'Trekking',
                'summary' => 'Multi-day treks through Nepal’s mountain regions and traditional villages.',
                'description' => 'Explore Nepal on foot with routes for a range of interests and experience levels.',
                'sort_order' => 1,
            ],
            [
                'name' => 'Peak Climbing',
                'summary' => 'Non-technical and technical climbing journeys among the Himalayan peaks.',
                'description' => 'Plan a Himalayan peak climb with experienced local support and a considered itinerary.',
                'sort_order' => 2,
            ],
            [
                'name' => 'Tours',
                'summary' => 'Guided journeys through Nepal’s historic cities, mountain towns, and landscapes.',
                'description' => 'Discover Nepal through cultural visits, scenic drives, and experiences with local guides.',
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
