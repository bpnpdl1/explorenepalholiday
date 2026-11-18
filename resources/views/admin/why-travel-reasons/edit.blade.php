<x-admin-layouts::app :title="__('Edit reason')">
    @include('admin.why-travel-reasons.partials.form-page-heading', ['heading' => 'Edit reason'])

    @include('admin.why-travel-reasons.partials.form', [
        'reason' => $reason,
        'action' => route('admin.why-travel-reasons.update', $reason),
        'method' => 'PUT',
        'submitLabel' => 'Save changes',
    ])
</x-admin-layouts::app>
