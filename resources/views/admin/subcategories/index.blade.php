<x-admin-layouts::app :title="__('Subcategories')">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-sm-0">Subcategories</h4>
                    <p class="text-muted mb-0 mt-1">Organize more specific travel experiences under each category.</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <ol class="breadcrumb m-0 d-none d-md-flex">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        <li class="breadcrumb-item active">Subcategories</li>
                    </ol>
                    <a href="{{ route('admin.subcategories.create') }}" class="btn btn-primary"><i class="ri-add-line me-1"></i>Add subcategory</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-sm-3 g-3 mb-3">
        <div class="col"><x-admin::stat-card label="Total subcategories" :value="$subcategoryCount" change="All records" icon="ri-list-check-2" tone="primary" /></div>
        <div class="col"><x-admin::stat-card label="Published" :value="$publishedCount" change="Visible to travelers" icon="ri-checkbox-circle-line" tone="success" /></div>
        <div class="col"><x-admin::stat-card label="Featured" :value="$featuredCount" change="Prioritized on the homepage" icon="ri-star-line" tone="warning" /></div>
    </div>

    <div class="card">
        <div class="card-header align-items-center d-flex flex-wrap gap-3">
            <div class="flex-grow-1">
                <h4 class="card-title mb-1">All subcategories</h4>
                <p class="text-muted mb-0">Search subcategories and parent categories, or filter by category, status, and featured placement.</p>
            </div>
            <span class="badge bg-primary-subtle text-primary">{{ $subcategories->total() }} subcategories</span>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.subcategories.index') }}" class="row g-2 mb-3">
                <div class="col-md-4">
                    <label class="visually-hidden" for="subcategory-search">Search subcategories</label>
                    <div class="search-box">
                        <input id="subcategory-search" type="search" name="search" value="{{ $search }}" class="form-control" placeholder="Search subcategory or category...">
                        <i class="ri-search-line search-icon"></i>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="visually-hidden" for="subcategory-category">Filter by category</label>
                    <select id="subcategory-category" name="category_id" class="form-select">
                        <option value="0">All categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected($categoryId === $category->id)>{{ $category->destination->name }} · {{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="visually-hidden" for="subcategory-status">Filter by status</label>
                    <select id="subcategory-status" name="status" class="form-select">
                        <option value="">All statuses</option>
                        <option value="published" @selected($status === 'published')>Published</option>
                        <option value="draft" @selected($status === 'draft')>Draft</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="visually-hidden" for="subcategory-featured">Filter by featured placement</label>
                    <select id="subcategory-featured" name="featured" class="form-select">
                        <option value="">Featured or not</option>
                        <option value="yes" @selected($featured === 'yes')>Featured</option>
                        <option value="no" @selected($featured === 'no')>Not featured</option>
                    </select>
                </div>
                <div class="col-md-auto d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    @if ($search !== '' || $status !== '' || $featured !== '' || $categoryId > 0)
                        <a href="{{ route('admin.subcategories.index') }}" class="btn btn-light">Clear</a>
                    @endif
                </div>
            </form>

            <div class="table-responsive table-card">
                <table class="table align-middle table-nowrap mb-0">
                    <thead class="table-light text-muted">
                        <tr>
                            <th scope="col">Subcategory</th>
                            <th scope="col">Category</th>
                            <th scope="col">Destination</th>
                            <th scope="col">Featured</th>
                            <th scope="col">Order</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($subcategories as $subcategory)
                            <tr>
                                <td>
                                    <div class="fw-medium">{{ $subcategory->name }}</div>
                                    <small class="text-muted">{{ $subcategory->slug }}</small>
                                </td>
                                <td>{{ $subcategory->category->name }}</td>
                                <td>{{ $subcategory->category->destination->name }}</td>
                                <td>
                                    @if ($subcategory->is_featured)
                                        <span class="badge bg-warning-subtle text-warning"><i class="ri-star-fill me-1" aria-hidden="true"></i>Featured</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>{{ $subcategory->sort_order }}</td>
                                <td><span class="badge bg-{{ $subcategory->is_published ? 'success' : 'warning' }}-subtle text-{{ $subcategory->is_published ? 'success' : 'warning' }}">{{ $subcategory->is_published ? 'Published' : 'Draft' }}</span></td>
                                <td class="text-end">
                                    <a href="{{ route('admin.subcategories.edit', $subcategory) }}" class="btn btn-soft-primary btn-sm" aria-label="Edit {{ $subcategory->name }}"><i class="ri-pencil-line align-bottom"></i></a>
                                    <form action="{{ route('admin.subcategories.destroy', $subcategory) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this subcategory? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-soft-danger btn-sm" aria-label="Delete {{ $subcategory->name }}"><i class="ri-delete-bin-line align-bottom"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center py-5 text-muted">No subcategories found. <a href="{{ route('admin.subcategories.create') }}">Add your first subcategory</a>.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($subcategories->hasPages())
                <div class="mt-3">{{ $subcategories->links('pagination::bootstrap-5') }}</div>
            @endif
        </div>
    </div>
</x-admin-layouts::app>
