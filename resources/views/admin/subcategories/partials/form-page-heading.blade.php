<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <div>
                <h4 class="mb-sm-0">{{ $heading }}</h4>
                <p class="text-muted mb-0 mt-1">Set the parent category, details, and visibility.</p>
            </div>
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.subcategories.index') }}">Subcategories</a></li>
                <li class="breadcrumb-item active">{{ $heading }}</li>
            </ol>
        </div>
    </div>
</div>
