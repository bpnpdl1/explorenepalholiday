<x-admin-layouts::app :title="__('Packages')">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <div>
            <h4 class="mb-sm-0">Packages</h4>
            <p class="text-muted mb-0 mt-1">Manage the trips and experiences shown on your website.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.packages.create') }}" class="btn btn-primary"><i class="ri-add-line me-1"></i>Create package</a>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-4 g-3 mb-3">
        <div class="col"><x-admin::stat-card label="Total packages" :value="$packageCount" change="All packages" icon="ri-map-2-line" tone="primary" /></div>
        <div class="col"><x-admin::stat-card label="Published" :value="$publishedCount" change="Visible on website" icon="ri-checkbox-circle-line" tone="success" /></div>
        <div class="col"><x-admin::stat-card label="Drafts" :value="$draftCount" change="Not published" icon="ri-draft-line" tone="warning" /></div>
        <div class="col"><x-admin::stat-card label="Featured" :value="$featuredCount" change="Promoted packages" icon="ri-star-line" tone="info" /></div>
    </div>

    <div class="card">
        <div class="card-header align-items-center d-flex flex-wrap gap-3">
            <div class="flex-grow-1">
                <h4 class="card-title mb-1">All packages</h4>
                <p class="text-muted mb-0">Search, filter, and manage package details.</p>
            </div>
            <span class="badge bg-primary-subtle text-primary">{{ $packages->total() }} packages</span>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.packages.index') }}" class="row g-2 mb-3">
                <div class="col-lg-4 col-md-6"><label class="visually-hidden" for="package-search">Search packages</label><input id="package-search" type="search" name="search" value="{{ $search }}" class="form-control" placeholder="Search package, slug, or subcategory"></div>
                <div class="col-lg-3 col-md-6"><label class="visually-hidden" for="package-subcategory-filter">Filter by subcategory</label><select id="package-subcategory-filter" name="subcategory_id" class="form-select js-select2" data-placeholder="All destinations and categories"><option value="">All destinations and categories</option>@foreach ($subcategories as $subcategory)<option value="{{ $subcategory->id }}" @selected($subcategoryId === $subcategory->id)>{{ $subcategory->category->destination->name }} / {{ $subcategory->category->name }} / {{ $subcategory->name }}</option>@endforeach</select></div>
                <div class="col-lg-2 col-md-4"><label class="visually-hidden" for="package-status-filter">Filter by status</label><select id="package-status-filter" name="status" class="form-select"><option value="">All statuses</option><option value="published" @selected($status === 'published')>Published</option><option value="draft" @selected($status === 'draft')>Draft</option></select></div>
                <div class="col-lg-2 col-md-4"><label class="visually-hidden" for="package-featured-filter">Filter featured</label><select id="package-featured-filter" name="featured" class="form-select"><option value="">Featured or not</option><option value="yes" @selected($featured === 'yes')>Featured</option><option value="no" @selected($featured === 'no')>Not featured</option></select></div>
                <div class="col-lg-1 col-md-4 d-flex gap-2"><button class="btn btn-primary flex-grow-1" type="submit" aria-label="Apply filters"><i class="ri-search-line"></i></button><a class="btn btn-light" href="{{ route('admin.packages.index') }}" aria-label="Clear filters"><i class="ri-close-line"></i></a></div>
            </form>

            <div class="table-responsive table-card">
                <table class="table align-middle table-nowrap mb-0">
                    <thead class="table-light text-muted"><tr><th scope="col">Package</th><th scope="col">Destination / category</th><th scope="col">Duration</th><th scope="col">Starting price</th><th scope="col">Status</th><th scope="col" class="text-end">Actions</th></tr></thead>
                    <tbody>
                        @forelse ($packages as $package)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-2 flex-shrink-0">
                                            @if ($package->getFirstMediaUrl('cover'))<img src="{{ $package->getFirstMediaUrl('cover', 'thumbnail') }}" alt="" class="rounded avatar-sm object-fit-cover">@else<span class="avatar-title rounded bg-primary-subtle text-primary"><i class="ri-landscape-line"></i></span>@endif
                                        </div>
                                        <div><a href="{{ route('admin.packages.show', $package) }}" class="fw-medium text-body">{{ $package->name }}</a><div class="d-flex gap-1 mt-1"><code>{{ $package->slug }}</code>@if ($package->is_featured)<span class="badge bg-warning-subtle text-warning">Featured</span>@endif</div></div>
                                    </div>
                                </td>
                                <td>{{ $package->subcategory->category->destination->name }}<div class="text-muted small">{{ $package->subcategory->category->name }} / {{ $package->subcategory->name }}</div></td>
                                <td>
                                    @if ($package->duration_days)
                                        {{ $package->duration_days }} days
                                        @if ($package->duration_nights)
                                            / {{ $package->duration_nights }} nights
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>@if ($package->price_from !== null){{ $package->currency }} {{ number_format((float) $package->price_from, 2) }}<div class="small text-muted">{{ $package->price_qualifier }}</div>@else—@endif</td>
                                <td><span class="badge bg-{{ $package->is_published ? 'success' : 'warning' }}-subtle text-{{ $package->is_published ? 'success' : 'warning' }}">{{ $package->is_published ? 'Published' : 'Draft' }}</span></td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-1">
                                        <a class="btn btn-soft-primary btn-sm" href="{{ route('admin.packages.show', $package) }}" aria-label="View {{ $package->name }}"><i class="ri-eye-line"></i></a>
                                        <a class="btn btn-soft-secondary btn-sm" href="{{ route('admin.packages.edit', $package) }}" aria-label="Edit {{ $package->name }}"><i class="ri-pencil-line"></i></a>
                                        <form action="{{ route('admin.packages.destroy', $package) }}" method="POST" class="js-package-delete-form" data-package-name="{{ $package->name }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-soft-danger btn-sm" aria-label="Delete {{ $package->name }}"><i class="ri-delete-bin-line"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-4 text-muted">No packages found. <a href="{{ route('admin.packages.create') }}">Create the first package.</a></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $packages->links() }}</div>
        </div>
    </div>
@push('scripts')
    <script>
        jQuery(function ($) {
            const $subcategoryFilter = $('#package-subcategory-filter');

            if ($subcategoryFilter.length && $.fn.select2) {
                $subcategoryFilter.select2({
                    width: '100%',
                    minimumResultsForSearch: 0,
                });
            }

            $('.js-package-delete-form').on('submit', function (event) {
                const form = this;

                if (form.dataset.confirmed === 'true') {
                    return;
                }

                if (!window.Swal) {
                    if (!window.confirm(`Delete ${form.dataset.packageName}?`)) {
                        event.preventDefault();
                    }

                    return;
                }

                event.preventDefault();

                window.Swal.fire({
                    title: 'Delete package?',
                    text: `Delete ${form.dataset.packageName}? This also deletes its images.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Delete package',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true,
                    confirmButtonColor: '#f06548',
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.dataset.confirmed = 'true';
                        form.requestSubmit();
                    }
                });
            });
        });
    </script>
@endpush
</x-admin-layouts::app>
