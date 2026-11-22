<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <div>
                <h4 class="mb-sm-0">{{ $heading }}</h4>
                <p class="text-muted mb-0 mt-1">Manage account details, administrator access, and email verification.</p>
            </div>
            <ol class="breadcrumb m-0 d-none d-md-flex">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
                <li class="breadcrumb-item active">{{ $heading }}</li>
            </ol>
        </div>
    </div>
</div>
