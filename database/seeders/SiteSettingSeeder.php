<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use RuntimeException;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaults = [
            'name' => 'Explore Nepal Holidays',
            'tagline' => 'For mountain days, meaningful encounters, and all the moments in between. Find your own way into Nepal.',
            'description' => 'Discover Nepal with Explore Nepal Holidays.',
            'email' => 'info@explorenepalholidays.com',
            'phone' => '+977 980-000-0000',
            'whatsapp_number' => '+977 980-000-0000',
            'address' => 'Thamel, Kathmandu, Nepal',
            'meta_title' => 'Explore Nepal Holidays | Treks, Tours & Tailor-Made Journeys',
            'meta_description' => 'Explore Nepal\'s mountain trails, cultural cities and wild lowlands. Discover handpicked journeys and plan a trip shaped around you.',
            'canonical_url' => 'https://explorenepalholidays.com/',
            'og_title' => 'Explore Nepal Holidays | Treks, Tours & Tailor-Made Journeys',
            'og_description' => 'Explore Nepal\'s mountain trails, cultural cities and wild lowlands. Discover handpicked journeys and plan a trip shaped around you.',
        ];

        $siteSetting = SiteSetting::query()->first();

        if (! $siteSetting) {
            $siteSetting = SiteSetting::query()->create($defaults);
        } else {
            $missingDefaults = collect($defaults)
                ->filter(fn ($value, $attribute): bool => blank($siteSetting->getAttribute($attribute)) && filled($value))
                ->all();

            if ($missingDefaults !== []) {
                $siteSetting->fill($missingDefaults)->save();
            }
        }

        $logoPath = public_path('site/assets/logo-mark.png');

        if (! is_file($logoPath)) {
            throw new RuntimeException("Site setting seed logo not found: {$logoPath}");
        }

        if (! $siteSetting->getFirstMedia('logo')) {
            $siteSetting->addMedia($logoPath)
                ->preservingOriginal()
                ->usingName('Explore Nepal Holidays logo')
                ->toMediaCollection('logo');
        }

        $faviconPath = public_path('site/assets/favicon.png');

        if (! is_file($faviconPath)) {
            throw new RuntimeException("Site setting seed favicon not found: {$faviconPath}");
        }

        if (! $siteSetting->getFirstMedia('favicon')) {
            $siteSetting->addMedia($faviconPath)
                ->preservingOriginal()
                ->usingName('Explore Nepal Holidays favicon')
                ->toMediaCollection('favicon');
        }

        Cache::forget(SiteSetting::CACHE_KEY);
    }
}
