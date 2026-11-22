<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateApproachPageRequest;
use App\Models\ApproachPage;
use App\Services\RichContentSanitizer;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ApproachPageController extends Controller
{
    public function edit(): View
    {
        $approachPage = ApproachPage::query()->findOrFail(ApproachPage::SINGLETON_ID);

        return view('admin.approach-page.edit', compact('approachPage'));
    }

    public function update(UpdateApproachPageRequest $request, RichContentSanitizer $sanitizer): RedirectResponse
    {
        $approachPage = ApproachPage::query()->findOrFail(ApproachPage::SINGLETON_ID);
        $approachPage->update([
            'content' => $sanitizer->sanitize($request->validated('content')),
        ]);

        return to_route('admin.approach-page.edit')
            ->with('success', 'Our Approach page updated successfully.');
    }
}
