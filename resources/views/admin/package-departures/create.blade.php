<x-admin-layouts::app :title="__('Add departure')">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <div><h4 class="mb-sm-0">Add departure</h4><p class="text-muted mb-0 mt-1">Create a scheduled travel window for a package.</p></div>
        <a href="{{ route('admin.package-departures.index') }}" class="btn btn-light">Back to departures</a>
    </div>
    @include('admin.package-departures.partials.multiple-form', ['action' => route('admin.package-departures.store')])
</x-admin-layouts::app>
