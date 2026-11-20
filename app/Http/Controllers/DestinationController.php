<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Package;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;

class DestinationController extends Controller
{
    public function show(Destination $destination): View
    {
        abort_unless($destination->is_published, 404);

        $destination->loadMissing('media');

        $relatedDestinations = Destination::query()
            ->where('is_published', true)
            ->whereKeyNot($destination->getKey())
            ->with('media')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->limit(3)
            ->get();

        $packages = Package::query()
            ->where('is_published', true)
            ->whereHas('subcategory.category', fn ($query) => $query->where('destination_id', $destination->id))
            ->with([
                'subcategory.category.destination',
                'seasons',
                'media',
            ])
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(9)
            ->withQueryString();

        $coverImage = $destination->getFirstMediaUrl('cover', 'card')
            ?: $destination->getFirstMediaUrl('cover')
            ?: asset('site/assets/annapurna-sunrise.jpg');
        $metaDescription = Str::limit(strip_tags($destination->summary ?: $destination->description ?: ''), 160);

        return view('site.destinations.show', compact(
            'destination',
            'relatedDestinations',
            'packages',
            'coverImage',
            'metaDescription',
        ));
    }
}
