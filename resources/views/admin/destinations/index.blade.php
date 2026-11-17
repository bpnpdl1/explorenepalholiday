<x-admin-layouts::app :title="__('Destinations')">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-sm-0">Destinations</h4>
                    <p class="text-muted mb-0 mt-1">Manage the places and regions featured across your travel website.</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <ol class="breadcrumb m-0 d-none d-md-flex">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        <li class="breadcrumb-item active">Destinations</li>
                    </ol>
                    <a href="{{ route('admin.destinations.create') }}" class="btn btn-primary"><i class="ri-add-line me-1"></i>Add destination</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3 g-3 mb-3">
        <div class="col"><x-admin::stat-card label="Total destinations" :value="$destinationCount" change="All records" icon="ri-map-pin-line" tone="primary" /></div>
        <div class="col"><x-admin::stat-card label="Published" :value="$publishedCount" change="Visible on website" icon="ri-checkbox-circle-line" tone="success" /></div>
        <div class="col"><x-admin::stat-card label="Featured" :value="$featuredCount" change="Highlighted destinations" icon="ri-star-line" tone="warning" /></div>
    </div>

    <div class="card">
        <div class="card-header align-items-center d-flex flex-wrap gap-3">
            <div class="flex-grow-1">
                <h4 class="card-title mb-1">All destinations</h4>
                <p class="text-muted mb-0">Search and update destination content.</p>
            </div>
            <span class="badge bg-primary-subtle text-primary">{{ $destinations->total() }} destinations</span>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.destinations.index') }}" class="row g-2 mb-3">
                <div class="col-md-6 col-lg-5">
                    <label class="visually-hidden" for="destination-search">Search destinations</label>
                    <div class="search-box">
                        <input id="destination-search" type="search" name="search" value="{{ $search }}" class="form-control" placeholder="Search name, region, or slug...">
                        <i class="ri-search-line search-icon"></i>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3">
                    <label class="visually-hidden" for="destination-status">Filter by status</label>
                    <select id="destination-status" name="status" class="form-select">
                        <option value="">All statuses</option>
                        <option value="published" @selected($status === 'published')>Published</option>
                        <option value="draft" @selected($status === 'draft')>Draft</option>
                    </select>
                </div>
                <div class="col-md-2 col-lg-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    @if ($search !== '' || $status !== '')
                        <a href="{{ route('admin.destinations.index') }}" class="btn btn-light">Clear</a>
                    @endif
                </div>
            </form>

            <div class="table-responsive table-card">
                <table class="table align-middle table-nowrap mb-0">
                    <thead class="table-light text-muted">
                        <tr>
                            <th scope="col">Destination</th>
                            <th scope="col">Region</th>
                            <th scope="col">Order</th>
                            <th scope="col">Status</th>
                            <th scope="col">Featured</th>
                            <th scope="col" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($destinations as $destination)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if ($destination->getFirstMediaUrl('cover'))
                                            <img src="{{ $destination->getFirstMediaUrl('cover', 'thumbnail') ?: $destination->getFirstMediaUrl('cover') }}" alt="" class="avatar-xs rounded object-fit-cover me-2">
                                        @else
                                            <div class="avatar-xs me-2 flex-shrink-0"><span class="avatar-title rounded bg-primary-subtle text-primary"><i class="ri-map-pin-line"></i></span></div>
                                        @endif
                                        <div>
                                            <div class="fw-medium">{{ $destination->name }}</div>
                                            <small class="text-muted">{{ $destination->slug }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $destination->region ?: '—' }}</td>
                                <td>{{ $destination->sort_order }}</td>
                                <td><span class="badge bg-{{ $destination->is_published ? 'success' : 'warning' }}-subtle text-{{ $destination->is_published ? 'success' : 'warning' }}">{{ $destination->is_published ? 'Published' : 'Draft' }}</span></td>
                                <td>{{ $destination->is_featured ? 'Yes' : '—' }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.destinations.edit', $destination) }}" class="btn btn-soft-primary btn-sm" aria-label="Edit {{ $destination->name }}"><i class="ri-pencil-line align-bottom"></i></a>
                                    <form action="{{ route('admin.destinations.destroy', $destination) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this destination? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-soft-danger btn-sm" aria-label="Delete {{ $destination->name }}"><i class="ri-delete-bin-line align-bottom"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-5 text-muted">No destinations found. <a href="{{ route('admin.destinations.create') }}">Add your first destination</a>.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($destinations->hasPages())
                <div class="mt-3">{{ $destinations->links('pagination::bootstrap-5') }}</div>
            @endif
        </div>
    </div>
</x-admin-layouts::app>
