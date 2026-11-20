<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePackageReviewRequest;
use App\Http\Requests\Admin\UpdatePackageReviewRequest;
use App\Models\Package;
use App\Models\PackageReview;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PackageReviewController extends Controller
{
    public function index(Request $request): View
    {
        return view('admin.package-reviews.index', $this->reviewListData($request));
    }

    public function forPackage(Request $request, Package $package): View
    {
        return view('admin.package-reviews.index', $this->reviewListData($request, $package));
    }

    /**
     * @return array<string, mixed>
     */
    private function reviewListData(Request $request, ?Package $package = null): array
    {
        $search = trim($request->string('search')->toString());
        $selectedPackageId = $package?->id ?? $request->integer('package_id');

        if (! $package && $selectedPackageId > 0) {
            $package = Package::query()->find($selectedPackageId);
        }

        $scopedReviews = PackageReview::query()
            ->when($package, fn ($query) => $query->where('package_id', $package->id));

        $reviews = (clone $scopedReviews)
            ->with('package:id,name,slug')
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('quote', 'like', "%{$search}%")
                        ->orWhere('reviewer_name', 'like', "%{$search}%")
                        ->orWhere('reviewer_label', 'like', "%{$search}%")
                        ->orWhereHas('package', fn ($packageQuery) => $packageQuery->where('name', 'like', "%{$search}%"));
                });
            })
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return [
            'reviews' => $reviews,
            'package' => $package,
            'packages' => $this->packagesForForm(),
            'search' => $search,
            'selectedPackageId' => $package?->id ?? 0,
            'reviewCount' => (clone $scopedReviews)->count(),
            'packageCount' => (clone $scopedReviews)->distinct('package_id')->count('package_id'),
        ];
    }

    public function create(Request $request): View
    {
        $package = Package::query()->find($request->integer('package_id'));
        $maxSortOrder = $package?->reviews()->max('sort_order');

        return view('admin.package-reviews.create', [
            'review' => new PackageReview([
                'package_id' => $package?->id,
                'sort_order' => $maxSortOrder === null ? 0 : min((int) $maxSortOrder + 1, 65535),
            ]),
            'packages' => $this->packagesForForm(),
        ]);
    }

    public function store(StorePackageReviewRequest $request): RedirectResponse
    {
        $review = PackageReview::create($request->validated());

        return to_route('admin.package-reviews.package', $review->package)
            ->with('success', 'Package review created successfully.');
    }

    public function edit(PackageReview $packageReview): View
    {
        return view('admin.package-reviews.edit', [
            'review' => $packageReview->load('package:id,name,slug'),
            'packages' => $this->packagesForForm(),
        ]);
    }

    public function update(UpdatePackageReviewRequest $request, PackageReview $packageReview): RedirectResponse
    {
        $packageReview->update($request->validated());

        return to_route('admin.package-reviews.package', $packageReview->package)
            ->with('success', 'Package review updated successfully.');
    }

    public function destroy(PackageReview $packageReview): RedirectResponse
    {
        $package = $packageReview->package;
        $packageReview->delete();

        return to_route('admin.package-reviews.package', $package)
            ->with('success', 'Package review deleted successfully.');
    }

    /** @return Collection<int, Package> */
    private function packagesForForm(): Collection
    {
        return Package::query()->orderBy('name')->get(['id', 'name', 'slug']);
    }
}
