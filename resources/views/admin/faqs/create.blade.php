<x-admin-layouts::app :title="__('Add FAQ')">
    @include('admin.faqs.partials.form-page-heading', ['heading' => 'Add FAQ'])

    @include('admin.faqs.partials.form', [
        'faq' => $faq,
        'action' => route('admin.faqs.store'),
        'method' => 'POST',
        'submitLabel' => 'Create FAQ',
    ])
</x-admin-layouts::app>
