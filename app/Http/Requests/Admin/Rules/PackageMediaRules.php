<?php

namespace App\Http\Requests\Admin\Rules;

class PackageMediaRules
{
    /** @return array<string, array<int, mixed>> */
    public static function rules(): array
    {
        return [
            'route_map_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:10240', 'dimensions:max_width=12000,max_height=12000'],
            'remove_route_map' => ['sometimes', 'boolean'],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:5120', 'dimensions:max_width=12000,max_height=12000'],
            'gallery' => ['nullable', 'array', 'max:20'],
            'gallery.*' => ['image', 'mimes:jpg,jpeg,png,webp,avif', 'max:5120', 'dimensions:max_width=12000,max_height=12000'],
            'remove_gallery' => ['nullable', 'array'],
            'remove_gallery.*' => ['integer', 'exists:media,id'],
        ];
    }
}
