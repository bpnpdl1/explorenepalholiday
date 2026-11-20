<?php

namespace App\Actions\Admin\SiteSettings;

use App\Models\SiteSetting;
use App\Services\MediaLibraryService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;

class UpdateSiteSettingsAction
{
    public function __construct(private readonly MediaLibraryService $mediaLibraryService) {}

    /** @param array<string, mixed> $attributes */
    public function handle(
        SiteSetting $siteSetting,
        array $attributes,
        ?UploadedFile $logo = null,
        ?UploadedFile $favicon = null,
    ): void {
        $attributes['social_links'] = array_filter(
            $attributes['social_links'] ?? [],
            fn (?string $url): bool => filled($url),
        );

        $siteSetting->update($attributes);
        Cache::forget(SiteSetting::CACHE_KEY);

        if ($logo) {
            $this->mediaLibraryService->storeImage($siteSetting, $logo, 'logo');
        }

        if ($favicon) {
            $this->mediaLibraryService->storeImage($siteSetting, $favicon, 'favicon');
        }

        Cache::forget(SiteSetting::CACHE_KEY);
    }
}
