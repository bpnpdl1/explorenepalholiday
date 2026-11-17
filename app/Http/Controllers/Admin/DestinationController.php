<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDestinationRequest;
use App\Http\Requests\Admin\UpdateDestinationRequest;
use App\Models\Destination;
use App\Services\RichContentSanitizer;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function __construct(private readonly RichContentSanitizer $richContentSanitizer) {}

    public function index(Request $request): View
    {
        $search = trim($request->string('search')->toString());
        $status = $request->string('status')->toString();

        $destinations = Destination::query()
            ->with('media')
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%");
                });
            })
            ->when($status === 'published', fn ($query) => $query->where('is_published', true))
            ->when($status === 'draft', fn ($query) => $query->where('is_published', false))
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.destinations.index', [
            'destinations' => $destinations,
            'search' => $search,
            'status' => in_array($status, ['published', 'draft'], true) ? $status : '',
            'destinationCount' => Destination::count(),
            'publishedCount' => Destination::where('is_published', true)->count(),
        ]);
    }

    public function create(): View
    {
        return view('admin.destinations.create', ['destination' => new Destination]);
    }

    public function store(StoreDestinationRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('cover_image');
        $data['is_published'] = $request->boolean('is_published');
        $data['description'] = $this->richContentSanitizer->sanitize($data['description'] ?? null);

        $destination = Destination::create($data);

        if ($request->hasFile('cover_image')) {
            $destination->addMediaFromRequest('cover_image')->toMediaCollection('cover');
        }

        return to_route('admin.destinations.index')
            ->with('success', 'Destination created successfully.');
    }

    public function edit(Destination $destination): View
    {
        $destination->load('media');

        return view('admin.destinations.edit', compact('destination'));
    }

    public function update(UpdateDestinationRequest $request, Destination $destination): RedirectResponse
    {
        $data = $request->safe()->except('cover_image');
        $data['is_published'] = $request->boolean('is_published');
        $data['description'] = $this->richContentSanitizer->sanitize($data['description'] ?? null);

        $destination->update($data);

        if ($request->hasFile('cover_image')) {
            $destination->addMediaFromRequest('cover_image')->toMediaCollection('cover');
        }

        return to_route('admin.destinations.index')
            ->with('success', 'Destination updated successfully.');
    }

    public function destroy(Destination $destination): RedirectResponse
    {
        $destination->delete();

        return to_route('admin.destinations.index')
            ->with('success', 'Destination deleted successfully.');
    }
}
