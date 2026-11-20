<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Inquiries\ListInquiriesAction;
use App\Actions\Admin\Inquiries\UpdateInquiryStatusAction;
use App\Enums\PackageInquiryStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdatePackageInquiryStatusRequest;
use App\Models\PackageInquiry;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index(Request $request, ListInquiriesAction $listInquiries): View
    {
        return view('admin.inquiries.index', $listInquiries->handle($request));
    }

    public function show(PackageInquiry $packageInquiry): View
    {
        $packageInquiry->load(['package.departures', 'package.seasons']);

        return view('admin.inquiries.show', [
            'inquiry' => $packageInquiry,
            'statuses' => PackageInquiryStatus::cases(),
            'statusClasses' => PackageInquiryStatus::badgeClasses(),
        ]);
    }

    public function updateStatus(
        UpdatePackageInquiryStatusRequest $request,
        PackageInquiry $packageInquiry,
        UpdateInquiryStatusAction $updateStatus,
    ): RedirectResponse {
        $updateStatus->handle($packageInquiry, PackageInquiryStatus::from($request->validated('status')));

        return back()->with('success', 'Inquiry status updated.');
    }
}
