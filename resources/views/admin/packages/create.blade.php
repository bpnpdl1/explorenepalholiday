<x-admin-layouts::app :title="__('Create package')">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <div><h4 class="mb-sm-0">Create package</h4><p class="text-muted mb-0 mt-1">Add a trip package and its route details.</p></div>
        <ol class="breadcrumb m-0"><li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li><li class="breadcrumb-item"><a href="{{ route('admin.packages.index') }}">Packages</a></li><li class="breadcrumb-item active">Create</li></ol>
    </div>
    @include('admin.packages.partials.form', [
        'package' => $package,
        'subcategories' => $subcategories,
        'action' => route('admin.packages.store'),
        'method' => 'POST',
        'submitLabel' => 'Create package',
    ])
</x-admin-layouts::app>
