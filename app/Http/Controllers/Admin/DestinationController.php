<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Destinations\SaveDestinationAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDestinationRequest;
use App\Http\Requests\Admin\UpdateDestinationRequest;
use App\Models\Destination;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
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

    public function store(StoreDestinationRequest $request, SaveDestinationAction $saveDestination): RedirectResponse
    {
        $data = $request->safe()->except('cover_image');
        $saveDestination->handle($data, $request->boolean('is_published'), $request->file('cover_image'));

        return to_route('admin.destinations.index')
            ->with('success', 'Destination created successfully.');
    }

    public function edit(Destination $destination): View
    {
        $destination->load('media');

        return view('admin.destinations.edit', compact('destination'));
    }

    public function update(
        UpdateDestinationRequest $request,
        Destination $destination,
        SaveDestinationAction $saveDestination,
    ): RedirectResponse {
        $data = $request->safe()->except('cover_image');
        $saveDestination->handle($data, $request->boolean('is_published'), $request->file('cover_image'), $destination);

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
