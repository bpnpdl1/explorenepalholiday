@extends('layouts.site')

@php
    $destination = $package->subcategory->category->destination;
    $category = $package->subcategory->category;
    $cover = $package->getFirstMedia('cover');
    $routeMapImage = $package->getFirstMediaUrl('route_map');
    $galleryImages = collect([$cover])
        ->filter()
        ->concat($package->getMedia('gallery'))
        ->take(3)
        ->values();
    $coverUrl =
        $package->getFirstMediaUrl('cover', 'card') ?:
        $package->getFirstMediaUrl('cover') ?:
        asset('site/assets/nepal-trail.jpg');
    $metaDescription = \Illuminate\Support\Str::limit(
        strip_tags($package->meta_description ?: $package->summary ?: $package->description ?: ''),
        160,
    );
    $price = $package->price_from !== null ? (float) $package->price_from : null;
    $compareAtPrice = $package->compare_at_price !== null ? (float) $package->compare_at_price : null;
    $currency = $package->currency ?: 'USD';
    $shareUrl = url()->current();
    $shareText = $package->name . ' | ' . $shareUrl;
    $whatsAppShareUrl = 'https://wa.me/?text=' . rawurlencode($shareText);
    $facebookShareUrl = 'https://www.facebook.com/sharer/sharer.php?u=' . rawurlencode($shareUrl);
    $emailShareUrl = 'mailto:?subject=' . rawurlencode('Trip idea: ' . $package->name) .
        '&body=' . rawurlencode('I thought you might like this trip: ' . $shareUrl);
    $whatsAppMessage = rawurlencode('I am interested in ' . $package->name . '.');
    $travelWindows = $package->departures
        ->map(
            fn($departure) => [
                'value' => 'departure-' . $departure->id,
                'label' =>
                    $departure->starts_on->format('M j, Y') .
                    ($departure->ends_on ? ' - ' . $departure->ends_on->format('M j, Y') : '') .
                    ' (' .
                    $departure->season->label() .
                    ')',
            ],
        )
        ->concat(
            $package->departures->isEmpty()
                ? $package->seasons->map(
                    fn($season) => [
                        'value' => 'season-' . $season->season->value,
                        'label' => $season->season->label(),
                    ],
                )
                : collect(),
        )
        ->push(['value' => 'flexible', 'label' => 'Flexible dates']);
    $travellerOptions = range(
        max(1, (int) ($package->min_group_size ?: 1)),
        max((int) ($package->min_group_size ?: 1), min(20, (int) ($package->max_group_size ?: 6))),
    );
@endphp

@section('page_title', ($package->meta_title ?: $package->name) . ' | ' . ($siteSetting?->name ?? config('app.name',
    'Explore Nepal Holidays')))
@section('meta_description', $metaDescription)
@section('og_title', $package->meta_title ?: $package->name)
@section('og_description', $metaDescription)
@section('og_image', $coverUrl)
@section('body_class', 'package-page')

@push('page_styles')
    <link rel="stylesheet" href="{{ asset('site/styles/package.css') }}">
@endpush

@push('page_scripts')
    <script src="{{ asset('site/scripts/package.js') }}"></script>
@endpush

