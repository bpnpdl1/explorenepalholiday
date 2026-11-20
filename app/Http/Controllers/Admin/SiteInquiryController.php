<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Inquiries\UpdateInquiryStatusAction;
use App\Enums\PackageInquiryStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSiteInquiryStatusRequest;
use App\Models\SiteInquiry;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SiteInquiryController extends Controller
{
    public function index(): RedirectResponse
    {
        return redirect()->route('admin.inquiries.index', ['source' => 'website']);
    }

    public function show(SiteInquiry $siteInquiry): View
    {
        return view('admin.site-inquiries.show', [
            'inquiry' => $siteInquiry,
            'statuses' => PackageInquiryStatus::cases(),
            'statusClasses' => PackageInquiryStatus::badgeClasses(),
        ]);
    }

    public function updateStatus(
        UpdateSiteInquiryStatusRequest $request,
        SiteInquiry $siteInquiry,
        UpdateInquiryStatusAction $updateStatus,
    ): RedirectResponse {
        $updateStatus->handle($siteInquiry, PackageInquiryStatus::from($request->validated('status')));

        return back()->with('success', 'Website inquiry status updated.');
    }
}
