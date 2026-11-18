<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;
use RuntimeException;

class TeamMemberSeeder extends Seeder
{
    public function run(): void
    {
        $teamMembers = [
            [
                'name' => 'Asha Gurung',
                'role' => 'Trip planner',
                'bio' => 'Route, season and pace guidance shaped around your plans.',
                'sort_order' => 1,
                'image' => 'person2.png',
            ],
            [
                'name' => 'Tenzing Sherpa',
                'role' => 'Trekking guide',
                'bio' => 'Walking day, altitude and trail advice for your trek.',
                'sort_order' => 2,
                'image' => 'person3.jpg',
            ],
            [
                'name' => 'Pema Tamang',
                'role' => 'Culture & wildlife guide',
                'bio' => 'Ideas for heritage visits and wildlife experiences in Nepal.',
                'sort_order' => 3,
                'image' => 'person3.png',
            ],
            [
                'name' => 'Rajan Lama',
                'role' => 'Guest support',
                'bio' => 'Answers to practical questions as you prepare to travel.',
                'sort_order' => 4,
                'image' => 'male-7275452_1280.jpg',
            ],
        ];

        foreach ($teamMembers as $data) {
            $imagePath = public_path('site/assets/'.$data['image']);

            if (! is_file($imagePath)) {
                throw new RuntimeException("Team member seed image not found: {$imagePath}");
            }

            $teamMember = TeamMember::firstOrCreate(
                ['name' => $data['name']],
                [
                    'role' => $data['role'],
                    'bio' => $data['bio'],
                    'is_published' => false,
                    'sort_order' => $data['sort_order'],
                ],
            );

            if (! $teamMember->getFirstMedia('portrait')) {
                $teamMember->addMedia($imagePath)
                    ->preservingOriginal()
                    ->usingName($data['name'].' portrait')
                    ->toMediaCollection('portrait');
            }
        }
    }
}
