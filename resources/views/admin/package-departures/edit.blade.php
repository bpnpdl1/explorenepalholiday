<x-admin-layouts::app :title="__('Edit departure')">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <div><h4 class="mb-sm-0">Edit departure</h4><p class="text-muted mb-0 mt-1">Update its package, dates, season, or availability.</p></div>
        <a href="{{ route('admin.package-departures.index') }}" class="btn btn-light">Back to departures</a>
    </div>
    @include('admin.package-departures.partials.form', ['action' => route('admin.package-departures.update', $departure), 'method' => 'PUT', 'submitLabel' => 'Save changes'])
</x-admin-layouts::app>
