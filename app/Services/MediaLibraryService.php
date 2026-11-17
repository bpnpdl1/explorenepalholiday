<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaLibraryService
{
    public function storeImage(HasMedia $model, UploadedFile $image, string $collection): Media
    {
        Validator::make(['image' => $image], [
            'image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp,avif',
                'max:10240',
                'dimensions:max_width=12000,max_height=12000',
            ],
        ])->validate();

        return $model
            ->addMedia($image)
            ->usingFileName($image->hashName())
            ->toMediaCollection($collection);
    }
}
