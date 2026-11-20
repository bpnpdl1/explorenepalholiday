<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\GuestReviews\ListGuestReviewsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGuestReviewRequest;
use App\Http\Requests\Admin\UpdateGuestReviewRequest;
use App\Models\GuestReview;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GuestReviewController extends Controller
{
    public function index(Request $request, ListGuestReviewsAction $listReviews): View
    {
        return view('admin.guest-reviews.index', $listReviews->handle($request));
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
