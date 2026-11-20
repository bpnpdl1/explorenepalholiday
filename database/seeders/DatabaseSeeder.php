<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            DestinationSeeder::class,
            SiteSettingSeeder::class,
            CategorySeeder::class,
            SubcategorySeeder::class,
            PackageSeeder::class,
            PackageFaqSeeder::class,
            PackageFeatureSeeder::class,
            PackageItinerarySeeder::class,
            GuestReviewSeeder::class,
            PackageReviewSeeder::class,
            TeamMemberSeeder::class,
            WhyTravelReasonSeeder::class,
            AdminSeeder::class,
        ]);
    }
}
