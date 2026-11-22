<x-admin-layouts::app :title="__('Edit package')">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <div><h4 class="mb-sm-0">Edit package</h4><p class="text-muted mb-0 mt-1">Update {{ $package->name }} and its route details.</p></div>
        <ol class="breadcrumb m-0"><li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li><li class="breadcrumb-item"><a href="{{ route('admin.packages.index') }}">Packages</a></li><li class="breadcrumb-item active">Edit</li></ol>
    </div>
    @include('admin.packages.partials.form', [
        'package' => $package,
        'action' => route('admin.packages.update', $package),
        'method' => 'PUT',
        'submitLabel' => 'Save changes',
    ])
</x-admin-layouts::app>
