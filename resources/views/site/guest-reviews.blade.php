@extends('layouts.site')

@section('page_title', 'Guest Reviews | Explore Nepal Holidays')
@section('meta_description', 'Read guest stories about trekking and exploring Nepal with Explore Nepal Holidays.')
@section('og_image', asset('site/assets/annapurna-sunrise.jpg'))
@section('body_class', 'bg-paper text-ink font-sans')

@push('page_styles')
<link rel="stylesheet" href="{{ asset('site/styles/about.css') }}">
<link rel="stylesheet" href="{{ asset('site/styles/guest-reviews.css') }}">
@endpush

@section('content')
<a class="skip-link" href="#main">Skip to content</a>
@include('site.partials.header')

<main id="main" class="about-page guest-reviews-page">
    <section class="about-banner guest-reviews-banner" aria-labelledby="reviews-title">
        <div class="container">
            <nav class="about-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a><span aria-hidden="true">/</span><span>Guest reviews</span>
            </nav>
            <h1 id="reviews-title">Guest reviews</h1>
        </div>
    </section>

    <section class="guest-review-intro container" aria-label="Review source">
        <div>
            <span class="guest-reviews-eyebrow">REAL TRAVELLER STORIES</span>
            <h2>Experiences shared in their own words</h2>
            <p>These excerpts come from guest reviews on our Tripadvisor listing. Each story links to the original source.</p>
        </div>
        <a class="guest-tripadvisor-link" href="https://www.tripadvisor.in/Attraction_Review-g293890-d19900205-Reviews-Explore_Nepal_Holidays-Kathmandu_Kathmandu_Valley_Bagmati_Zone_Central_Region.html" target="_blank" rel="noopener noreferrer">
            See the Tripadvisor listing <span aria-hidden="true">↗</span>
        </a>
    </section>

    <section class="guest-review-grid container" aria-label="Guest review excerpts">
        <article class="guest-review-card">
            <div class="guest-review-card-top"><span class="guest-review-stars" aria-label="5 out of 5 stars">★★★★★</span><span>September 2026</span></div>
            <blockquote>Our trek to Poon Hill with ABC Camp was simply incredible and a true once-in-a-lifetime experience! From start to finish, everything was perfectly organized.</blockquote>
            <div class="guest-review-meta">
                <div class="guest-review-avatar" aria-hidden="true">KN</div>
                <div><strong>K N</strong><span>Poon Hill and Annapurna Base Camp</span><small>Annapurna region</small></div>
            </div>
            <a class="guest-review-source" href="https://www.tripadvisor.in/Attraction_Review-g293890-d19900205-Reviews-Explore_Nepal_Holidays-Kathmandu_Kathmandu_Valley_Bagmati_Zone_Central_Region.html" target="_blank" rel="noopener noreferrer">Read source review <span aria-hidden="true">↗</span></a>
        </article>

        <article class="guest-review-card">
            <div class="guest-review-card-top"><span class="guest-review-stars" aria-label="5 out of 5 stars">★★★★★</span><span>December 2025</span></div>
            <blockquote>I thoroughly enjoyed my time with my guide Ram Kumar he was very knowledgeable on Nepali history and the landscape of each place we went. Ram made me feel very welcome and made my time in Nepal very easy.</blockquote>
            <div class="guest-review-meta">
                <div class="guest-review-avatar" aria-hidden="true">DL</div>
                <div><strong>Denver L</strong><span>Kathmandu sightseeing and the Nagarkot trek</span><small>Kathmandu Valley</small></div>
            </div>
            <a class="guest-review-source" href="https://www.tripadvisor.in/Attraction_Review-g293890-d19900205-Reviews-Explore_Nepal_Holidays-Kathmandu_Kathmandu_Valley_Bagmati_Zone_Central_Region.html" target="_blank" rel="noopener noreferrer">Read source review <span aria-hidden="true">↗</span></a>
        </article>

        <article class="guest-review-card">
            <div class="guest-review-card-top"><span class="guest-review-stars" aria-label="5 out of 5 stars">★★★★★</span><span>March 2026</span></div>
            <blockquote>A friend and I completed the Tsum Valley and Manaslu trek (18 days) with them. Our guide Subarna was great, he helped us through the whole trip, providing us with interesting information. He took great care of us and showed flexibility and ability to adapt to our needs.</blockquote>
            <div class="guest-review-meta">
                <div class="guest-review-avatar" aria-hidden="true">AS</div>
                <div><strong>Asier</strong><span>Tsum Valley and Manaslu trek</span><small>Manaslu and Tsum Valley</small></div>
            </div>
            <a class="guest-review-source" href="https://www.tripadvisor.in/Attraction_Review-g293890-d19900205-Reviews-Explore_Nepal_Holidays-Kathmandu_Kathmandu_Valley_Bagmati_Zone_Central_Region.html" target="_blank" rel="noopener noreferrer">Read source review <span aria-hidden="true">↗</span></a>
        </article>
    </section>

    <section class="guest-review-cta">
        <div class="container">
            <div>
                <span class="guest-reviews-eyebrow">YOUR NEPAL STORY STARTS HERE</span>
                <h2>Thinking about a journey of your own?</h2>
                <p>Tell us what you would like to see, how much time you have and when you hope to travel.</p>
            </div>
            <a class="header-cta inline-flex items-center justify-center font-semibold text-white bg-orange-brand hover:bg-orange-hover transition-colors rounded-brand" href="{{ route('home') }}#plan">Start planning <span aria-hidden="true">↗</span></a>
        </div>
    </section>
