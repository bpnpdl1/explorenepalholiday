@php
    $selectedPackage = $packages->firstWhere('id', (int) old('package_id', $review->package_id));
    $backUrl = $selectedPackage
        ? route('admin.package-reviews.package', $selectedPackage)
        : route('admin.package-reviews.index');
@endphp

<form action="{{ $action }}" method="POST">
    @csrf
    @if ($method !== 'POST') @method($method) @endif

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <p class="fw-semibold mb-1">Please correct the highlighted fields.</p>
            <ul class="mb-0 ps-3">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="row g-3">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Review content</h5></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="package_id" class="form-label">Package <span class="text-danger">*</span></label>
                        <select id="package_id" name="package_id" class="form-select js-select2 @error('package_id') is-invalid @enderror" data-placeholder="Choose a package" required>
                            <option value="">Choose a package</option>
                            @foreach ($packages as $package)
                                <option value="{{ $package->id }}" @selected((string) old('package_id', $review->package_id) === (string) $package->id)>{{ $package->name }}</option>
                            @endforeach
                        </select>
                        @error('package_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text">This review will appear on the selected package page.</div>
                    </div>
                    <div class="mb-3">
                        <label for="quote" class="form-label">Customer review <span class="text-danger">*</span></label>
                        <textarea id="quote" name="quote" rows="6" maxlength="10000" class="form-control @error('quote') is-invalid @enderror" placeholder="Enter the customer’s review quote" required>{{ old('quote', $review->quote) }}</textarea>
                        @error('quote')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="reviewer_name" class="form-label">Customer name</label>
                            <input id="reviewer_name" name="reviewer_name" type="text" maxlength="255" value="{{ old('reviewer_name', $review->reviewer_name) }}" class="form-control @error('reviewer_name') is-invalid @enderror" placeholder="e.g. Alex Morgan">
                            @error('reviewer_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="reviewer_label" class="form-label">Trip / reviewer label</label>
                            <input id="reviewer_label" name="reviewer_label" type="text" maxlength="255" value="{{ old('reviewer_label', $review->reviewer_label) }}" class="form-control @error('reviewer_label') is-invalid @enderror" placeholder="e.g. Everest Base Camp Trek">
                            @error('reviewer_label')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Display order</h5></div>
                <div class="card-body">
                    <label for="sort_order" class="form-label">Order on package page</label>
                    <input id="sort_order" name="sort_order" type="number" min="0" max="65535" value="{{ old('sort_order', $review->sort_order ?? 0) }}" class="form-control @error('sort_order') is-invalid @enderror" required>
                    @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <div class="form-text">Lower numbers appear first.</div>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mb-4">
                <a href="{{ $backUrl }}" class="btn btn-light">Cancel</a>
                <button type="submit" class="btn btn-primary"><i class="ri-save-line me-1"></i>{{ $submitLabel }}</button>
            </div>
        </div>
    </div>
</form>

@push('scripts')
    <script>
        jQuery(function ($) {
            const $package = $('#package_id');

            if ($package.length && $.fn.select2) {
                $package.select2({
                    width: '100%',
                    placeholder: $package.data('placeholder'),
                    allowClear: true,
                });
            }
        });
    </script>
@endpush
