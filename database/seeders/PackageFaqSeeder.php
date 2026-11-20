<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageFaqSeeder extends Seeder
{
    public function run(): void
    {
        $packageFaqs = [
            'Everest Base Camp Trek' => [
                [
                    'question' => 'How challenging is the Everest Base Camp trek?',
                    'answer' => 'It is a challenging, high-altitude trek with several hours of walking on most days. Regular hiking and cardio training are recommended before departure.',
                ],
                [
                    'question' => 'How high does the trek go?',
                    'answer' => 'The itinerary reaches approximately 5,364 meters at Everest Base Camp. Take acclimatization seriously and follow your guide’s advice.',
                ],
                [
                    'question' => 'When is the best time to go?',
                    'answer' => 'Spring and autumn are the listed trekking seasons. Weather and flight operations can still affect daily plans.',
                ],
                [
                    'question' => 'Are flights to Lukla included?',
                    'answer' => 'Kathmandu–Lukla flights are included when listed in the confirmed itinerary. They are weather dependent, so allow flexibility around your international flights.',
                ],
            ],
            'Annapurna Base Camp Trek' => [
                [
                    'question' => 'How many days is the Annapurna Base Camp trek?',
                    'answer' => 'The package is 10 days and 9 nights. Check the day-by-day itinerary for the route and planned overnight stops.',
                ],
                [
                    'question' => 'How fit should I be?',
                    'answer' => 'A good level of fitness helps with consecutive walking days and long stair sections. Regular walks and hill training are useful preparation.',
                ],
                [
                    'question' => 'What is the highest point?',
                    'answer' => 'The route reaches approximately 4,130 meters at Annapurna Base Camp. Walk at a steady pace and follow your guide’s guidance.',
                ],
                [
                    'question' => 'When can I trek to Annapurna Base Camp?',
                    'answer' => 'Spring and autumn are the listed trekking seasons, with conditions varying by weather and trail conditions.',
                ],
            ],
            'Manaslu Circuit Trek' => [
                [
                    'question' => 'How difficult is the Manaslu Circuit Trek?',
                    'answer' => 'It is a challenging trek with long walking days, remote trail conditions, and a high pass crossing. Prior hiking experience and preparation are recommended.',
                ],
                [
                    'question' => 'How high does the route go?',
                    'answer' => 'The itinerary reaches approximately 5,106 meters at Larkya La Pass. The guide may adjust the pace or plan according to conditions.',
                ],
                [
                    'question' => 'Do I need special permits?',
                    'answer' => 'Yes. The restricted-area and conservation permits required for the route are arranged as listed in the confirmed itinerary.',
                ],
                [
                    'question' => 'When is the trek offered?',
                    'answer' => 'Spring and autumn are the listed trekking seasons. Confirm current route and permit conditions before booking.',
                ],
            ],
            'Langtang Valley Trek' => [
                [
                    'question' => 'How long is the Langtang Valley Trek?',
                    'answer' => 'The package is 8 days and 7 nights. See the itinerary for the daily walking route and overnight locations.',
                ],
                [
                    'question' => 'Is this trek suitable for beginners?',
                    'answer' => 'It is rated moderate. Regular walking and hill training are recommended, and optional viewpoint hikes add distance and elevation.',
                ],
                [
                    'question' => 'What is the highest point on the itinerary?',
                    'answer' => 'The itinerary reaches approximately 3,870 meters. Walk at a comfortable pace and follow your guide’s advice.',
                ],
                [
                    'question' => 'Which seasons are recommended?',
                    'answer' => 'Spring and autumn are the listed trekking seasons. Trail and weather conditions can vary.',
                ],
            ],
            'Island Peak Climbing' => [
                [
                    'question' => 'Do I need climbing experience for Island Peak?',
                    'answer' => 'Previous trekking experience and strong cardiovascular fitness are recommended. The itinerary includes basic mountaineering skills practice before the summit attempt.',
                ],
                [
                    'question' => 'How high is Island Peak?',
                    'answer' => 'Island Peak reaches approximately 6,189 meters. The summit attempt depends on weather, route conditions, and the climbing guide’s safety assessment.',
                ],
                [
                    'question' => 'Are flights to Lukla part of the package?',
                    'answer' => 'Kathmandu–Lukla flights are included when listed in the confirmed itinerary. Flights are weather dependent and plans may need flexibility.',
                ],
                [
                    'question' => 'When is the climbing season?',
                    'answer' => 'Spring and autumn are the listed climbing seasons. Summit plans depend on wind, snow, and visibility.',
                ],
            ],
            'Mera Peak Climbing' => [
                [
                    'question' => 'How high is Mera Peak?',
                    'answer' => 'The itinerary reaches approximately 6,476 meters. The summit plan depends on weather and the guide’s assessment of mountain conditions.',
                ],
                [
                    'question' => 'Do I need previous mountaineering experience?',
                    'answer' => 'Strong fitness and preparation for long days at altitude are important. Experience with crampons and an ice axe is useful, and instruction is included in the itinerary.',
                ],
                [
                    'question' => 'Are flights to Lukla included?',
                    'answer' => 'Kathmandu–Lukla flights are included when listed in the confirmed itinerary. Allow flexibility because mountain flights depend on weather.',
                ],
                [
                    'question' => 'When is Mera Peak climbing offered?',
                    'answer' => 'Spring and autumn are the listed climbing seasons. Cold, wind, and snowfall can affect summit conditions.',
                ],
            ],
            'Kathmandu Valley Heritage Tour' => [
                [
                    'question' => 'How long is the heritage tour?',
                    'answer' => 'The tour is 3 days and 2 nights, with guided visits to historic sites and traditional neighborhoods around Kathmandu Valley.',
                ],
                [
                    'question' => 'Are monument entry tickets included?',
                    'answer' => 'Entry tickets are included only when specified in the confirmed itinerary. Otherwise, tickets are paid separately at the sites.',
                ],
                [
                    'question' => 'Is the tour suitable for year-round travel?',
                    'answer' => 'The package is listed for spring, autumn, winter, and monsoon. Conditions vary through the year, and clear days offer the best distant mountain views.',
                ],
            ],
            'Chitwan Jungle Safari' => [
                [
                    'question' => 'How long is the Chitwan safari package?',
                    'answer' => 'The package is 3 days and 2 nights. Activities are guided and follow park rules and wildlife safety guidance.',
                ],
                [
                    'question' => 'Are transfers to Chitwan included?',
                    'answer' => 'Transfers are included only when listed in the confirmed itinerary. Check your booking details to confirm the transport plan.',
                ],
                [
                    'question' => 'What should I expect from the activities?',
                    'answer' => 'The itinerary may include guided nature activities with local naturalists. Wildlife sightings are not guaranteed, and visitors should follow their guide’s instructions.',
                ],
                [
                    'question' => 'When is a good time to visit?',
                    'answer' => 'Autumn, winter, and spring are the listed seasons. The Terai is warm, and summer brings heat and monsoon rain.',
                ],
            ],
        ];

        foreach ($packageFaqs as $packageName => $faqs) {
            $package = Package::query()->where('name', $packageName)->firstOrFail();

            if ($package->faqs()->exists()) {
                continue;
            }

            $package->faqs()->createMany(array_map(
                fn (array $faq, int $sortOrder): array => [
                    ...$faq,
                    'sort_order' => $sortOrder,
                ],
                $faqs,
                array_keys($faqs),
            ));
        }
    }
}
