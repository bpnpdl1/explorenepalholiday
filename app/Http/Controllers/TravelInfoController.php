<?php

namespace App\Http\Controllers;

use App\Models\TravelInfoPage;
use Illuminate\Contracts\View\View;

class TravelInfoController extends Controller
{
    public function index(): View
    {
        $travelInfoPages = TravelInfoPage::query()
            ->where('is_published', true)
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        return view('site.travel-info.index', compact('travelInfoPages'));
    }

    public function show(string $slug): View
    {
        $travelInfoPage = TravelInfoPage::query()
            ->where('is_published', true)
            ->where('slug', $slug)
            ->firstOrFail();

        return view('site.travel-info.show', compact('travelInfoPage'));
    }
}
