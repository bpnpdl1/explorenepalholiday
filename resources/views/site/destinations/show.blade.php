@extends('layouts.site')

@section('page_title'){{ $destination->name }} | {{ $siteSetting?->name ?? config('app.name', 'Explore Nepal Holidays') }}@endsection
@section('meta_description'){{ $metaDescription }}@endsection
@section('og_image', $coverImage)
@section('body_class', 'destination-page')

@push('page_styles')
    <link rel="stylesheet" href="{{ asset('site/styles/destination.css') }}">
@endpush

@section('content')
    <a class="skip-link" href="#main">Skip to content</a>

    @include('site.partials.header')

    <main id="main">
        <section class="destination-hero" aria-labelledby="destination-title">
            <img class="destination-hero__image" src="{{ $coverImage }}" alt="{{ $destination->name }}" fetchpriority="high">
            <div class="destination-hero__shade"></div>
            <div class="container destination-hero__content">
                <nav class="destination-breadcrumb" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}">Home</a>
                    <span aria-hidden="true">/</span>
                    <a href="{{ route('home') }}#destinations">Destinations</a>
                    <span aria-hidden="true">/</span>
                    <span aria-current="page">{{ $destination->name }}</span>
                </nav>

                <p class="destination-hero__eyebrow">Explore Nepal</p>
                <h1 id="destination-title">{{ $destination->name }}</h1>
                @if ($destination->summary)
                    <p class="destination-hero__summary">{{ $destination->summary }}</p>
                @endif
            </div>
        </section>

        <section class="destination-content" aria-labelledby="destination-about-title">
            <div class="container destination-content__grid">
                <article class="destination-description">
                    <span class="destination-kicker">Discover Nepal</span>
                    <h2 id="destination-about-title">About {{ $destination->name }}</h2>
                    @if ($destination->description)
                        <x-rich-content :html="$destination->description" class="destination-description__content" />
                    @elseif ($destination->summary)
                        <p>{{ $destination->summary }}</p>
                    @else
                        <p>More information about this destination is coming soon. Contact our local team to start planning your visit.</p>
                    @endif
                </article>

                <aside class="destination-aside" aria-label="Plan a trip">
                    <span class="destination-aside__icon" aria-hidden="true">✦</span>
                    <p class="destination-kicker">Make it your journey</p>
                    <h2>Explore {{ $destination->name }}</h2>
                    <p>Tell us what you would like to see. Our local team can help shape a journey around your dates and interests.</p>
                    <a href="{{ route('contact') }}" class="destination-aside__button">Ask our team <span aria-hidden="true">↗</span></a>
                </aside>
            </div>
        </section>

        <section class="destination-packages" aria-labelledby="destination-packages-title">
            <div class="container">
                <div class="destination-related__heading">
                    <div>
                        <span class="destination-kicker">Trips in {{ $destination->name }}</span>
                        <h2 id="destination-packages-title">Choose your journey</h2>
                    </div>
                    <p>{{ $packages->total() }} {{ \Illuminate\Support\Str::plural('published trip', $packages->total()) }}</p>
                </div>

                @if ($packages->isNotEmpty())
                    <div class="trip-grid destination-packages__grid">
                        @foreach ($packages as $package)
                            <article class="trip-card">
                                <a class="trip-image" href="{{ route('packages.show', $package) }}">
                                    <img src="{{ $package->getFirstMediaUrl('cover', 'card') ?: $package->getFirstMediaUrl('cover') ?: asset('site/assets/nepal-trail.jpg') }}" alt="{{ $package->name }}" loading="lazy">
                                    <span class="trip-category">{{ $package->subcategory->category->name }}</span>
                                </a>
                                <div class="trip-content">
                                    <div class="trip-meta">
                                        <span><a href="{{ route('subcategories.show', $package->subcategory->slug) }}">{{ $package->subcategory->name }}</a></span>
                                        @if ($package->is_featured)<span>FEATURED</span>@endif
                                    </div>
                                    <h3><a href="{{ route('packages.show', $package) }}">{{ $package->name }}</a></h3>
                                    @if ($package->summary)<p>{{ $package->summary }}</p>@endif
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

                    @if ($packages->hasPages())
                        <div class="destination-packages__pagination">{{ $packages->links() }}</div>
                    @endif
                @else
                    <div class="destination-packages__empty">
                        <h3>Trips for this destination are being prepared.</h3>
                        <p>Contact our team and we’ll help plan a journey around {{ $destination->name }}.</p>
                        <a href="{{ route('contact') }}">Plan a trip</a>
                    </div>
                @endif
            </div>
        </section>

        @if ($relatedDestinations->isNotEmpty())
            <section class="destination-related" aria-labelledby="related-destinations-title">
                <div class="container">
                    <div class="destination-related__heading">
                        <div>
                            <span class="destination-kicker">Keep exploring</span>
                            <h2 id="related-destinations-title">More destinations</h2>
                        </div>
                        <a href="{{ route('home') }}#destinations">All destinations <span aria-hidden="true">↗</span></a>
                    </div>

                    <div class="destination-related__grid">
                        @foreach ($relatedDestinations as $relatedDestination)
                            @php($relatedImage = $relatedDestination->getFirstMediaUrl('cover', 'thumbnail') ?: $relatedDestination->getFirstMediaUrl('cover') ?: asset('site/assets/annapurna-sunrise.jpg'))
                            <a class="destination-related-card" href="{{ route('destinations.show', $relatedDestination) }}">
                                <img src="{{ $relatedImage }}" alt="{{ $relatedDestination->name }}" loading="lazy">
                                <span>
                                    <strong>{{ $relatedDestination->name }}</strong>
                                </span>
                                <span class="destination-related-card__arrow" aria-hidden="true">↗</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <section class="destination-bottom-cta">
            <div class="container destination-bottom-cta__inner">
                <div>
                    <span>Ready when you are</span>
                    <h2>Let’s plan a Nepal journey together.</h2>
                </div>
                <a href="{{ route('contact') }}">Start planning <span aria-hidden="true">↗</span></a>
            </div>
        </section>
    </main>

    @include('site.partials.footer')
@endsection
