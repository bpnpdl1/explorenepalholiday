<form action="{{ $action }}" method="POST">
    @csrf
    @if ($method !== 'POST') @method($method) @endif

    @if ($errors->any())
        <div class="alert alert-danger" role="alert"><p class="fw-semibold mb-1">Please correct the highlighted fields.</p><ul class="mb-0 ps-3">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <div class="row g-3">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Departure details</h5></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="package_id" class="form-label">Package <span class="text-danger">*</span></label>
                        <select id="package_id" name="package_id" class="form-select js-select2 @error('package_id') is-invalid @enderror" data-placeholder="Choose a package" required>
                            <option value="">Choose a package</option>
                            @foreach ($packages as $package)
                                <option value="{{ $package->id }}" @selected((string) old('package_id', $departure->package_id) === (string) $package->id)>{{ $package->name }}</option>
                            @endforeach
                        </select>
                        @error('package_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="season" class="form-label">Season <span class="text-danger">*</span></label>
                            <select id="season" name="season" class="form-select @error('season') is-invalid @enderror" required>
                                <option value="">Choose a season</option>
                                @foreach (\App\Enums\Season::cases() as $season)
                                    <option value="{{ $season->value }}" @selected(old('season', $departure->season?->value ?? '') === $season->value)>{{ $season->label() }}</option>
                                @endforeach
                            </select>
                            @error('season')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="status" class="form-label">Availability status <span class="text-danger">*</span></label>
                            <input id="status" name="status" type="text" maxlength="50" value="{{ old('status', $departure->status ?? 'available_to_discuss') }}" class="form-control @error('status') is-invalid @enderror" placeholder="e.g. available_to_discuss" required>
                            <div class="form-text">Shown to travelers. Use a short label such as “available” or “sold_out”.</div>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="starts_on" class="form-label">Start date <span class="text-danger">*</span></label>
                            <input id="starts_on" name="starts_on" type="date" value="{{ old('starts_on', $departure->starts_on?->toDateString()) }}" class="form-control @error('starts_on') is-invalid @enderror" required>
                            @error('starts_on')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="ends_on" class="form-label">End date</label>
                            <input id="ends_on" name="ends_on" type="date" value="{{ old('ends_on', $departure->ends_on?->toDateString()) }}" class="form-control @error('ends_on') is-invalid @enderror">
                            <div class="form-text">Optional; must be on or after the start date.</div>
                            @error('ends_on')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Price and order</h5></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="price" class="form-label">Price (optional)</label>
                        <input id="price" name="price" type="number" min="0" max="99999999.99" step="0.01" value="{{ old('price', $departure->price) }}" class="form-control @error('price') is-invalid @enderror">
                        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="currency" class="form-label">Currency</label>
                        <input id="currency" name="currency" type="text" maxlength="3" pattern="[A-Z]{3}" value="{{ old('currency', $departure->currency ?? 'USD') }}" class="form-control text-uppercase @error('currency') is-invalid @enderror" required>
                        @error('currency')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label for="sort_order" class="form-label">Display order</label>
                        <input id="sort_order" name="sort_order" type="number" min="0" max="65535" value="{{ old('sort_order', $departure->sort_order ?? 0) }}" class="form-control @error('sort_order') is-invalid @enderror" required>
                        @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mb-4">
                <a href="{{ route('admin.package-departures.index') }}" class="btn btn-light">Cancel</a>
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
