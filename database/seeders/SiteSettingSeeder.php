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
            'footer_resources_eyebrow' => 'PLAN WITH GOOD INFORMATION',
            'footer_resources_title' => 'Nepal travel resources',
            'footer_resources_description' => 'External organizations for travel, conservation and trekking guidance.',
            'footer_resources' => [
                ['name' => 'Government of Nepal tourism ministry', 'url' => 'https://tourism.gov.np/', 'logo' => '/site/assets/nepal-goverment.svg', 'alt' => 'Government of Nepal tourism ministry'],
                ['name' => 'Nepal Tourism Board', 'url' => 'https://ntb.gov.np/', 'logo' => '/site/assets/ntb.svg', 'alt' => 'Nepal Tourism Board'],
                ['name' => 'Nepal Mountaineering Association', 'url' => 'https://www.nepalmountaineering.org/', 'logo' => '/site/assets/nma.svg', 'alt' => 'Nepal Mountaineering Association'],
                ['name' => "Trekking Agencies' Association of Nepal", 'url' => 'https://www.taan.org.np/', 'logo' => '/site/assets/taan.svg', 'alt' => "Trekking Agencies' Association of Nepal"],
                ['name' => 'Kathmandu Environmental Education Project', 'url' => 'https://keepnepal.org/', 'logo' => '/site/assets/keep.webp', 'alt' => 'Kathmandu Environmental Education Project'],
            ],
            'footer_payment_title' => 'PAYMENT OPTIONS',
            'footer_payment_description' => 'Card networks shown as examples. Accepted methods are confirmed before you pay.',
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
