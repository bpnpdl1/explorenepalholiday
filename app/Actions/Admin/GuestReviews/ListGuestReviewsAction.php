<?php

namespace App\Actions\Admin\GuestReviews;

use App\Models\GuestReview;
use Illuminate\Http\Request;

class ListGuestReviewsAction
{
    /** @return array<string, mixed> */
    public function handle(Request $request): array
    {
        $search = trim($request->string('search')->toString());

        return [
            'reviews' => GuestReview::query()
                ->when($search !== '', function ($query) use ($search): void {
                    $query->where(function ($query) use ($search): void {
                        $query->where('reviewer_name', 'like', "%{$search}%")
                            ->orWhere('review_text', 'like', "%{$search}%")
                            ->orWhere('trip_name', 'like', "%{$search}%")
                            ->orWhere('region_name', 'like', "%{$search}%");
                    });
                })
                ->orderByDesc('reviewed_at')
                ->orderByDesc('id')
                ->paginate(15)
                ->withQueryString(),
            'search' => $search,
            'reviewCount' => GuestReview::query()->count(),
            'averageRating' => GuestReview::query()->avg('rating'),
        ];
    }
}
