<?php

namespace App\Http\Controllers;

use App\Actions\Notifications\SendSubmissionNotificationsAction;
use App\Http\Requests\StoreSiteInquiryRequest;
use App\Models\SiteInquiry;
use Illuminate\Http\RedirectResponse;

class SiteInquiryController extends Controller
{
    public function store(
        StoreSiteInquiryRequest $request,
        SendSubmissionNotificationsAction $sendNotifications,
    ): RedirectResponse {
        $inquiry = SiteInquiry::create($request->safe()->only(['name', 'email', 'phone', 'interest', 'message']));
        $sendNotifications->handle($inquiry);

        $confirmationUrl = match ($request->validated('source')) {
            'home' => route('home').'#plan',
            default => route('contact').'#contact-section-title',
        };

        return redirect($confirmationUrl)->with('site_inquiry_submitted', true);
    }
}
