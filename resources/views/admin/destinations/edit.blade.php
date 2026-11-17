<x-admin-layouts::app :title="__('Edit destination')">
    @include('admin.destinations.partials.form-page-heading', ['heading' => 'Edit destination'])

    @include('admin.destinations.partials.form', [
        'destination' => $destination,
        'action' => route('admin.destinations.update', $destination),
        'method' => 'PUT',
        'submitLabel' => 'Save changes',
    ])
</x-admin-layouts::app>
