<x-admin-layouts::app :title="__('Edit FAQ')">
    @include('admin.faqs.partials.form-page-heading', ['heading' => 'Edit FAQ'])

    @include('admin.faqs.partials.form', [
        'faq' => $faq,
        'action' => route('admin.faqs.update', $faq),
        'method' => 'PUT',
        'submitLabel' => 'Save changes',
    ])
</x-admin-layouts::app>
