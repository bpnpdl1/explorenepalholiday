<?php

namespace App\Http\Controllers;

use App\Models\GuestReview;
use Illuminate\Contracts\View\View;

class GuestReviewController extends Controller
{
    public function __invoke(): View
    {
        $reviews = GuestReview::query()
            ->orderByDesc('reviewed_at')
            ->orderByDesc('id')
            ->paginate(9);

        return view('site.guest-reviews', [
            'reviews' => $reviews,
            'averageRating' => GuestReview::query()->avg('rating'),
        ]);
    }
}
