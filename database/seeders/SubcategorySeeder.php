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
                'category' => 'Peak Climbing in Nepal',
                'name' => 'Everest Region Peak Climbing',
                'summary' => 'Climb Himalayan peaks in the Khumbu and Hinku regions.',
                'description' => 'Explore guided climbs such as Island Peak and Mera Peak, with acclimatization and technical preparation planned into each itinerary.',
                'sort_order' => 1,
            ],
            [
                'category' => 'Peak Climbing in Nepal',
                'name' => 'Annapurna Region Peak Climbing',
                'summary' => 'Plan a peak climb among the Annapurna range and surrounding valleys.',
                'description' => 'Browse climbing journeys in the Annapurna region, including approaches, acclimatization, and summit preparation.',
                'sort_order' => 2,
            ],
            [
                'category' => 'Peak Climbing in Nepal',
                'name' => 'Langtang Region Peak Climbing',
                'summary' => 'Climb peaks north of Kathmandu in the Langtang Himal.',
                'description' => 'Find guided climbing routes in Langtang, with time for acclimatization and local trail experiences.',
                'sort_order' => 3,
            ],
            [
                'category' => 'Tours in Nepal',
                'name' => 'Kathmandu Valley & Heritage Tours',
                'summary' => 'Visit historic squares, temples, stupas, and traditional neighborhoods.',
                'description' => 'Discover Kathmandu Valley’s living heritage through guided visits to its historic cities and sacred sites.',
                'sort_order' => 1,
            ],
            [
                'category' => 'Tours in Nepal',
                'name' => 'Pokhara & Lakeside Tours',
                'summary' => 'Explore Pokhara, Phewa Lake, and nearby viewpoints.',
                'description' => 'Browse relaxed stays and guided experiences around Pokhara’s lakeside setting and mountain viewpoints.',
                'sort_order' => 2,
            ],
            [
                'category' => 'Tours in Nepal',
                'name' => 'Nepal Discovery Tours',
                'summary' => 'Combine Nepal’s cities, landscapes, and local experiences in one trip.',
                'description' => 'Explore multi-stop journeys that connect Kathmandu, Pokhara, and other destinations across Nepal.',
                'sort_order' => 3,
            ],
            [
                'category' => 'Tours in Nepal',
                'name' => 'Wildlife & Nature Tours',
                'summary' => 'Discover national parks, river habitats, and Nepal’s lowland wildlife.',
                'description' => 'Browse nature-focused journeys with guided wildlife viewing and responsible visits to protected areas.',
                'sort_order' => 4,
            ],
            [
                'category' => 'Tours in Nepal',
                'name' => 'Pilgrimage & Spiritual Tours',
                'summary' => 'Visit Nepal’s important Buddhist and Hindu heritage sites.',
                'description' => 'Explore sacred places and pilgrimage routes with respectful, locally guided visits.',
                'sort_order' => 5,
            ],
            [
                'category' => 'Trekking in Nepal',
                'name' => 'Everest Region Trekking',
                'summary' => 'Trek through Sherpa villages and high valleys in the Khumbu.',
                'description' => 'Explore Everest Base Camp, Gokyo, and other Khumbu routes with itineraries suited to different trip lengths.',
                'sort_order' => 1,
            ],
            [
                'category' => 'Trekking in Nepal',
                'name' => 'Annapurna Region Trekking',
                'summary' => 'Walk through mountain villages and trails across the Annapurna region.',
                'description' => 'Browse journeys to Annapurna Base Camp, around the Annapurna Circuit, and through nearby valleys.',
                'sort_order' => 2,
            ],
            [
                'category' => 'Trekking in Nepal',
                'name' => 'Langtang Region Trekking',
                'summary' => 'Explore alpine valleys and Tamang communities north of Kathmandu.',
                'description' => 'Find routes through Langtang Valley, Gosainkunda, and nearby trails in the Langtang Himal.',
                'sort_order' => 3,
            ],
            [
                'category' => 'Trekking in Nepal',
                'name' => 'Manaslu Region Trekking',
                'summary' => 'Trek remote valleys and high passes around Mount Manaslu.',
                'description' => 'Explore guided routes in the Manaslu region, including the circuit and Tsum Valley, with applicable permit requirements.',
                'sort_order' => 4,
            ],
            [
                'category' => 'Trekking in Nepal',
                'name' => 'Mustang Region Trekking',
                'summary' => 'Discover high desert landscapes and historic settlements in Mustang.',
                'description' => 'Browse treks through Upper Mustang and the rain-shadow landscapes of the trans-Himalaya.',
                'sort_order' => 5,
            ],
            [
                'category' => 'Trekking in Nepal',
                'name' => 'Kanchenjunga & Makalu Trekking',
                'summary' => 'Explore remote eastern Nepal and its high mountain trails.',
                'description' => 'Find longer trekking journeys in the Kanchenjunga and Makalu regions, with logistics and permits planned in advance.',
                'sort_order' => 6,
            ],
            [
                'category' => 'Wildlife & Safari',
                'name' => 'Chitwan Jungle Safari',
                'summary' => 'Discover Chitwan’s forests, river habitats, and wildlife with local guides.',
                'description' => 'Join guided nature activities in the Terai that follow park rules and responsible wildlife-viewing practices.',
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

        $categories = Category::query()
            ->whereBelongsTo($destination)
            ->whereIn('name', collect($subcategories)->pluck('category')->unique())
            ->get()
            ->keyBy('name');

        foreach ($subcategories as $data) {
            $category = $categories->get($data['category']);

            if (! $category) {
                throw new \RuntimeException("Category not found for subcategory seed: {$data['category']}");
            }

            Subcategory::updateOrCreate(
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
