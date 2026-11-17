<?php

namespace App\Http\Controllers;

use App\Models\Destination;
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
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->limit(3)
            ->get();

        $coverImage = $destination->getFirstMediaUrl('cover', 'card')
            ?: $destination->getFirstMediaUrl('cover')
            ?: asset('site/assets/annapurna-sunrise.jpg');
        $metaDescription = Str::limit(strip_tags($destination->summary ?: $destination->description ?: ''), 160);

        return view('site.destinations.show', compact(
            'destination',
            'relatedDestinations',
            'coverImage',
            'metaDescription',
        ));
    }
}
