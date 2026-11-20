<?php

namespace App\Http\Controllers;

use App\Actions\Notifications\SendSubmissionNotificationsAction;
use App\Http\Requests\StorePackageInquiryRequest;
use App\Models\Package;
use App\Models\PackageInquiry;
use Illuminate\Http\RedirectResponse;

class PackageInquiryController extends Controller
{
    public function store(
        StorePackageInquiryRequest $request,
        Package $package,
        SendSubmissionNotificationsAction $sendNotifications,
    ): RedirectResponse {
        abort_unless($package->is_published, 404);

        $inquiry = new PackageInquiry($request->validated());
        $inquiry->package()->associate($package);
        $inquiry->save();
        $sendNotifications->handle($inquiry);

        return redirect()
            ->to(route('packages.show', $package).'#sidebar-enquiry-form')
            ->with('inquiry_submitted', true);
    }
}
