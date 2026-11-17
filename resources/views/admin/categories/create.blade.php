<x-admin-layouts::app :title="__('Add category')">
    @include('admin.categories.partials.form-page-heading', ['heading' => 'Add category'])

    @include('admin.categories.partials.form', [
        'category' => $category,
        'destinations' => $destinations,
        'action' => route('admin.categories.store'),
        'method' => 'POST',
        'submitLabel' => 'Create category',
    ])
</x-admin-layouts::app>
