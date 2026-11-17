<x-admin-layouts::app :title="__('Packages')">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-sm-0">Packages</h4>
                    <p class="text-muted mb-0 mt-1">Manage the trips and experiences shown on your website.</p>
                </div>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        <li class="breadcrumb-item active">Packages</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-4 g-3 mb-3">
        <div class="col">
            <x-admin::stat-card label="Total packages" :value="$packageCount" change="All packages" icon="ri-map-2-line" tone="primary" />
        </div>
        <div class="col">
            <x-admin::stat-card label="Published" :value="$publishedCount" change="Visible on website" icon="ri-checkbox-circle-line" tone="success" />
        </div>
        <div class="col">
            <x-admin::stat-card label="Drafts" :value="$draftCount" change="Not published" icon="ri-draft-line" tone="warning" />
        </div>
        <div class="col">
            <x-admin::stat-card label="Bookings" :value="$bookingCount" change="Across packages" icon="ri-calendar-check-line" tone="info" />
        </div>
    </div>

    <div class="card">
        <div class="card-header align-items-center d-flex flex-wrap gap-3">
            <div class="flex-grow-1">
                <h4 class="card-title mb-1">All packages</h4>
                <p class="text-muted mb-0">Sample catalog records for the package index preview.</p>
            </div>
            <span class="badge bg-primary-subtle text-primary">{{ $packageCount }} packages</span>
        </div>

        <div class="card-body">
            <div class="row g-2 mb-3">
                <div class="col-md-5 col-lg-4">
                    <div class="search-box">
                        <input type="search" class="form-control search" id="package-search" placeholder="Search packages..." aria-label="Search packages">
                        <i class="ri-search-line search-icon"></i>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3">
                    <select class="form-select" id="package-category-filter" aria-label="Filter packages by category">
                        <option value="">All categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 col-lg-2">
                    <select class="form-select" id="package-status-filter" aria-label="Filter packages by publication status">
                        <option value="">All statuses</option>
                        <option value="Published">Published</option>
                        <option value="Draft">Draft</option>
                    </select>
                </div>
            </div>

            <div class="table-responsive table-card">
                <table class="table align-middle table-nowrap mb-0" id="packages-table">
                    <thead class="table-light text-muted">
                        <tr>
                            <th scope="col">Package</th>
                            <th scope="col">Category</th>
                            <th scope="col">Destination</th>
                            <th scope="col">Duration</th>
                            <th scope="col">Price</th>
                            <th scope="col">Bookings</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-end">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($packages as $package)
                            <tr data-package-row data-category="{{ $package['category'] }}" data-status="{{ $package['status'] }}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-xs me-2 flex-shrink-0">
                                            <span class="avatar-title rounded bg-primary-subtle text-primary"><i class="ri-landscape-line"></i></span>
                                        </div>
                                        <span class="fw-medium">{{ $package['name'] }}</span>
                                    </div>
                                </td>
                                <td>{{ $package['category'] }}</td>
                                <td>{{ $package['destination'] }}</td>
                                <td>{{ $package['duration'] }}</td>
                                <td class="fw-medium">{{ $package['price'] }}</td>
                                <td>{{ $package['bookings'] }}</td>
                                <td><span class="badge bg-{{ $package['status_class'] }}-subtle text-{{ $package['status_class'] }}">{{ $package['status'] }}</span></td>
                                <td class="text-end">
                                    <a class="btn btn-soft-primary btn-sm" href="{{ route('admin.packages.show', $package['slug']) }}" aria-label="View {{ $package['name'] }} details">
                                        <i class="ri-eye-line align-bottom"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        <tr id="package-empty-state" class="d-none">
                            <td colspan="8" class="text-center py-4 text-muted">No packages match these filters.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('admin/js/packages.init.js') }}"></script>
    @endpush
</x-admin-layouts::app>
