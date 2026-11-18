<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreWhyTravelReasonRequest;
use App\Http\Requests\Admin\UpdateWhyTravelReasonRequest;
use App\Models\WhyTravelReason;
use App\Services\MediaLibraryService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class WhyTravelReasonController extends Controller
{
    public function __construct(private readonly MediaLibraryService $mediaLibraryService) {}

    public function index(Request $request): View
    {
        $search = trim($request->string('search')->toString());
        $status = $request->string('status')->toString();

        $reasons = WhyTravelReason::query()
            ->with('media')
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($status === 'published', fn ($query) => $query->where('is_published', true))
            ->when($status === 'draft', fn ($query) => $query->where('is_published', false))
            ->orderBy('sort_order')
            ->orderBy('title')
            ->paginate(15)
            ->withQueryString();

        return view('admin.why-travel-reasons.index', [
            'reasons' => $reasons,
            'search' => $search,
            'status' => in_array($status, ['published', 'draft'], true) ? $status : '',
            'reasonCount' => WhyTravelReason::count(),
            'publishedCount' => WhyTravelReason::where('is_published', true)->count(),
        ]);
    }

    public function create(): View
    {
        return view('admin.why-travel-reasons.create', ['reason' => new WhyTravelReason]);
    }

    public function store(StoreWhyTravelReasonRequest $request): RedirectResponse
    {
        $data = $request->safe()->only(['title', 'description', 'sort_order']);
        $data['is_published'] = $request->boolean('is_published');

        $reason = WhyTravelReason::create($data);

        if ($icon = $request->file('icon_image')) {
            $this->mediaLibraryService->storeImage($reason, $icon, 'icon');
        }

        return to_route('admin.why-travel-reasons.index')
            ->with('success', 'Why travel with us item created successfully.');
    }

    public function edit(WhyTravelReason $whyTravelReason): View
    {
        $whyTravelReason->load('media');

        return view('admin.why-travel-reasons.edit', ['reason' => $whyTravelReason]);
    }

    public function update(UpdateWhyTravelReasonRequest $request, WhyTravelReason $whyTravelReason): RedirectResponse
    {
        $data = $request->safe()->only(['title', 'description', 'sort_order']);
        $data['is_published'] = $request->boolean('is_published');

        $whyTravelReason->update($data);

        if ($icon = $request->file('icon_image')) {
            $this->mediaLibraryService->storeImage($whyTravelReason, $icon, 'icon');
        }

        return to_route('admin.why-travel-reasons.index')
            ->with('success', 'Why travel with us item updated successfully.');
    }

    public function destroy(WhyTravelReason $whyTravelReason): RedirectResponse
    {
        $whyTravelReason->delete();

        return to_route('admin.why-travel-reasons.index')
            ->with('success', 'Why travel with us item deleted successfully.');
    }
}
