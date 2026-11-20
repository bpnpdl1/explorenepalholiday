<x-admin-layouts::app :title="__('Add package review')">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between gap-3">
        <div>
            <h4 class="mb-sm-0">Add package review</h4>
            <p class="text-muted mb-0 mt-1">Add a customer quote to a package’s public review section.</p>
        </div>
        <a href="{{ route('admin.package-reviews.index') }}" class="btn btn-light">Back to package reviews</a>
    </div>
    @include('admin.package-reviews.partials.form', [
        'action' => route('admin.package-reviews.store'),
        'method' => 'POST',
        'submitLabel' => 'Add review',
    ])
</x-admin-layouts::app>
