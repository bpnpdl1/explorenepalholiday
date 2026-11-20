<?php

namespace App\Actions\Admin\PackageReviews;

use App\Models\Package;
use App\Models\PackageReview;
use Illuminate\Http\Request;

class ListPackageReviewsAction
{
    /** @return array<string, mixed> */
    public function handle(Request $request, ?Package $package = null): array
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
            'packages' => Package::query()->orderBy('name')->get(['id', 'name', 'slug']),
            'search' => $search,
            'selectedPackageId' => $package?->id ?? 0,
            'reviewCount' => (clone $scopedReviews)->count(),
            'packageCount' => (clone $scopedReviews)->distinct('package_id')->count('package_id'),
        ];
    }
}
