<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Contracts\View\View;

class PackageController extends Controller
{
    public function show(Package $package): View
    {
        abort_unless($package->is_published, 404);

        $package->load([
            'subcategory.category.destination',
            'seasons',
            'highlights',
            'itineraryDays',
            'elevationPoints',
            'departures',
            'features',
            'faqs',
            'reviews',
            'media',
        ]);

        return view('site.package', compact('package'));
    }
}
