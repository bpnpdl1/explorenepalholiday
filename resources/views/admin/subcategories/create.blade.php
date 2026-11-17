<x-admin-layouts::app :title="__('Add subcategory')">
    @include('admin.subcategories.partials.form-page-heading', ['heading' => 'Add subcategory'])

    @include('admin.subcategories.partials.form', [
        'subcategory' => $subcategory,
        'categories' => $categories,
        'action' => route('admin.subcategories.store'),
        'method' => 'POST',
        'submitLabel' => 'Create subcategory',
    ])
</x-admin-layouts::app>
