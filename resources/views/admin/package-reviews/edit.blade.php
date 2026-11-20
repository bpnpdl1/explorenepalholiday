<x-admin-layouts::app :title="__('Edit package review')">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between gap-3">
        <div>
            <h4 class="mb-sm-0">Edit package review</h4>
            <p class="text-muted mb-0 mt-1">Update this customer quote or move it to another package.</p>
        </div>
        <a href="{{ route('admin.package-reviews.package', $review->package) }}" class="btn btn-light">Back to {{ $review->package->name }} reviews</a>
    </div>
    @include('admin.package-reviews.partials.form', [
        'action' => route('admin.package-reviews.update', $review),
        'method' => 'PUT',
        'submitLabel' => 'Save changes',
    ])
</x-admin-layouts::app>
