<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\SiteSettings\UpdateSiteSettingsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSiteSettingRequest;
use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SiteSettingController extends Controller
{
    public function edit(): View
    {
        $siteSetting = SiteSetting::query()
            ->with('media')
            ->firstOrFail();

        return view('admin.site-settings.edit', compact('siteSetting'));
    }

    public function update(UpdateSiteSettingRequest $request, UpdateSiteSettingsAction $updateSiteSettings): RedirectResponse
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
        $updateSiteSettings->handle(
            $siteSetting,
            $data,
            $request->file('logo'),
            $request->file('favicon'),
            $request->file('footer_logo'),
        );

        return to_route('admin.site-settings.edit')
            ->with('success', 'Site settings updated successfully.');
    }
}
