<x-admin-layouts::app :title="__('SEO & metadata')">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-sm-0">SEO &amp; metadata</h4>
                    <p class="text-muted mb-0 mt-1">Review search titles, descriptions, and indexing rules for site pages.</p>
                </div>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        <li class="breadcrumb-item">Master</li>
                        <li class="breadcrumb-item active">SEO &amp; metadata</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-4 g-3 mb-3">
        <div class="col">
            <x-admin::stat-card label="Pages tracked" :value="$pageCount" change="Website pages" icon="ri-file-list-3-line" tone="primary" />
        </div>
        <div class="col">
            <x-admin::stat-card label="Optimized" :value="$optimizedCount" change="Metadata is complete" icon="ri-checkbox-circle-line" tone="success" />
        </div>
        <div class="col">
            <x-admin::stat-card label="Needs review" :value="$reviewCount" change="Check title or description" icon="ri-error-warning-line" tone="warning" />
        </div>
        <div class="col">
            <x-admin::stat-card label="Indexable pages" :value="$indexableCount" change="Index, follow directive" icon="ri-search-eye-line" tone="info" />
        </div>
    </div>

    <div class="card">
        <div class="card-header align-items-center d-flex flex-wrap gap-3">
            <div class="flex-grow-1">
                <h4 class="card-title mb-1">Page metadata</h4>
                <p class="text-muted mb-0">Sample SEO records for the admin index preview.</p>
            </div>
            <span class="badge bg-primary-subtle text-primary">{{ $pageCount }} pages</span>
        </div>

        <div class="card-body">
            <div class="row g-2 mb-3">
                <div class="col-md-5 col-lg-4">
                    <div class="search-box">
                        <input type="search" class="form-control search" id="seo-search" placeholder="Search pages or metadata..." aria-label="Search SEO metadata">
                        <i class="ri-search-line search-icon"></i>
                    </div>
                </div>
                <div class="col-md-3 col-lg-2">
                    <select class="form-select" id="seo-status-filter" aria-label="Filter pages by SEO status">
                        <option value="">All statuses</option>
                        <option value="Optimized">Optimized</option>
                        <option value="Needs review">Needs review</option>
                    </select>
                </div>
                <div class="col-md-4 col-lg-3">
                    <select class="form-select" id="seo-robots-filter" aria-label="Filter pages by indexing directive">
                        <option value="">All indexing rules</option>
                        <option value="index, follow">Index, follow</option>
                        <option value="noindex, follow">Noindex, follow</option>
                    </select>
                </div>
            </div>

            <div class="table-responsive table-card">
                <table class="table align-middle table-nowrap mb-0" id="seo-table">
                    <thead class="table-light text-muted">
                        <tr>
                            <th scope="col">Page</th>
                            <th scope="col">SEO title</th>
                            <th scope="col">Meta description</th>
                            <th scope="col">Robots</th>
                            <th scope="col">Status</th>
                            <th scope="col">Last updated</th>
                            <th scope="col" class="text-end">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pages as $page)
                            <tr
                                data-seo-row
                                data-status="{{ $page['status'] }}"
                                data-robots="{{ $page['robots'] }}"
                                data-search="{{ implode(' ', [$page['page'], $page['path'], $page['title'], $page['description'], $page['robots']]) }}"
                            >
                                <td>
                                    <div class="fw-medium">{{ $page['page'] }}</div>
                                    <small class="text-muted">{{ $page['path'] }}</small>
                                </td>
                                <td class="text-wrap" style="min-width: 250px; max-width: 340px;">{{ $page['title'] }}</td>
                                <td style="min-width: 260px; max-width: 360px;">
                                    @if ($page['description'])
                                        <span class="text-muted">{{ $page['description'] }}</span>
                                    @else
                                        <span class="text-warning"><i class="ri-error-warning-line me-1"></i>Description missing</span>
                                    @endif
                                </td>
                                <td><span class="badge bg-light text-body">{{ $page['robots'] }}</span></td>
                                <td><span class="badge bg-{{ $page['status_class'] }}-subtle text-{{ $page['status_class'] }}">{{ $page['status'] }}</span></td>
                                <td class="text-muted">{{ $page['updated'] }}</td>
                                <td class="text-end">
                                    <button
                                        type="button"
                                        class="btn btn-soft-primary btn-sm"
                                        data-seo-details
                                        data-page="{{ $page['page'] }}"
                                        data-path="{{ $page['path'] }}"
                                        data-title="{{ $page['title'] }}"
                                        data-description="{{ $page['description'] ?: 'No meta description has been added.' }}"
                                        data-robots="{{ $page['robots'] }}"
                                        aria-label="View metadata for {{ $page['page'] }}"
                                    >
                                        <i class="ri-eye-line align-bottom"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        <tr id="seo-empty-state" class="d-none">
                            <td colspan="7" class="text-center py-4 text-muted">No pages match these filters.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('admin/js/seo.init.js') }}"></script>
    @endpush
</x-admin-layouts::app>
