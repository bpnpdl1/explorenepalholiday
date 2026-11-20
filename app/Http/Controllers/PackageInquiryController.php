<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePackageInquiryRequest;
use App\Models\Package;
use Illuminate\Http\RedirectResponse;

class PackageInquiryController extends Controller
{
    public function store(StorePackageInquiryRequest $request, Package $package): RedirectResponse
    {
        abort_unless($package->is_published, 404);

        $package->inquiries()->create($request->validated());

        return redirect()
            ->to(route('packages.show', $package).'#sidebar-enquiry-form')
            ->with('inquiry_submitted', true);
    }
}
