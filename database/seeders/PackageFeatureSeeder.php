<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageFeatureSeeder extends Seeder
{
    public function run(): void
    {
        $packageFeatures = [
            'Everest Base Camp Trek' => [
                'included' => [
                    'Airport transfers in Kathmandu as listed in the itinerary.',
                    'Domestic flights between Kathmandu and Lukla, subject to airline operations and the confirmed itinerary.',
                    'Licensed English-speaking trekking guide and required porter support.',
                    'Teahouse accommodation during the trek and hotel accommodation in Kathmandu as listed.',
                    'Trekking permits and required local entry fees.',
                    'Meals during the trek as specified in the itinerary.',
                ],
                'excluded' => [
                    'International flights to and from Nepal.',
                    'Nepal visa fees and personal travel insurance, including high-altitude evacuation cover.',
                    'Meals in Kathmandu that are not listed in the itinerary.',
                    'Personal trekking equipment, snacks, drinks, Wi-Fi, charging, and hot showers.',
                    'Tips for guides and porters, and personal expenses.',
                ],
            ],
            'Annapurna Base Camp Trek' => [
                'included' => [
                    'Ground transfers between Pokhara and the trek trailhead as listed in the itinerary.',
                    'Licensed English-speaking trekking guide and required porter support.',
                    'Teahouse accommodation during the trek and hotel accommodation in Pokhara as listed.',
                    'Annapurna Conservation Area permits and required local entry fees.',
                    'Meals during the trek as specified in the itinerary.',
                ],
                'excluded' => [
                    'International and domestic flights to and from Nepal or Pokhara.',
                    'Nepal visa fees and personal travel insurance, including evacuation cover.',
                    'Meals in Pokhara that are not listed in the itinerary.',
                    'Personal trekking equipment, snacks, drinks, Wi-Fi, charging, and hot showers.',
                    'Tips for guides and porters, and personal expenses.',
                ],
            ],
            'Manaslu Circuit Trek' => [
                'included' => [
                    'Ground transportation between Kathmandu and the trek trailheads as listed in the itinerary.',
                    'Licensed guide and required porter support for the restricted-area route.',
                    'Restricted-area, conservation-area, and local permits required by the confirmed itinerary.',
                    'Teahouse accommodation and meals during the trek as specified in the itinerary.',
                    'Basic first-aid support from the trekking guide.',
                ],
                'excluded' => [
                    'International flights to and from Nepal.',
                    'Nepal visa fees and personal travel insurance, including high-altitude evacuation cover.',
                    'Meals in Kathmandu that are not listed in the itinerary.',
                    'Personal trekking equipment, snacks, drinks, Wi-Fi, charging, and hot showers.',
                    'Tips for guides and porters, and personal expenses.',
                ],
            ],
            'Langtang Valley Trek' => [
                'included' => [
                    'Ground transportation between Kathmandu and Syabrubesi as listed in the itinerary.',
                    'Licensed English-speaking trekking guide and required porter support.',
                    'Langtang National Park permits and required local entry fees.',
                    'Teahouse accommodation and meals during the trek as specified in the itinerary.',
                    'Basic first-aid support from the trekking guide.',
                ],
                'excluded' => [
                    'International flights to and from Nepal.',
                    'Nepal visa fees and personal travel insurance, including high-altitude evacuation cover.',
                    'Meals in Kathmandu that are not listed in the itinerary.',
                    'Personal trekking equipment, snacks, drinks, Wi-Fi, charging, and hot showers.',
                    'Tips for guides and porters, and personal expenses.',
                ],
            ],
            'Island Peak Climbing' => [
                'included' => [
                    'Airport transfers and domestic flights between Kathmandu and Lukla as listed in the itinerary.',
                    'Licensed trekking guide, climbing guide, and required porter support.',
                    'Island Peak climbing permit and required trekking permits.',
                    'Teahouse accommodation, base-camp logistics, and meals as specified in the itinerary.',
                    'Group climbing equipment and pre-summit skills practice as described in the itinerary.',
                ],
                'excluded' => [
                    'International flights to and from Nepal and Nepal visa fees.',
                    'Personal travel and high-altitude evacuation insurance.',
                    'Personal mountaineering clothing and equipment.',
                    'Meals in Kathmandu, snacks, drinks, Wi-Fi, charging, and hot showers unless listed.',
                    'Tips, personal expenses, and costs caused by itinerary changes outside the operator’s control.',
                ],
            ],
            'Mera Peak Climbing' => [
                'included' => [
                    'Airport transfers and domestic flights between Kathmandu and Lukla as listed in the itinerary.',
                    'Licensed trekking guide, climbing guide, and required porter support.',
                    'Mera Peak climbing permit and required trekking permits.',
                    'Teahouse accommodation, high-camp logistics, and meals as specified in the itinerary.',
                    'Group climbing equipment and pre-summit skills practice as described in the itinerary.',
                ],
                'excluded' => [
                    'International flights to and from Nepal and Nepal visa fees.',
                    'Personal travel and high-altitude evacuation insurance.',
                    'Personal mountaineering clothing and equipment.',
                    'Meals in Kathmandu, snacks, drinks, Wi-Fi, charging, and hot showers unless listed.',
                    'Tips, personal expenses, and costs caused by itinerary changes outside the operator’s control.',
                ],
            ],
            'Kathmandu Valley Heritage Tour' => [
                'included' => [
                    'Local English-speaking guide for the scheduled sightseeing days.',
                    'Ground transfers between listed sites as specified in the itinerary.',
                    'Hotel accommodation and breakfast when included in the confirmed booking.',
                    'Airport transfers when specified in the confirmed itinerary.',
                ],
                'excluded' => [
                    'International flights to and from Nepal and Nepal visa fees.',
                    'Monument and museum entry tickets unless listed in the confirmed itinerary.',
                    'Lunch, dinner, drinks, and personal travel insurance.',
                    'Tips, personal purchases, and other personal expenses.',
                ],
            ],
            'Chitwan Jungle Safari' => [
                'included' => [
                    'Lodge accommodation and meals as specified in the confirmed itinerary.',
                    'Scheduled guided nature activities with local naturalists.',
                    'Park entry fees and activity permits for activities listed in the itinerary.',
                    'Transfers to and from Chitwan when included in the confirmed itinerary.',
                ],
                'excluded' => [
                    'International flights to and from Nepal and Nepal visa fees.',
                    'Transfers to and from Chitwan unless specifically listed in the itinerary.',
                    'Drinks, laundry, phone or internet charges, and personal purchases.',
                    'Travel insurance, tips, and other personal expenses.',
                ],
            ],
        ];

        foreach ($packageFeatures as $packageName => $featureLists) {
            $package = Package::query()->where('name', $packageName)->firstOrFail();

            foreach ($featureLists as $type => $descriptions) {
                if ($package->features()->where('type', $type)->exists()) {
                    continue;
                }

                $package->features()->createMany(array_map(
                    fn (string $description, int $sortOrder): array => [
                        'type' => $type,
                        'description' => $description,
                        'sort_order' => $sortOrder,
                    ],
                    $descriptions,
                    array_keys($descriptions),
                ));
            }
        }
    }
}
