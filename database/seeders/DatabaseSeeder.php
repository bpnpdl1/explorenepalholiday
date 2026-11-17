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
            CategorySeeder::class,
            SubcategorySeeder::class,
            GuestReviewSeeder::class,
            AdminSeeder::class,
        ]);
    }
}
