# Media Library

The app uses Spatie Laravel Media Library for model-owned uploads. Media files and generated conversions use the `media` disk, stored under `storage/app/public/media`. Run `php artisan storage:link` so the public storage link serves those files. For production, the disk can be changed to an S3-compatible disk through `MEDIA_DISK` and `MEDIA_CONVERSIONS_DISK`.

## Add travel image collections to a model

Use the `HasTravelMedia` concern on image-owning travel models such as packages, destinations, and activities. The concern provides a replaceable `cover` collection, a multiple-file `gallery` collection, and queued `thumbnail` and `card` conversions.

```php
use App\Models\Concerns\HasTravelMedia;
use App\Services\MediaLibraryService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Spatie\MediaLibrary\HasMedia;

class Package extends Model implements HasMedia
{
    use HasTravelMedia;
}
```

## Store a validated image

Inject `MediaLibraryService` into a controller or action and pass a model that implements `HasMedia`:

```php
public function store(StorePackageRequest $request, MediaLibraryService $mediaLibrary): RedirectResponse
{
    $package = Package::create($request->safe()->except('cover'));

    if ($request->hasFile('cover')) {
        $mediaLibrary->storeImage($package, $request->file('cover'), 'cover');
    }

    return to_route('admin.packages.index');
}
```

The service validates image content, allowed formats, a 10 MB limit, and maximum dimensions before attaching it. Keep authorization and request-specific validation in the Form Request as well. Use `getFirstMediaUrl('cover', 'card')` for a converted image URL, `getFirstMediaUrl('cover')` for the original, and `getMedia('gallery')` to retrieve gallery entries.

## Runtime requirements

Image conversions use GD and the database queue by default. The project has the GD extension and its dev process starts a queue listener. Run a queue worker in production so conversions complete. The media table migration is `database/migrations/2026_10_15_182030_create_media_table.php`.
