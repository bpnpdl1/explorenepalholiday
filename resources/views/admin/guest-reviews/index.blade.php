<x-admin-layouts::app :title="__('Guest reviews')">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-sm-0">Guest reviews</h4>
                    <p class="text-muted mb-0 mt-1">Manage traveler stories and their source links.</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <ol class="breadcrumb m-0 d-none d-md-flex">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        <li class="breadcrumb-item active">Guest reviews</li>
                    </ol>
                    <a href="{{ route('admin.guest-reviews.create') }}" class="btn btn-primary"><i class="ri-add-line me-1"></i>Add review</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 g-3 mb-3">
        <div class="col"><x-admin::stat-card label="Total reviews" :value="$reviewCount" change="All records" icon="ri-chat-quote-line" tone="primary" /></div>
        <div class="col"><x-admin::stat-card label="Average rating" :value="number_format($averageRating ?? 0, 1).' / 5'" change="Across all reviews" icon="ri-star-line" tone="warning" /></div>
    </div>

    <div class="card">
        <div class="card-header align-items-center d-flex flex-wrap gap-3">
            <div class="flex-grow-1">
                <h4 class="card-title mb-1">All guest reviews</h4>
                <p class="text-muted mb-0">Search reviewer names, trip details, regions, and review text.</p>
            </div>
            <span class="badge bg-primary-subtle text-primary">{{ $reviews->total() }} reviews</span>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.guest-reviews.index') }}" class="row g-2 mb-3">
                <div class="col-md-7 col-lg-6">
                    <label class="visually-hidden" for="review-search">Search reviews</label>
                    <div class="search-box">
                        <input id="review-search" type="search" name="search" value="{{ $search }}" class="form-control" placeholder="Search guest, trip, region, or review...">
                        <i class="ri-search-line search-icon"></i>
                    </div>
                </div>
                <div class="col-md-3 col-lg-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Search</button>
                    @if ($search !== '')
                        <a href="{{ route('admin.guest-reviews.index') }}" class="btn btn-light">Clear</a>
                    @endif
                </div>
            </form>

            <div class="table-responsive table-card">
                <table class="table align-middle table-nowrap mb-0">
                    <thead class="table-light text-muted">
                        <tr>
                            <th scope="col">Review</th>
                            <th scope="col">Guest and trip</th>
                            <th scope="col">Date</th>
                            <th scope="col">Rating</th>
                            <th scope="col" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reviews as $review)
                            <tr>
                                <td style="min-width: 280px; max-width: 540px; white-space: normal;">
                                    <span class="text-muted">{{ \Illuminate\Support\Str::limit($review->review_text, 180) }}</span>
                                    @if ($review->source_url)
                                        <div><a href="{{ $review->source_url }}" target="_blank" rel="noopener noreferrer" class="small">View source <i class="ri-external-link-line"></i></a></div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-medium">{{ $review->reviewer_name }}</div>
                                    <small class="text-muted">{{ $review->trip_name ?: 'Trip not specified' }}{{ $review->region_name ? ' · '.$review->region_name : '' }}</small>
                                </td>
                                <td>{{ $review->reviewed_at?->format('M Y') ?? '—' }}</td>
                                <td><span class="text-warning">{{ str_repeat('★', $review->rating) }}</span> <small class="text-muted">{{ $review->rating }}/5</small></td>
                                <td class="text-end">
                                    <a href="{{ route('admin.guest-reviews.edit', $review) }}" class="btn btn-soft-primary btn-sm" aria-label="Edit review by {{ $review->reviewer_name }}"><i class="ri-pencil-line align-bottom"></i></a>
                                    <form action="{{ route('admin.guest-reviews.destroy', $review) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this guest review? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-soft-danger btn-sm" aria-label="Delete review by {{ $review->reviewer_name }}"><i class="ri-delete-bin-line align-bottom"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-5 text-muted">No guest reviews found. <a href="{{ route('admin.guest-reviews.create') }}">Add your first review</a>.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($reviews->hasPages())
                <div class="mt-3">{{ $reviews->links('pagination::bootstrap-5') }}</div>
            @endif
        </div>
    </div>
</x-admin-layouts::app>
