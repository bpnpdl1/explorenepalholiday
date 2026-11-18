<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

#[Fillable([
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
])]
class SiteSetting extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'social_links' => 'array',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->singleFile()
            ->useDisk(config('media-library.disk_name'))
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/avif']);

        $this->addMediaCollection('favicon')
            ->singleFile()
            ->useDisk(config('media-library.disk_name'))
            ->acceptsMimeTypes(['image/png']);
    }
}
