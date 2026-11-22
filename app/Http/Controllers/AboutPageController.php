<?php

namespace App\Http\Controllers;

use App\Models\AboutPage;
use App\Models\GuestReview;
use Illuminate\Contracts\View\View;

class AboutPageController extends Controller
{
    public function __invoke(): View
    {
        $aboutPage = AboutPage::query()->findOrFail(AboutPage::SINGLETON_ID);
        $guestReviews = GuestReview::query()
            ->orderByDesc('reviewed_at')
            ->orderByDesc('id')
            ->limit(6)
            ->get();

        return view('site.about', compact('aboutPage', 'guestReviews'));
    }
}
