@extends('layouts.site')

@section('page_title', 'Nepal Trips & Packages | '.($siteSetting?->name ?: config('app.name')))
@section('meta_description', 'Browse Nepal trekking, peak climbing and cultural tour packages. Filter trips by region, style, duration and season.')

@section('content')
    @include('site.partials.header')

    <main class="package-listing-page">
        <section class="package-listing-intro">
            <div class="container">
                <nav class="package-listing-breadcrumbs" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}">Home</a>
                    <span aria-hidden="true">/</span>
                    <span aria-current="page">Nepal trips</span>
                </nav>
                <span class="eyebrow dark">FIND YOUR NEPAL JOURNEY</span>
                <h1>Trips made for <em>your kind of Nepal.</em></h1>
                <p>Explore published treks, peak climbs and cultural journeys. Use the filters to find trips that fit your place, pace and travel season.</p>
            </div>
        </section>

        <section class="package-listing-results" aria-labelledby="package-listing-title">
            <div class="container">
                <form action="{{ route('packages.index') }}" method="GET" class="package-listing-filters">
                    <div class="package-listing-filter-heading">
                        <div>
                            <span class="eyebrow dark">NARROW YOUR SEARCH</span>
                            <h2 id="package-listing-title">Find the right trip</h2>
                        </div>
                        @if ($filterLabels->isNotEmpty())
                            <a class="package-listing-clear" href="{{ route('packages.index') }}">Clear filters</a>
                        @endif
                    </div>

                    <div class="package-listing-filter-fields">
                        <label>
                            <span>Region / trip area</span>
                            <select name="region">
                                <option value="">All regions</option>
                                @foreach ($regions as $region)
                                    <option value="{{ $region->slug }}" @selected(($filters['region'] ?? '') === $region->slug)>{{ $region->name }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label>
                            <span>Trip style</span>
                            <select name="style">
                                <option value="">Any trip style</option>
                                @foreach ($styles as $style)
                                    <option value="{{ $style->slug }}" @selected(($filters['style'] ?? '') === $style->slug)>{{ $style->name }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label>
                            <span>Trip duration</span>
                            <select name="duration">
                                <option value="">Any duration</option>
                                @foreach ($durations as $duration)
                                    <option value="{{ $duration['value'] }}" @selected(($filters['duration'] ?? '') === $duration['value'])>{{ $duration['label'] }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label>
                            <span>Best season</span>
                            <select name="season">
                                <option value="">Any season</option>
                                @foreach ($seasons as $season)
                                    <option value="{{ $season->value }}" @selected(($filters['season'] ?? '') === $season->value)>{{ $season->label() }}</option>
                                @endforeach
                            </select>
                        </label>
                        <button class="package-listing-submit" type="submit">Show trips <span aria-hidden="true">→</span></button>
                    </div>

                    @if ($filterLabels->isNotEmpty())
                        <div class="package-listing-active-filters" aria-label="Active filters">
                            @foreach ($filterLabels as $key => $label)
                                <span>{{ $label }}</span>
                            @endforeach
                        </div>
                    @endif
                </form>

                <div class="package-listing-summary" aria-live="polite">
                    <p><strong>{{ $packages->total() }}</strong> {{ \Illuminate\Support\Str::plural('trip', $packages->total()) }} found</p>
                    <span>Showing {{ $packages->firstItem() ?? 0 }}–{{ $packages->lastItem() ?? 0 }} of {{ $packages->total() }}</span>
                </div>

                @if ($packages->isNotEmpty())
                    <div class="trip-grid package-listing-grid">
                        @foreach ($packages as $package)
                            <article class="trip-card">
                                <a class="trip-image" href="{{ route('packages.show', $package) }}">
                                    <img src="{{ $package->getFirstMediaUrl('cover', 'card') ?: $package->getFirstMediaUrl('cover') ?: asset('site/assets/nepal-trail.jpg') }}" alt="{{ $package->name }}" loading="lazy">
                                    <span class="trip-category">{{ $package->subcategory->category->name }}</span>
                                </a>
                                <div class="trip-content">
                                    <div class="trip-meta">
                                        <span>{{ $package->subcategory->category->destination->name }} / {{ $package->subcategory->name }}</span>
                                        @if ($package->is_featured)<span>FEATURED</span>@endif
                                    </div>
                                    <h3><a href="{{ route('packages.show', $package) }}">{{ $package->name }}</a></h3>
                                    <p>{{ $package->summary }}</p>
                                    <div class="trip-facts">
                                        <span>{{ $package->duration_days ? $package->duration_days.' days' : 'Flexible duration' }}</span>
                                        <span>{{ $package->difficulty ?: 'Ask us' }}</span>
                                    </div>
                                    <p class="trip-price">
                                        @if ($package->price_from !== null)
                                            <span class="trip-price__from">From</span> {{ $package->currency }} {{ number_format((float) $package->price_from, 0) }}
                                            @if ($package->price_qualifier)<small>{{ $package->price_qualifier }}</small>@endif
                                        @else
                                            <span class="trip-price__from">Ask us for pricing</span>
                                        @endif
                                    </p>
                                    <a href="{{ route('packages.show', $package) }}">View package <span aria-hidden="true">↗</span></a>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="package-listing-pagination">{{ $packages->links() }}</div>
                @else
                    <div class="package-listing-empty">
                        <span aria-hidden="true">⌕</span>
                        <h2>No trips match these filters</h2>
                        <p>Try another region, season or duration to see more Nepal journeys.</p>
                        <a href="{{ route('packages.index') }}">View all trips</a>
                    </div>
                @endif
            </div>
        </section>
    </main>

    @include('site.partials.footer')
@endsection

@push('page_styles')
<style>
    .package-listing-page { background: #f8f7f3; min-height: 70vh; }
    .package-listing-intro { padding: 30px 0 58px; background: linear-gradient(135deg, #f1f5f4, #fbf8f0); }
    .package-listing-intro .container { max-width: 1320px; }
    .package-listing-breadcrumbs { display: flex; gap: 10px; align-items: center; margin-bottom: 42px; color: #718096; font-size: .82rem; }
    .package-listing-breadcrumbs a { color: #173d5f; text-decoration: none; }
    .package-listing-intro h1 { max-width: 850px; margin: 12px 0; color: #102b46; font: 800 clamp(2.4rem, 5vw, 4.2rem)/1.05 Outfit, sans-serif; letter-spacing: -.04em; }
    .package-listing-intro h1 em { color: #df793c; font-style: normal; }
    .package-listing-intro p { max-width: 680px; margin: 0; color: #5e6d79; font-size: 1.05rem; line-height: 1.7; }
    .package-listing-results { padding: 40px 0 90px; }
    .package-listing-results .container { max-width: 1320px; }
    .package-listing-filters { margin-bottom: 30px; padding: 26px; background: #fff; border: 1px solid #e1e7e9; border-radius: 18px; box-shadow: 0 12px 30px rgba(16,43,70,.05); }
    .package-listing-filter-heading { display: flex; align-items: end; justify-content: space-between; gap: 20px; margin-bottom: 20px; }
    .package-listing-filter-heading h2 { margin: 5px 0 0; color: #102b46; font: 700 1.35rem Outfit, sans-serif; }
    .package-listing-clear { color: #516778; font-size: .9rem; font-weight: 600; }
    .package-listing-filter-fields { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)) auto; align-items: end; gap: 14px; }
    .package-listing-filter-fields label { display: grid; gap: 7px; color: #34495a; font-size: .8rem; font-weight: 700; }
    .package-listing-filter-fields select { width: 100%; min-height: 48px; padding: 0 13px; border: 1px solid #d8e0e4; border-radius: 9px; background: #fff; color: #18324b; font: inherit; font-size: .9rem; }
    .package-listing-submit { min-height: 48px; padding: 0 20px; border: 0; border-radius: 9px; background: #102b46; color: #fff; font-weight: 700; cursor: pointer; white-space: nowrap; }
    .package-listing-submit:hover { background: #1b496e; }
    .package-listing-submit span { margin-left: 8px; }
    .package-listing-active-filters { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 16px; }
    .package-listing-active-filters span { padding: 6px 10px; border-radius: 99px; background: #eef3f5; color: #29485e; font-size: .78rem; font-weight: 600; }
    .package-listing-summary { display: flex; justify-content: space-between; gap: 15px; align-items: center; margin: 0 0 18px; color: #667784; font-size: .88rem; }
    .package-listing-summary p { margin: 0; }
    .package-listing-summary strong { color: #102b46; }
    .package-listing-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
    .package-listing-grid .trip-content h3 a { color: inherit; text-decoration: none; }
    .package-listing-pagination { margin-top: 34px; }
    .package-listing-empty { padding: 70px 20px; border: 1px dashed #c8d2d8; border-radius: 18px; text-align: center; }
    .package-listing-empty > span { display: inline-grid; width: 48px; height: 48px; place-items: center; border-radius: 50%; background: #e9eff2; color: #173d5f; font-size: 1.7rem; }
    .package-listing-empty h2 { margin: 16px 0 7px; color: #102b46; font: 700 1.5rem Outfit, sans-serif; }
    .package-listing-empty p { margin: 0 0 18px; color: #637381; }
    .package-listing-empty a { display: inline-block; padding: 11px 17px; border-radius: 8px; background: #102b46; color: #fff; text-decoration: none; font-weight: 700; }
    @media (max-width: 900px) { .package-listing-filter-fields { grid-template-columns: repeat(2, minmax(0, 1fr)); } .package-listing-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    @media (max-width: 560px) { .package-listing-intro { padding: 22px 0 42px; } .package-listing-breadcrumbs { margin-bottom: 28px; } .package-listing-results { padding: 24px 0 60px; } .package-listing-filters { padding: 19px 15px; } .package-listing-filter-fields, .package-listing-grid { grid-template-columns: 1fr; } .package-listing-filter-heading { align-items: center; } .package-listing-summary { align-items: start; flex-direction: column; gap: 4px; } }
</style>
@endpush
