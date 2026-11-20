<form action="{{ $action }}" method="POST" data-multiple-departures-form>
    @csrf
    @php($packageLocked = filled($departure->package_id))

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <p class="fw-semibold mb-1">Please correct the highlighted fields.</p>
            <ul class="mb-0 ps-3">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="card mb-3">
        <div class="card-header"><h5 class="card-title mb-0">Package</h5></div>
        <div class="card-body row g-3">
            <div class="col-md-8">
                <label for="package_id" class="form-label">Package <span class="text-danger">*</span></label>
                <select id="package_id" @unless ($packageLocked) name="package_id" @endunless class="form-select js-select2 @error('package_id') is-invalid @enderror" data-placeholder="Choose a package" @disabled($packageLocked) required>
                    <option value="">Choose a package</option>
                    @foreach ($packages as $package)
                        <option value="{{ $package->id }}" @selected((string) old('package_id', $departure->package_id) === (string) $package->id)>{{ $package->name }}</option>
                    @endforeach
                </select>
                @if ($packageLocked)
                    <input type="hidden" name="package_id" value="{{ old('package_id', $departure->package_id) }}">
                @endif
                @error('package_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <div class="form-text">{{ $packageLocked ? 'Package selected from its departures page.' : 'All date rows below will be added to this package.' }}</div>
            </div>
            <div class="col-md-4">
                <label for="season" class="form-label">Season <span class="text-danger">*</span></label>
                <select id="season" name="season" class="form-select @error('season') is-invalid @enderror" required>
                    <option value="">Choose a season</option>
                    @foreach (\App\Enums\Season::cases() as $season)
                        <option value="{{ $season->value }}" @selected(old('season') === $season->value)>{{ $season->label() }}</option>
                    @endforeach
                </select>
                @error('season')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>

    @php
        $departureRows = old('departures', [[
            'starts_on' => '',
            'ends_on' => '',
            'price' => '',
        ]]);
    @endphp

    <div class="card mb-3">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div><h5 class="card-title mb-1">Departure dates</h5><p class="text-muted mb-0">Add a row for each scheduled date range.</p></div>
        </div>
        <div class="card-body">
            <div class="alert alert-danger d-none" data-departure-limit role="alert">You can add up to 100 departure rows at once.</div>
            <div class="d-grid gap-3" data-departures-container>
                @foreach ($departureRows as $index => $row)
                    <div class="border rounded p-3" data-departure-row>
                        <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
                            <h6 class="mb-0">Departure <span data-departure-number>{{ $loop->iteration }}</span></h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4"><label class="form-label" for="departure-{{ $index }}-starts-on">Start date <span class="text-danger">*</span></label><input data-datepicker data-field="starts_on" id="departure-{{ $index }}-starts-on" type="text" autocomplete="off" placeholder="Choose start date" name="departures[{{ $index }}][starts_on]" value="{{ $row['starts_on'] ?? '' }}" class="form-control @error("departures.$index.starts_on") is-invalid @enderror" required>@error("departures.$index.starts_on")<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                            <div class="col-md-4"><label class="form-label" for="departure-{{ $index }}-ends-on">End date</label><input data-datepicker data-field="ends_on" id="departure-{{ $index }}-ends-on" type="text" autocomplete="off" placeholder="Choose end date" name="departures[{{ $index }}][ends_on]" value="{{ $row['ends_on'] ?? '' }}" class="form-control @error("departures.$index.ends_on") is-invalid @enderror">@error("departures.$index.ends_on")<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                            <div class="col-md-3"><label class="form-label" for="departure-{{ $index }}-price">Price (optional)</label><input data-field="price" id="departure-{{ $index }}-price" type="number" min="0" max="99999999.99" step="0.01" name="departures[{{ $index }}][price]" value="{{ $row['price'] ?? '' }}" class="form-control @error("departures.$index.price") is-invalid @enderror">@error("departures.$index.price")<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <button type="button" class="btn btn-sm btn-soft-danger" data-remove-departure aria-label="Remove departure row"><i class="ri-delete-bin-line me-1"></i>Remove</button>
                            <button type="button" class="btn btn-sm btn-soft-primary" data-add-departure-row><i class="ri-add-line me-1"></i>Add date row</button>
                        </div>
                    </div>
                @endforeach
            </div>
            @error('departures')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mb-4">
        <a href="{{ route('admin.package-departures.index') }}" class="btn btn-light">Cancel</a>
        <button type="submit" class="btn btn-primary"><i class="ri-save-line me-1"></i>Create departures</button>
    </div>
</form>

@push('scripts')
    <script>
        jQuery(function ($) {
            const $package = $('#package_id');
            if ($package.length && $.fn.select2) {
                $package.select2({ width: '100%', placeholder: $package.data('placeholder'), allowClear: true });
            }
        });

        (() => {
            const form = document.querySelector('[data-multiple-departures-form]');
            if (!form) return;

            const container = form.querySelector('[data-departures-container]');
            const limitNotice = form.querySelector('[data-departure-limit]');
            const initializeDatepickers = (scope = form) => {
                if (typeof window.flatpickr !== 'function') return;

                scope.querySelectorAll('[data-datepicker]:not([data-datepicker-ready])').forEach((input) => {
                    window.flatpickr(input, {
                        dateFormat: 'Y-m-d',
                        altInput: true,
                        altFormat: 'M j, Y',
                        allowInput: true,
                        disableMobile: true,
                    });
                    input.dataset.datepickerReady = 'true';
                });
            };
            const template = document.createElement('template');
            template.innerHTML = `<div class="border rounded p-3" data-departure-row>
                <div class="d-flex justify-content-between align-items-center gap-2 mb-3"><h6 class="mb-0">Departure <span data-departure-number></span></h6></div>
                <div class="row g-3">
                    <div class="col-md-4"><label class="form-label">Start date <span class="text-danger">*</span></label><input data-datepicker data-field="starts_on" type="text" autocomplete="off" placeholder="Choose start date" class="form-control" required></div>
                    <div class="col-md-4"><label class="form-label">End date</label><input data-datepicker data-field="ends_on" type="text" autocomplete="off" placeholder="Choose end date" class="form-control"></div>
                    <div class="col-md-3"><label class="form-label">Price (optional)</label><input data-field="price" type="number" min="0" max="99999999.99" step="0.01" class="form-control"></div>
                </div>
                <div class="d-flex justify-content-end gap-2 mt-3"><button type="button" class="btn btn-sm btn-soft-danger" data-remove-departure aria-label="Remove departure row"><i class="ri-delete-bin-line me-1"></i>Remove</button><button type="button" class="btn btn-sm btn-soft-primary" data-add-departure-row><i class="ri-add-line me-1"></i>Add date row</button></div>
            </div>`;

            const refreshRows = () => {
                const rows = [...container.querySelectorAll('[data-departure-row]')];
                rows.forEach((row, index) => {
                    row.querySelector('[data-departure-number]').textContent = String(index + 1);
                    row.querySelector('[data-remove-departure]').disabled = rows.length === 1;
                    row.querySelector('[data-add-departure-row]').disabled = rows.length >= 100;
                    row.querySelectorAll('[data-field]').forEach((field) => {
                        field.name = `departures[${index}][${field.dataset.field}]`;
                        field.id = `departure-${index}-${field.dataset.field.replaceAll('_', '-')}`;
                        field.labels[0]?.setAttribute('for', field.id);
                    });
                });
                limitNotice.classList.toggle('d-none', rows.length < 100);
            };

            container.addEventListener('click', (event) => {
                const addButton = event.target.closest('[data-add-departure-row]');
                if (addButton) {
                    if (container.querySelectorAll('[data-departure-row]').length >= 100) return;
                    const row = template.content.firstElementChild.cloneNode(true);
                    addButton.closest('[data-departure-row]').after(row);
                    refreshRows();
                    initializeDatepickers(row);
                    row.querySelector('[data-field="starts_on"]')?.focus();
                    return;
                }

                const removeButton = event.target.closest('[data-remove-departure]');
                if (!removeButton || container.querySelectorAll('[data-departure-row]').length === 1) return;
                removeButton.closest('[data-departure-row]').remove();
                refreshRows();
            });

            refreshRows();
            initializeDatepickers();
        })();
    </script>
@endpush
