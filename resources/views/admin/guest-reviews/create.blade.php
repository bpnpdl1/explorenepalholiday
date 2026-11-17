<x-admin-layouts::app :title="__('Add guest review')">
    @include('admin.guest-reviews.partials.form-page-heading', ['heading' => 'Add guest review'])

    @include('admin.guest-reviews.partials.form', [
        'review' => $review,
        'action' => route('admin.guest-reviews.store'),
        'method' => 'POST',
        'submitLabel' => 'Create review',
    ])
</x-admin-layouts::app>
