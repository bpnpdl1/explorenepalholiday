<x-admin-layouts::app :title="__('Travel information pages')">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-sm-0">Travel information pages</h4>
                    <p class="text-muted mb-0 mt-1">Manage the pages linked from the Travel Info menu.</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <ol class="breadcrumb m-0 d-none d-md-flex">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        <li class="breadcrumb-item active">Travel information pages</li>
                    </ol>
                    <a href="{{ route('admin.travel-info-pages.create') }}" class="btn btn-primary"><i class="ri-add-line me-1"></i>Add page</a>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header align-items-center d-flex flex-wrap gap-3">
            <div class="flex-grow-1">
                <h4 class="card-title mb-1">All travel information pages</h4>
                <p class="text-muted mb-0">Edit page content, publication status, and menu order.</p>
            </div>
            <span class="badge bg-primary-subtle text-primary">{{ $travelInfoPages->total() }} pages</span>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.travel-info-pages.index') }}" class="row g-2 mb-3">
                <div class="col-md-6 col-lg-5">
                    <label class="visually-hidden" for="travel-info-search">Search pages</label>
                    <input id="travel-info-search" type="search" name="search" value="{{ $search }}" class="form-control" placeholder="Search by title or slug...">
                </div>
                <div class="col-md-4 col-lg-3">
                    <label class="visually-hidden" for="travel-info-status">Filter by status</label>
                    <select id="travel-info-status" name="status" class="form-select">
                        <option value="">All statuses</option>
                        <option value="published" @selected($status === 'published')>Published</option>
                        <option value="draft" @selected($status === 'draft')>Draft</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    @if ($search !== '' || $status !== '')
                        <a href="{{ route('admin.travel-info-pages.index') }}" class="btn btn-light">Clear</a>
                    @endif
                </div>
            </form>

            <div class="table-responsive table-card">
                <table class="table align-middle table-nowrap mb-0">
                    <thead class="table-light text-muted">
                        <tr>
                            <th scope="col">Page</th>
                            <th scope="col">Order</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($travelInfoPages as $travelInfoPage)
                            <tr>
                                <td>
                                    <div class="fw-medium">{{ $travelInfoPage->title }}</div>
                                    <small class="text-muted">/travel-info/{{ $travelInfoPage->slug }}</small>
                                </td>
                                <td>{{ $travelInfoPage->sort_order }}</td>
                                <td><span class="badge bg-{{ $travelInfoPage->is_published ? 'success' : 'warning' }}-subtle text-{{ $travelInfoPage->is_published ? 'success' : 'warning' }}">{{ $travelInfoPage->is_published ? 'Published' : 'Draft' }}</span></td>
                                <td class="text-end">
                                    @if ($travelInfoPage->is_published)
                                        <a href="{{ route('travel-info.show', $travelInfoPage->slug) }}" target="_blank" rel="noopener noreferrer" class="btn btn-soft-secondary btn-sm" aria-label="View {{ $travelInfoPage->title }}"><i class="ri-external-link-line align-bottom"></i></a>
                                    @endif
                                    <a href="{{ route('admin.travel-info-pages.edit', $travelInfoPage) }}" class="btn btn-soft-primary btn-sm" aria-label="Edit {{ $travelInfoPage->title }}"><i class="ri-pencil-line align-bottom"></i></a>
                                    <form action="{{ route('admin.travel-info-pages.destroy', $travelInfoPage) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this travel information page? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-soft-danger btn-sm" aria-label="Delete {{ $travelInfoPage->title }}"><i class="ri-delete-bin-line align-bottom"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center py-5 text-muted">No pages found. <a href="{{ route('admin.travel-info-pages.create') }}">Add your first page</a>.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($travelInfoPages->hasPages())
                <div class="mt-3">{{ $travelInfoPages->links('pagination::bootstrap-5') }}</div>
            @endif
        </div>
    </div>
</x-admin-layouts::app>
