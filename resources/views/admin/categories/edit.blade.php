<x-admin-layouts::app :title="__('Edit category')">
    @include('admin.categories.partials.form-page-heading', ['heading' => 'Edit category'])

    @include('admin.categories.partials.form', [
        'category' => $category,
        'destinations' => $destinations,
        'action' => route('admin.categories.update', $category),
        'method' => 'PUT',
        'submitLabel' => 'Save changes',
    ])
</x-admin-layouts::app>
