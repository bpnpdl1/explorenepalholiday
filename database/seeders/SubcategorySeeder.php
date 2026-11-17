<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Destination;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;

class SubcategorySeeder extends Seeder
{
    public function run(): void
    {
        $destination = Destination::query()->where('name', 'Nepal')->firstOrFail();

        $subcategories = [
            [
                'category' => 'Trekking',
                'name' => 'Everest Base Camp Trek',
                'summary' => 'Trek through Sherpa villages to the base of the world’s highest mountain.',
                'description' => 'A classic Himalayan trek through the Khumbu region, with acclimatization days and mountain lodge stays.',
                'sort_order' => 1,
            ],
            [
                'category' => 'Trekking',
                'name' => 'Annapurna Base Camp Trek',
                'summary' => 'Walk into a high mountain sanctuary surrounded by the Annapurna range.',
                'description' => 'Follow forest trails and mountain paths through Gurung villages to Annapurna Base Camp.',
                'sort_order' => 2,
            ],
            [
                'category' => 'Trekking',
                'name' => 'Manaslu Circuit Trek',
                'summary' => 'Cross remote valleys and high passes around Mount Manaslu.',
                'description' => 'A challenging circuit through the Budhi Gandaki valley and over Larkya La, with the required local permits and guide.',
                'sort_order' => 3,
            ],
            [
                'category' => 'Trekking',
                'name' => 'Langtang Valley Trek',
                'summary' => 'Explore alpine scenery and Tamang communities north of Kathmandu.',
                'description' => 'A rewarding route through forests, yak pastures, and mountain villages in Langtang National Park.',
                'sort_order' => 4,
            ],
            [
                'category' => 'Peak Climbing',
                'name' => 'Island Peak Climbing',
                'summary' => 'Combine a Khumbu trek with a guided ascent of Island Peak.',
                'description' => 'A mountaineering journey that pairs acclimatization in the Everest region with a technical summit attempt.',
                'sort_order' => 1,
            ],
            [
                'category' => 'Peak Climbing',
                'name' => 'Mera Peak Climbing',
                'summary' => 'Reach a high Himalayan summit with broad views across the Khumbu peaks.',
                'description' => 'A high-altitude climbing itinerary through the Hinku Valley, planned with time for acclimatization.',
                'sort_order' => 2,
            ],
            [
                'category' => 'Tours',
                'name' => 'Kathmandu Valley Heritage Tour',
                'summary' => 'Visit historic squares, temples, and traditional neighborhoods around Kathmandu.',
                'description' => 'A guided introduction to the architecture and living heritage of Kathmandu Valley.',
                'sort_order' => 1,
            ],
            [
                'category' => 'Tours',
                'name' => 'Pokhara and Phewa Lake Tour',
                'summary' => 'Enjoy lakeside views and cultural highlights in Pokhara.',
                'description' => 'Explore Pokhara’s lakeside setting, viewpoints, and local attractions at a relaxed pace.',
                'sort_order' => 2,
            ],
            [
                'category' => 'Wildlife & Safari',
                'name' => 'Chitwan Jungle Safari',
                'summary' => 'Discover the forests and wildlife of Chitwan National Park.',
                'description' => 'Join guided nature activities in the Terai, following park rules and responsible wildlife viewing practices.',
                'sort_order' => 1,
            ],
            [
                'category' => 'Cultural Experiences',
                'name' => 'Lumbini Pilgrimage Tour',
                'summary' => 'Visit the birthplace of the Buddha and its international monastic zone.',
                'description' => 'Explore the sacred garden, archaeological sites, and monasteries of Lumbini with a knowledgeable guide.',
                'sort_order' => 1,
            ],
        ];

        foreach ($subcategories as $data) {
            $category = Category::query()
                ->whereBelongsTo($destination)
                ->where('name', $data['category'])
                ->firstOrFail();

            Subcategory::firstOrCreate(
                [
                    'category_id' => $category->id,
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
