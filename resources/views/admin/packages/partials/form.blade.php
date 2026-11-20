@php
    $hasOldInput = session()->hasOldInput();
    $seasons = old('seasons', $package->seasons->map(fn ($season) => $season->season->value)->all());
    $tags = old('tags', $package->tags ?? []);
    $includedFeatures = old('included_features', $package->features->where('type', 'included')->map(fn ($feature) => [
        'id' => $feature->id,
        'description' => $feature->description,
    ])->values()->all());
    $excludedFeatures = old('excluded_features', $package->features->where('type', 'excluded')->map(fn ($feature) => [
        'id' => $feature->id,
        'description' => $feature->description,
    ])->values()->all());
    $itineraryDays = old('itinerary_days', $package->itineraryDays->map(fn ($day) => [
        'id' => $day->id,
        'title' => $day->title,
        'location' => $day->location,
        'altitude_meters' => $day->altitude_meters,
        'activity_label' => $day->activity_label,
        'meal_plan' => $day->meal_plan,
        'description' => $day->description,
    ])->all());
@endphp

<form action="{{ $action }}" method="POST" enctype="multipart/form-data" data-package-wizard-form novalidate>
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

    <div class="package-wizard mb-4" data-package-wizard>
        <div class="package-wizard__header card mb-3">
            <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-3">
                    <div>
                        <h5 class="mb-1" data-wizard-heading>Package basics</h5>
                        <p class="text-muted mb-0" data-wizard-description>Set the package name, category, overview, and tags.</p>
                    </div>
                    <span class="badge bg-primary-subtle text-primary" data-wizard-count aria-live="polite">Step 1 of 6</span>
                </div>
                <div class="progress mb-3" role="progressbar" aria-label="Package form progress" aria-valuemin="1" aria-valuemax="6" aria-valuenow="1">
                    <div class="progress-bar" data-wizard-progress style="width: 16.67%"></div>
                </div>
                <ol class="package-wizard__steps" aria-label="Package form steps">
                    @foreach (['Package basics', 'Trip facts', 'Inclusions', 'Route details', 'Itinerary', 'Images & publishing'] as $stepLabel)
                        <li><button type="button" class="package-wizard__step {{ $loop->first ? 'is-current' : '' }}" data-wizard-go="{{ $loop->index }}" aria-current="{{ $loop->first ? 'step' : 'false' }}"><span>{{ $loop->iteration }}</span><span>{{ $stepLabel }}</span></button></li>
                    @endforeach
                </ol>
            </div>
        </div>

        <section class="package-wizard__panel" data-wizard-panel data-step-title="Package basics" data-step-description="Set the package name, category, overview, and tags.">
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

        </section>
        <section class="package-wizard__panel" data-wizard-panel data-step-title="Trip facts" data-step-description="Add duration, difficulty, group size, price, and the best seasons.">
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

        </section>
        <section class="package-wizard__panel" data-wizard-panel data-step-title="Inclusions & exclusions" data-step-description="List what this package includes and what travelers should budget for separately.">
    @php
        $featureLists = [
            'included' => ['label' => 'Included', 'input' => 'included_features', 'rows' => $includedFeatures, 'tone' => 'success', 'hint' => 'Services and costs included in the package price.'],
            'excluded' => ['label' => 'Not included', 'input' => 'excluded_features', 'rows' => $excludedFeatures, 'tone' => 'warning', 'hint' => 'Costs or services travelers should arrange or budget for separately.'],
        ];
    @endphp
    <div class="row g-3">
        @foreach ($featureLists as $featureType => $featureList)
            @php($rows = $featureList['rows'])
            <div class="col-xl-6">
                <div class="card h-100">
                    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <div><h5 class="card-title mb-0"><i class="ri-{{ $featureType === 'included' ? 'check' : 'close' }}-line text-{{ $featureList['tone'] }} me-1"></i>{{ $featureList['label'] }}</h5><p class="text-muted mb-0 small">{{ $featureList['hint'] }}</p></div>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-warning d-none" data-feature-limit="{{ $featureType }}" role="alert">You can add up to 100 items in this list.</div>
                        <div class="text-center py-4 text-muted" data-feature-empty="{{ $featureType }}" @if (count($rows)) hidden @endif>
                            <span class="d-block mb-2">No items added yet.</span>
                            <button type="button" class="btn btn-sm btn-soft-primary" data-add-feature="{{ $featureType }}"><i class="ri-add-line me-1"></i>Add first item</button>
                        </div>
                        <div class="d-grid gap-2" data-feature-list="{{ $featureType }}" data-input-name="{{ $featureList['input'] }}">
                            @foreach ($rows as $index => $feature)
                                <div class="border rounded p-3" data-feature-row>
                                    @if (!empty($feature['id']))<input type="hidden" data-feature-id name="{{ $featureList['input'] }}[{{ $index }}][id]" value="{{ $feature['id'] }}">@endif
                                    <div class="d-flex justify-content-between align-items-center gap-2 mb-2"><span class="small fw-semibold">Item <span data-feature-number>{{ $loop->iteration }}</span></span></div>
                                    <label class="visually-hidden" for="{{ $featureList['input'] }}-{{ $index }}-description">{{ $featureList['label'] }} description</label>
                                    <textarea data-field="description" id="{{ $featureList['input'] }}-{{ $index }}-description" name="{{ $featureList['input'] }}[{{ $index }}][description]" rows="2" maxlength="5000" class="form-control @error("{$featureList['input']}.$index.description") is-invalid @enderror" placeholder="e.g. Airport transfers in a private vehicle" required>{{ $feature['description'] ?? '' }}</textarea>
                                    @error("{$featureList['input']}.$index.description")<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    <div class="d-flex justify-content-end gap-2 mt-2">
                                        <button type="button" class="btn btn-sm btn-light" data-move-feature="up" aria-label="Move item up" title="Move up"><i class="ri-arrow-up-line"></i></button>
                                        <button type="button" class="btn btn-sm btn-light" data-move-feature="down" aria-label="Move item down" title="Move down"><i class="ri-arrow-down-line"></i></button>
                                        <button type="button" class="btn btn-sm btn-soft-danger" data-remove-feature aria-label="Remove item" title="Remove item"><i class="ri-delete-bin-line"></i></button>
                                        <button type="button" class="btn btn-sm btn-soft-primary" data-add-feature="{{ $featureType }}"><i class="ri-add-line me-1"></i>Add item</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @error($featureList['input'])<div class="text-danger small mt-2">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        @endforeach
    </div>

        </section>
        <section class="package-wizard__panel" data-wizard-panel data-step-title="Route details" data-step-description="Add route links, accommodation information, and planning notes.">
    <div class="card mb-3">
        <div class="card-header"><h5 class="card-title mb-0">Route information</h5></div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="route_map_image" class="form-label">Route map image</label>
                    @if ($package->getFirstMediaUrl('route_map'))
                        <div class="mb-2 p-2 border rounded bg-light"><img src="{{ $package->getFirstMediaUrl('route_map') }}" alt="Current route map for {{ $package->name }}" class="img-fluid rounded" style="max-height: 220px; width: 100%; object-fit: contain"></div>
                    @endif
                    <input id="route_map_image" name="route_map_image" type="file" accept="image/jpeg,image/png,image/webp,image/avif" class="form-control @error('route_map_image') is-invalid @enderror">
                    <div class="form-text">Upload a JPG, PNG, WebP, or AVIF map image up to 10 MB. A new upload replaces the current image.</div>
                    @error('route_map_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    @if ($package->getFirstMedia('route_map'))
                        <label class="form-check mt-2"><input type="checkbox" name="remove_route_map" value="1" class="form-check-input" @checked(old('remove_route_map'))><span class="form-check-label">Remove current route map image</span></label>
                    @endif
                </div>
                <div class="col-md-6"><label for="route_map_url" class="form-label">External route map URL (optional)</label><input id="route_map_url" name="route_map_url" type="url" value="{{ old('route_map_url', $package->route_map_url) }}" class="form-control @error('route_map_url') is-invalid @enderror" placeholder="https://...">@error('route_map_url')<div class="invalid-feedback">{{ $message }}</div>@enderror<div class="form-text">Use this for a Google Maps, GPX, or other external route link.</div></div>
                <div class="col-12"><label for="accommodation" class="form-label">Accommodation</label><textarea id="accommodation" name="accommodation" rows="2" class="form-control @error('accommodation') is-invalid @enderror">{{ old('accommodation', $package->accommodation) }}</textarea>@error('accommodation')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-6"><label for="fitness_guidance" class="form-label">Fitness guidance</label><textarea id="fitness_guidance" name="fitness_guidance" rows="4" class="form-control @error('fitness_guidance') is-invalid @enderror">{{ old('fitness_guidance', $package->fitness_guidance) }}</textarea>@error('fitness_guidance')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-6"><label for="permit_notes" class="form-label">Permit notes</label><textarea id="permit_notes" name="permit_notes" rows="4" class="form-control @error('permit_notes') is-invalid @enderror">{{ old('permit_notes', $package->permit_notes) }}</textarea>@error('permit_notes')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-6"><label for="safety_notes" class="form-label">Safety notes</label><textarea id="safety_notes" name="safety_notes" rows="4" class="form-control @error('safety_notes') is-invalid @enderror">{{ old('safety_notes', $package->safety_notes) }}</textarea>@error('safety_notes')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-6"><label for="weather_notes" class="form-label">Weather notes</label><textarea id="weather_notes" name="weather_notes" rows="4" class="form-control @error('weather_notes') is-invalid @enderror">{{ old('weather_notes', $package->weather_notes) }}</textarea>@error('weather_notes')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            </div>
        </div>
    </div>

        </section>
        <section class="package-wizard__panel" data-wizard-panel data-step-title="Itinerary" data-step-description="Build the ordered day-by-day route for this package.">
    <div class="card mb-3">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <h5 class="card-title mb-1">Day-by-day itinerary</h5>
                <p class="text-muted mb-0">Add one row per day. Row order sets the day number on the public package page.</p>
            </div>
            <button type="button" class="btn btn-sm btn-primary" data-add-itinerary-day><i class="ri-add-line me-1"></i>Add day</button>
        </div>
        <div class="card-body">
            <div class="alert alert-danger d-none" data-itinerary-limit role="alert">A package can have up to 100 itinerary days.</div>
            <div class="text-center py-4 text-muted" data-itinerary-empty @if (count($itineraryDays)) hidden @endif>
                <i class="ri-route-line fs-2 d-block mb-2"></i>
                <p class="mb-0">No itinerary added yet. Add a day to describe the route.</p>
            </div>
            <div class="d-grid gap-3" data-itinerary-days>
                @foreach ($itineraryDays as $index => $day)
                    <div class="border rounded p-3" data-itinerary-day>
                        @if (!empty($day['id']))<input type="hidden" data-itinerary-id name="itinerary_days[{{ $index }}][id]" value="{{ $day['id'] }}">@endif
                        <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
                            <h6 class="mb-0">Day <span data-day-number>{{ $loop->iteration }}</span></h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label" for="itinerary-{{ $index }}-title">Day title <span class="text-danger">*</span></label><input data-field="title" id="itinerary-{{ $index }}-title" name="itinerary_days[{{ $index }}][title]" type="text" maxlength="255" value="{{ $day['title'] ?? '' }}" class="form-control @error("itinerary_days.$index.title") is-invalid @enderror" placeholder="e.g. Trek to Namche Bazaar" required>@error("itinerary_days.$index.title")<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                            <div class="col-md-6"><label class="form-label" for="itinerary-{{ $index }}-location">Location / route</label><input data-field="location" id="itinerary-{{ $index }}-location" name="itinerary_days[{{ $index }}][location]" type="text" maxlength="255" value="{{ $day['location'] ?? '' }}" class="form-control @error("itinerary_days.$index.location") is-invalid @enderror" placeholder="e.g. Phakding to Namche Bazaar">@error("itinerary_days.$index.location")<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                            <div class="col-md-4"><label class="form-label" for="itinerary-{{ $index }}-altitude">Altitude (meters)</label><input data-field="altitude_meters" id="itinerary-{{ $index }}-altitude" name="itinerary_days[{{ $index }}][altitude_meters]" type="number" min="0" max="65535" value="{{ $day['altitude_meters'] ?? '' }}" class="form-control @error("itinerary_days.$index.altitude_meters") is-invalid @enderror" placeholder="e.g. 3440">@error("itinerary_days.$index.altitude_meters")<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                            <div class="col-md-4"><label class="form-label" for="itinerary-{{ $index }}-activity">Activity label</label><input data-field="activity_label" id="itinerary-{{ $index }}-activity" name="itinerary_days[{{ $index }}][activity_label]" type="text" maxlength="255" value="{{ $day['activity_label'] ?? '' }}" class="form-control @error("itinerary_days.$index.activity_label") is-invalid @enderror" placeholder="e.g. 5–6 hours">@error("itinerary_days.$index.activity_label")<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                            <div class="col-md-4"><label class="form-label" for="itinerary-{{ $index }}-meals">Meals</label><input data-field="meal_plan" id="itinerary-{{ $index }}-meals" name="itinerary_days[{{ $index }}][meal_plan]" type="text" maxlength="255" value="{{ $day['meal_plan'] ?? '' }}" class="form-control @error("itinerary_days.$index.meal_plan") is-invalid @enderror" placeholder="e.g. Breakfast, lunch, dinner">@error("itinerary_days.$index.meal_plan")<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                            <div class="col-12"><label class="form-label" for="itinerary-{{ $index }}-description">Day details</label><textarea data-field="description" id="itinerary-{{ $index }}-description" name="itinerary_days[{{ $index }}][description]" rows="3" maxlength="100000" class="form-control @error("itinerary_days.$index.description") is-invalid @enderror" placeholder="Describe the route, key stops, and what travelers can expect.">{{ $day['description'] ?? '' }}</textarea>@error("itinerary_days.$index.description")<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                        </div>
                        <div class="d-flex flex-wrap justify-content-end gap-2 mt-3">
                            <button type="button" class="btn btn-sm btn-light" data-move-day="up" aria-label="Move day up"><i class="ri-arrow-up-line"></i></button>
                            <button type="button" class="btn btn-sm btn-light" data-move-day="down" aria-label="Move day down"><i class="ri-arrow-down-line"></i></button>
                            <button type="button" class="btn btn-sm btn-soft-danger" data-remove-day><i class="ri-delete-bin-line me-1"></i>Remove day</button>
                            <button type="button" class="btn btn-sm btn-soft-primary" data-add-day-after><i class="ri-add-line me-1"></i>Add day after</button>
                        </div>
                    </div>
                @endforeach
            </div>
            @error('itinerary_days')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
        </div>
    </div>

        </section>
        <section class="package-wizard__panel" data-wizard-panel data-step-title="Images & publishing" data-step-description="Manage trip images, search details, and package visibility.">
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

        </section>
    </div>

    <div class="card mb-3">
        <div class="card-header"><h5 class="card-title mb-0">Visibility</h5></div>
        <div class="card-body d-flex flex-wrap gap-4">
            <label class="form-check"><input class="form-check-input" type="checkbox" name="is_published" value="1" @checked(old('is_published', $package->is_published))><span class="form-check-label">Published</span><div class="form-text">Published packages can appear on the public website.</div></label>
            <label class="form-check"><input class="form-check-input" type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $package->is_featured))><span class="form-check-label">Featured</span><div class="form-text">Mark this package for featured placements.</div></label>
        </div>
    </div>

    <div class="d-flex flex-wrap justify-content-between gap-2 mb-4" data-wizard-controls>
        <a href="{{ route('admin.packages.index') }}" class="btn btn-light">Cancel</a>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-light" data-wizard-previous disabled><i class="ri-arrow-left-line me-1"></i>Previous</button>
            <button type="button" class="btn btn-primary" data-wizard-next>Next<i class="ri-arrow-right-line ms-1"></i></button>
            <button type="submit" class="btn btn-primary d-none" data-wizard-submit><i class="ri-save-line me-1"></i>{{ $submitLabel }}</button>
        </div>
    </div>