</main>

@include('site.partials.footer')

<div class="trip-search-backdrop" x-show="tripSearchOpen" x-cloak @click.self="closeTripSearch()" @keydown.tab="trapSearchTab($event)" @keydown.escape.stop="closeTripSearch()">
    <section class="trip-search-dialog" x-ref="tripSearchDialog" role="dialog" aria-modal="true" aria-labelledby="trip-search-title" aria-describedby="trip-search-description">
        <button class="trip-search-close" type="button" @click="closeTripSearch()" aria-label="Close trip search">×</button>
        <div class="trip-search-heading"><span class="eyebrow dark">FIND YOUR NEPAL JOURNEY</span><h2 id="trip-search-title">Where would you like to go?</h2><p id="trip-search-description">Search trekking, tour and peak climbing ideas.</p></div>
        <label class="trip-search-input"><img class="icon-img icon-img--light" src="{{ asset('site/assets/icons/search.svg') }}" alt=""><span class="sr-only">Search trips and regions</span><input x-ref="tripSearchInput" type="search" x-model.debounce.150ms="tripSearchQuery" placeholder="Try Annapurna, wildlife or Island Peak" autocomplete="off"></label>
        <div class="trip-search-filters" role="group" aria-label="Filter by journey type">
            <button type="button" @click="tripSearchActivity='all'" :aria-pressed="(tripSearchActivity==='all').toString()" :class="tripSearchActivity==='all' ? 'active' : ''">All journeys</button>
            <button type="button" @click="tripSearchActivity='Trekking'" :aria-pressed="(tripSearchActivity==='Trekking').toString()" :class="tripSearchActivity==='Trekking' ? 'active' : ''">Trekking</button>
            <button type="button" @click="tripSearchActivity='Tours'" :aria-pressed="(tripSearchActivity==='Tours').toString()" :class="tripSearchActivity==='Tours' ? 'active' : ''">Tours</button>
            <button type="button" @click="tripSearchActivity='Peak climbing'" :aria-pressed="(tripSearchActivity==='Peak climbing').toString()" :class="tripSearchActivity==='Peak climbing' ? 'active' : ''">Peak climbing</button>
        </div>
        <div class="trip-search-results-head"><span x-text="tripSearchQuery ? 'SEARCH RESULTS' : 'IDEAS TO GET YOU STARTED'">IDEAS TO GET YOU STARTED</span><span x-text="filteredSearchTrips().length + ' sample ideas'">9 sample ideas</span></div>
        <div class="trip-search-results" aria-live="polite">
            <template x-for="trip in filteredSearchTrips()" :key="trip.activity + trip.category + trip.name">
                <a class="trip-search-result" href="{{ route('home') }}#plan" @click="selectSearchTrip(trip)">
                    <span class="trip-search-result-meta"><span x-text="trip.activity">Trekking</span><span x-text="trip.category">Annapurna Region Trekking</span></span>
                    <strong x-text="trip.name">14 Day Annapurna Base Camp Trek</strong><span class="trip-search-result-arrow" aria-hidden="true">↗</span>
                </a>
            </template>
            <p class="trip-search-empty" x-show="filteredSearchTrips().length===0" x-cloak>No sample journeys match that search. Try another name or choose a different journey type.</p>
        </div>
        <p class="trip-search-note">These are sample enquiry topics. Routes and availability need confirmation.</p>
    </section>
</div>

<div class="floating-actions">
    <a class="back-to-top" href="#top" aria-label="Back to top" title="Back to top" x-show="showBackToTop" x-cloak><img src="{{ asset('site/assets/explore-nepal-back-to-top-animated.gif') }}" alt="" width="384" height="384"></a>
    <a class="whatsapp-float" href="https://wa.me/?text=I%27m%20planning%20a%20Nepal%20trip%20with%20Explore%20Nepal%20Holidays." target="_blank" rel="noopener noreferrer" aria-label="Share your Nepal trip plans on WhatsApp" title="Share your trip plans on WhatsApp"><img class="icon-img icon-img--dark" src="{{ asset('site/assets/icons/whatsapp.svg') }}" alt=""></a>
</div>
@endsection
