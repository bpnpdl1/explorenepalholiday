<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class SeoController extends Controller
{
    public function index(): View
    {
        $pages = $this->pages();

        return view('admin.seo.index', [
            'pages' => $pages,
            'pageCount' => count($pages),
            'optimizedCount' => count(array_filter($pages, fn (array $page): bool => $page['status'] === 'Optimized')),
            'reviewCount' => count(array_filter($pages, fn (array $page): bool => $page['status'] === 'Needs review')),
            'indexableCount' => count(array_filter($pages, fn (array $page): bool => $page['robots'] === 'index, follow')),
        ]);
    }

    /**
     * Static SEO records used until metadata is connected to persistent storage.
     *
     * @return array<int, array{page: string, path: string, title: string, description: string, robots: string, status: string, status_class: string, updated: string}>
     */
    private function pages(): array
    {
        return [
            [
                'page' => 'Home page',
                'path' => '/',
                'title' => 'Nepal Holidays, Tours & Trekking Packages | Explore Nepal Holidays',
                'description' => 'Discover Nepal with locally guided trekking, cultural tours, wildlife experiences, and tailor-made holiday packages.',
                'robots' => 'index, follow',
                'status' => 'Optimized',
                'status_class' => 'success',
                'updated' => 'Oct 12, 2026',
            ],
            [
                'page' => 'Packages listing',
                'path' => '/packages',
                'title' => 'Nepal Tour & Trekking Packages | Explore Nepal Holidays',
                'description' => 'Browse Nepal trekking, culture, and wildlife packages. Find a trip that fits your schedule and travel style.',
                'robots' => 'index, follow',
                'status' => 'Optimized',
                'status_class' => 'success',
                'updated' => 'Oct 10, 2026',
            ],
            [
                'page' => 'Everest Base Camp Trek',
                'path' => '/packages/everest-base-camp-trek',
                'title' => 'Everest Base Camp Trek – 14 Days | Explore Nepal Holidays',
                'description' => 'Trek to Everest Base Camp in 14 days with experienced local guides. Explore Sherpa villages and Himalayan trails.',
                'robots' => 'index, follow',
                'status' => 'Optimized',
                'status_class' => 'success',
                'updated' => 'Oct 8, 2026',
            ],
            [
                'page' => 'Annapurna Circuit Trek',
                'path' => '/packages/annapurna-circuit-trek',
                'title' => 'Annapurna Circuit Trek – 12 Days | Explore Nepal Holidays',
                'description' => 'Discover the Annapurna region on a 12-day circuit trek through mountain villages and high Himalayan passes.',
                'robots' => 'index, follow',
                'status' => 'Needs review',
                'status_class' => 'warning',
                'updated' => 'Sep 26, 2026',
            ],
            [
                'page' => 'About us',
                'path' => '/about',
                'title' => 'About Explore Nepal Holidays',
                'description' => '',
                'robots' => 'index, follow',
                'status' => 'Needs review',
                'status_class' => 'warning',
                'updated' => 'Sep 18, 2026',
            ],
            [
                'page' => 'Privacy policy',
                'path' => '/privacy-policy',
                'title' => 'Privacy Policy | Explore Nepal Holidays',
                'description' => 'Read how Explore Nepal Holidays handles personal information and protects visitor privacy.',
                'robots' => 'noindex, follow',
                'status' => 'Optimized',
                'status_class' => 'success',
                'updated' => 'Sep 12, 2026',
            ],
        ];
    }
}
