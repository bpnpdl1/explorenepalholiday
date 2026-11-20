<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Faq;
use App\Models\Package;
use App\Models\WhyTravelReason;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $destinations = Destination::query()
            ->where('is_published', true)
            // ->where('is_featured', true)
            ->with('media')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->limit(6)
            ->get();

        $faqs = Faq::query()
            ->where('is_published', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->limit(6)
            ->get();

        $whyTravelReasons = WhyTravelReason::query()
            ->where('is_published', true)
            ->with('media')
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        $packages = Package::query()
            ->where('is_published', true)
            ->with([
                'subcategory.category.destination',
                'seasons',
                'media',
            ])
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->limit(18)
            ->get();

        $featuredPackages = $packages->where('is_featured', true)->values();

        if ($featuredPackages->isEmpty()) {
            $featuredPackages = $packages->take(6)->values();
        }

        $featuredPackageCategories = $featuredPackages
            ->map(fn (Package $package): string => $package->subcategory->category->name)
            ->unique()
            ->values();

        $packageCategories = $packages
            ->map(fn (Package $package): string => $package->subcategory->category->name)
            ->unique()
            ->values();

        return view('site.home', compact(
            'destinations',
            'faqs',
            'whyTravelReasons',
            'packages',
            'featuredPackages',
            'featuredPackageCategories',
            'packageCategories',
        ));
    }
}
