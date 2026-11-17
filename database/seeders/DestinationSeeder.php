<?php

namespace Database\Seeders;

use App\Models\Destination;
use App\Services\RichContentSanitizer;
use Illuminate\Database\Seeder;
use RuntimeException;

class DestinationSeeder extends Seeder
{
    public function run(): void
    {
        $destinations = [
            [
                'name' => 'Nepal',
                'summary' => 'Discover Nepal, from Himalayan trails and ancient cities to wildlife-rich lowlands and welcoming mountain communities.',
                'description' => '<p>Nepal is a land of remarkable contrasts, where the <strong>Himalaya</strong> rises above green valleys, historic cities, and subtropical plains. Travelers can trek to mountain viewpoints, explore centuries-old temples, and experience the warmth of local communities.</p><p>Whether you are looking for an active trek or a slower cultural journey, Nepal offers many ways to make the trip your own.</p>',
                'sort_order' => 1,
                'image' => 'nepal-trail.jpg',
            ],
            [
                'name' => 'Bhutan',
                'summary' => 'Discover Bhutan\'s Himalayan valleys, cliffside monasteries, traditional dzongs, and distinctive local culture.',
                'description' => '<p>Bhutan offers a quieter Himalayan journey through forested valleys, traditional villages, and striking dzong architecture. Visit the iconic <strong>Paro Taktsang</strong>, learn about local Buddhist traditions, and take in wide mountain views along the way.</p><p>Our team can help shape a thoughtful itinerary around your interests and travel dates.</p>',
                'sort_order' => 2,
                'image' => 'everest-hikers.jpg',
            ],
            [
                'name' => 'Tibet',
                'summary' => 'Explore Tibet\'s high plateau, Buddhist monasteries, sacred landmarks, and far-reaching Himalayan landscapes.',
                'description' => '<p>Tibet is known for its high-altitude plateau, enduring Buddhist traditions, and vast mountain scenery. Discover monasteries and historic landmarks, experience the distinct local culture, and plan carefully for the altitude.</p><p>Travel arrangements and access requirements should be confirmed before departure.</p>',
                'sort_order' => 3,
                'image' => 'kathmandu-stupa.jpg',
            ],
        ];
        $sanitizer = app(RichContentSanitizer::class);

        foreach ($destinations as $data) {
            $imagePath = public_path('site/assets/'.$data['image']);

            if (! is_file($imagePath)) {
                throw new RuntimeException("Destination seed image not found: {$imagePath}");
            }

            $destination = Destination::firstOrCreate(
                ['name' => $data['name']],
                [
                    'summary' => $data['summary'],
                    'description' => $sanitizer->sanitize($data['description']),
                    'is_published' => true,
                    'sort_order' => $data['sort_order'],
                ],
            );

            if (! $destination->getFirstMedia('cover')) {
                $destination->addMedia($imagePath)
                    ->preservingOriginal()
                    ->usingName($data['name'].' cover')
                    ->toMediaCollection('cover');
            }
        }
    }
}
