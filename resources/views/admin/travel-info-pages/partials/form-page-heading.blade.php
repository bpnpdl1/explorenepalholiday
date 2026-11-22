<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <div>
                <h4 class="mb-sm-0">{{ $heading }}</h4>
                <p class="text-muted mb-0 mt-1">Manage the title, URL, content, and visibility for this travel information page.</p>
            </div>
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.travel-info-pages.index') }}">Travel information pages</a></li>
                <li class="breadcrumb-item active">{{ $heading }}</li>
            </ol>
        </div>
    </div>
</div>
