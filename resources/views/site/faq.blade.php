@extends('layouts.site')

@section('page_title', 'FAQs | '.($siteSetting?->name ?? config('app.name', 'Explore Nepal Holidays')))
@section('meta_description', 'Answers to common questions about planning trips, trekking and booking with Explore Nepal Holidays.')
@section('og_image', asset('site/assets/annapurna-sunrise.jpg'))
@section('body_class', 'bg-paper text-ink font-sans')

@push('page_styles')
<link rel="stylesheet" href="{{ asset('site/styles/about.css') }}">
<link rel="stylesheet" href="{{ asset('site/styles/faq.css') }}">
@endpush

@section('content')
<a class="skip-link" href="#main">Skip to content</a>
@include('site.partials.header')

  <main id="main" class="faq-page about-page">
    <section class="about-banner" aria-labelledby="faq-page-title">
      <div class="container">
        <nav class="about-breadcrumb" aria-label="Breadcrumb"><a href="{{ route('home') }}">Home</a><span aria-hidden="true">/</span><span>FAQs</span></nav>
        <h1 id="faq-page-title">Frequently asked questions</h1>
      </div>
    </section>

    <nav class="faq-page-topics" aria-label="FAQ topics">
      <div class="container"><a href="#planning">Trip planning</a><a href="#trekking">Trekking</a><a href="#booking">Booking and payment</a></div>
    </nav>

    <div class="container faq-page-content">
      <section class="faq-page-group" id="planning" aria-labelledby="planning-title">
        <div class="faq-page-group__intro"><span class="eyebrow dark">START WITH THE BASICS</span><h2 id="planning-title">Trip planning</h2><p>A few details can help shape a trip around your time, interests and preferred pace.</p></div>
        <div class="faq-list">
          <details><summary><span>01</span><strong>When is a good time to visit Nepal?</strong><span class="plus" aria-hidden="true">+</span></summary><p>Spring and autumn are popular for many treks. Cities and lowland areas can be rewarding at other times too. The best season depends on your route and what you want to experience.</p></details>
          <details><summary><span>02</span><strong>How do I choose the right trip?</strong><span class="plus" aria-hidden="true">+</span></summary><p>Start with your available days, walking experience, comfort with altitude and the landscapes you most want to see. These details help narrow the options.</p></details>
          <details><summary><span>03</span><strong>Can I combine trekking, culture and wildlife?</strong><span class="plus" aria-hidden="true">+</span></summary><p>Yes. A custom journey can combine a trek, time in Kathmandu and a visit to the lowlands. Travel time and season help determine a comfortable itinerary.</p></details>
          <details><summary><span>04</span><strong>Can you tailor a trip to my dates and interests?</strong><span class="plus" aria-hidden="true">+</span></summary><p>Share your preferred dates, group size, interests and pace. The team can discuss suitable route options and confirm the final itinerary with you.</p></details>
        </div>
      </section>

      <section class="faq-page-group" id="trekking" aria-labelledby="trekking-title">
        <div class="faq-page-group__intro"><span class="eyebrow dark">ON THE TRAIL</span><h2 id="trekking-title">Trekking in Nepal</h2><p>Understand the preparation and practical details to discuss before choosing a route.</p></div>
        <div class="faq-list">
          <details><summary><span>05</span><strong>Do I need trekking experience?</strong><span class="plus" aria-hidden="true">+</span></summary><p>It depends on the route. Some walks suit first-time trekkers who prepare well; longer or higher routes call for stronger fitness and experience. Discuss your background when choosing a trek.</p></details>
          <details><summary><span>06</span><strong>How fit do I need to be?</strong><span class="plus" aria-hidden="true">+</span></summary><p>Many treks involve several hours of walking on uneven trails, stairs and gradual climbs. Build regular walking or hill training into your preparation, and choose a pace that suits you.</p></details>
          <details><summary><span>07</span><strong>How should I prepare for altitude?</strong><span class="plus" aria-hidden="true">+</span></summary><p>Choose an itinerary with a sensible ascent and acclimatization time. Follow your guide’s advice, tell them about symptoms promptly, and seek medical help if you feel unwell.</p></details>
          <details><summary><span>08</span><strong>What travel insurance should I arrange?</strong><span class="plus" aria-hidden="true">+</span></summary><p>Arrange insurance that explicitly covers trekking at your planned altitude, medical treatment and emergency evacuation. Check the policy details before you travel.</p></details>
          <details><summary><span>09</span><strong>What should I pack?</strong><span class="plus" aria-hidden="true">+</span></summary><p>Pack in layers and bring comfortable broken-in walking shoes, rain protection, sun protection and personal medication. Exact gear depends on season, route and altitude; confirm a route-specific list before departure.</p></details>
        </div>
      </section>

      <section class="faq-page-group" id="booking" aria-labelledby="booking-title">
        <div class="faq-page-group__intro"><span class="eyebrow dark">BEFORE YOU CONFIRM</span><h2 id="booking-title">Booking and payment</h2><p>Get clear on how enquiries, trip details and payment are handled.</p></div>
        <div class="faq-list">
          <details><summary><span>10</span><strong>Are the trips listed on the site ready to book?</strong><span class="plus" aria-hidden="true">+</span></summary><p>Listed trips are a starting point for an enquiry. Routes, dates, inclusions, prices and availability are confirmed with you before a trip is offered.</p></details>
          <details><summary><span>11</span><strong>What happens after I send an enquiry?</strong><span class="plus" aria-hidden="true">+</span></summary><p>The team reviews your dates, interests and group details, then follows up to discuss suitable options and any questions before confirming a plan.</p></details>
          <details><summary><span>12</span><strong>When will the final price and inclusions be confirmed?</strong><span class="plus" aria-hidden="true">+</span></summary><p>Your written trip plan should set out the agreed itinerary, inclusions and price before you make a payment. Ask the team to clarify any item that is not listed.</p></details>
          <details><summary><span>13</span><strong>Which payment methods can I use?</strong><span class="plus" aria-hidden="true">+</span></summary><p>Available payment methods and any applicable charges are confirmed with your trip details before you pay. Please follow the payment instructions provided for your booking.</p></details>
        </div>
      </section>

      <section class="faq-page-contact" aria-labelledby="faq-contact-title"><div><span class="eyebrow light-eye">STILL HAVE A QUESTION?</span><h2 id="faq-contact-title">We can help you plan the details.</h2><p>Tell us what you’re considering, and our team can help you explore the next steps.</p></div><a class="faq-page-cta" href="{{ route('contact') }}">Contact our team <span aria-hidden="true">→</span></a></section>
    </div>
  </main>

  <!-- Reusable Site Footer -->
  @include('site.partials.footer')

  <!-- Reusable Trip Search Modal Dialog -->
  <div class="trip-search-backdrop" x-show="tripSearchOpen" x-cloak @click.self="closeTripSearch()"
    @keydown.tab="trapSearchTab($event)" @keydown.escape.stop="closeTripSearch()">
    <section class="trip-search-dialog" x-ref="tripSearchDialog" role="dialog" aria-modal="true"
      aria-labelledby="trip-search-title" aria-describedby="trip-search-description">
      <button class="trip-search-close" type="button" @click="closeTripSearch()" aria-label="Close trip search">×</button>
      <div class="trip-search-heading">
        <span class="eyebrow dark">FIND YOUR NEPAL JOURNEY</span>
        <h2 id="trip-search-title">Where would you like to go?</h2>
        <p id="trip-search-description">Search trekking, tour and peak climbing ideas.</p>
      </div>
      <label class="trip-search-input">
        <img class="icon-img icon-img--light" src="{{ asset('site/assets/icons/search.svg') }}" alt="">
        <span class="sr-only">Search trips and regions</span>
        <input x-ref="tripSearchInput" type="search" x-model.debounce.150ms="tripSearchQuery"
          placeholder="Try Annapurna, wildlife or Island Peak" autocomplete="off">
      </label>
      <div class="trip-search-filters" role="group" aria-label="Filter by journey type">
        <button type="button" @click="tripSearchActivity='all'" :aria-pressed="(tripSearchActivity==='all').toString()" :class="tripSearchActivity==='all' ? 'active' : ''">All journeys</button>
        <button type="button" @click="tripSearchActivity='Trekking'" :aria-pressed="(tripSearchActivity==='Trekking').toString()" :class="tripSearchActivity==='Trekking' ? 'active' : ''">Trekking</button>
        <button type="button" @click="tripSearchActivity='Tours'" :aria-pressed="(tripSearchActivity==='Tours').toString()" :class="tripSearchActivity==='Tours' ? 'active' : ''">Tours</button>
        <button type="button" @click="tripSearchActivity='Peak climbing'" :aria-pressed="(tripSearchActivity==='Peak climbing').toString()" :class="tripSearchActivity==='Peak climbing' ? 'active' : ''">Peak climbing</button>
      </div>
      <div class="trip-search-results-head">
        <span x-text="tripSearchQuery ? 'SEARCH RESULTS' : 'IDEAS TO GET YOU STARTED'">IDEAS TO GET YOU STARTED</span>
        <span x-text="filteredSearchTrips().length + ' sample ideas'">9 sample ideas</span>
      </div>
      <div class="trip-search-results" aria-live="polite">
        <template x-for="trip in filteredSearchTrips()" :key="trip.activity + trip.category + trip.name">
          <a class="trip-search-result" href="{{ route('home') }}#plan" @click="selectSearchTrip(trip)">
            <span class="trip-search-result-meta">
              <span x-text="trip.activity">Trekking</span>
              <span x-text="trip.category">Annapurna Region Trekking</span>
            </span>
            <strong x-text="trip.name">14 Day Annapurna Base Camp Trek</strong>
            <span class="trip-search-result-arrow" aria-hidden="true">↗</span>
          </a>
        </template>
        <p class="trip-search-empty" x-show="filteredSearchTrips().length===0" x-cloak>
          No sample journeys match that search. Try another name or choose a different journey type.
        </p>
      </div>
      <p class="trip-search-note">These are sample enquiry topics. Routes and availability need confirmation.</p>
    </section>
  </div>

  <!-- Reusable Floating Actions -->
  <div class="floating-actions">
    <a class="back-to-top" href="#top" aria-label="Back to top" title="Back to top" x-show="showBackToTop" x-cloak>
      <img src="{{ asset('site/assets/explore-nepal-back-to-top-animated.gif') }}" alt="" width="384" height="384">
    </a>
    <a class="whatsapp-float" href="https://wa.me/?text=I%27m%20planning%20a%20Nepal%20trip%20with%20Explore%20Nepal%20Holidays."
      target="_blank" rel="noopener noreferrer" aria-label="Share your Nepal trip plans on WhatsApp" title="Share your trip plans on WhatsApp">
      <img class="icon-img icon-img--dark" src="{{ asset('site/assets/icons/whatsapp.svg') }}" alt="">
    </a>
  </div>

  <!-- Scripts -->
@endsection
