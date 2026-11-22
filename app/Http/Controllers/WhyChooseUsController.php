<?php

namespace App\Http\Controllers;

use App\Models\WhyTravelReason;
use Illuminate\Contracts\View\View;

class WhyChooseUsController extends Controller
{
    public function __invoke(): View
    {
        $reasons = WhyTravelReason::query()
            ->where('is_published', true)
            ->with('media')
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        return view('site.why-choose-us', compact('reasons'));
    }
}
