<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSiteSettingRequest;
use App\Models\SiteSetting;
use App\Services\MediaLibraryService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SiteSettingController extends Controller
{
    public function __construct(private readonly MediaLibraryService $mediaLibraryService) {}

    public function edit(): View
    {
        $siteSetting = SiteSetting::query()
            ->with('media')
            ->firstOrFail();

        return view('admin.site-settings.edit', compact('siteSetting'));
    }

    public function update(UpdateSiteSettingRequest $request): RedirectResponse
    {
        $siteSetting = SiteSetting::query()->firstOrFail();
        $data = $request->safe()->only([
            'name',
            'tagline',
            'description',
            'email',
            'phone',
            'whatsapp_number',
            'address',
            'social_links',
            'meta_title',
            'meta_description',
            'canonical_url',
            'og_title',
            'og_description',
        ]);
        $data['social_links'] = array_filter(
            $data['social_links'] ?? [],
            fn (?string $url): bool => filled($url),
        );

        $siteSetting->update($data);

        if ($logo = $request->file('logo')) {
            $this->mediaLibraryService->storeImage($siteSetting, $logo, 'logo');
        }

        if ($favicon = $request->file('favicon')) {
            $this->mediaLibraryService->storeImage($siteSetting, $favicon, 'favicon');
        }

        return to_route('admin.site-settings.edit')
            ->with('success', 'Site settings updated successfully.');
    }
}
