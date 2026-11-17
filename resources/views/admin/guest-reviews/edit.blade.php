<x-admin-layouts::app :title="__('Edit guest review')">
    @include('admin.guest-reviews.partials.form-page-heading', ['heading' => 'Edit guest review'])

    @include('admin.guest-reviews.partials.form', [
        'review' => $review,
        'action' => route('admin.guest-reviews.update', $review),
        'method' => 'PUT',
        'submitLabel' => 'Save changes',
    ])
</x-admin-layouts::app>
