<x-admin-layouts::app :title="__('Edit subcategory')">
    @include('admin.subcategories.partials.form-page-heading', ['heading' => 'Edit subcategory'])

    @include('admin.subcategories.partials.form', [
        'subcategory' => $subcategory,
        'categories' => $categories,
        'action' => route('admin.subcategories.update', $subcategory),
        'method' => 'PUT',
        'submitLabel' => 'Save changes',
    ])
</x-admin-layouts::app>
