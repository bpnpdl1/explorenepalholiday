<?php

namespace App\Actions\Admin\WhyTravelReasons;

use App\Models\WhyTravelReason;
use App\Services\MediaLibraryService;
use Illuminate\Http\UploadedFile;

class SaveWhyTravelReasonAction
{
    public function __construct(private readonly MediaLibraryService $mediaLibraryService) {}

    /** @param array<string, mixed> $attributes */
    public function handle(
        array $attributes,
        bool $isPublished,
        ?UploadedFile $iconImage = null,
        ?WhyTravelReason $reason = null,
    ): WhyTravelReason {
        $attributes['is_published'] = $isPublished;

        if ($reason) {
            $reason->update($attributes);
        } else {
            $reason = WhyTravelReason::create($attributes);
        }

        if ($iconImage) {
            $this->mediaLibraryService->storeImage($reason, $iconImage, 'icon');
        }

        return $reason;
    }
}