@section('content')
    <a class="skip-link" href="#main">Skip to content</a>
    @if (session('inquiry_submitted'))
        <div class="package-toast is-visible" data-package-toast role="status" aria-live="polite">
            <i data-lucide="circle-check" aria-hidden="true"></i>
            <p>Thanks for your inquiry. Our team will be in touch.</p>
            <button type="button" data-toast-dismiss aria-label="Dismiss notification">&times;</button>
        </div>
    @endif
    @include('site.partials.header')
    <main id="main">
        <section class="package-hero" aria-labelledby="package-title">
            <div class="package-hero__inner">
                <nav class="package-hero__breadcrumbs" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}">Home</a>
                    <span aria-hidden="true">/</span>
                    <a href="{{ route('home') }}#journeys">{{ $destination->name }}</a>
                    <span aria-hidden="true">/</span>
                    <a href="{{ route('home') }}#journeys">{{ $category->name }}</a>
                    <span aria-hidden="true">/</span>
                    <span>{{ $package->name }}</span>
                </nav>

                <div class="package-hero__grid">
                    <div class="package-hero__copy">
                        <div class="package-hero__badges" aria-label="Trip highlights">
                            @forelse ($package->tags ?? [] as $tag)
                                <span>{{ \Illuminate\Support\Str::headline($tag) }}</span>
                            @empty
                                <span>{{ $category->name }}</span>
                                @if ($package->difficulty)
                                    <span>{{ $package->difficulty }}</span>
                                @endif
                                @if ($package->is_featured)
                                    <span>Featured journey</span>
                                @endif
                            @endforelse
                        </div>
                        <p class="package-hero__kicker">{{ $destination->name }} /
                            {{ $package->duration_days ? $package->duration_days . ' Days' : 'Flexible duration' }}</p>
                        <h1 id="package-title">{{ $package->name }}</h1>
                        @if ($package->summary)
                            <p class="package-hero__summary">{{ $package->summary }}</p>
                        @endif
                        <div class="package-hero__actions">
                            <a class="package-button package-button--orange" href="#sidebar-enquiry-form">Ask about this
                                trip <span aria-hidden="true">&rarr;</span></a>
                            <a class="package-text-link" href="#overview">Explore details <span
                                    aria-hidden="true">&darr;</span></a>
                        </div>
                        <div class="package-share" aria-label="Share {{ $package->name }}">
                            <span>SHARE THIS TRIP</span>
                            <a class="package-share__link" href="{{ $facebookShareUrl }}" data-share="facebook" target="_blank"
                                rel="noopener noreferrer" aria-label="Share {{ $package->name }} on Facebook"
                                title="Share on Facebook"><img class="package-icon-image"
                                    src="{{ asset('site/assets/icons/facebook.svg') }}" alt=""></a>
                            <a class="package-share__link" href="{{ $whatsAppShareUrl }}" data-share="whatsapp" target="_blank"
                                rel="noopener noreferrer" aria-label="Share {{ $package->name }} on WhatsApp"
                                title="Share on WhatsApp"><img class="package-icon-image"
                                    src="{{ asset('site/assets/icons/whatsapp.svg') }}" alt=""></a>
                            <a class="package-share__link package-share__email" href="{{ $emailShareUrl }}" data-share="email"
                                aria-label="Share {{ $package->name }} by email" title="Share by email"><span
                                    aria-hidden="true">✉</span></a>
                        </div>
                    </div>

                        <div class="package-hero__media package-gallery"
                        data-package-gallery role="region" aria-label="{{ $package->name }} photo gallery"
                        aria-roledescription="carousel">
                        <div class="package-gallery__frame">
                            @forelse ($galleryImages as $image)
                                <figure class="package-gallery__slide" role="group" aria-roledescription="slide"
                                    aria-label="{{ $loop->iteration }} of {{ $galleryImages->count() }}"
                                    @if (!$loop->first) hidden @endif>
                                    <img src="{{ $image->getUrl('card') ?: $image->getUrl() }}"
                                        alt="{{ $package->name }} photo {{ $loop->iteration }}"
                                        @if ($loop->first) fetchpriority="high" @else loading="lazy" @endif>
                                    <figcaption><span>{{ $destination->name }}</span><strong>{{ $package->name }}</strong>
                                    </figcaption>
                                </figure>
                            @empty
                                <figure class="package-gallery__slide" role="group" aria-roledescription="slide"
                                    aria-label="1 of 1">
                                    <img src="{{ $coverUrl }}" alt="{{ $package->name }}" fetchpriority="high">
                                    <figcaption><span>{{ $destination->name }}</span><strong>{{ $package->name }}</strong>
                                    </figcaption>
                                </figure>
                            @endforelse
                        </div>
                        <div class="package-gallery__toolbar" role="group" aria-label="Photo controls">
                            <div class="package-gallery__dots" role="group" aria-label="Choose a photo">
                                @foreach ($galleryImages as $image)
                                    <button type="button" class="{{ $loop->first ? 'is-active' : '' }}"
                                        aria-label="Show photo {{ $loop->iteration }} of {{ $galleryImages->count() }}"
                                        aria-pressed="{{ $loop->first ? 'true' : 'false' }}"
                                        data-package-gallery-dot="{{ $loop->index }}"></button>
                                @endforeach
                                @if ($galleryImages->isEmpty())
                                    <button type="button" class="is-active" aria-label="Show photo 1 of 1"
                                        aria-pressed="true" data-package-gallery-dot="0"></button>
                                @endif
                            </div>
                            <div class="package-gallery__arrows">
                                <button type="button" aria-label="Previous photo" data-package-gallery-prev><span
                                        aria-hidden="true">&larr;</span></button>
                                <button type="button" aria-label="Next photo" data-package-gallery-next><span
                                        aria-hidden="true">&rarr;</span></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="package-hero__stats" aria-label="Quick trip facts">
                    <div><span><i data-lucide="calendar-days"
                                aria-hidden="true"></i>Duration</span><strong>{{ $package->duration_days ? $package->duration_days . ' days' : 'Flexible' }}
                            @if ($package->duration_nights)
                                / {{ $package->duration_nights }} nights
                            @endif
                        </strong>
                    </div>
                    <div><span><i data-lucide="mountain" aria-hidden="true"></i>Max
                            altitude</span><strong>{{ $package->max_altitude_meters ? number_format($package->max_altitude_meters) . ' m' : 'Varies by route' }}</strong>
                    </div>
                    <div><span><i data-lucide="gauge"
                                aria-hidden="true"></i>Grade</span><strong>{{ $package->difficulty ?: 'Discuss with our team' }}</strong>
                    </div>
                    <div><span><i data-lucide="bed-double"
                                aria-hidden="true"></i>Accommodation</span><strong>{{ $package->accommodation ?: 'See trip details' }}</strong>
                    </div>
                    <div><span><i data-lucide="sun" aria-hidden="true"></i>Best
                            season</span><strong>{{ $package->seasons->pluck('season')->map(fn($season) => $season->label())->implode(' / ') ?: 'Ask our team' }}</strong>
                    </div>
                    <div><span><i data-lucide="users-round" aria-hidden="true"></i>Group
                            size</span><strong>{{ $package->min_group_size ?: 'Flexible' }}@if ($package->max_group_size)
                                to {{ $package->max_group_size }}
                            @endif
                        </strong>
                    </div>
                </div>
            </div>
        </section>
        <section class="package-layout package-section" aria-label="{{ $package->name }} details">
            <div class="package-container package-layout__grid" data-aos="fade-up">
                <div class="package-main">
                    <nav class="package-subnav" aria-label="Package sections" data-package-subnav>
                        <div class="package-subnav__inner">
                            <a class="is-active" href="#overview" data-package-tab aria-label="Overview"
                                aria-current="location"><i class="package-tab-icon" data-lucide="compass"
                                    aria-hidden="true"></i><span>Overview</span></a>
                            @if ($package->itineraryDays->isNotEmpty())
                                <a href="#itinerary" data-package-tab aria-label="Itinerary"><i class="package-tab-icon"
                                        data-lucide="list-ordered" aria-hidden="true"></i><span>Itinerary</span></a>
                            @endif
                            @if ($routeMapImage || $package->route_map_url)
                                <a href="#route-map" data-package-tab aria-label="Route map"><i class="package-tab-icon"
                                        data-lucide="map" aria-hidden="true"></i><span>Route map</span></a>
                            @endif
                            @if ($package->elevationPoints->isNotEmpty())
                                <a href="#elevation" data-package-tab aria-label="Elevation profile"><i
                                        class="package-tab-icon" data-lucide="mountain" aria-hidden="true"></i><span
                                        class="package-tab-label-full">Elevation profile</span><span
                                        class="package-tab-label-short">Elevation</span></a>
                            @endif
                            @if ($package->departures->isNotEmpty() || $package->seasons->isNotEmpty())
                                <a href="#dates" data-package-tab aria-label="Seasons and departures"><i
                                        class="package-tab-icon" data-lucide="calendar-days" aria-hidden="true"></i><span
                                        class="package-tab-label-full">Seasons &amp; departures</span><span
                                        class="package-tab-label-short">Dates</span></a>
                            @endif
                            @if ($package->features->isNotEmpty())
                                <a href="#included" data-package-tab aria-label="Inclusions and exclusions"><i
                                        class="package-tab-icon" data-lucide="badge-check"
                                        aria-hidden="true"></i><span>What's included</span></a>
                            @endif
                            @if (
                                $package->faqs->isNotEmpty() ||
                                    $package->fitness_guidance ||
                                    $package->permit_notes ||
                                    $package->safety_notes ||
                                    $package->weather_notes)
                                <a href="#faq" data-package-tab
                                    aria-label="Planning notes and frequently asked questions"><i class="package-tab-icon"
                                        data-lucide="circle-help" aria-hidden="true"></i><span>Trip notes</span></a>
                            @endif
                            @if ($package->reviews->isNotEmpty())
                                <a href="#reviews" data-package-tab aria-label="Reviews"><i class="package-tab-icon"
                                        data-lucide="message-square-text" aria-hidden="true"></i><span>Reviews</span></a>
                            @endif
                        </div>
                    </nav>
                    <section class="package-overview" id="overview" aria-labelledby="overview-title">
                        <span class="package-eyebrow">THE TRIP IN BRIEF</span>
                        <h2 id="overview-title">Overview</h2>
                        @if ($package->summary)
                            <p class="package-lead">{{ $package->summary }}</p>
                        @endif
                        @if ($package->description)
                            <p>{{ $package->description }}</p>
                        @endif
                    </section>
                    <div class="package-trust" data-aos="fade-up">
                        <p class="package-trust-score"><span class="package-trust-stars"
                                aria-hidden="true">*</span><strong>Route fit</strong><span
                                class="package-trust-outof">before confirmation</span></p>
                        <p class="package-trust-meta">Talk through the pace, altitude, accommodation and best season for
                            {{ $package->name }} before confirming your plans.</p>
                        <a class="package-trust-link" href="#trip-planning">Ask about this trip <span
                                aria-hidden="true">↗</span></a>
                    </div>
                    @if ($package->itineraryDays->isNotEmpty())
                        <section class="package-itinerary" id="itinerary" aria-labelledby="itinerary-title">
                            <div class="package-section-heading">
                                <div><span class="package-eyebrow">DAY BY DAY</span>
                                    <h2 id="itinerary-title">Day-by-day itinerary</h2>
                                </div>
                                <span class="package-section-count">{{ $package->itineraryDays->count() }} DAYS / ROUTE
                                    OVERVIEW</span>
                            </div>
                            <div class="package-details-list">
                                @foreach ($package->itineraryDays as $day)
                                    <details @if ($loop->first) open @endif>
                                        <summary>
                                            <span>{{ str_pad((string) $day->day_number, 2, '0', STR_PAD_LEFT) }}</span>
                                            <strong>{{ $day->title }}</strong>
                                            <small class="package-itinerary__chips">
                                                @if ($day->altitude_meters)
                                                    <span>{{ number_format($day->altitude_meters) }} m</span>
                                                @endif
                                                @if ($day->activity_label)
                                                    <i>{{ $day->activity_label }}</i>
                                                @endif
                                                @if ($day->meal_plan)
                                                    <i>{{ $day->meal_plan }}</i>
                                                @endif
                                            </small>
                                        </summary>
                                        @if ($day->description)
                                            <p>{{ $day->description }}</p>
                                        @endif
                                        @if ($day->location)
                                            <p class="package-itinerary__location">{{ $day->location }}</p>
                                        @endif
                                    </details>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    @if ($routeMapImage || $package->route_map_url)
                        <section class="package-route-map" id="route-map" aria-labelledby="route-map-title">
                            <div class="package-section-heading">
                                <div><span class="package-eyebrow">ROUTE MAP</span>
                                    <h2 id="route-map-title">Route map</h2>
                                </div>
                            </div>
                            @if ($routeMapImage)
                                <figure class="package-route-map__visual package-route-map__visual--image">
                                    <img src="{{ $routeMapImage }}" alt="Route map for {{ $package->name }}" loading="lazy">
                                </figure>
                            @endif
                            @if ($package->route_map_url)
                                <a href="{{ $package->route_map_url }}" target="_blank" rel="noopener noreferrer"
                                    class="package-button package-button--orange">{{ $routeMapImage ? 'Open interactive route map' : 'Open route map' }} <span aria-hidden="true">&#8599;</span></a>
                            @endif
                        </section>
                    @endif

                    @if ($package->elevationPoints->isNotEmpty())
                        @php
                            $elevationPoints = $package->elevationPoints->values();
                            $chartWidth = 960;
                            $chartHeight = 360;
                            $plotLeft = 72;
                            $plotRight = 24;
                            $plotTop = 24;
                            $plotBottom = 286;
                            $plotWidth = $chartWidth - $plotLeft - $plotRight;
                            $plotHeight = $plotBottom - $plotTop;
                            $pointCount = $elevationPoints->count();
                            $minAltitude = (int) floor($elevationPoints->min('altitude_meters') / 1000) * 1000;
                            $maxAltitude = (int) ceil($elevationPoints->max('altitude_meters') / 1000) * 1000;

                            if ($maxAltitude <= $minAltitude) {
                                $maxAltitude = $minAltitude + 1000;
                            }

                            $tickStep = (int) (max(1, ceil(($maxAltitude - $minAltitude) / 4 / 500)) * 500);
                            $altitudeTicks = range($minAltitude, $maxAltitude, $tickStep);
                            if (end($altitudeTicks) !== $maxAltitude) {
                                $altitudeTicks[] = $maxAltitude;
                            }

                            $chartCoordinates = $elevationPoints->map(fn ($point, $index) => [
                                'x' => $pointCount === 1 ? $plotLeft + ($plotWidth / 2) : $plotLeft + ($index / ($pointCount - 1) * $plotWidth),
                                'y' => $plotBottom - (($point->altitude_meters - $minAltitude) / ($maxAltitude - $minAltitude) * $plotHeight),
                            ]);
                            $linePath = $chartCoordinates->map(fn ($point, $index) => ($index === 0 ? 'M ' : 'L ')
                                .number_format($point['x'], 2, '.', '').' '.number_format($point['y'], 2, '.', ''))
                                ->implode(' ');
                            $firstCoordinate = $chartCoordinates->first();
                            $lastCoordinate = $chartCoordinates->last();
                            $areaPath = $linePath.' L '.number_format($lastCoordinate['x'], 2, '.', '').' '.$plotBottom
                                .' L '.number_format($firstCoordinate['x'], 2, '.', '').' '.$plotBottom.' Z';
                            $labelIndexes = $pointCount <= 6
                                ? range(0, $pointCount - 1)
                                : array_values(array_unique(array_map(fn ($index) => (int) round($index * ($pointCount - 1) / 5), range(0, 5))));
                        @endphp
                        <section class="package-elevation package-section" id="elevation"
                            aria-labelledby="elevation-title">
                            <div class="package-section-heading">
                                <div><span class="package-eyebrow">ALTITUDE PROFILE</span>
                                    <h2 id="elevation-title">Altitude profile</h2>
                                </div>
                            </div>
                            <p class="package-lead">Approximate elevations along the route.</p>
                            <div class="package-elevation-chart-wrap">
                                <svg viewBox="0 0 {{ $chartWidth }} {{ $chartHeight }}" role="img" aria-labelledby="elevation-chart-title elevation-chart-description">
                                    <title id="elevation-chart-title">Altitude profile for {{ $package->name }}</title>
                                    <desc id="elevation-chart-description">Approximate elevations at the route stops, measured in metres.</desc>
                                    <defs>
                                        <linearGradient id="elevation-chart-fill" x1="0" x2="0" y1="0" y2="1">
                                            <stop offset="0%" stop-color="#1764a5" stop-opacity=".24" />
                                            <stop offset="100%" stop-color="#1764a5" stop-opacity=".02" />
                                        </linearGradient>
                                    </defs>
                                    @foreach ($altitudeTicks as $tick)
                                        @php
                                            $tickY = $plotBottom - (($tick - $minAltitude) / ($maxAltitude - $minAltitude) * $plotHeight);
                                        @endphp
                                        <line x1="{{ $plotLeft }}" y1="{{ $tickY }}" x2="{{ $chartWidth - $plotRight }}" y2="{{ $tickY }}" stroke="#e7edf1" stroke-width="1" />
                                        <text x="{{ $plotLeft - 12 }}" y="{{ $tickY + 4 }}" text-anchor="end" fill="#536878" font-size="12">{{ number_format($tick) }} m</text>
                                    @endforeach
                                    <path d="{{ $areaPath }}" fill="url(#elevation-chart-fill)" />
                                    <path d="{{ $linePath }}" fill="none" stroke="#1764a5" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                    @foreach ($chartCoordinates as $index => $coordinate)
                                        @php
                                            $point = $elevationPoints[$index];
                                        @endphp
                                        <circle cx="{{ $coordinate['x'] }}" cy="{{ $coordinate['y'] }}" r="5" fill="#1764a5" stroke="#fff" stroke-width="2">
                                            <title>{{ $point->stop_name }}: {{ number_format($point->altitude_meters) }} metres</title>
                                        </circle>
                                        @if (in_array($index, $labelIndexes, true))
                                            @php
                                                $anchor = $index === 0 ? 'start' : ($index === $pointCount - 1 ? 'end' : 'middle');
                                            @endphp
                                            <text x="{{ $coordinate['x'] }}" y="{{ $chartHeight - 22 }}" text-anchor="{{ $anchor }}" fill="#536878" font-size="12">{{ \Illuminate\Support\Str::limit($point->stop_name, 18) }}</text>
                                        @endif
                                    @endforeach
                                </svg>
                            </div>
                        </section>
                    @endif

                    @if ($package->departures->isNotEmpty() || $package->seasons->isNotEmpty())
                        <section class="package-dates package-section" id="dates" aria-labelledby="dates-title">
                            <div class="package-dates__grid">
                                <div>
                                    <span class="package-eyebrow">TRAVEL WINDOWS</span>
                                    <h2 id="dates-title">Seasons &amp; departures</h2>
                                    <p class="package-lead">Share your preferred dates and our team can confirm
                                        availability and the final itinerary.</p>
                                    @if ($package->seasons->isNotEmpty())
                                        <p class="package-dates__note">Best seasons:
                                            {{ $package->seasons->pluck('season')->map(fn($season) => $season->label())->implode(', ') }}
                                        </p>
                                    @endif
                                </div>
                                @if ($package->departures->isNotEmpty())
                                    <div class="package-dates__list" role="list" aria-label="Departure date ideas">
                                        @foreach ($package->departures as $departure)
                                            <article class="package-date-row" role="listitem">
                                                <div>
                                                    <span
                                                        class="package-date-row__season">{{ $departure->season->label() }}</span>
                                                    <strong>{{ $departure->starts_on->format('M j, Y') }}@if ($departure->ends_on)
                                                            - {{ $departure->ends_on->format('M j, Y') }}
                                                        @endif
                                                    </strong>
                                                    @if ($departure->price !== null)
                                                        <span class="package-date-row__price">From
                                                            {{ $departure->currency }}
                                                            {{ number_format((float) $departure->price, 0) }} @if ($package->price_qualifier)
                                                                <small>{{ $package->price_qualifier }}</small>
                                                            @endif
                                                        </span>
                                                    @endif
                                                </div>
                                                <span
                                                    class="package-date-row__status">{{ str($departure->status)->replace('_', ' ')->headline() }}</span>
                                                <a href="{{ route('packages.bookings.create', ['package' => $package, 'departure_id' => $departure->id]) }}"
                                                    aria-label="Book {{ $departure->season->label() }} departure">Book
                                                    <span aria-hidden="true">&#8599;</span></a>
                                            </article>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="package-dates__list">
                                        <p class="package-dates__note">No fixed departures are listed yet. Contact us to
                                            discuss dates that work for you.</p>
                                    </div>
                                @endif
                                <p class="package-dates__price-note">Dates and prices are planning guides and are confirmed
                                    with your group and route details.</p>
                            </div>
                        </section>
                    @endif

                    @php
                        $includedFeatures = $package->features->where('type', 'included');
                    @endphp
                    @if ($includedFeatures->isNotEmpty())
                        <section class="package-split package-section" id="included" aria-labelledby="included-title">
                            <div class="package-split__grid">
                                <div><span class="package-eyebrow">WHAT'S INCLUDED</span>
                                    <h2 id="included-title">Our includes</h2>
                                    <p class="package-lead">Services listed for this package.</p>
                                </div>
                                <div class="package-checklists package-checklists--single">
                                    <div class="package-checklist-card--included">
                                        <ul>
                                            @foreach ($includedFeatures as $feature)
                                                <li>{{ $feature->description }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </section>
                    @endif
                    @php
                        $excludedFeatures = $package->features->where('type', 'excluded');
                    @endphp
                    @if ($excludedFeatures->isNotEmpty())
                        <section class="package-split package-section" id="excluded" aria-labelledby="excluded-title">
                            <div class="package-split__grid">
                                <div><span class="package-eyebrow">NOT INCLUDED</span>
                                    <h2 id="excluded-title">Our excludes</h2>
                                    <p class="package-lead">Items listed as excluded from this package.</p>
                                </div>
                                <div class="package-checklists package-checklists--single">
                                    <div class="package-checklist-card--excluded">
                                        <ul>
                                            @foreach ($excludedFeatures as $feature)
                                                <li>{{ $feature->description }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </section>
                    @endif
                    @php
                        $planningNotes = collect([
                            'Fitness guidance' => $package->fitness_guidance,
                            'Permit notes' => $package->permit_notes,
                            'Safety notes' => $package->safety_notes,
                            'Weather notes' => $package->weather_notes,
                        ])->filter();
                    @endphp
                    @if ($planningNotes->isNotEmpty() || $package->faqs->isNotEmpty())
                        <section class="package-faq package-section" id="faq" aria-labelledby="package-faq-title">
                            <div class="package-faq__grid">
                                <div><span class="package-eyebrow">CLEAR ANSWERS</span>
                                    <h2 id="package-faq-title">
                                        {{ $package->faqs->isNotEmpty() ? 'Frequently asked questions' : 'Planning notes' }}
                                    </h2>
                                </div>
                                <div class="package-info__items">
                                    @foreach ($planningNotes as $label => $note)
                                        <details>
                                            <summary>{{ $label }}</summary>
                                            <p>{{ $note }}</p>
                                        </details>
                                    @endforeach
                                    @foreach ($package->faqs as $faq)
                                        <details>
                                            <summary>{{ $faq->question }}</summary>
                                            <p>{{ $faq->answer }}</p>
                                        </details>
                                    @endforeach
                                </div>
                            </div>
                        </section>
                    @endif
                </div>
                <aside class="package-sidebar" id="trip-planning" aria-label="Plan {{ $package->name }}"
                    x-data="packageBookingSidebar()">
                    <div class="package-conversion-card">
                        <div class="package-conversion-heading">
                            <div class="package-price-offer">
                                @if ($price !== null && $compareAtPrice !== null && $compareAtPrice > $price)
                                    <span class="package-price-offer__label">SPECIAL PRICE <span>Save {{ $currency }} {{ number_format($compareAtPrice - $price, 0) }}</span></span>
                                    <p class="package-price-offer__was">Was <del>{{ $currency }} {{ number_format($compareAtPrice, 0) }}</del></p>
                                    <p class="package-price-offer__now"><span>From</span> {{ $currency }} {{ number_format($price, 0) }}</p>
                                @elseif ($price !== null)
                                    <span class="package-price-offer__label">PACKAGE PRICE</span>
                                    <p class="package-price-offer__now"><span>From</span> {{ $currency }} {{ number_format($price, 0) }}</p>
                                @else
                                    <span class="package-price-offer__label">PACKAGE PRICE</span>
                                    <p class="package-price-offer__now">Request a quote</p>
                                @endif
                                <p class="package-price-offer__per-person">{{ $package->price_qualifier ?: 'per person' }}</p>
                            </div>
                        </div>
                        <ul class="package-price-benefits" aria-label="Trip benefits">
                            <li><i data-lucide="trending-up" aria-hidden="true"></i><span>98% Trip Success Rate</span></li>
                            <li><i data-lucide="calendar-check" aria-hidden="true"></i><span>Flexible Booking &amp; Trip Options</span></li>
                            <li><i data-lucide="badge-check" aria-hidden="true"></i><span>Best Price Guarantee</span></li>
                            <li><i data-lucide="shield-check" aria-hidden="true"></i><span>Safety-First on Every Trip</span></li>
                            <li><i data-lucide="wallet-cards" aria-hidden="true"></i><span>Secure &amp; Flexible Lifetime Deposit</span></li>
                            <li><i data-lucide="user-check" aria-hidden="true"></i><span>Highly Experienced Guides</span></li>
                            <li><i data-lucide="circle-check" aria-hidden="true"></i><span>Guaranteed Departures</span></li>
                        </ul>
                    </div>
                    <div class="package-conversion-card package-form-card">
                        <div class="package-form-tabs" aria-label="Choose how to continue">
                            <button type="button" :class="sidebarForm === 'inquiry' ? 'is-active' : ''"
                                @click="sidebarForm = 'inquiry'">Send Free Inquiry</button>
                            <button type="button" :class="sidebarForm === 'booking' ? 'is-active' : ''"
                                @click="sidebarForm = 'booking'">Plan Booking</button>
                        </div>
                        <form class="package-conversion-form" id="sidebar-enquiry-form"
                            action="{{ route('packages.inquiries.store', $package) }}" method="POST"
                            x-show="sidebarForm === 'inquiry'" role="tabpanel">
                            @csrf
                            <label for="sidebar-enquiry-name">Your full name <b>*</b></label><input
                                id="sidebar-enquiry-name" name="customer_name" type="text" autocomplete="name"
                                value="{{ old('customer_name') }}" required placeholder="e.g. David Jenkins">
                            @error('customer_name') <small class="text-danger">{{ $message }}</small> @enderror
                            <div class="package-conversion-form__row">
                                <div><label for="sidebar-enquiry-email">Email address <b>*</b></label><input
                                        id="sidebar-enquiry-email" name="email" type="email"
                                        autocomplete="email" value="{{ old('email') }}" required placeholder="david@example.com">
                                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror</div>
                                <div><label for="sidebar-enquiry-phone">WhatsApp / phone <b>*</b></label><input
                                        id="sidebar-enquiry-phone" name="phone" type="tel"
                                        autocomplete="tel" value="{{ old('phone') }}" required placeholder="+1 555-0199">
                                    @error('phone') <small class="text-danger">{{ $message }}</small> @enderror</div>
                            </div>
                            <label for="sidebar-enquiry-window">Preferred travel window <b>*</b></label><select
                                id="sidebar-enquiry-window" name="travel_window" required>
                                <option value="">Choose a season or date</option>
                                @foreach ($travelWindows as $window)
                                    <option value="{{ $window['value'] }}" @selected(old('travel_window') === $window['value'])>{{ $window['label'] }}</option>
                                @endforeach
                            </select>
                            @error('travel_window') <small class="text-danger">{{ $message }}</small> @enderror
                            <label for="sidebar-enquiry-message">Questions / specific requests</label>
                            <textarea id="sidebar-enquiry-message" name="message" rows="3"
                                maxlength="10000"
                                placeholder="e.g. Vegetarian diet, private group, slow pacing request...">{{ old('message') }}</textarea>
                            @error('message') <small class="text-danger">{{ $message }}</small> @enderror
                            <button class="package-conversion-submit" type="submit">Send inquiry</button><a
                                class="package-whatsapp-button"
                                href="https://wa.me/?text={{ $whatsAppMessage }}"
                                target="_blank" rel="noopener noreferrer"><img
                                class="package-icon-image package-whatsapp-button__icon"
                                src="{{ asset('site/assets/icons/whatsapp.svg') }}" alt="">Instant Chat on WhatsApp</a>
                            <p class="package-form__status" role="status" hidden></p>
                        </form>
                        <form class="package-conversion-form" id="sidebar-booking-form"
                            action="{{ route('packages.bookings.store', $package) }}" method="POST"
                            x-show="sidebarForm === 'booking'" role="tabpanel">
                            @csrf
                            <input type="hidden" name="booking_source" value="package">
                            <label for="sidebar-booking-name">Your full name <b>*</b></label>
                            <input id="sidebar-booking-name" name="customer_name" type="text" autocomplete="name"
                                value="{{ old('customer_name') }}" required placeholder="Your name">
                            @error('customer_name') <small class="text-danger">{{ $message }}</small> @enderror
                            <div class="package-conversion-form__row">
                                <div>
                                    <label for="sidebar-booking-email">Email address <b>*</b></label>
                                    <input id="sidebar-booking-email" name="email" type="email" autocomplete="email"
                                        value="{{ old('email') }}" required placeholder="you@example.com">
                                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div>
                                    <label for="sidebar-booking-phone">WhatsApp / phone <b>*</b></label>
                                    <input id="sidebar-booking-phone" name="phone" type="tel" autocomplete="tel"
                                        value="{{ old('phone') }}" required placeholder="+1 555-0199">
                                    @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <label for="sidebar-booking-date">Preferred departure date <b>*</b></label>
                            <input id="sidebar-booking-date" name="travel_date" type="date"
                                min="{{ now()->toDateString() }}" value="{{ old('travel_date') }}" required>
                            @error('travel_date') <small class="text-danger">{{ $message }}</small> @enderror
                            <label for="sidebar-booking-guests">Number of travellers <b>*</b></label>
                            <select id="sidebar-booking-guests" name="guests" required>
                                <option value="">Select group size</option>
                                @foreach ($travellerOptions as $travellers)
                                    <option value="{{ $travellers }}" @selected((string) old('guests') === (string) $travellers)>{{ $travellers }} {{ \Illuminate\Support\Str::plural('traveller', $travellers) }}</option>
                                @endforeach
                            </select>
                            @error('guests') <small class="text-danger">{{ $message }}</small> @enderror
                            <label for="sidebar-booking-notes">Special requests</label>
                            <textarea id="sidebar-booking-notes" name="special_requests" rows="3" maxlength="10000"
                                placeholder="Anything else we should know?">{{ old('special_requests') }}</textarea>
                            @error('special_requests') <small class="text-danger">{{ $message }}</small> @enderror
                            <label class="package-checkbox package-booking-consent" for="sidebar-booking-consent">
                                <input id="sidebar-booking-consent" type="checkbox" name="consent" value="1" required @checked(old('consent'))>
                                <span>Our team may use these details to reply to your request. <b>*</b></span>
                            </label>
                            @error('consent') <small class="text-danger">{{ $message }}</small> @enderror
                            <button class="package-conversion-submit" type="submit">Send booking request <span aria-hidden="true">&#8599;</span></button>
                            <a class="package-booking-full-link" href="{{ route('packages.bookings.create', $package) }}">Open the full booking form <span aria-hidden="true">&#8599;</span></a>
                            <a class="package-whatsapp-button"
                                href="https://wa.me/?text={{ rawurlencode('I am ready to discuss booking '.$package->name.'.') }}"
                                target="_blank" rel="noopener noreferrer"><img
                                class="package-icon-image package-whatsapp-button__icon"
                                src="{{ asset('site/assets/icons/whatsapp.svg') }}" alt="">Instant Chat on WhatsApp</a>
                            <p class="package-form__status" role="status" hidden></p>
                        </form>
                    </div>
                </aside>
            </div>
        </section>
        @if ($package->reviews->isNotEmpty())
            <section class="package-reviews package-section" id="reviews" aria-labelledby="reviews-title">
                <div class="package-container">
                    <div class="package-reviews__heading">
                        <div><span class="package-eyebrow">TRAVELLER FEEDBACK</span>
                            <h2 id="reviews-title">Customer reviews</h2>
                        </div>
                        <div class="package-reviews__heading-side">
                            <p>Feedback from travellers about {{ $package->name }}.</p>
                            <div class="package-review-controls" aria-label="Review controls"><button
                                    class="package-review-control package-review-prev" type="button"
                                    aria-label="Previous review" title="Previous review">&#8592;</button>
                                <div class="package-review-pagination" aria-label="Choose a review"></div><button
                                    class="package-review-control package-review-next" type="button"
                                    aria-label="Next review" title="Next review">&#8594;</button>
                            </div>
                        </div>
                    </div>
                    <div class="swiper package-review-swiper">
                        <div class="swiper-wrapper">
                            @foreach ($package->reviews as $review)
                                <article
                                    class="swiper-slide package-review-card {{ $loop->iteration % 2 === 0 ? 'package-review-card--accent' : '' }}">
                                    <div class="package-review-card__top">
                                        <span>{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span><small>CUSTOMER
                                            REVIEW</small></div>
                                    <blockquote>{{ $review->quote }}</blockquote>
                                    <div class="package-review-card__source"><span aria-hidden="true">&mdash;</span>
                                        <div>
                                            <strong>{{ $review->reviewer_name ?: $package->name . ' guest' }}</strong><span>{{ $review->reviewer_label ?: 'Customer feedback' }}</span>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif
    </main>
    @include('site.partials.footer')
    <div class="floating-actions">
        <a class="back-to-top" href="#top" aria-label="Back to top" title="Back to top" x-show="showBackToTop"
            x-cloak><img src="{{ asset('site/assets/explore-nepal-back-to-top-animated.gif') }}" alt=""
                width="384" height="384"></a>
        <a class="whatsapp-float"
            href="https://wa.me/?text=I%27m%20planning%20a%20Nepal%20trip%20with%20Explore%20Nepal%20Holidays."
            target="_blank" rel="noopener noreferrer" aria-label="Share your Nepal trip plans on WhatsApp"
            title="Share your trip plans on WhatsApp"><img class="package-icon-image"
                src="{{ asset('site/assets/icons/whatsapp.svg') }}" alt=""></a>
    </div>
@endsection
