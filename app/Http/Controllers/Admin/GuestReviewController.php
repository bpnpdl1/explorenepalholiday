<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGuestReviewRequest;
use App\Http\Requests\Admin\UpdateGuestReviewRequest;
use App\Models\GuestReview;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GuestReviewController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim($request->string('search')->toString());

        $reviews = GuestReview::query()
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
            ->withQueryString();

        return view('admin.guest-reviews.index', [
            'reviews' => $reviews,
            'search' => $search,
            'reviewCount' => GuestReview::count(),
            'averageRating' => GuestReview::query()->avg('rating'),
        ]);
    }

    public function create(): View
    {
        return view('admin.guest-reviews.create', ['review' => new GuestReview]);
    }

    public function store(StoreGuestReviewRequest $request): RedirectResponse
    {
        GuestReview::create($request->validated());

        return to_route('admin.guest-reviews.index')
            ->with('success', 'Guest review created successfully.');
    }

    public function edit(GuestReview $guestReview): View
    {
        return view('admin.guest-reviews.edit', ['review' => $guestReview]);
    }

    public function update(UpdateGuestReviewRequest $request, GuestReview $guestReview): RedirectResponse
    {
        $guestReview->update($request->validated());

        return to_route('admin.guest-reviews.index')
            ->with('success', 'Guest review updated successfully.');
    }

    public function destroy(GuestReview $guestReview): RedirectResponse
    {
        $guestReview->delete();

        return to_route('admin.guest-reviews.index')
            ->with('success', 'Guest review deleted successfully.');
    }
}
