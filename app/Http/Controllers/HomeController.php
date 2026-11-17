<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Faq;
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

        return view('site.home', compact('destinations', 'faqs'));
    }
}
