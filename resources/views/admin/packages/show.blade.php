<x-admin-layouts::app :title="$package->name">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <div>
            <h4 class="mb-sm-0">{{ $package->name }}</h4>
            <p class="text-muted mb-0 mt-1">Package fields and media.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.package-reviews.package', $package) }}" class="btn btn-soft-primary"><i class="ri-chat-quote-line me-1"></i>Reviews</a>
            <a href="{{ route('admin.package-departures.package', $package) }}" class="btn btn-soft-primary"><i class="ri-calendar-event-line me-1"></i>Departures</a>
            @if ($package->is_published)
                <a href="{{ route('packages.show', $package) }}" class="btn btn-soft-success" target="_blank" rel="noopener noreferrer"><i class="ri-external-link-line me-1"></i>View on site</a>
            @endif
            <a href="{{ route('admin.packages.edit', $package) }}" class="btn btn-primary"><i class="ri-pencil-line me-1"></i>Edit package</a>
            <a href="{{ route('admin.packages.index') }}" class="btn btn-light">Back to packages</a>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-start gap-4">
                        @if ($package->getFirstMediaUrl('cover'))
                            <img src="{{ $package->getFirstMediaUrl('cover', 'card') }}" alt="{{ $package->name }} cover" class="img-fluid rounded" style="max-width: 280px; max-height: 190px; object-fit: cover">
                        @endif
                        <div class="flex-grow-1">
                            <div class="d-flex flex-wrap gap-2 mb-2">
                                <span class="badge bg-{{ $package->is_published ? 'success' : 'warning' }}-subtle text-{{ $package->is_published ? 'success' : 'warning' }}">{{ $package->is_published ? 'Published' : 'Draft' }}</span>
                                @if ($package->is_featured)<span class="badge bg-warning-subtle text-warning">Featured</span>@endif
                            </div>
                            <h3>{{ $package->name }}</h3>
                            <p class="text-muted">{{ $package->summary }}</p>
                            <div class="text-muted">{{ $package->subcategory->category->destination->name }} / {{ $package->subcategory->category->name }} / {{ $package->subcategory->name }}</div>
                            <div class="small mt-1">URL slug: <code>{{ $package->slug }}</code></div>
                        </div>
                    </div>

                    @if ($package->description)
                        <hr>
                        <h5>Overview</h5>
                        <div class="text-body" style="white-space: pre-line">{{ $package->description }}</div>
                    @endif
                </div>
            </div>

            @if ($package->getMedia('gallery')->isNotEmpty())
                <div class="card">
                    <div class="card-header"><h5 class="card-title mb-0">Gallery</h5></div>
                    <div class="card-body">
                        <div class="row g-3">
                            @foreach ($package->getMedia('gallery') as $image)
                                <div class="col-6 col-md-4"><img src="{{ $image->getUrl('card') }}" alt="{{ $package->name }} gallery image {{ $loop->iteration }}" class="img-fluid rounded"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            @if ($package->getFirstMediaUrl('route_map'))
                <div class="card">
                    <div class="card-header"><h5 class="card-title mb-0">Route map image</h5></div>
                    <div class="card-body"><img src="{{ $package->getFirstMediaUrl('route_map') }}" alt="Route map for {{ $package->name }}" class="img-fluid rounded" style="max-height: 420px; width: 100%; object-fit: contain"></div>
                </div>
            @endif

            @foreach ([
                'Route map URL' => $package->route_map_url,
                'Accommodation' => $package->accommodation,
                'Fitness guidance' => $package->fitness_guidance,
                'Permit notes' => $package->permit_notes,
                'Safety notes' => $package->safety_notes,
                'Weather notes' => $package->weather_notes,
            ] as $label => $value)
                @if ($value)
                    <div class="card"><div class="card-header"><h5 class="card-title mb-0">{{ $label }}</h5></div><div class="card-body">@if ($label === 'Route map URL')<a href="{{ $value }}" target="_blank" rel="noopener noreferrer">{{ $value }}</a>@else<div style="white-space: pre-line">{{ $value }}</div>@endif</div></div>
                @endif
            @endforeach
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Package fields</h5></div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-7">Duration</dt>
                        <dd class="col-5 text-end">{{ $package->duration_days ? $package->duration_days.' days' : '-' }}{{ $package->duration_nights ? ' / '.$package->duration_nights.' nights' : '' }}</dd>
                        <dt class="col-7">Difficulty</dt><dd class="col-5 text-end">{{ $package->difficulty ?: '-' }}</dd>
                        <dt class="col-7">Tags</dt><dd class="col-5 text-end">{{ collect($package->tags ?? [])->map(fn ($tag) => \Illuminate\Support\Str::headline($tag))->implode(', ') ?: '-' }}</dd>
                        <dt class="col-7">Maximum altitude</dt><dd class="col-5 text-end">{{ $package->max_altitude_meters ? number_format($package->max_altitude_meters).' m' : '-' }}</dd>
                        <dt class="col-7">Minimum group</dt><dd class="col-5 text-end">{{ $package->min_group_size ?: '-' }}</dd>
                        <dt class="col-7">Maximum group</dt><dd class="col-5 text-end">{{ $package->max_group_size ?: '-' }}</dd>
                        <dt class="col-7">Price from</dt><dd class="col-5 text-end">{{ $package->price_from !== null ? $package->currency.' '.number_format((float) $package->price_from, 2) : '-' }}</dd>
                        <dt class="col-7">Previous price</dt><dd class="col-5 text-end">{{ $package->compare_at_price !== null ? $package->currency.' '.number_format((float) $package->compare_at_price, 2) : '-' }}</dd>
                        <dt class="col-7">Price note</dt><dd class="col-5 text-end">{{ $package->price_qualifier ?: '-' }}</dd>
                        <dt class="col-7">Best seasons</dt><dd class="col-5 text-end">{{ $package->seasons->pluck('season')->map(fn ($season) => $season->label())->implode(', ') ?: '-' }}</dd>
                        <dt class="col-7">Display order</dt><dd class="col-5 text-end">{{ $package->sort_order }}</dd>
                    </dl>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h5 class="card-title mb-0">Search engine details</h5></div>
                <div class="card-body">
                    <p class="mb-1"><strong>{{ $package->meta_title ?: $package->name }}</strong></p>
                    <p class="text-muted mb-0">{{ $package->meta_description ?: 'No meta description set.' }}</p>
                </div>
            </div>
        </div>
    </div>
</x-admin-layouts::app>
