<x-admin-layouts::app :title="__('Team members')">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-sm-0">Team members</h4>
                    <p class="text-muted mb-0 mt-1">Manage the profiles shown on the Our Team page.</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <ol class="breadcrumb m-0 d-none d-md-flex">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        <li class="breadcrumb-item active">Team members</li>
                    </ol>
                    <a href="{{ route('admin.team-members.create') }}" class="btn btn-primary"><i class="ri-add-line me-1"></i>Add team member</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 g-3 mb-3">
        <div class="col"><x-admin::stat-card label="Total team members" :value="$teamMemberCount" change="All records" icon="ri-team-line" tone="primary" /></div>
        <div class="col"><x-admin::stat-card label="Published" :value="$publishedCount" change="Visible to travelers" icon="ri-checkbox-circle-line" tone="success" /></div>
    </div>

    <div class="card">
        <div class="card-header align-items-center d-flex flex-wrap gap-3">
            <div class="flex-grow-1">
                <h4 class="card-title mb-1">All team members</h4>
                <p class="text-muted mb-0">Search profiles or filter them by publication status.</p>
            </div>
            <span class="badge bg-primary-subtle text-primary">{{ $teamMembers->total() }} profiles</span>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.team-members.index') }}" class="row g-2 mb-3">
                <div class="col-md-6 col-lg-5">
                    <label class="visually-hidden" for="team-member-search">Search team members</label>
                    <div class="search-box">
                        <input id="team-member-search" type="search" name="search" value="{{ $search }}" class="form-control" placeholder="Search name, role, or bio...">
                        <i class="ri-search-line search-icon"></i>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3">
                    <label class="visually-hidden" for="team-member-status">Filter by status</label>
                    <select id="team-member-status" name="status" class="form-select">
                        <option value="">All statuses</option>
                        <option value="published" @selected($status === 'published')>Published</option>
                        <option value="draft" @selected($status === 'draft')>Draft</option>
                    </select>
                </div>
                <div class="col-md-2 col-lg-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    @if ($search !== '' || $status !== '')
                        <a href="{{ route('admin.team-members.index') }}" class="btn btn-light">Clear</a>
                    @endif
                </div>
            </form>

            <div class="table-responsive table-card">
                <table class="table align-middle table-nowrap mb-0">
                    <thead class="table-light text-muted">
                        <tr>
                            <th scope="col">Profile</th>
                            <th scope="col">Order</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($teamMembers as $teamMember)
                            <tr>
                                <td style="min-width: 280px; white-space: normal;">
                                    <div class="d-flex align-items-center gap-3">
                                        @if ($teamMember->getFirstMediaUrl('portrait'))
                                            <img src="{{ $teamMember->getFirstMediaUrl('portrait') }}" alt="" class="rounded object-fit-cover" width="52" height="52">
                                        @else
                                            <span class="avatar-sm bg-primary-subtle text-primary rounded d-inline-flex align-items-center justify-content-center"><i class="ri-user-line"></i></span>
                                        @endif
                                        <div>
                                            <div class="fw-medium">{{ $teamMember->name }}</div>
                                            <small class="text-muted">{{ $teamMember->role }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $teamMember->sort_order }}</td>
                                <td><span class="badge bg-{{ $teamMember->is_published ? 'success' : 'warning' }}-subtle text-{{ $teamMember->is_published ? 'success' : 'warning' }}">{{ $teamMember->is_published ? 'Published' : 'Draft' }}</span></td>
                                <td class="text-end">
                                    <a href="{{ route('admin.team-members.edit', $teamMember) }}" class="btn btn-soft-primary btn-sm" aria-label="Edit team member: {{ $teamMember->name }}"><i class="ri-pencil-line align-bottom"></i></a>
                                    <form action="{{ route('admin.team-members.destroy', $teamMember) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this team member? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-soft-danger btn-sm" aria-label="Delete team member: {{ $teamMember->name }}"><i class="ri-delete-bin-line align-bottom"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center py-5 text-muted">No team members found. <a href="{{ route('admin.team-members.create') }}">Add your first team member</a>.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($teamMembers->hasPages())
                <div class="mt-3">{{ $teamMembers->links('pagination::bootstrap-5') }}</div>
            @endif
        </div>
    </div>
</x-admin-layouts::app>
