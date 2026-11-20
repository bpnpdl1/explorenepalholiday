<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\PackageReviews\ListPackageReviewsAction;
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
    public function index(Request $request, ListPackageReviewsAction $listReviews): View
    {
        return view('admin.package-reviews.index', $listReviews->handle($request));
    }

    public function forPackage(Request $request, Package $package, ListPackageReviewsAction $listReviews): View
    {
        return view('admin.package-reviews.index', $listReviews->handle($request, $package));
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
