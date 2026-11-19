@extends('layouts.site')

@section('page_title', 'Contact Us | '.($siteSetting?->name ?? config('app.name', 'Explore Nepal Holidays')))
@section('meta_description', 'Contact Explore Nepal Holidays about your Nepal travel plans. View a Kathmandu map and use the enquiry form preview to share your questions.')
@section('og_image', asset('site/assets/annapurna-sunrise.jpg'))
@section('body_class', 'bg-paper text-ink font-sans')

@push('page_styles')
<link rel="stylesheet" href="{{ asset('site/styles/about.css') }}">
@endpush

@section('content')
<a class="skip-link" href="#main">Skip to content</a>
@include('site.partials.header')

  <main id="main" class="about-page">
    <section class="about-banner" aria-labelledby="contact-title">
      <div class="container">
        <nav class="about-breadcrumb" aria-label="Breadcrumb">
          <a href="{{ route('home') }}">Home</a><span aria-hidden="true">/</span><span>Contact Us</span>
        </nav>
        <h1 id="contact-title">Contact Us</h1>
      </div>
    </section>

    <section class="contact-details-section" aria-labelledby="contact-details-title">
      <div class="contact-details-inner">
        <header class="contact-details-heading">
          <span>{{ $siteSetting?->name ?? config('app.name', 'Explore Nepal Holidays') }}</span>
          <h2 id="contact-details-title">Company contact details</h2>
        </header>
        <div class="contact-details-grid">
          <article class="contact-detail">
            <h3>Location</h3>
            <p>{{ $siteSetting?->address ?: 'Contact us for location details.' }}</p>
          </article>
          <article class="contact-detail">
            <h3>Email</h3>
            <p>@if ($siteSetting?->email)<a href="mailto:{{ $siteSetting->email }}">{{ $siteSetting->email }}</a>@else Contact details coming soon @endif</p>
          </article>
          <article class="contact-detail">
            <h3>Phone</h3>
            <p>@if ($siteSetting?->phone)<a href="tel:{{ preg_replace('/[^0-9+]/', '', $siteSetting->phone) }}">{{ $siteSetting->phone }}</a>@else Contact details coming soon @endif</p>
          </article>
          <article class="contact-detail">
            <h3>Mobile / WhatsApp</h3>
            <p>@if ($siteSetting?->whatsapp_number)<a href="https://wa.me/{{ preg_replace('/\D+/', '', $siteSetting->whatsapp_number) }}">{{ $siteSetting->whatsapp_number }}</a>@else Contact details coming soon @endif</p>
          </article>
          <article class="contact-detail">
            <h3>Working hours</h3>
            <p>10:15 am–8:15 pm, daily</p>
            <small>As shown on the <a href="https://www.tripadvisor.in/Attraction_Review-g293890-d19900205-Reviews-Explore_Nepal_Holidays-Kathmandu_Kathmandu_Valley_Bagmati_Zone_Central_Region.html" target="_blank" rel="noopener noreferrer">Tripadvisor listing</a>.</small>
          </article>
        </div>
      </div>
    </section>

    <section class="contact-section" aria-labelledby="contact-section-title">
      <div class="contact-section-inner">
        <header class="contact-section-heading">
          <h2 id="contact-section-title">Talk to us about your Nepal trip</h2>
          <p>Share your travel ideas, dates and questions. We can discuss the possibilities together.</p>
        </header>
        <div class="contact-columns">
          <aside class="contact-map-panel" aria-labelledby="contact-map-title">
            <span class="contact-eyebrow">OUR LOCATION</span>
            <h3 id="contact-map-title">Kathmandu, Nepal</h3>
            <p>The map shows central Kathmandu for orientation. It does not mark a confirmed office address.</p>
            <div class="contact-map-frame">
              <iframe
                title="Map of central Kathmandu, Nepal"
                src="https://www.openstreetmap.org/export/embed.html?bbox=85.2860%2C27.6950%2C85.3540%2C27.7400&amp;layer=mapnik"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <a class="contact-map-link" href="https://www.openstreetmap.org/#map=13/27.7172/85.3240" target="_blank" rel="noopener noreferrer">View Kathmandu on OpenStreetMap <span aria-hidden="true">↗</span></a>
          </aside>

          <div class="contact-form-panel">
            <h3>Send us your questions</h3>
            <p>Tell us a little about what you are planning.</p>
            <form class="contact-form" @submit.prevent="formSubmitted = true">
              <label for="contact-full-name">Full name</label>
              <input id="contact-full-name" name="full_name" type="text" autocomplete="name" required>

              <label for="contact-email">Email address</label>
              <input id="contact-email" name="email" type="email" autocomplete="email" required>

              <div class="contact-phone-row">
                <div>
                  <label for="contact-country-code">Country code</label>
                  <input id="contact-country-code" name="country_code" type="tel" inputmode="tel" autocomplete="tel-country-code" placeholder="+977" pattern="\+[0-9]{1,4}" title="Enter a country calling code, such as +977">
                </div>
                <div>
                  <label for="contact-phone">Phone number</label>
                  <input id="contact-phone" name="phone" type="tel" inputmode="tel" autocomplete="tel-national">
                </div>
              </div>

              <label for="contact-message">Questions or comments</label>
              <textarea id="contact-message" name="message" rows="5" required></textarea>

              <button class="contact-submit" type="submit">Submit enquiry <span aria-hidden="true">↗</span></button>
            </form>
            <p class="contact-form-note">This form is not connected to a live inbox yet.</p>
            <p class="contact-form-note" role="status" x-show="formSubmitted" x-cloak>Your enquiry was not sent. Please contact us by phone or WhatsApp to continue.</p>
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
