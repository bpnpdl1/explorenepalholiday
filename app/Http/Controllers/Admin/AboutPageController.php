<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateAboutPageRequest;
use App\Models\AboutPage;
use App\Services\RichContentSanitizer;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class AboutPageController extends Controller
{
    public function edit(): View
    {
        $aboutPage = AboutPage::query()->findOrFail(AboutPage::SINGLETON_ID);

        return view('admin.about-page.edit', compact('aboutPage'));
    }

    public function update(UpdateAboutPageRequest $request, RichContentSanitizer $sanitizer): RedirectResponse
    {
        $aboutPage = AboutPage::query()->findOrFail(AboutPage::SINGLETON_ID);
        $aboutPage->update([
            'content' => $sanitizer->sanitize($request->validated('content')),
        ]);

        return to_route('admin.about-page.edit')
            ->with('success', 'About Us page updated successfully.');
    }
}
