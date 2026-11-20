<?php

namespace App\Http\Controllers\Admin;

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
            'statusClasses' => $this->statusClasses(),
        ]);
    }

    public function updateStatus(UpdateSiteInquiryStatusRequest $request, SiteInquiry $siteInquiry): RedirectResponse
    {
        $siteInquiry->status = PackageInquiryStatus::from($request->validated('status'));
        $siteInquiry->save();

        return back()->with('success', 'Website inquiry status updated.');
    }

    /** @return array<string, string> */
    private function statusClasses(): array
    {
        return [
            PackageInquiryStatus::New->value => 'info',
            PackageInquiryStatus::Contacted->value => 'success',
            PackageInquiryStatus::Cancelled->value => 'secondary',
        ];
    }
}
