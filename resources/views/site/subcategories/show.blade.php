@extends('layouts.site')

@section('page_title', $subcategory->name.' | '.$subcategory->category->name.' | '.($siteSetting?->name ?: config('app.name')))
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($subcategory->summary ?: $subcategory->description ?: 'Explore published trips in '.$subcategory->name.'.'), 160))
@section('og_image', $heroImage)
@section('body_class', 'subcategory-detail-page')

@push('page_styles')
    <link rel="stylesheet" href="{{ asset('site/styles/subcategory.css') }}">
    <link rel="stylesheet" href="{{ asset('site/styles/trek-region.css') }}">
@endpush

@section('content')
    <a class="skip-link" href="#main">Skip to content</a>
    @include('site.partials.header')

    <main id="main" class="annapurna-page subcategory-page">
        <section class="annapurna-hero subcategory-hero" aria-labelledby="subcategory-title" style="background-image: url('{{ $heroImage }}')">
            <div class="container subcategory-hero__inner">
                <nav class="annapurna-breadcrumb" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}">Home</a>
                    <span aria-hidden="true">/</span>
                    <a href="{{ route('destinations.show', $subcategory->category->destination) }}">{{ $subcategory->category->destination->name }}</a>
                    <span aria-hidden="true">/</span>
                    <a href="{{ route('packages.index', ['style' => $subcategory->category->slug]) }}">{{ $subcategory->category->name }}</a>
                    <span aria-hidden="true">/</span>
                    <span aria-current="page">{{ $subcategory->name }}</span>
                </nav>
                <div class="subcategory-hero__copy">
                    <p class="subcategory-hero__eyebrow">{{ $subcategory->category->name }} <span aria-hidden="true">&middot;</span> {{ $subcategory->category->destination->name }}</p>
                    <h1 id="subcategory-title">{{ $subcategory->name }}</h1>
                    @if ($subcategory->summary)
                        <p class="subcategory-hero__summary">{{ $subcategory->summary }}</p>
                    @endif
                    <div class="subcategory-hero__actions">
                        <a href="#subcategory-packages" class="subcategory-hero__primary">Explore {{ $packages->total() }} {{ \Illuminate\Support\Str::plural('trip', $packages->total()) }} <span aria-hidden="true">&#8595;</span></a>
                        <a href="{{ route('packages.index', ['style' => $subcategory->category->slug]) }}" class="subcategory-hero__secondary">Browse {{ $subcategory->category->name }}</a>
                    </div>
                </div>
            </div>
        </section>

        <div class="annapurna-content-wrap">
            <div class="annapurna-facts" aria-label="{{ $subcategory->name }} at a glance">
                <div>
                    <span>PUBLISHED TRIPS</span>
                    <strong>{{ $packages->total() }} {{ \Illuminate\Support\Str::plural('package', $packages->total()) }}</strong>
                </div>
                <div>
                    <span>TRIP STYLE</span>
                    <strong>{{ $subcategory->category->name }}</strong>
                </div>
                <div>
                    <span>DESTINATION</span>
                    <strong>{{ $subcategory->category->destination->name }}</strong>
                </div>
            </div>

            <article class="annapurna-richtext subcategory-intro" aria-label="About {{ $subcategory->name }}">
                <span class="eyebrow dark">EXPLORE {{ mb_strtoupper($subcategory->name) }}</span>
                <h2>Discover {{ $subcategory->name }}</h2>
                @if ($subcategory->description)
                    <x-rich-content :html="$subcategory->description" />
                @elseif ($subcategory->summary)
                    <p>Use the trip options below to compare duration, difficulty, seasonal options and pricing before opening a package for its full itinerary.</p>
                @else
                    <p>Explore published {{ strtolower($subcategory->category->name) }} in {{ $subcategory->name }}. Compare trip length, difficulty and seasonal options below, then open a package for its itinerary and departure details.</p>
                @endif
            </article>
        </div>

        <section class="annapurna-packages" id="subcategory-packages" aria-labelledby="subcategory-packages-title">
            <div class="container">
                <div class="annapurna-packages__header">
                    <span class="eyebrow dark">{{ mb_strtoupper($subcategory->category->name) }}</span>
                    <h2 id="subcategory-packages-title">Trips in {{ $subcategory->name }}</h2>
                    <p>Compare trip length, difficulty, altitude and pricing. Open a trip to review its itinerary, departures and booking details.</p>
                </div>

                @if ($packages->isNotEmpty())
                    <div class="annapurna-grid">
                        @foreach ($packages as $package)
                            <article class="annapurna-card">
                                <a class="annapurna-card__image" href="{{ route('packages.show', $package) }}" aria-label="View {{ $package->name }}">
                                    <img src="{{ $package->getFirstMediaUrl('cover', 'card') ?: $package->getFirstMediaUrl('cover') ?: $heroImage }}" alt="{{ $package->name }}" loading="lazy">
                                    <span class="annapurna-card__badge">{{ $package->is_featured ? 'Featured trip' : $subcategory->category->name }}</span>
                                    <span class="subcategory-card__image-shade" aria-hidden="true"></span>
                                </a>
                                <div class="annapurna-card__body">
                                    <div class="annapurna-card__meta">
                                        <span>{{ $package->duration_days ? $package->duration_days.' days' : 'Flexible duration' }}</span>
                                        @if ($package->max_altitude_meters)<span>Max {{ number_format($package->max_altitude_meters) }}m</span>@endif
                                    </div>
                                    <h3>{{ $package->name }}</h3>
                                    @if ($package->summary)<p>{{ $package->summary }}</p>@endif
                                    <div class="subcategory-card__details">
                                        @if ($package->difficulty)<span>{{ $package->difficulty }}</span>@endif
                                        @foreach ($package->seasons->take(2) as $season)
                                            <span>{{ $season->season->label() }}</span>
                                        @endforeach
                                    </div>
                                    <div class="annapurna-card__footer">
                                        <div class="annapurna-card__price">
                                            @if ($package->price_from !== null)
                                                <span>From</span>
                                                <strong>{{ $package->currency }} {{ number_format((float) $package->price_from, 0) }}</strong>
                                                <small>{{ $package->price_qualifier ?: 'per person' }}</small>
                                            @else
                                                <span>Pricing</span>
                                                <strong>Ask us</strong>
                                            @endif
                                        </div>
                                        <a href="{{ route('packages.show', $package) }}" class="annapurna-card__link">View itinerary <span aria-hidden="true">&#8599;</span></a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    @if ($packages->hasPages())
                        <div class="subcategory-pagination">{{ $packages->links() }}</div>
                    @endif
                @else
                    <div class="subcategory-empty">
                        <h3>Trips for this area are being prepared.</h3>
                        <p>Our local team can help you plan a journey in {{ $subcategory->name }}.</p>
                        <a href="{{ route('contact') }}">Ask our team</a>
                    </div>
                @endif
            </div>
        </section>

        @if ($relatedSubcategories->isNotEmpty())
            <section class="region-ideas subcategory-related" aria-labelledby="subcategory-related-title">
                <div class="container">
                    <header class="region-ideas__header">
                        <span class="eyebrow dark">MORE {{ mb_strtoupper($subcategory->category->name) }}</span>
                        <h2 id="subcategory-related-title">Explore other areas</h2>
                        <p>Browse other trip areas in {{ $subcategory->category->name }}.</p>
                    </header>
                    <div class="region-ideas__grid">
                        @foreach ($relatedSubcategories as $relatedSubcategory)
                            @php
                                $relatedPackage = $relatedSubcategory->packages->first();
                                $relatedImage = $relatedPackage?->getFirstMediaUrl('cover', 'card')
                                    ?: $relatedPackage?->getFirstMediaUrl('cover')
                                    ?: $heroImage;
                            @endphp
                            <article class="region-idea-card">
                                <a class="region-idea-card__image" href="{{ route('subcategories.show', $relatedSubcategory->slug) }}">
                                    <img src="{{ $relatedImage }}" alt="{{ $relatedSubcategory->name }}" loading="lazy">
                                    <span>{{ $relatedSubcategory->published_packages_count }} {{ \Illuminate\Support\Str::plural('trip', $relatedSubcategory->published_packages_count) }}</span>
                                </a>
                                <div class="region-idea-card__body">
                                    <h3>{{ $relatedSubcategory->name }}</h3>
                                    <p>{{ $relatedSubcategory->summary ?: 'Explore published trips in '.$relatedSubcategory->name.'.' }}</p>
                                    <a class="region-idea-card__link" href="{{ route('subcategories.show', $relatedSubcategory->slug) }}">Explore this area <span aria-hidden="true">&#8594;</span></a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    </main>

    @include('site.partials.footer')
@endsection
