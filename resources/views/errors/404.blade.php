@extends('layouts.site')

@section('page_title', 'Page Not Found | Explore Nepal Holidays')
@section('meta_description', 'The page you are looking for could not be found. Explore Nepal Holidays can help you find your next Nepal journey.')
@section('meta_robots', 'noindex, follow')
@section('og_image', asset('site/assets/langtang-lirung.webp'))
@section('body_class', 'package-page error-page')

@push('page_styles')
<link rel="stylesheet" href="{{ asset('site/styles/package.css') }}">
<link rel="stylesheet" href="{{ asset('site/styles/error-pages.css') }}">
@endpush

@section('content')
<a class="skip-link" href="#main">Skip to content</a>
  @include('site.partials.header')
  <main id="main" class="error-main">
    <section class="error-banner" aria-labelledby="error-title">
      <img class="error-banner-image" src="{{ asset('site/assets/langtang-lirung.webp') }}" alt="" width="1600" height="900" fetchpriority="high">
      <div class="error-banner-shade" aria-hidden="true"></div>
      <div class="error-banner-content"><nav aria-label="Breadcrumb"><a href="{{ route('home') }}">Home</a><span aria-hidden="true">/</span><span>404</span></nav><p>ERROR 404</p><h1 id="error-title">Page not found</h1><div>Looks like this trail has taken an unexpected turn.</div></div>
    </section>
    <section class="error-card" aria-labelledby="error-card-title">
      <h2 id="error-card-title">Let’s find another way</h2>
      <p class="error-copy">The page may have moved or the address may be mistyped. Let’s get you back to planning your Nepal journey.</p>
      <div class="error-actions"><a class="error-primary" href="{{ route('home') }}">Back to home</a><a class="error-secondary" href="{{ route('home') }}#journeys">Explore journeys <span aria-hidden="true">↗</span></a></div>
      <p class="error-help">Need a hand? <a href="{{ route('contact') }}">Talk with our team</a>.</p>
    </section>
  </main>
  <footer class="footer" id="footer">
    <div class="footer-main">
      <div class="container footer-main-grid">
        <div class="footer-about">
          <a class="footer-logo" href="{{ route('home') }}" aria-label="Explore Nepal Holidays, back to top"><img
              src="{{ asset('site/assets/footer-logo-compact.png') }}" alt="Explore Nepal Holidays" width="620" height="207"
              loading="lazy"></a>
          <p>For mountain days, meaningful encounters, and all the moments in between. Find your own way into Nepal.</p>
          <a class="footer-plan" href="{{ route('home') }}#plan">Start planning your journey <span
              aria-hidden="true">↗</span></a>
        </div>
        <nav class="footer-nav" aria-label="Footer exploration links">
          <h2>Explore Nepal</h2>
          <a href="{{ route('about') }}">About Us</a>
          <a href="{{ route('team') }}">Our Team</a>
          <a href="{{ route('home') }}#why-choose">Why travel with us</a>
          <a href="{{ route('contact') }}">Contact Us</a>
          <a href="{{ route('home') }}#journeys">Featured journeys</a>
          <a href="{{ route('home') }}#experiences">Ways to travel</a>
          <a href="{{ route('home') }}#why-nepal">Our approach</a>
          <a href="{{ route('home') }}#testimonials">Traveller stories</a>
          <a href="{{ route('home') }}#newsletter">Newsletter</a>
          <a href="{{ route('faq') }}">FAQs</a>
        </nav>
        <nav class="footer-nav" aria-label="Footer planning links">
          <h2>Plan your trip</h2>
          <a href="{{ route('home') }}#journeys">Trekking journeys</a>
          <a href="{{ route('home') }}#journeys">Culture &amp; heritage</a>
          <a href="{{ route('home') }}#journeys">Wildlife escapes</a>
          <a href="{{ route('home') }}#plan">Tell us your ideas</a>
        </nav>
        <div class="footer-contact-card">
          <h2>Contact</h2>
          <address class="footer-contact"><span>VISIT US</span>Thamel, Kathmandu, Nepal <small>Office address</small><span class="footer-contact-label">MESSAGE US</span><a href="https://wa.me/?text=I%27m%20planning%20a%20Langtang%20Valley%20trek." target="_blank" rel="noopener noreferrer">WhatsApp trip planning</a><small>Best for dates, group size and route questions</small></address>
          <div class="footer-social" aria-label="Social media">
            <span class="footer-social-label">FIND US ONLINE</span>
            <div class="footer-social-icons">
              <span class="social-icon social-muted" role="img" aria-label="Facebook profile"
                title="Facebook profile"><img class="package-icon-image" src="{{ asset('site/assets/icons/facebook.svg') }}" alt=""></span>
              <span class="social-icon social-muted" role="img" aria-label="Instagram profile"
                title="Instagram profile"><img class="package-icon-image" src="{{ asset('site/assets/icons/instagram.svg') }}" alt=""></span>
              <span class="social-icon social-muted" role="img" aria-label="TikTok profile"
                title="TikTok profile"><img class="package-icon-image" src="{{ asset('site/assets/icons/tiktok.svg') }}" alt=""></span>
              <span class="social-icon social-muted" role="img" aria-label="YouTube channel"
                title="YouTube channel"><img class="package-icon-image" src="{{ asset('site/assets/icons/youtube.svg') }}" alt=""></span>
              <a class="social-icon"
                href="https://wa.me/?text=I%27m%20planning%20a%20Nepal%20trip%20with%20Explore%20Nepal%20Holidays."
                target="_blank" rel="noopener noreferrer" aria-label="Share your Nepal trip plans on WhatsApp"
                title="Share your trip plans on WhatsApp"><img class="package-icon-image" src="{{ asset('site/assets/icons/whatsapp.svg') }}" alt=""></a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-resources">
      <div class="container footer-resources-grid">
        <div class="footer-resource-intro"><span class="eyebrow dark">PLAN WITH GOOD INFORMATION</span>
          <h2>Nepal travel resources</h2>
          <p>External organizations for travel, conservation and trekking guidance.</p>
        </div>
        <div class="resource-logos" aria-label="Independent Nepal travel organizations">
          <a href="https://tourism.gov.np/" target="_blank" rel="noopener noreferrer"
            title="Government of Nepal tourism ministry"><img src="{{ asset('site/assets/nepal-goverment.svg') }}"
              alt="Government of Nepal tourism ministry" width="226" height="194" loading="lazy"></a>
          <a href="https://ntb.gov.np/" target="_blank" rel="noopener noreferrer" title="Nepal Tourism Board"><img
              src="{{ asset('site/assets/ntb.svg') }}" alt="Nepal Tourism Board" width="169" height="172" loading="lazy"></a>
          <a href="https://www.nepalmountaineering.org/" target="_blank" rel="noopener noreferrer"
            title="Nepal Mountaineering Association"><img src="{{ asset('site/assets/nma.svg') }}" alt="Nepal Mountaineering Association"
              width="248" height="212" loading="lazy"></a>
          <a href="https://www.taan.org.np/" target="_blank" rel="noopener noreferrer"
            title="Trekking Agencies' Association of Nepal"><img src="{{ asset('site/assets/taan.svg') }}"
              alt="Trekking Agencies' Association of Nepal" width="158" height="213" loading="lazy"></a>
          <a href="https://keepnepal.org/" target="_blank" rel="noopener noreferrer"
            title="Kathmandu Environmental Education Project"><img src="{{ asset('site/assets/keep.webp') }}"
              alt="Kathmandu Environmental Education Project" width="124" height="48" loading="lazy"></a>
        </div>
      </div>
    </div>
    <div class="footer-base">
      <div class="container footer-base-top">
        <div><span class="footer-base-label">PAYMENT OPTIONS</span>
          <p>Card networks shown as examples. Accepted methods are confirmed before you pay.</p>
        </div><img src="{{ asset('site/assets/pay-cards01.svg') }}"
          alt="Examples of card networks: Visa, Mastercard, American Express and UnionPay" width="276" height="38"
          loading="lazy">
      </div>
      <div class="container footer-base-bottom"><span>© 2026 Explore Nepal Holidays.</span><a href="#top">Back to top
          <span aria-hidden="true">↑</span></a></div>
    </div>
  </footer>
  <div class="trip-search-backdrop" x-show="tripSearchOpen" x-cloak @click.self="closeTripSearch()"
    @keydown.tab="trapSearchTab($event)" @keydown.escape.stop="closeTripSearch()">
    <section class="trip-search-dialog" x-ref="tripSearchDialog" role="dialog" aria-modal="true"
      aria-labelledby="trip-search-title" aria-describedby="trip-search-description">
      <button class="trip-search-close" type="button" @click="closeTripSearch()"
        aria-label="Close trip search">×</button>
      <div class="trip-search-heading"><span class="eyebrow dark">FIND YOUR NEPAL JOURNEY</span>
        <h2 id="trip-search-title">Where would you like to go?</h2>
        <p id="trip-search-description">Search trekking, tour and peak climbing ideas.</p>
      </div>
      <label class="trip-search-input">
        <img class="package-icon-image package-icon-image--search" src="{{ asset('site/assets/icons/search.svg') }}" alt="">
        <span class="sr-only">Search trips and regions</span><input x-ref="tripSearchInput" type="search"
          x-model.debounce.150ms="tripSearchQuery" placeholder="Try Annapurna, wildlife or Island Peak"
          autocomplete="off"></label>
      <div class="trip-search-filters" role="group" aria-label="Filter by journey type"><button type="button"
          @click="tripSearchActivity='all'" :aria-pressed="(tripSearchActivity==='all').toString()"
          :class="tripSearchActivity==='all' ? 'active' : ''">All journeys</button><button type="button"
          @click="tripSearchActivity='Trekking'" :aria-pressed="(tripSearchActivity==='Trekking').toString()"
          :class="tripSearchActivity==='Trekking' ? 'active' : ''">Trekking</button><button type="button"
          @click="tripSearchActivity='Tours'" :aria-pressed="(tripSearchActivity==='Tours').toString()"
          :class="tripSearchActivity==='Tours' ? 'active' : ''">Tours</button><button type="button"
          @click="tripSearchActivity='Peak climbing'" :aria-pressed="(tripSearchActivity==='Peak climbing').toString()"
          :class="tripSearchActivity==='Peak climbing' ? 'active' : ''">Peak climbing</button></div>
      <div class="trip-search-results-head"><span
          x-text="tripSearchQuery ? 'SEARCH RESULTS' : 'IDEAS TO GET YOU STARTED'">IDEAS TO GET YOU STARTED</span><span
          x-text="filteredSearchTrips().length + ' ideas'">9 ideas</span></div>
      <div class="trip-search-results" aria-live="polite">
        <template x-for="trip in filteredSearchTrips()" :key="trip.activity + trip.category + trip.name"><a
            class="trip-search-result" href="{{ route('home') }}#plan" @click="selectSearchTrip(trip)"><span
              class="trip-search-result-meta"><span x-text="trip.activity">Trekking</span><span
                x-text="trip.category">Annapurna Region Trekking</span></span><strong x-text="trip.name">14 Day
              Annapurna Base Camp Trek</strong><span class="trip-search-result-arrow"
              aria-hidden="true">↗</span></a></template>
        <p class="trip-search-empty" x-show="filteredSearchTrips().length===0" x-cloak>No journeys match that
          search. Try another name or choose a different journey type.</p>
      </div>
      <p class="trip-search-note">Routes, inclusions and availability are confirmed when you enquire.</p>
    </section>
  </div>
  <div class="floating-actions">
    <a class="back-to-top" href="#top" aria-label="Back to top" title="Back to top" x-show="showBackToTop" x-cloak><img
        src="{{ asset('site/assets/explore-nepal-back-to-top-animated.gif') }}" alt="" width="384" height="384"></a>
    <a class="whatsapp-float"
      href="https://wa.me/?text=I%27m%20planning%20a%20Nepal%20trip%20with%20Explore%20Nepal%20Holidays."
      target="_blank" rel="noopener noreferrer" aria-label="Share your Nepal trip plans on WhatsApp"
      title="Share your trip plans on WhatsApp"><img class="package-icon-image" src="{{ asset('site/assets/icons/whatsapp.svg') }}" alt=""></a>
  </div>
@endsection
