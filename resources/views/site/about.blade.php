@extends('layouts.site')

@section('page_title', 'About Us | '.($siteSetting?->name ?? config('app.name', 'Explore Nepal Holidays')))
@section('meta_description', 'Get to know Explore Nepal Holidays and our approach to trekking, culture, wildlife and tailor-made journeys across Nepal.')
@section('og_image', asset('site/assets/annapurna-sunrise.jpg'))
@section('body_class', 'bg-paper text-ink font-sans about-page')

@push('page_styles')
<link rel="stylesheet" href="{{ asset('site/styles/about.css') }}">
@endpush

@push('page_scripts')
<script src="{{ asset('site/scripts/about.js') }}"></script>
@endpush

@section('content')
<a class="skip-link" href="#main">Skip to content</a>
@include('site.partials.header')

  <!-- About Us content -->
  <main id="main" class="about-page">
    <section class="about-banner" aria-labelledby="about-title">
      <div class="container">
        <nav class="about-breadcrumb" aria-label="Breadcrumb">
          <a href="{{ route('home') }}">Home</a><span aria-hidden="true">/</span><span>About Us</span>
        </nav>
        <h1 id="about-title">About Us</h1>
      </div>
    </section>

    <div class="about-content-wrap">
      <!-- This article can be replaced with the HTML from a rich text editor. -->
      <article class="about-richtext" aria-label="About Explore Nepal Holidays">
        <h2>Discover Nepal at your own pace</h2>
        <p>Explore Nepal Holidays helps travellers find a journey that fits their interests, time and preferred pace. From mountain trails and historic cities to wildlife lowlands, Nepal has many ways to explore.</p>
        <p>We start with what matters to you, then discuss routes, seasons and practical details so you can choose a trip with a clear picture of what it involves.</p>

        <figure>
          <img src="{{ asset('site/assets/kathmandu-stupa.jpg') }}" alt="Boudhanath Stupa and prayer flags in Kathmandu" width="1200" height="800" loading="lazy">
          <figcaption>Nepal's living heritage is part of the journey.</figcaption>
        </figure>

        <h2>What you can explore</h2>
        <p>Our travel ideas span trekking, cultural tours, wildlife experiences and tailor-made journeys. You can focus on one interest or combine several places and experiences in the time you have.</p>
        <ul>
          <li><strong>Trekking:</strong> Choose from gentler valley walks to more demanding mountain routes.</li>
          <li><strong>Culture:</strong> Spend time with Nepal's heritage, local traditions and everyday life.</li>
          <li><strong>Wildlife:</strong> Explore the forests and lowlands of the Terai.</li>
          <li><strong>Tailor-made travel:</strong> Discuss a route shaped around your own priorities.</li>
        </ul>

        <h2>Planning with the details in mind</h2>
        <p>A useful itinerary considers more than destinations. Walking hours, altitude, road travel, accommodation, permits and seasonal conditions all affect how a trip feels. We aim to make those details clear while you compare your options.</p>
        <p>Tell us when you hope to travel, how long you have and what you would most like to experience. We can then talk through a route that suits your plans.</p>

        <h2>Travel with care</h2>
        <p>Respect for local communities, shared spaces and Nepal's landscapes belongs in every journey. Good preparation also helps you travel more comfortably, especially where weather, altitude or remote roads can change the day.</p>
        <p>Ready to begin? <a href="{{ route('home') }}#journeys">Explore our journeys</a> or <a href="{{ route('home') }}#plan">share your travel ideas</a>.</p>
        <p><small>The enquiry form currently previews the process and does not send a message.</small></p>
      </article>
    </div>

    <section class="about-reviews" aria-labelledby="about-reviews-title">
      <div class="about-reviews-inner">
        <header class="about-reviews-heading">
          <div>
            <span class="about-reviews-eyebrow">WHAT OUR TRAVELERS SAY</span>
            <h2 id="about-reviews-title">Client Reviews</h2>
          </div>
          <div class="about-reviews-heading-side">
            <p>Hear from travelers who have explored Nepal with us — their experiences, challenges, and memories from the journey.</p>
            <div class="about-review-controls" aria-label="Review controls">
              <button class="about-review-control about-review-prev" type="button" aria-label="Previous review" title="Previous review">&larr;</button>
              <div class="about-review-pagination" aria-label="Choose a review"></div>
              <button class="about-review-control about-review-next" type="button" aria-label="Next review" title="Next review">&rarr;</button>
            </div>
          </div>
        </header>
        <div class="swiper about-review-swiper">
          <div class="swiper-wrapper">
            <article class="swiper-slide about-review-card">
              <div class="about-review-card__top"><span>01</span><small>CLIENT REVIEW</small></div>
              <blockquote>&ldquo;The route felt ambitious, but well paced. We wanted an Everest route that felt ambitious but still thoughtful. The itinerary gave us time to settle into the trail, enjoy Namche, and keep the mountain days manageable.&rdquo;</blockquote>
              <div class="about-review-card__source"><span aria-hidden="true">&mdash;</span>
                <div><strong>Marcus &amp; Claire Vance</strong><span>United Kingdom &middot; EBC Trek &middot; Nov 2025</span></div>
              </div>
            </article>
            <article class="swiper-slide about-review-card about-review-card--accent">
              <div class="about-review-card__top"><span>02</span><small>CLIENT REVIEW</small></div>
              <blockquote>&ldquo;First flight out to Lukla &amp; pristine safety management. Their airport connections and standby slots ensure you don&rsquo;t get trapped by Lukla weather. The food was fresh, hot, and hygienic. Our guide Dawa was patient with our 12-year-old son the whole trail.&rdquo;</blockquote>
              <div class="about-review-card__source"><span aria-hidden="true">&mdash;</span>
                <div><strong>David &amp; Sarah Henderson</strong><span>Australia &middot; EBC Family &middot; Oct 2025</span></div>
              </div>
            </article>
            <article class="swiper-slide about-review-card">
              <div class="about-review-card__top"><span>03</span><small>CLIENT REVIEW</small></div>
              <blockquote>&ldquo;True Sherpa heritage and respect for the mountains. You immediately sense the difference when booking with native Sherpas. Our porter had lightweight, proper mountain gear, and our guide treated the monasteries and trails with sacred respect. 10/10 recommendation.&rdquo;</blockquote>
              <div class="about-review-card__source"><span aria-hidden="true">&mdash;</span>
                <div><strong>Jens Lindqvist</strong><span>Sweden &middot; Annapurna Circuit &middot; Apr 2025</span></div>
              </div>
            </article>
          </div>
        </div>
      </div>
    </section>
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
