<x-admin-layouts::app :title="__('Edit travel information page')">
    @include('admin.travel-info-pages.partials.form-page-heading', ['heading' => 'Edit travel information page'])
    @include('admin.travel-info-pages.partials.form', [
        'travelInfoPage' => $travelInfoPage,
        'action' => route('admin.travel-info-pages.update', $travelInfoPage),
        'method' => 'PUT',
        'submitLabel' => 'Save changes',
    ])
</x-admin-layouts::app>
