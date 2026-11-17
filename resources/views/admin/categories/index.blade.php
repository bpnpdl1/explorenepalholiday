<x-admin-layouts::app :title="__('Categories')">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-sm-0">Categories</h4>
                    <p class="text-muted mb-0 mt-1">Organize travel categories under their destinations.</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <ol class="breadcrumb m-0 d-none d-md-flex">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        <li class="breadcrumb-item active">Categories</li>
                    </ol>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary"><i class="ri-add-line me-1"></i>Add category</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 g-3 mb-3">
        <div class="col"><x-admin::stat-card label="Total categories" :value="$categoryCount" change="All records" icon="ri-list-check-2" tone="primary" /></div>
        <div class="col"><x-admin::stat-card label="Published" :value="$publishedCount" change="Visible to travelers" icon="ri-checkbox-circle-line" tone="success" /></div>
    </div>

    <div class="card">
        <div class="card-header align-items-center d-flex flex-wrap gap-3">
            <div class="flex-grow-1">
                <h4 class="card-title mb-1">All categories</h4>
                <p class="text-muted mb-0">Search categories and destinations, or filter by status and destination.</p>
            </div>
            <span class="badge bg-primary-subtle text-primary">{{ $categories->total() }} categories</span>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.categories.index') }}" class="row g-2 mb-3">
                <div class="col-md-5 col-lg-4">
                    <label class="visually-hidden" for="category-search">Search categories</label>
                    <div class="search-box">
                        <input id="category-search" type="search" name="search" value="{{ $search }}" class="form-control" placeholder="Search category or destination...">
                        <i class="ri-search-line search-icon"></i>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="visually-hidden" for="category-destination">Filter by destination</label>
                    <select id="category-destination" name="destination_id" class="form-select">
                        <option value="0">All destinations</option>
                        @foreach ($destinations as $destination)
                            <option value="{{ $destination->id }}" @selected($destinationId === $destination->id)>{{ $destination->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="visually-hidden" for="category-status">Filter by status</label>
                    <select id="category-status" name="status" class="form-select">
                        <option value="">All statuses</option>
                        <option value="published" @selected($status === 'published')>Published</option>
                        <option value="draft" @selected($status === 'draft')>Draft</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    @if ($search !== '' || $status !== '' || $destinationId > 0)
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-light">Clear</a>
                    @endif
                </div>
            </form>

            <div class="table-responsive table-card">
                <table class="table align-middle table-nowrap mb-0">
                    <thead class="table-light text-muted">
                        <tr>
                            <th scope="col">Category</th>
                            <th scope="col">Destination</th>
                            <th scope="col">Order</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td>
                                    <div class="fw-medium">{{ $category->name }}</div>
                                    <small class="text-muted">{{ $category->slug }}</small>
                                </td>
                                <td>{{ $category->destination->name }}</td>
                                <td>{{ $category->sort_order }}</td>
                                <td><span class="badge bg-{{ $category->is_published ? 'success' : 'warning' }}-subtle text-{{ $category->is_published ? 'success' : 'warning' }}">{{ $category->is_published ? 'Published' : 'Draft' }}</span></td>
                                <td class="text-end">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-soft-primary btn-sm" aria-label="Edit {{ $category->name }}"><i class="ri-pencil-line align-bottom"></i></a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this category? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-soft-danger btn-sm" aria-label="Delete {{ $category->name }}"><i class="ri-delete-bin-line align-bottom"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-5 text-muted">No categories found. <a href="{{ route('admin.categories.create') }}">Add your first category</a>.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($categories->hasPages())
                <div class="mt-3">{{ $categories->links('pagination::bootstrap-5') }}</div>
            @endif
        </div>
    </div>
</x-admin-layouts::app>
