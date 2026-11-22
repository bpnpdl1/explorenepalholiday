<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTravelInfoPageRequest;
use App\Http\Requests\Admin\UpdateTravelInfoPageRequest;
use App\Models\TravelInfoPage;
use App\Services\RichContentSanitizer;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TravelInfoPageController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim($request->string('search')->toString());
        $status = $request->string('status')->toString();

        $travelInfoPages = TravelInfoPage::query()
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%");
                });
            })
            ->when($status === 'published', fn ($query) => $query->where('is_published', true))
            ->when($status === 'draft', fn ($query) => $query->where('is_published', false))
            ->orderBy('sort_order')
            ->orderBy('title')
            ->paginate(15)
            ->withQueryString();

        return view('admin.travel-info-pages.index', [
            'travelInfoPages' => $travelInfoPages,
            'search' => $search,
            'status' => in_array($status, ['published', 'draft'], true) ? $status : '',
        ]);
    }

    public function create(): View
    {
        return view('admin.travel-info-pages.create', ['travelInfoPage' => new TravelInfoPage]);
    }

    public function store(StoreTravelInfoPageRequest $request, RichContentSanitizer $sanitizer): RedirectResponse
    {
        $attributes = $request->safe()->only(['title', 'slug', 'sort_order']);
        $attributes['content'] = $sanitizer->sanitize($request->validated('content'));
        $attributes['is_published'] = $request->boolean('is_published');

        TravelInfoPage::create($attributes);

        return to_route('admin.travel-info-pages.index')
            ->with('success', 'Travel information page created successfully.');
    }

    public function edit(TravelInfoPage $travelInfoPage): View
    {
        return view('admin.travel-info-pages.edit', compact('travelInfoPage'));
    }

    public function update(
        UpdateTravelInfoPageRequest $request,
        TravelInfoPage $travelInfoPage,
        RichContentSanitizer $sanitizer,
    ): RedirectResponse {
        $attributes = $request->safe()->only(['title', 'slug', 'sort_order']);
        $attributes['content'] = $sanitizer->sanitize($request->validated('content'));
        $attributes['is_published'] = $request->boolean('is_published');
        $travelInfoPage->update($attributes);

        return to_route('admin.travel-info-pages.index')
            ->with('success', 'Travel information page updated successfully.');
    }

    public function destroy(TravelInfoPage $travelInfoPage): RedirectResponse
    {
        $travelInfoPage->delete();

        return to_route('admin.travel-info-pages.index')
            ->with('success', 'Travel information page deleted successfully.');
    }
}
