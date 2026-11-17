<x-admin-layouts::app :title="__('Add destination')">
    @include('admin.destinations.partials.form-page-heading', ['heading' => 'Add destination'])

    @include('admin.destinations.partials.form', [
        'destination' => $destination,
        'action' => route('admin.destinations.store'),
        'method' => 'POST',
        'submitLabel' => 'Create destination',
    ])
</x-admin-layouts::app>
