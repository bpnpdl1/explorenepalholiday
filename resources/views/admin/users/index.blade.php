<x-admin-layouts::app :title="__('Users')">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div>
                    <h4 class="mb-sm-0">Users</h4>
                    <p class="text-muted mb-0 mt-1">Review admin accounts and traveler registrations.</p>
                </div>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        <li class="breadcrumb-item">Privilege</li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3 g-3 mb-3">
        <div class="col">
            <x-admin::stat-card label="Total users" :value="$userCount" change="All registered accounts" icon="ri-group-line" tone="primary" />
        </div>
        <div class="col">
            <x-admin::stat-card label="Administrators" :value="$adminCount" change="Admin access enabled" icon="ri-shield-user-line" tone="warning" />
        </div>
        <div class="col">
            <x-admin::stat-card label="Verified emails" :value="$verifiedCount" change="Email address confirmed" icon="ri-checkbox-circle-line" tone="success" />
        </div>
    </div>

    <div class="card">
        <div class="card-header align-items-center d-flex flex-wrap gap-3">
            <div class="flex-grow-1">
                <h4 class="card-title mb-1">All users</h4>
                <p class="text-muted mb-0">User access and account status.</p>
            </div>
            <span class="badge bg-primary-subtle text-primary">{{ $users->total() }} users</span>
        </div>

        <div class="card-body">
            <form method="GET" action="{{ route('admin.users.index') }}" class="row g-2 mb-3">
                <div class="col-md-6 col-lg-5">
                    <div class="search-box">
                        <input type="search" class="form-control search" name="search" value="{{ $search }}" placeholder="Search name or email..." aria-label="Search users">
                        <i class="ri-search-line search-icon"></i>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3">
                    <select class="form-select" name="role" aria-label="Filter users by account type">
                        <option value="">All account types</option>
                        <option value="admin" @selected($role === 'admin')>Administrators</option>
                        <option value="traveler" @selected($role === 'traveler')>Travelers</option>
                    </select>
                </div>
                <div class="col-md-2 col-lg-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="ri-filter-3-line me-1"></i>Filter</button>
                </div>
                @if ($search || $role)
                    <div class="col-md-2 col-lg-2">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-light w-100">Reset</a>
                    </div>
                @endif
            </form>

            <div class="table-responsive table-card">
                <table class="table align-middle table-nowrap mb-0">
                    <thead class="table-light text-muted">
                        <tr>
                            <th scope="col">User</th>
                            <th scope="col">Account type</th>
                            <th scope="col">Email status</th>
                            <th scope="col">Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-xs me-2 flex-shrink-0">
                                            <span class="avatar-title rounded-circle bg-primary-subtle text-primary">{{ $user->initials() }}</span>
                                        </div>
                                        <div>
                                            <h5 class="fs-14 mb-0">{{ $user->name }}</h5>
                                            <span class="text-muted">{{ $user->email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if ($user->is_admin)
                                        <span class="badge bg-warning-subtle text-warning"><i class="ri-shield-user-line me-1"></i>Administrator</span>
                                    @else
                                        <span class="badge bg-primary-subtle text-primary">Traveler</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($user->email_verified_at)
                                        <span class="badge bg-success-subtle text-success"><i class="ri-checkbox-circle-line me-1"></i>Verified</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary"><i class="ri-time-line me-1"></i>Unverified</span>
                                    @endif
                                </td>
                                <td class="text-muted">{{ $user->created_at?->format('M j, Y') ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="avatar-md mx-auto mb-3">
                                        <span class="avatar-title rounded-circle bg-primary-subtle text-primary fs-2"><i class="ri-user-search-line"></i></span>
                                    </div>
                                    <h5 class="mb-1">No users found</h5>
                                    <p class="text-muted mb-0">Try changing your search or account type filter.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($users->hasPages())
                <div class="d-flex justify-content-end mt-3">
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layouts::app>
