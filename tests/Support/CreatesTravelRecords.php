<?php

namespace Tests\Support;

use App\Models\Category;
use App\Models\Destination;
use App\Models\Package;
use App\Models\Subcategory;
use Illuminate\Support\Str;

trait CreatesTravelRecords
{
    protected function createPublishedPackage(array $attributes = []): Package
    {
        $suffix = Str::uuid()->toString();

        $destination = Destination::query()->create([
            'name' => 'Test Destination '.$suffix,
            'is_published' => true,
            'sort_order' => 1,
        ]);

        $category = Category::query()->create([
            'destination_id' => $destination->id,
            'name' => 'Test Category '.$suffix,
            'is_published' => true,
            'sort_order' => 1,
        ]);

        $subcategory = Subcategory::query()->create([
            'category_id' => $category->id,
            'name' => 'Test Subcategory '.$suffix,
            'is_published' => true,
            'sort_order' => 1,
        ]);

        return Package::query()->create(array_replace([
            'subcategory_id' => $subcategory->id,
            'name' => 'Test Package '.$suffix,
            'summary' => 'A test package for feature coverage.',
            'duration_days' => 5,
            'duration_nights' => 4,
            'min_group_size' => 1,
            'max_group_size' => 6,
            'price_from' => 1200,
            'currency' => 'USD',
            'is_published' => true,
            'sort_order' => 1,
        ], $attributes));
    }
}
