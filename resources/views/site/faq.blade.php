@extends('layouts.site')

@section('page_title', 'FAQs | Explore Nepal Holidays')
@section('meta_description', 'Answers to common questions about planning trips, trekking and booking with Explore Nepal Holidays.')
@section('og_image', asset('site/assets/annapurna-sunrise.jpg'))
@section('body_class', 'bg-paper text-ink font-sans')

@push('page_styles')
<link rel="stylesheet" href="{{ asset('site/styles/about.css') }}">
<link rel="stylesheet" href="{{ asset('site/styles/faq.css') }}">
@endpush

@section('content')
<a class="skip-link" href="#main">Skip to content</a>

  <!-- Shared Global SVG Icon Sprite -->

  <!-- Reusable Topbar -->
  <div class="topbar" id="top">
    <div class="container topbar-inner flex items-center justify-between text-xs md:text-sm">
      <span>20 Years Experience</span>
      <a class="hover:text-orange-brand transition-colors" href="https://wa.me/9779800000000" target="_blank" rel="noopener noreferrer">+977-9800000000 · WhatsApp ↗</a>
    </div>
  </div>

  <!-- Reusable Site Header with Mega Menu and Responsive Navigation -->
  <header class="site-header" :class="headerCompact ? 'is-compact' : ''" @mouseleave="openNav=null">
    <div class="container header-primary flex items-center justify-between">
      <a class="brand" href="{{ route('home') }}" aria-label="Explore Nepal Holidays, home">
        <span class="brand-mark"><img src="{{ asset('site/assets/logo-mark.png') }}" alt="" width="78" height="63"></span>
        <span class="brand-name font-display">EXPLORE <small>NEPAL HOLIDAYS</small></span>
      </a>
      <div class="header-actions flex items-center gap-4">
        <button class="header-find inline-flex items-center gap-2 font-medium" type="button" @click="openTripSearch()">
          <img class="icon-img icon-img--light" src="{{ asset('site/assets/icons/search.svg') }}" alt="">
          Find a Trip
        </button>
        <a class="header-cta inline-flex items-center justify-center font-semibold text-white bg-orange-brand hover:bg-orange-hover transition-colors rounded-brand"
          href="{{ route('home') }}#plan">Plan your journey <span aria-hidden="true">↗</span></a>
      </div>
      <button class="mobile-find" type="button" @click="openTripSearch()" aria-label="Find a trip">
        <img class="icon-img icon-img--light" src="{{ asset('site/assets/icons/search.svg') }}" alt="">
      </button>
      <button class="menu-toggle" type="button" @click="menuOpen=!menuOpen;mobileSection=null;mobileRegion=null"
        :aria-expanded="menuOpen.toString()" aria-controls="mobile-menu" aria-label="Toggle menu">
        <span></span><span></span><span></span>
      </button>
    </div>

    <!-- Desktop Navigation Row -->
    <div class="header-nav-row">
      <nav class="container desktop-nav" aria-label="Primary navigation">
        <a class="compact-brand" href="{{ route('home') }}" aria-label="Explore Nepal Holidays, back to top">
          <img src="{{ asset('site/assets/logo-mark.png') }}" alt="" width="42" height="42">
        </a>
        <div class="nav-item cascade" @mouseenter="openNav='trekking';openRegion=trekRegions[0].id"
          @focusout="if(!$el.contains($event.relatedTarget)) openNav=null">
          <button type="button" data-nav-trigger="trekking" @click="openNav='trekking';openRegion=trekRegions[0].id"
            :aria-expanded="(openNav==='trekking').toString()" aria-controls="nav-trekking">Trekking in Nepal <span
              class="nav-chevron" aria-hidden="true"></span></button>
          <div id="nav-trekking" class="nav-panel cascade-panel" x-show="openNav==='trekking'" x-cloak>
            <div class="cascade-heading font-display">TREKKING REGIONS <span x-text="trekRegions.length + ' categories'"></span></div>
            <template x-for="region in trekRegions" :key="region.id">
              <div class="cascade-region" @mouseenter="openRegion=region.id" @focusin="openRegion=region.id">
                <button type="button" @click="openRegion=region.id" :aria-expanded="(openRegion===region.id).toString()"
                  :aria-controls="'region-'+region.id"><span x-text="region.name"></span><span aria-hidden="true">›</span></button>
                <div class="cascade-flyout" :id="'region-'+region.id" x-show="openRegion===region.id" x-cloak>
                  <div class="flyout-heading"><strong x-text="region.name"></strong><span x-text="region.trips.length + ' sample trek ideas'"></span></div>
                  <div class="flyout-scroll">
                    <template x-for="trip in region.trips" :key="trip">
                      <a href="{{ route('home') }}#plan" @click="chooseMenuTrip(trip)" x-text="trip"></a>
                    </template>
                  </div>
                  <div class="flyout-note">Choose a trek to add it to the demo enquiry form. Routes and availability need confirmation.</div>
                </div>
              </div>
            </template>
          </div>
        </div>
        <div class="nav-item cascade" @mouseenter="openNav='tours';openRegion=tourGroups[0].id"
          @focusout="if(!$el.contains($event.relatedTarget)) openNav=null">
          <button type="button" data-nav-trigger="tours" @click="openNav='tours';openRegion=tourGroups[0].id"
            :aria-expanded="(openNav==='tours').toString()" aria-controls="nav-tours">Tours in Nepal <span
              class="nav-chevron" aria-hidden="true"></span></button>
          <div id="nav-tours" class="nav-panel cascade-panel tour-cascade" x-show="openNav==='tours'" x-cloak>
            <div class="cascade-heading font-display">TOUR STYLES <span x-text="tourGroups.length + ' categories'"></span></div>
            <template x-for="region in tourGroups" :key="region.id">
              <div class="cascade-region" @mouseenter="openRegion=region.id" @focusin="openRegion=region.id">
                <button type="button" @click="openRegion=region.id" :aria-expanded="(openRegion===region.id).toString()"
                  :aria-controls="'tour-region-'+region.id"><span x-text="region.name"></span><span aria-hidden="true">›</span></button>
                <div class="cascade-flyout" :id="'tour-region-'+region.id" x-show="openRegion===region.id" x-cloak>
                  <div class="flyout-heading"><strong x-text="region.name"></strong><span x-text="region.trips.length + ' sample tour ideas'"></span></div>
                  <div class="flyout-scroll">
                    <template x-for="trip in region.trips" :key="trip">
                      <a href="{{ route('home') }}#plan" @click="chooseMenuTrip(trip)" x-text="trip"></a>
                    </template>
                  </div>
                  <div class="flyout-note">Choose a tour to add it to the demo enquiry form.</div>
                </div>
              </div>
            </template>
          </div>
        </div>
        <div class="nav-item cascade" @mouseenter="openNav='climbing';openRegion=climbingGroups[0].id"
          @focusout="if(!$el.contains($event.relatedTarget)) openNav=null">
          <button type="button" data-nav-trigger="climbing" @click="openNav='climbing';openRegion=climbingGroups[0].id"
            :aria-expanded="(openNav==='climbing').toString()" aria-controls="nav-climbing">Peak Climbing Nepal <span
              class="nav-chevron" aria-hidden="true"></span></button>
          <div id="nav-climbing" class="nav-panel cascade-panel climbing-cascade" x-show="openNav==='climbing'" x-cloak>
            <div class="cascade-heading font-display">CLIMBING REGIONS <span x-text="climbingGroups.length + ' categories'"></span></div>
            <template x-for="region in climbingGroups" :key="region.id">
              <div class="cascade-region" @mouseenter="openRegion=region.id" @focusin="openRegion=region.id">
                <button type="button" @click="openRegion=region.id" :aria-expanded="(openRegion===region.id).toString()"
                  :aria-controls="'climb-region-'+region.id"><span x-text="region.name"></span><span aria-hidden="true">›</span></button>
                <div class="cascade-flyout" :id="'climb-region-'+region.id" x-show="openRegion===region.id" x-cloak>
                  <div class="flyout-heading"><strong x-text="region.name"></strong><span x-text="region.trips.length + ' peak ideas'"></span></div>
                  <div class="flyout-scroll">
                    <template x-for="trip in region.trips" :key="trip">
                      <a href="{{ route('home') }}#plan" @click="chooseMenuTrip(trip)" x-text="trip"></a>
                    </template>
                  </div>
                  <div class="flyout-note">Climbing plans depend on experience, conditions and permits.</div>
                </div>
              </div>
            </template>
          </div>
        </div>
        <div class="nav-item compact" @mouseenter="openNav='company'"
          @focusout="if(!$el.contains($event.relatedTarget)) openNav=null">
          <button type="button" data-nav-trigger="company" @click="openNav='company'"
            :aria-expanded="(openNav==='company').toString()" aria-controls="nav-company">Company <span
              class="nav-chevron" aria-hidden="true"></span></button>
          <div id="nav-company" class="nav-panel dropdown-panel" x-show="openNav==='company'" x-cloak>
            <a href="{{ route('about') }}" @click="closeNav()">About Us ↗</a>
            <a href="{{ route('team') }}" @click="closeNav()">Our Team ↗</a>
            <a href="{{ route('home') }}#why-choose" @click="closeNav()">Why travel with us ↗</a>
            <a href="{{ route('home') }}#why-nepal" @click="closeNav()">Our approach ↗</a>
            <a href="{{ route('home') }}#intro" @click="closeNav()">Why travel Nepal ↗</a>
            <a href="{{ route('home') }}#testimonials" @click="closeNav()">Traveller stories ↗</a>
          </div>
        </div>
        <div class="nav-item compact" @mouseenter="openNav='info'"
          @focusout="if(!$el.contains($event.relatedTarget)) openNav=null">
          <button type="button" data-nav-trigger="info" @click="openNav='info'"
            :aria-expanded="(openNav==='info').toString()" aria-controls="nav-info">Travel Info <span
              class="nav-chevron" aria-hidden="true"></span></button>
          <div id="nav-info" class="nav-panel dropdown-panel" x-show="openNav==='info'" x-cloak>
            <a href="{{ route('faq') }}#planning" @click="closeNav()">Best time to visit ↗</a>
            <a href="{{ route('faq') }}#trekking" @click="closeNav()">Trekking experience ↗</a>
            <a href="{{ route('home') }}#combine-trips" @click="closeNav()">Combining experiences ↗</a>
            <a href="{{ route('faq') }}" @click="closeNav()">Frequently asked questions ↗</a>
          </div>
        </div>
        <a class="nav-contact" href="{{ route('contact') }}" @mouseenter="openNav=null">Contact Us <span aria-hidden="true">↗</span></a>
        <button class="nav-find" type="button" @click="openTripSearch()" aria-label="Find a trip">
          <img class="icon-img icon-img--light" src="{{ asset('site/assets/icons/search.svg') }}" alt="">
        </button>
      </nav>
    </div>

    <!-- Mobile Navigation -->
    <nav id="mobile-menu" class="mobile-nav" aria-label="Mobile navigation" x-show="menuOpen" x-cloak>
      <div class="mobile-menu-intro font-display">EXPLORE NEPAL YOUR WAY</div>
      <div class="mobile-nav-group">
        <button type="button" @click="toggleMobileSection('trekking')"
          :aria-expanded="(mobileSection==='trekking').toString()" aria-controls="mobile-trekking">Trekking in Nepal <span aria-hidden="true">+</span></button>
        <div id="mobile-trekking" class="mobile-subnav" x-show="mobileSection==='trekking'" x-cloak>
          <p>Explore sample trek ideas by region.</p>
          <template x-for="region in trekRegions" :key="region.id">
            <div class="mobile-region">
              <button type="button" @click="toggleMobileRegion(region.id)"
                :aria-expanded="(mobileRegion===region.id).toString()" :aria-controls="'mobile-region-'+region.id"><span x-text="region.name"></span><span aria-hidden="true">+</span></button>
              <div class="mobile-trip-list" :id="'mobile-region-'+region.id" x-show="mobileRegion===region.id" x-cloak>
                <template x-for="trip in region.trips" :key="trip">
                  <a href="{{ route('home') }}#plan" @click="chooseMenuTrip(trip)" x-text="trip"></a>
                </template>
              </div>
            </div>
          </template>
        </div>
      </div>
      <div class="mobile-nav-group">
        <button type="button" @click="toggleMobileSection('tours')"
          :aria-expanded="(mobileSection==='tours').toString()" aria-controls="mobile-tours">Tours in Nepal <span aria-hidden="true">+</span></button>
        <div id="mobile-tours" class="mobile-subnav" x-show="mobileSection==='tours'" x-cloak>
          <p>Explore sample tour ideas by theme.</p>
          <template x-for="region in tourGroups" :key="region.id">
            <div class="mobile-region">
              <button type="button" @click="toggleMobileRegion(region.id)"
                :aria-expanded="(mobileRegion===region.id).toString()" :aria-controls="'mobile-tour-'+region.id"><span x-text="region.name"></span><span aria-hidden="true">+</span></button>
              <div class="mobile-trip-list" :id="'mobile-tour-'+region.id" x-show="mobileRegion===region.id" x-cloak>
                <template x-for="trip in region.trips" :key="trip">
                  <a href="{{ route('home') }}#plan" @click="chooseMenuTrip(trip)" x-text="trip"></a>
                </template>
              </div>
            </div>
          </template>
        </div>
      </div>
      <div class="mobile-nav-group">
        <button type="button" @click="toggleMobileSection('climbing')"
          :aria-expanded="(mobileSection==='climbing').toString()" aria-controls="mobile-climbing">Peak Climbing Nepal <span aria-hidden="true">+</span></button>
        <div id="mobile-climbing" class="mobile-subnav" x-show="mobileSection==='climbing'" x-cloak>
          <p>Explore climbing ideas by region.</p>
          <template x-for="region in climbingGroups" :key="region.id">
            <div class="mobile-region">
              <button type="button" @click="toggleMobileRegion(region.id)"
                :aria-expanded="(mobileRegion===region.id).toString()" :aria-controls="'mobile-climb-'+region.id"><span x-text="region.name"></span><span aria-hidden="true">+</span></button>
              <div class="mobile-trip-list" :id="'mobile-climb-'+region.id" x-show="mobileRegion===region.id" x-cloak>
                <template x-for="trip in region.trips" :key="trip">
                  <a href="{{ route('home') }}#plan" @click="chooseMenuTrip(trip)" x-text="trip"></a>
                </template>
              </div>
            </div>
          </template>
        </div>
      </div>
      <div class="mobile-nav-group">
        <button type="button" @click="toggleMobileSection('company')"
          :aria-expanded="(mobileSection==='company').toString()" aria-controls="mobile-company">Company <span aria-hidden="true">+</span></button>
        <div id="mobile-company" class="mobile-subnav" x-show="mobileSection==='company'" x-cloak>
          <a href="{{ route('about') }}" @click="menuOpen=false">About Us</a>
          <a href="{{ route('team') }}" @click="menuOpen=false">Our Team</a>
          <a href="{{ route('home') }}#why-choose" @click="menuOpen=false">Why travel with us</a>
          <a href="{{ route('home') }}#why-nepal" @click="menuOpen=false">Our approach</a>
          <a href="{{ route('home') }}#intro" @click="menuOpen=false">Why Nepal</a>
          <a href="{{ route('home') }}#testimonials" @click="menuOpen=false">Traveller stories</a>
        </div>
      </div>
      <div class="mobile-nav-group">
        <button type="button" @click="toggleMobileSection('info')"
          :aria-expanded="(mobileSection==='info').toString()" aria-controls="mobile-info">Travel Info <span aria-hidden="true">+</span></button>
        <div id="mobile-info" class="mobile-subnav" x-show="mobileSection==='info'" x-cloak>
          <a href="{{ route('faq') }}#planning" @click="menuOpen=false">Best time to visit</a>
          <a href="{{ route('faq') }}#trekking" @click="menuOpen=false">Trekking experience</a>
          <a href="{{ route('faq') }}" @click="menuOpen=false">All FAQs</a>
        </div>
      </div>
      <a class="mobile-contact font-semibold text-white bg-orange-brand" href="{{ route('contact') }}" @click="menuOpen=false">Contact Us <span aria-hidden="true">↗</span></a>
    </nav>
  </header>

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
  <footer class="footer" id="footer">
    <div class="footer-main">
      <div class="container footer-main-grid">
        <div class="footer-about">
          <a class="footer-logo" href="{{ route('home') }}" aria-label="Explore Nepal Holidays, back to top">
            <img src="{{ asset('site/assets/footer-logo-compact.png') }}" alt="Explore Nepal Holidays" width="620" height="207" loading="lazy">
          </a>
          <p>For mountain days, meaningful encounters, and all the moments in between. Find your own way into Nepal.</p>
          <a class="footer-plan" href="{{ route('home') }}#plan">Start planning your journey <span aria-hidden="true">↗</span></a>
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
          <address class="footer-contact">
            <span>VISIT US</span>Thamel, Kathmandu, Nepal <small>Sample office address</small>
            <span class="footer-contact-label">CALL US</span><a href="tel:+9779800000000">+977 980-000-0000</a><small>Sample contact number</small>
          </address>
          <div class="footer-social" aria-label="Social media">
            <span class="footer-social-label">FIND US ONLINE</span>
            <div class="footer-social-icons">
              <span class="social-icon social-pending" role="img" aria-label="Facebook profile link pending" title="Facebook profile link pending"><img class="icon-img icon-img--dark" src="{{ asset('site/assets/icons/facebook.svg') }}" alt=""></span>
              <span class="social-icon social-pending" role="img" aria-label="Instagram profile link pending" title="Instagram profile link pending"><img class="icon-img icon-img--dark" src="{{ asset('site/assets/icons/instagram.svg') }}" alt=""></span>
              <span class="social-icon social-pending" role="img" aria-label="TikTok profile link pending" title="TikTok profile link pending"><img class="icon-img icon-img--dark" src="{{ asset('site/assets/icons/tiktok.svg') }}" alt=""></span>
              <span class="social-icon social-pending" role="img" aria-label="YouTube channel link pending" title="YouTube channel link pending"><img class="icon-img icon-img--dark" src="{{ asset('site/assets/icons/youtube.svg') }}" alt=""></span>
              <a class="social-icon" href="https://wa.me/?text=I%27m%20planning%20a%20Nepal%20trip%20with%20Explore%20Nepal%20Holidays." target="_blank" rel="noopener noreferrer" aria-label="Share your Nepal trip plans on WhatsApp" title="Share your trip plans on WhatsApp"><img class="icon-img icon-img--dark" src="{{ asset('site/assets/icons/whatsapp.svg') }}" alt=""></a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-resources">
      <div class="container footer-resources-grid">
        <div class="footer-resource-intro">
          <span class="eyebrow dark">PLAN WITH GOOD INFORMATION</span>
          <h2>Nepal travel resources</h2>
          <p>External organizations for travel, conservation and trekking guidance.</p>
        </div>
        <div class="resource-logos" aria-label="Independent Nepal travel organizations">
          <a href="https://tourism.gov.np/" target="_blank" rel="noopener noreferrer" title="Government of Nepal tourism ministry"><img src="{{ asset('site/assets/nepal-goverment.svg') }}" alt="Government of Nepal tourism ministry" width="226" height="194" loading="lazy"></a>
          <a href="https://ntb.gov.np/" target="_blank" rel="noopener noreferrer" title="Nepal Tourism Board"><img src="{{ asset('site/assets/ntb.svg') }}" alt="Nepal Tourism Board" width="169" height="172" loading="lazy"></a>
          <a href="https://www.nepalmountaineering.org/" target="_blank" rel="noopener noreferrer" title="Nepal Mountaineering Association"><img src="{{ asset('site/assets/nma.svg') }}" alt="Nepal Mountaineering Association" width="248" height="212" loading="lazy"></a>
          <a href="https://www.taan.org.np/" target="_blank" rel="noopener noreferrer" title="Trekking Agencies' Association of Nepal"><img src="{{ asset('site/assets/taan.svg') }}" alt="Trekking Agencies' Association of Nepal" width="158" height="213" loading="lazy"></a>
          <a href="https://keepnepal.org/" target="_blank" rel="noopener noreferrer" title="Kathmandu Environmental Education Project"><img src="{{ asset('site/assets/keep.webp') }}" alt="Kathmandu Environmental Education Project" width="124" height="48" loading="lazy"></a>
        </div>
      </div>
    </div>
    <div class="footer-base">
      <div class="container footer-base-top">
        <div>
          <span class="footer-base-label">PAYMENT OPTIONS</span>
          <p>Card networks shown as examples. Accepted methods are confirmed before you pay.</p>
        </div>
        <img src="{{ asset('site/assets/pay-cards01.svg') }}" alt="Examples of card networks: Visa, Mastercard, American Express and UnionPay" width="276" height="38" loading="lazy">
      </div>
      <div class="container footer-base-bottom">
        <span>© 2026 Explore Nepal Holidays.</span>
        <a href="#top">Back to top <span aria-hidden="true">↑</span></a>
      </div>
    </div>
  </footer>

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
