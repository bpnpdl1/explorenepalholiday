<x-admin-layouts::app :title="__('Add travel information page')">
    @include('admin.travel-info-pages.partials.form-page-heading', ['heading' => 'Add travel information page'])
    @include('admin.travel-info-pages.partials.form', [
        'travelInfoPage' => $travelInfoPage,
        'action' => route('admin.travel-info-pages.store'),
        'method' => 'POST',
        'submitLabel' => 'Create page',
    ])
</x-admin-layouts::app>
