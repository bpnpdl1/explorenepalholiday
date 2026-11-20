<x-admin-layouts::app :title="$package ? $package->name.' reviews' : __('Package reviews')">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between gap-3">
        <div>
            <h4 class="mb-sm-0">{{ $package ? $package->name.' reviews' : 'Package reviews' }}</h4>
            <p class="text-muted mb-0 mt-1">{{ $package ? 'Manage the customer quotes shown on this package page.' : 'Manage customer quotes attached to your travel packages.' }}</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            @if ($package)
                <a href="{{ route('admin.package-reviews.index') }}" class="btn btn-light"><i class="ri-arrow-left-line me-1"></i>All reviews</a>
                <a href="{{ route('admin.packages.show', $package) }}" class="btn btn-light"><i class="ri-map-2-line me-1"></i>Package details</a>
            @else
                <a href="{{ route('admin.packages.index') }}" class="btn btn-light"><i class="ri-map-2-line me-1"></i>View packages</a>
            @endif
            <a href="{{ route('admin.package-reviews.create', $package ? ['package_id' => $package->id] : []) }}" class="btn btn-primary"><i class="ri-add-line me-1"></i>Add review</a>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 g-3 mb-3">
        <div class="col"><x-admin::stat-card label="Package reviews" :value="$reviewCount" change="Customer quotes" icon="ri-chat-quote-line" tone="primary" /></div>
        <div class="col"><x-admin::stat-card label="Packages covered" :value="$packageCount" change="Packages with reviews" icon="ri-map-2-line" tone="success" /></div>
    </div>

    <div class="card">
        <div class="card-header border-bottom-0 pb-0">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-2">
                <div>
                    <h4 class="card-title mb-1">Customer reviews</h4>
                    <p class="text-muted mb-0">{{ $package ? 'Reviews are shown in display order on '.$package->name.'.' : 'Each review belongs to one package and can be ordered independently.' }}</p>
                </div>
                <span class="badge bg-primary-subtle text-primary">{{ $reviews->total() }} matching {{ \Illuminate\Support\Str::plural('review', $reviews->total()) }}</span>
            </div>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ $package ? route('admin.package-reviews.package', $package) : route('admin.package-reviews.index') }}" class="rounded border bg-light-subtle p-3 mb-3">
                <div class="row g-2 align-items-end">
                    <div class="{{ $package ? 'col-md-10' : 'col-lg-6 col-md-5' }}">
                        <label for="review-search" class="form-label small fw-medium">Search</label>
                        <div class="search-box">
                            <input id="review-search" type="search" name="search" value="{{ $search }}" class="form-control search" placeholder="Reviewer, package, or review text">
                            <i class="ri-search-line search-icon"></i>
                        </div>
                    </div>
                    @unless ($package)
                        <div class="col-lg-4 col-md-5">
                            <label for="review-package" class="form-label small fw-medium">Package</label>
                            <select id="review-package" name="package_id" class="form-select">
                                <option value="">All packages</option>
                                @foreach ($packages as $packageOption)
                                    <option value="{{ $packageOption->id }}" @selected($selectedPackageId === $packageOption->id)>{{ $packageOption->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endunless
                    <div class="{{ $package ? 'col-md-2' : 'col-lg-2' }} d-flex gap-2">
                        <button class="btn btn-primary flex-grow-1" type="submit"><i class="ri-equalizer-line me-1"></i>Filter</button>
                        @if ($search !== '' || $selectedPackageId > 0)
                            <a class="btn btn-light" href="{{ $package ? route('admin.package-reviews.package', $package) : route('admin.package-reviews.index') }}" aria-label="Clear filters" title="Clear filters"><i class="ri-close-line"></i></a>
                        @endif
                    </div>
                </div>
            </form>

            @if ($reviews->isNotEmpty())
                <div class="table-responsive table-card">
                    <table class="table align-middle table-hover mb-0">
                        <thead class="table-light text-muted">
                            <tr>
                                @unless ($package)<th scope="col">Package</th>@endunless
                                <th scope="col">Review</th>
                                <th scope="col">Reviewer</th>
                                <th scope="col">Order</th>
                                <th scope="col" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reviews as $review)
                                <tr>
                                    @unless ($package)
                                        <td><a href="{{ route('admin.package-reviews.package', $review->package) }}" class="fw-semibold text-body">{{ $review->package->name }}</a></td>
                                    @endunless
                                    <td><div class="text-body" style="max-width: 540px">“{{ \Illuminate\Support\Str::limit($review->quote, 180) }}”</div></td>
                                    <td>
                                        <div class="fw-medium">{{ $review->reviewer_name ?: 'Anonymous' }}</div>
                                        @if ($review->reviewer_label)<div class="small text-muted">{{ $review->reviewer_label }}</div>@endif
                                    </td>
                                    <td><span class="badge bg-light text-body">{{ $review->sort_order }}</span></td>
                                    <td class="text-end">
                                        <div class="d-inline-flex gap-1">
                                            <a class="btn btn-soft-secondary btn-sm" href="{{ route('admin.package-reviews.edit', $review) }}" aria-label="Edit review" title="Edit review"><i class="ri-pencil-line"></i></a>
                                            <form action="{{ route('admin.package-reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('Delete this package review?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-soft-danger btn-sm" aria-label="Delete review" title="Delete review"><i class="ri-delete-bin-line"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-3">
                    <p class="text-muted small mb-0">Showing {{ $reviews->firstItem() }}–{{ $reviews->lastItem() }} of {{ $reviews->total() }} reviews</p>
                    {{ $reviews->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <div class="avatar-md mx-auto mb-3"><div class="avatar-title bg-primary-subtle text-primary rounded-circle fs-2"><i class="ri-chat-quote-line"></i></div></div>
                    <h5>{{ $search !== '' ? 'No reviews match your search' : ($package ? 'No reviews for this package yet' : 'No package reviews yet') }}</h5>
                    <p class="text-muted mb-3">{{ $search !== '' ? 'Try another search or clear the current filters.' : 'Add a customer quote to feature it on a package page.' }}</p>
                    @if ($search !== '')
                        <a href="{{ $package ? route('admin.package-reviews.package', $package) : route('admin.package-reviews.index') }}" class="btn btn-light me-1">Clear filters</a>
                    @endif
                    <a href="{{ route('admin.package-reviews.create', $package ? ['package_id' => $package->id] : []) }}" class="btn btn-primary"><i class="ri-add-line me-1"></i>Add review</a>
                </div>
            @endif
        </div>
    </div>
</x-admin-layouts::app>
