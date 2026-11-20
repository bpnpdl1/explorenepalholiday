<?php

namespace App\Actions\Admin\Destinations;

use App\Models\Destination;
use App\Services\MediaLibraryService;
use App\Services\RichContentSanitizer;
use Illuminate\Http\UploadedFile;

class SaveDestinationAction
{
    public function __construct(
        private readonly RichContentSanitizer $richContentSanitizer,
        private readonly MediaLibraryService $mediaLibraryService,
    ) {}

    /** @param array<string, mixed> $attributes */
    public function handle(
        array $attributes,
        bool $isPublished,
        ?UploadedFile $coverImage = null,
        ?Destination $destination = null,
    ): Destination {
        $attributes['is_published'] = $isPublished;
        $attributes['description'] = $this->richContentSanitizer->sanitize($attributes['description'] ?? null);

        if ($destination) {
            $destination->update($attributes);
        } else {
            $destination = Destination::create($attributes);
        }

        if ($coverImage) {
            $this->mediaLibraryService->storeImage($destination, $coverImage, 'cover');
        }

        return $destination;
    }
}
