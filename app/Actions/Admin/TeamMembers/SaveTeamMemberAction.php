<?php

namespace App\Actions\Admin\TeamMembers;

use App\Models\TeamMember;
use App\Services\MediaLibraryService;
use Illuminate\Http\UploadedFile;

class SaveTeamMemberAction
{
    public function __construct(private readonly MediaLibraryService $mediaLibraryService) {}

    /** @param array<string, mixed> $attributes */
    public function handle(
        array $attributes,
        bool $isPublished,
        ?UploadedFile $portraitImage = null,
        bool $removePortrait = false,
        ?TeamMember $teamMember = null,
    ): TeamMember {
        $attributes['is_published'] = $isPublished;

        if ($teamMember) {
            $teamMember->update($attributes);
        } else {
            $teamMember = TeamMember::create($attributes);
        }

        if ($portraitImage) {
            $this->mediaLibraryService->storeImage($teamMember, $portraitImage, 'portrait');
        } elseif ($removePortrait) {
            $teamMember->clearMediaCollection('portrait');
        }

        return $teamMember;
    }
}
