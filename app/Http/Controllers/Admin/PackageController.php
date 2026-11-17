<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class PackageController extends Controller
{
    public function index(): View
    {
        $packages = $this->packages();

        return view('admin.packages.index', [
            'packages' => $packages,
            'categories' => array_values(array_unique(array_column($packages, 'category'))),
            'packageCount' => count($packages),
            'publishedCount' => count(array_filter($packages, fn (array $package): bool => $package['status'] === 'Published')),
            'draftCount' => count(array_filter($packages, fn (array $package): bool => $package['status'] === 'Draft')),
            'bookingCount' => array_sum(array_column($packages, 'bookings')),
        ]);
    }

    public function show(string $slug): View
    {
        $package = collect($this->packages())->firstWhere('slug', $slug);

        abort_unless($package, 404);

        return view('admin.packages.show', ['package' => $package]);
    }

    /**
     * Static package records used until the package catalog is connected to storage.
     *
     * @return array<int, array{name: string, slug: string, category: string, destination: string, duration: string, price: string, bookings: int, status: string, status_class: string, description: string}>
     */
    private function packages(): array
    {
        return [
            [
                'name' => 'Everest Base Camp Trek',
                'slug' => 'everest-base-camp-trek',
                'category' => 'Trekking',
                'destination' => 'Khumbu Region',
                'duration' => '14 days',
                'price' => 'USD 1,450',
                'bookings' => 42,
                'status' => 'Published',
                'status_class' => 'success',
                'description' => 'A classic trek through Sherpa villages to the base of the world’s highest mountain.',
            ],
            [
                'name' => 'Annapurna Circuit Trek',
                'slug' => 'annapurna-circuit-trek',
                'category' => 'Trekking',
                'destination' => 'Annapurna Region',
                'duration' => '12 days',
                'price' => 'USD 1,150',
                'bookings' => 36,
                'status' => 'Published',
                'status_class' => 'success',
                'description' => 'A high mountain circuit with Himalayan scenery and traditional villages.',
            ],
            [
                'name' => 'Chitwan Wildlife Safari',
                'slug' => 'chitwan-wildlife-safari',
                'category' => 'Wildlife',
                'destination' => 'Chitwan',
                'duration' => '3 days',
                'price' => 'USD 420',
                'bookings' => 28,
                'status' => 'Published',
                'status_class' => 'success',
                'description' => 'Explore the forests and wildlife of Chitwan National Park with a local guide.',
            ],
            [
                'name' => 'Kathmandu Heritage Tour',
                'slug' => 'kathmandu-heritage-tour',
                'category' => 'Cultural',
                'destination' => 'Kathmandu Valley',
                'duration' => '4 days',
                'price' => 'USD 360',
                'bookings' => 19,
                'status' => 'Published',
                'status_class' => 'success',
                'description' => 'Visit historic squares, temples, and cultural sites across the Kathmandu Valley.',
            ],
            [
                'name' => 'Manaslu Circuit Trek',
                'slug' => 'manaslu-circuit-trek',
                'category' => 'Trekking',
                'destination' => 'Manaslu Region',
                'duration' => '16 days',
                'price' => 'USD 1,780',
                'bookings' => 0,
                'status' => 'Draft',
                'status_class' => 'warning',
                'description' => 'A remote circuit through mountain settlements and high Himalayan passes.',
            ],
            [
                'name' => 'Pokhara Adventure Escape',
                'slug' => 'pokhara-adventure-escape',
                'category' => 'Adventure',
                'destination' => 'Pokhara',
                'duration' => '5 days',
                'price' => 'USD 510',
                'bookings' => 0,
                'status' => 'Draft',
                'status_class' => 'warning',
                'description' => 'A short adventure stay with lake activities and views of the Annapurna range.',
            ],
        ];
    }
}