</form>

@push('styles')
    <style>
        .package-wizard__steps { display: grid; grid-template-columns: repeat(6, minmax(0, 1fr)); gap: .75rem; margin: 0; padding: 0; list-style: none; }
        .package-wizard__step { display: flex; align-items: center; gap: .6rem; width: 100%; padding: .55rem .7rem; border: 1px solid var(--vz-border-color, #e9ebec); border-radius: .5rem; background: var(--vz-card-bg, #fff); color: var(--vz-secondary-color, #878a99); text-align: left; }
        .package-wizard__step span:first-child { display: grid; width: 1.7rem; height: 1.7rem; flex: 0 0 1.7rem; place-items: center; border-radius: 50%; background: #f3f6f9; font-size: .8rem; font-weight: 600; }
        .package-wizard__step.is-current { border-color: var(--vz-primary, #405189); color: var(--vz-primary, #405189); font-weight: 600; }
        .package-wizard__step.is-current span:first-child { background: var(--vz-primary, #405189); color: #fff; }
        .package-wizard__step:disabled { cursor: not-allowed; opacity: .6; }
        @media (max-width: 767.98px) {
            .package-wizard__steps { grid-template-columns: repeat(6, minmax(0, 1fr)); gap: .35rem; }
            .package-wizard__step { justify-content: center; padding: .45rem .25rem; }
            .package-wizard__step span:last-child { position: absolute; width: 1px; height: 1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; }
        }
    </style>
@endpush

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

        (() => {
            const wizard = document.querySelector('[data-package-wizard]');
            const form = document.querySelector('[data-package-wizard-form]');

            if (!wizard || !form) return;

            const panels = [...wizard.querySelectorAll('[data-wizard-panel]')];
            const steps = [...wizard.querySelectorAll('[data-wizard-go]')];
            const previous = form.querySelector('[data-wizard-previous]');
            const next = form.querySelector('[data-wizard-next]');
            const submit = form.querySelector('[data-wizard-submit]');
            const heading = wizard.querySelector('[data-wizard-heading]');
            const description = wizard.querySelector('[data-wizard-description]');
            const count = wizard.querySelector('[data-wizard-count]');
            const progress = wizard.querySelector('[data-wizard-progress]');
            const progressTrack = progress?.parentElement;
            const featureLists = [...form.querySelectorAll('[data-feature-list]')];
            const featureTemplate = document.createElement('template');
            featureTemplate.innerHTML = `<div class="border rounded p-3" data-feature-row>
                <div class="d-flex justify-content-between align-items-center gap-2 mb-2"><span class="small fw-semibold">Item <span data-feature-number></span></span></div>
                <label class="visually-hidden" data-feature-label>Description</label>
                <textarea data-field="description" rows="2" maxlength="5000" class="form-control" placeholder="e.g. Airport transfers in a private vehicle" required></textarea>
                <div class="d-flex justify-content-end gap-2 mt-2">
                    <button type="button" class="btn btn-sm btn-light" data-move-feature="up" aria-label="Move item up"><i class="ri-arrow-up-line"></i></button>
                    <button type="button" class="btn btn-sm btn-light" data-move-feature="down" aria-label="Move item down"><i class="ri-arrow-down-line"></i></button>
                    <button type="button" class="btn btn-sm btn-soft-danger" data-remove-feature><i class="ri-delete-bin-line me-1"></i>Remove</button>
                    <button type="button" class="btn btn-sm btn-soft-primary" data-add-feature><i class="ri-add-line me-1"></i>Add item</button>
                </div>
            </div>`;
            const itineraryContainer = form.querySelector('[data-itinerary-days]');
            const itineraryEmpty = form.querySelector('[data-itinerary-empty]');
            const itineraryLimit = form.querySelector('[data-itinerary-limit]');
            const itineraryAddButton = form.querySelector('[data-add-itinerary-day]');
            const itineraryTemplate = document.createElement('template');
            itineraryTemplate.innerHTML = `<div class="border rounded p-3" data-itinerary-day>
                <div class="d-flex justify-content-between align-items-center gap-2 mb-3"><h6 class="mb-0">Day <span data-day-number></span></h6></div>
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">Day title <span class="text-danger">*</span></label><input data-field="title" type="text" maxlength="255" class="form-control" placeholder="e.g. Trek to Namche Bazaar" required></div>
                    <div class="col-md-6"><label class="form-label">Location / route</label><input data-field="location" type="text" maxlength="255" class="form-control" placeholder="e.g. Phakding to Namche Bazaar"></div>
                    <div class="col-md-4"><label class="form-label">Altitude (meters)</label><input data-field="altitude_meters" type="number" min="0" max="65535" class="form-control" placeholder="e.g. 3440"></div>
                    <div class="col-md-4"><label class="form-label">Activity label</label><input data-field="activity_label" type="text" maxlength="255" class="form-control" placeholder="e.g. 5–6 hours"></div>
                    <div class="col-md-4"><label class="form-label">Meals</label><input data-field="meal_plan" type="text" maxlength="255" class="form-control" placeholder="e.g. Breakfast, lunch, dinner"></div>
                    <div class="col-12"><label class="form-label">Day details</label><textarea data-field="description" rows="3" maxlength="100000" class="form-control" placeholder="Describe the route, key stops, and what travelers can expect."></textarea></div>
                </div>
                <div class="d-flex flex-wrap justify-content-end gap-2 mt-3">
                    <button type="button" class="btn btn-sm btn-light" data-move-day="up" aria-label="Move day up"><i class="ri-arrow-up-line"></i></button>
                    <button type="button" class="btn btn-sm btn-light" data-move-day="down" aria-label="Move day down"><i class="ri-arrow-down-line"></i></button>
                    <button type="button" class="btn btn-sm btn-soft-danger" data-remove-day><i class="ri-delete-bin-line me-1"></i>Remove day</button>
                    <button type="button" class="btn btn-sm btn-soft-primary" data-add-day-after><i class="ri-add-line me-1"></i>Add day after</button>
                </div>
            </div>`;
            let current = 0;

            const invalidField = (panel) => [...panel.querySelectorAll('input, select, textarea')]
                .find((field) => !field.disabled && !field.checkValidity());

            const showStep = (index, focusHeading = false) => {
                current = Math.max(0, Math.min(index, panels.length - 1));

                panels.forEach((panel, panelIndex) => {
                    panel.hidden = panelIndex !== current;
                });

                steps.forEach((step, stepIndex) => {
                    step.disabled = false;
                    step.classList.toggle('is-current', stepIndex === current);
                    if (stepIndex === current) step.setAttribute('aria-current', 'step');
                    else step.removeAttribute('aria-current');
                });

                previous.disabled = current === 0;
                next.classList.toggle('d-none', current === panels.length - 1);
                submit.classList.toggle('d-none', current !== panels.length - 1);
                heading.textContent = panels[current].dataset.stepTitle;
                description.textContent = panels[current].dataset.stepDescription;
                count.textContent = `Step ${current + 1} of ${panels.length}`;
                progress.style.width = `${((current + 1) / panels.length) * 100}%`;
                progressTrack.setAttribute('aria-valuenow', String(current + 1));

                if (focusHeading) {
                    heading.setAttribute('tabindex', '-1');
                    heading.focus({ preventScroll: true });
                    wizard.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            };

            const refreshFeatureList = (list) => {
                const type = list.dataset.featureList;
                const inputName = list.dataset.inputName;
                const rows = [...list.querySelectorAll('[data-feature-row]')];
                form.querySelector(`[data-feature-empty="${type}"]`).hidden = rows.length > 0;
                form.querySelector(`[data-feature-limit="${type}"]`).classList.toggle('d-none', rows.length < 100);
                form.querySelectorAll('[data-add-feature]').forEach((button) => {
                    const buttonList = button.closest('[data-feature-list]');
                    if (button.dataset.addFeature !== type && buttonList !== list) return;

                    button.disabled = rows.length >= 100;
                    const buttonRow = button.closest('[data-feature-row]');
                    if (buttonRow) button.hidden = buttonRow !== rows[rows.length - 1];
                });

                rows.forEach((row, index) => {
                    row.querySelector('[data-feature-number]').textContent = String(index + 1);
                    const idField = row.querySelector('[data-feature-id]');
                    if (idField) idField.name = `${inputName}[${index}][id]`;
                    row.querySelector('[data-move-feature="up"]').disabled = index === 0;
                    row.querySelector('[data-move-feature="down"]').disabled = index === rows.length - 1;
                    row.querySelectorAll('[data-field]').forEach((field) => {
                        field.name = `${inputName}[${index}][${field.dataset.field}]`;
                        field.id = `${inputName}-${index}-${field.dataset.field}`;
                        row.querySelector('[data-feature-label]').htmlFor = field.id;
                    });
                });
            };

            form.addEventListener('click', (event) => {
                const addButton = event.target.closest('[data-add-feature]');
                if (!addButton) return;

                const type = addButton.dataset.addFeature || addButton.closest('[data-feature-list]')?.dataset.featureList;
                const list = featureLists.find((featureList) => featureList.dataset.featureList === type);
                if (!list || list.querySelectorAll('[data-feature-row]').length >= 100) return;

                const row = featureTemplate.content.firstElementChild.cloneNode(true);
                const currentRow = addButton.closest('[data-feature-row]');
                if (currentRow) currentRow.after(row);
                else list.append(row);

                refreshFeatureList(list);
                row.querySelector('[data-field="description"]')?.focus();
            });

            featureLists.forEach((list) => {
                list.addEventListener('click', (event) => {
                    if (event.target.closest('[data-add-feature]')) return;
                    const row = event.target.closest('[data-feature-row]');
                    if (!row) return;

                    if (event.target.closest('[data-remove-feature]')) {
                        row.remove();
                    } else {
                        const moveButton = event.target.closest('[data-move-feature]');
                        if (moveButton?.dataset.moveFeature === 'up' && row.previousElementSibling) {
                            list.insertBefore(row, row.previousElementSibling);
                        } else if (moveButton?.dataset.moveFeature === 'down' && row.nextElementSibling) {
                            list.insertBefore(row.nextElementSibling, row);
                        }
                    }

                    refreshFeatureList(list);
                });

                refreshFeatureList(list);
            });

            const refreshItineraryDays = () => {
                const rows = [...itineraryContainer.querySelectorAll('[data-itinerary-day]')];
                itineraryEmpty.hidden = rows.length > 0;
                itineraryLimit.classList.toggle('d-none', rows.length < 100);
                itineraryAddButton.disabled = rows.length >= 100;

                rows.forEach((row, index) => {
                    row.querySelector('[data-day-number]').textContent = String(index + 1);
                    const idField = row.querySelector('[data-itinerary-id]');
                    if (idField) idField.name = `itinerary_days[${index}][id]`;
                    row.querySelector('[data-move-day="up"]').disabled = index === 0;
                    row.querySelector('[data-move-day="down"]').disabled = index === rows.length - 1;
                    row.querySelector('[data-add-day-after]').disabled = rows.length >= 100;
                    row.querySelectorAll('[data-field]').forEach((field) => {
                        field.name = `itinerary_days[${index}][${field.dataset.field}]`;
                        field.id = `itinerary-${index}-${field.dataset.field.replaceAll('_', '-')}`;
                        field.labels[0]?.setAttribute('for', field.id);
                    });
                });
            };

            const addItineraryDay = (after = null) => {
                if (itineraryContainer.querySelectorAll('[data-itinerary-day]').length >= 100) return;
                const row = itineraryTemplate.content.firstElementChild.cloneNode(true);
                if (after) after.after(row);
                else itineraryContainer.append(row);
                refreshItineraryDays();
                row.querySelector('[data-field="title"]')?.focus();
            };

            itineraryAddButton.addEventListener('click', () => addItineraryDay());
            itineraryContainer.addEventListener('click', (event) => {
                const row = event.target.closest('[data-itinerary-day]');
                if (!row) return;

                if (event.target.closest('[data-add-day-after]')) {
                    addItineraryDay(row);
                    return;
                }

                if (event.target.closest('[data-remove-day]')) {
                    row.remove();
                    refreshItineraryDays();
                    return;
                }

                const moveButton = event.target.closest('[data-move-day]');
                if (moveButton?.dataset.moveDay === 'up' && row.previousElementSibling) {
                    itineraryContainer.insertBefore(row, row.previousElementSibling);
                } else if (moveButton?.dataset.moveDay === 'down' && row.nextElementSibling) {
                    itineraryContainer.insertBefore(row.nextElementSibling, row);
                }

                if (moveButton) refreshItineraryDays();
            });
            refreshItineraryDays();

            const validatePanel = (panel) => {
                const field = invalidField(panel);
                if (!field) return true;

                if (field.id === 'subcategory_id' && window.jQuery && window.jQuery.fn.select2) {
                    window.jQuery(field).select2('open');
                } else {
                    field.reportValidity();
                }

                return false;
            };

            previous.addEventListener('click', () => showStep(current - 1, true));
            next.addEventListener('click', () => {
                if (validatePanel(panels[current])) showStep(current + 1, true);
            });

            steps.forEach((step) => {
                step.addEventListener('click', () => {
                    const target = Number(step.dataset.wizardGo);
                    if (Number.isInteger(target) && panels[target]) showStep(target, true);
                });
            });

            form.addEventListener('submit', (event) => {
                const invalidPanel = panels.findIndex((panel) => invalidField(panel));
                if (invalidPanel === -1) return;

                event.preventDefault();
                showStep(invalidPanel, true);
                requestAnimationFrame(() => validatePanel(panels[invalidPanel]));
            });

            const firstPanelWithErrors = panels.findIndex((panel) => panel.querySelector('.is-invalid, .invalid-feedback, .text-danger.small'));
            showStep(firstPanelWithErrors === -1 ? 0 : firstPanelWithErrors);
        })();
    </script>
@endpush

