<x-admin-layouts::app :title="__('Why travel with us')">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-sm-0">Why travel with us</h4>
                    <p class="text-muted mb-0 mt-1">Manage the feature cards shown on the homepage.</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <ol class="breadcrumb m-0 d-none d-md-flex">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        <li class="breadcrumb-item active">Why travel with us</li>
                    </ol>
                    <a href="{{ route('admin.why-travel-reasons.create') }}" class="btn btn-primary"><i class="ri-add-line me-1"></i>Add reason</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 g-3 mb-3">
        <div class="col"><x-admin::stat-card label="Total reasons" :value="$reasonCount" change="All records" icon="ri-lightbulb-line" tone="primary" /></div>
        <div class="col"><x-admin::stat-card label="Published" :value="$publishedCount" change="Visible on homepage" icon="ri-checkbox-circle-line" tone="success" /></div>
    </div>

    <div class="card">
        <div class="card-header align-items-center d-flex flex-wrap gap-3">
            <div class="flex-grow-1">
                <h4 class="card-title mb-1">All reasons</h4>
                <p class="text-muted mb-0">Search card content or filter by publication status.</p>
            </div>
            <span class="badge bg-primary-subtle text-primary">{{ $reasons->total() }} reasons</span>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.why-travel-reasons.index') }}" class="row g-2 mb-3">
                <div class="col-md-6 col-lg-5">
                    <label class="visually-hidden" for="reason-search">Search reasons</label>
                    <div class="search-box">
                        <input id="reason-search" type="search" name="search" value="{{ $search }}" class="form-control" placeholder="Search titles or descriptions...">
                        <i class="ri-search-line search-icon"></i>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3">
                    <label class="visually-hidden" for="reason-status">Filter by status</label>
                    <select id="reason-status" name="status" class="form-select">
                        <option value="">All statuses</option>
                        <option value="published" @selected($status === 'published')>Published</option>
                        <option value="draft" @selected($status === 'draft')>Draft</option>
                    </select>
                </div>
                <div class="col-md-2 col-lg-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    @if ($search !== '' || $status !== '')
                        <a href="{{ route('admin.why-travel-reasons.index') }}" class="btn btn-light">Clear</a>
                    @endif
                </div>
            </form>

            <div class="table-responsive table-card">
                <table class="table align-middle table-nowrap mb-0">
                    <thead class="table-light text-muted">
                        <tr>
                            <th scope="col">Reason</th>
                            <th scope="col">Order</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reasons as $reason)
                            <tr>
                                <td style="min-width: 300px; max-width: 620px; white-space: normal;">
                                    <div class="d-flex align-items-center gap-3">
                                        @if ($reason->getFirstMediaUrl('icon'))
                                            <img src="{{ $reason->getFirstMediaUrl('icon') }}" alt="" class="rounded object-fit-cover" width="48" height="48">
                                        @else
                                            <span class="avatar-sm bg-primary-subtle text-primary rounded d-inline-flex align-items-center justify-content-center"><i class="ri-image-line"></i></span>
                                        @endif
                                        <div>
                                            <div class="fw-medium">{{ $reason->title }}</div>
                                            <small class="text-muted">{{ \Illuminate\Support\Str::limit($reason->description, 160) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $reason->sort_order }}</td>
                                <td><span class="badge bg-{{ $reason->is_published ? 'success' : 'warning' }}-subtle text-{{ $reason->is_published ? 'success' : 'warning' }}">{{ $reason->is_published ? 'Published' : 'Draft' }}</span></td>
                                <td class="text-end">
                                    <a href="{{ route('admin.why-travel-reasons.edit', $reason) }}" class="btn btn-soft-primary btn-sm" aria-label="Edit reason: {{ $reason->title }}"><i class="ri-pencil-line align-bottom"></i></a>
                                    <form action="{{ route('admin.why-travel-reasons.destroy', $reason) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this reason? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-soft-danger btn-sm" aria-label="Delete reason: {{ $reason->title }}"><i class="ri-delete-bin-line align-bottom"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center py-5 text-muted">No reasons found. <a href="{{ route('admin.why-travel-reasons.create') }}">Add your first reason</a>.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($reasons->hasPages())
                <div class="mt-3">{{ $reasons->links('pagination::bootstrap-5') }}</div>
            @endif
        </div>
    </div>
</x-admin-layouts::app>
