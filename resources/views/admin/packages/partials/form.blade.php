@php
    $hasOldInput = session()->hasOldInput();
    $seasons = old('seasons', $package->seasons->map(fn ($season) => $season->season->value)->all());
    $tags = old('tags', $package->tags ?? []);
@endphp

<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <p class="fw-semibold mb-1">Please correct the highlighted fields.</p>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card mb-3">
        <div class="card-header"><h5 class="card-title mb-0">Package details</h5></div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-12">
                    <label for="subcategory_id" class="form-label">Trip category <span class="text-danger">*</span></label>
                    <select id="subcategory_id" name="subcategory_id" class="form-select js-select2 @error('subcategory_id') is-invalid @enderror" data-placeholder="Choose a destination and category" required>
                        <option value="">Choose a destination and category</option>
                        @foreach ($subcategories as $subcategory)
                            <option value="{{ $subcategory->id }}" @selected((string) old('subcategory_id', $package->subcategory_id) === (string) $subcategory->id)>
                                {{ $subcategory->category->destination->name }} / {{ $subcategory->category->name }} / {{ $subcategory->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('subcategory_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-8">
                    <label for="name" class="form-label">Package name <span class="text-danger">*</span></label>
                    <input id="name" name="name" type="text" value="{{ old('name', $package->name) }}" class="form-control @error('name') is-invalid @enderror" maxlength="255" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    @if ($package->exists)<div class="form-text">URL slug: <code>{{ $package->slug }}</code></div>@endif
                </div>
                <div class="col-md-4">
                    <label for="sort_order" class="form-label">Display order</label>
                    <input id="sort_order" name="sort_order" type="number" min="0" max="65535" value="{{ old('sort_order', $package->sort_order ?? 0) }}" class="form-control @error('sort_order') is-invalid @enderror" required>
                    @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label for="summary" class="form-label">Short summary</label>
                    <textarea id="summary" name="summary" rows="2" maxlength="5000" class="form-control @error('summary') is-invalid @enderror">{{ old('summary', $package->summary) }}</textarea>
                    @error('summary')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label for="description" class="form-label">Overview</label>
                    <textarea id="description" name="description" rows="5" class="form-control @error('description') is-invalid @enderror">{{ old('description', $package->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <span class="form-label d-block">Package tags</span>
                    <div class="d-flex flex-wrap gap-4">
                        @foreach (['trekking' => 'Trekking', 'challenging' => 'Challenging', 'featured journey' => 'Featured journey'] as $value => $label)
                            <label class="form-check">
                                <input class="form-check-input" type="checkbox" name="tags[]" value="{{ $value }}" @checked(in_array($value, $tags, true))>
                                <span class="form-check-label">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('tags')<div class="text-danger small">{{ $message }}</div>@enderror
                    @error('tags.*')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header"><h5 class="card-title mb-0">Trip facts and pricing</h5></div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-sm-6 col-lg-3"><label for="duration_days" class="form-label">Duration (days)</label><input id="duration_days" name="duration_days" type="number" min="1" value="{{ old('duration_days', $package->duration_days) }}" class="form-control @error('duration_days') is-invalid @enderror">@error('duration_days')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-sm-6 col-lg-3"><label for="duration_nights" class="form-label">Duration (nights)</label><input id="duration_nights" name="duration_nights" type="number" min="0" value="{{ old('duration_nights', $package->duration_nights) }}" class="form-control @error('duration_nights') is-invalid @enderror">@error('duration_nights')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-sm-6 col-lg-3"><label for="difficulty" class="form-label">Grade / difficulty</label><input id="difficulty" name="difficulty" type="text" maxlength="50" value="{{ old('difficulty', $package->difficulty) }}" class="form-control @error('difficulty') is-invalid @enderror">@error('difficulty')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-sm-6 col-lg-3"><label for="max_altitude_meters" class="form-label">Maximum altitude (m)</label><input id="max_altitude_meters" name="max_altitude_meters" type="number" min="0" value="{{ old('max_altitude_meters', $package->max_altitude_meters) }}" class="form-control @error('max_altitude_meters') is-invalid @enderror">@error('max_altitude_meters')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-sm-6 col-lg-3"><label for="min_group_size" class="form-label">Minimum group size</label><input id="min_group_size" name="min_group_size" type="number" min="1" value="{{ old('min_group_size', $package->min_group_size) }}" class="form-control @error('min_group_size') is-invalid @enderror">@error('min_group_size')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-sm-6 col-lg-3"><label for="max_group_size" class="form-label">Maximum group size</label><input id="max_group_size" name="max_group_size" type="number" min="1" value="{{ old('max_group_size', $package->max_group_size) }}" class="form-control @error('max_group_size') is-invalid @enderror">@error('max_group_size')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-sm-6 col-lg-3"><label for="price_from" class="form-label">Starting price</label><input id="price_from" name="price_from" type="number" step="0.01" min="0" value="{{ old('price_from', $package->price_from) }}" class="form-control @error('price_from') is-invalid @enderror">@error('price_from')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-sm-6 col-lg-3"><label for="compare_at_price" class="form-label">Previous price (optional)</label><input id="compare_at_price" name="compare_at_price" type="number" step="0.01" min="0" value="{{ old('compare_at_price', $package->compare_at_price) }}" class="form-control @error('compare_at_price') is-invalid @enderror">@error('compare_at_price')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-sm-6 col-lg-3"><label for="currency" class="form-label">Currency</label><input id="currency" name="currency" type="text" maxlength="3" pattern="[A-Z]{3}" value="{{ old('currency', $package->currency ?? 'USD') }}" class="form-control text-uppercase @error('currency') is-invalid @enderror" required>@error('currency')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-sm-6 col-lg-9"><label for="price_qualifier" class="form-label">Price note</label><input id="price_qualifier" name="price_qualifier" type="text" maxlength="255" placeholder="e.g. per person" value="{{ old('price_qualifier', $package->price_qualifier) }}" class="form-control @error('price_qualifier') is-invalid @enderror">@error('price_qualifier')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-12">
                    <span class="form-label d-block">Best seasons</span>
                    <div class="d-flex flex-wrap gap-3">
                        @foreach (\App\Enums\Season::cases() as $season)
                            <label class="form-check"><input class="form-check-input" type="checkbox" name="seasons[]" value="{{ $season->value }}" @checked(in_array($season->value, $seasons, true))><span class="form-check-label">{{ $season->label() }}</span></label>
                        @endforeach
                    </div>
                    @error('seasons')<div class="text-danger small">{{ $message }}</div>@enderror
                    @error('seasons.*')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header"><h5 class="card-title mb-0">Route information</h5></div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-12"><label for="route_map_url" class="form-label">Route map URL</label><input id="route_map_url" name="route_map_url" type="url" value="{{ old('route_map_url', $package->route_map_url) }}" class="form-control @error('route_map_url') is-invalid @enderror" placeholder="https://...">@error('route_map_url')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-12"><label for="accommodation" class="form-label">Accommodation</label><textarea id="accommodation" name="accommodation" rows="2" class="form-control @error('accommodation') is-invalid @enderror">{{ old('accommodation', $package->accommodation) }}</textarea>@error('accommodation')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-6"><label for="fitness_guidance" class="form-label">Fitness guidance</label><textarea id="fitness_guidance" name="fitness_guidance" rows="4" class="form-control @error('fitness_guidance') is-invalid @enderror">{{ old('fitness_guidance', $package->fitness_guidance) }}</textarea>@error('fitness_guidance')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-6"><label for="permit_notes" class="form-label">Permit notes</label><textarea id="permit_notes" name="permit_notes" rows="4" class="form-control @error('permit_notes') is-invalid @enderror">{{ old('permit_notes', $package->permit_notes) }}</textarea>@error('permit_notes')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-6"><label for="safety_notes" class="form-label">Safety notes</label><textarea id="safety_notes" name="safety_notes" rows="4" class="form-control @error('safety_notes') is-invalid @enderror">{{ old('safety_notes', $package->safety_notes) }}</textarea>@error('safety_notes')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-6"><label for="weather_notes" class="form-label">Weather notes</label><textarea id="weather_notes" name="weather_notes" rows="4" class="form-control @error('weather_notes') is-invalid @enderror">{{ old('weather_notes', $package->weather_notes) }}</textarea>@error('weather_notes')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header"><h5 class="card-title mb-0">Package images</h5></div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="cover" class="form-label">Cover image</label>
                    @if ($package->getFirstMediaUrl('cover'))<div class="mb-2"><img src="{{ $package->getFirstMediaUrl('cover') }}" alt="Current package cover" class="img-fluid rounded" style="max-height: 180px"></div>@endif
                    <input id="cover" name="cover" type="file" accept="image/jpeg,image/png,image/webp,image/avif" class="form-control @error('cover') is-invalid @enderror">
                    <div class="form-text">JPG, PNG, WebP, or AVIF; up to 5 MB.</div>
                    @error('cover')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label for="gallery" class="form-label">Gallery images</label>
                    <input id="gallery" name="gallery[]" type="file" multiple accept="image/jpeg,image/png,image/webp,image/avif" class="form-control @error('gallery.*') is-invalid @enderror">
                    <div class="form-text">Select up to 20 images; each file can be up to 5 MB.</div>
                    @error('gallery.*')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                @if ($package->exists && $package->getMedia('gallery')->isNotEmpty())
                    <div class="col-12"><span class="form-label d-block">Current gallery</span><div class="row g-3">
                        @foreach ($package->getMedia('gallery') as $image)
                            <div class="col-6 col-md-3"><img src="{{ $image->getUrl('thumbnail') }}" alt="Current gallery image {{ $loop->iteration }}" class="img-fluid rounded mb-2"><label class="form-check"><input type="checkbox" class="form-check-input" name="remove_gallery[]" value="{{ $image->id }}"><span class="form-check-label">Remove image</span></label></div>
                        @endforeach
                    </div></div>
                @endif
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header"><h5 class="card-title mb-0">Search engine details</h5></div>
        <div class="card-body row g-3">
            <div class="col-12"><label for="meta_title" class="form-label">Meta title</label><input id="meta_title" name="meta_title" maxlength="255" value="{{ old('meta_title', $package->meta_title) }}" class="form-control @error('meta_title') is-invalid @enderror">@error('meta_title')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-12"><label for="meta_description" class="form-label">Meta description</label><textarea id="meta_description" name="meta_description" rows="3" maxlength="1000" class="form-control @error('meta_description') is-invalid @enderror">{{ old('meta_description', $package->meta_description) }}</textarea>@error('meta_description')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header"><h5 class="card-title mb-0">Visibility</h5></div>
        <div class="card-body d-flex flex-wrap gap-4">
            <label class="form-check"><input class="form-check-input" type="checkbox" name="is_published" value="1" @checked(old('is_published', $package->is_published))><span class="form-check-label">Published</span><div class="form-text">Published packages can appear on the public website.</div></label>
            <label class="form-check"><input class="form-check-input" type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $package->is_featured))><span class="form-check-label">Featured</span><div class="form-text">Mark this package for featured placements.</div></label>
        </div>
    </div>

    <div class="d-flex flex-wrap justify-content-between gap-2 mb-4">
        <a href="{{ route('admin.packages.index') }}" class="btn btn-light">Cancel</a>
        <button type="submit" class="btn btn-primary"><i class="ri-save-line me-1"></i>{{ $submitLabel }}</button>
    </div>
</form>

@push('scripts')
    <script>
        jQuery(function ($) {
            const $subcategory = $('#subcategory_id');

            if ($subcategory.length && $.fn.select2) {
                $subcategory.select2({
                    width: '100%',
                    placeholder: $subcategory.data('placeholder'),
                    allowClear: true,
                });
            }
        });
    </script>
@endpush

