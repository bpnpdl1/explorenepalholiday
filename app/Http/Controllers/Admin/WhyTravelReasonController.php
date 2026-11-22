<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\WhyTravelReasons\SaveWhyTravelReasonAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreWhyTravelReasonRequest;
use App\Http\Requests\Admin\UpdateWhyTravelReasonRequest;
use App\Models\WhyTravelReason;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class WhyTravelReasonController extends Controller
{
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

    public function store(StoreWhyTravelReasonRequest $request, SaveWhyTravelReasonAction $saveReason): RedirectResponse
    {
        $data = $request->safe()->only(['title', 'description', 'sort_order']);
        $saveReason->handle($data, $request->boolean('is_published'), $request->file('icon_image'));

        return to_route('admin.why-travel-reasons.index')
            ->with('success', 'Why Choose Us reason created successfully.');
    }

    public function edit(WhyTravelReason $whyTravelReason): View
    {
        $whyTravelReason->load('media');

        return view('admin.why-travel-reasons.edit', ['reason' => $whyTravelReason]);
    }

    public function update(
        UpdateWhyTravelReasonRequest $request,
        WhyTravelReason $whyTravelReason,
        SaveWhyTravelReasonAction $saveReason,
    ): RedirectResponse {
        $data = $request->safe()->only(['title', 'description', 'sort_order']);
        $saveReason->handle($data, $request->boolean('is_published'), $request->file('icon_image'), $whyTravelReason);

        return to_route('admin.why-travel-reasons.index')
            ->with('success', 'Why Choose Us reason updated successfully.');
    }

    public function destroy(WhyTravelReason $whyTravelReason): RedirectResponse
    {
        $whyTravelReason->delete();

        return to_route('admin.why-travel-reasons.index')
            ->with('success', 'Why Choose Us reason deleted successfully.');
    }
}
