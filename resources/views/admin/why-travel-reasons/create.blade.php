<x-admin-layouts::app :title="__('Add reason')">
    @include('admin.why-travel-reasons.partials.form-page-heading', ['heading' => 'Add reason'])

    @include('admin.why-travel-reasons.partials.form', [
        'reason' => $reason,
        'action' => route('admin.why-travel-reasons.store'),
        'method' => 'POST',
        'submitLabel' => 'Create reason',
    ])
</x-admin-layouts::app>
