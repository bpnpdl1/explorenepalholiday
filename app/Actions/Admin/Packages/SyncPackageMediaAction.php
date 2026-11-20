<?php

namespace App\Actions\Admin\Packages;

use App\Models\Package;
use App\Services\MediaLibraryService;
use Illuminate\Http\UploadedFile;

class SyncPackageMediaAction
{
    public function __construct(private readonly MediaLibraryService $mediaLibraryService) {}

    /**
     * @param  array<int, UploadedFile>  $gallery
     * @param  array<int, int>  $removeGalleryIds
     */
    public function handle(
        Package $package,
        ?UploadedFile $cover,
        array $gallery,
        ?UploadedFile $routeMap,
        bool $removeRouteMap,
        array $removeGalleryIds,
    ): void {
        if ($cover) {
            $this->mediaLibraryService->storeImage($package, $cover, 'cover');
        }

        foreach ($gallery as $image) {
            $this->mediaLibraryService->storeImage($package, $image, 'gallery');
        }

        if ($routeMap) {
            $this->mediaLibraryService->storeImage($package, $routeMap, 'route_map');
        } elseif ($removeRouteMap) {
            $package->getMedia('route_map')->each->delete();
        }

        if ($removeGalleryIds !== []) {
            $package->media()
                ->where('collection_name', 'gallery')
                ->whereIn('id', $removeGalleryIds)
                ->get()
                ->each
                ->delete();
        }
    }
}
