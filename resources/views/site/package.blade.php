@extends('layouts.site')

@section('page_title', 'Langtang Valley Trek | 11-Day Package | Explore Nepal Holidays')
@section('meta_description', "Explore the 11-day Langtang Valley Trek with forest trails, Tamang villages, Kyanjin Gompa, itinerary highlights and enquiry options.")
@section('og_image', asset('site/assets/langtang-lirung.webp'))
@section('body_class', 'package-page')

@push('page_styles')
<link rel="stylesheet" href="{{ asset('site/styles/package.css') }}">
@endpush

@push('page_scripts')
<script src="{{ asset('site/scripts/package.js') }}"></script>
@endpush

@section('content')
<a class="skip-link" href="#main">Skip to content</a>
  <div class="topbar" id="top">
    <div class="container topbar-inner"><span>20 Years Experience</span><a
      href="https://wa.me/9779800000000" target="_blank" rel="noopener noreferrer">+977-9800000000 · WhatsApp ↗</a></div>
  </div>
  <header class="site-header" :class="headerCompact ? 'is-compact' : ''" @mouseleave="openNav=null">
    <div class="container header-primary">
      <a class="brand" href="{{ route('home') }}" aria-label="Explore Nepal Holidays, home"><span class="brand-mark"><img
            src="{{ asset('site/assets/logo-mark.png') }}" alt="" width="78" height="63"></span><span class="brand-name">EXPLORE
          <small>NEPAL HOLIDAYS</small></span></a>
      <div class="header-actions flex items-center gap-3"><button
          class="header-find inline-flex items-center gap-2 font-medium transition-colors" type="button"
          @click="openTripSearch()">
          <img class="package-icon-image package-icon-image--search" src="{{ asset('site/assets/icons/search.svg') }}" alt="">Find a Trip</button><a
          class="header-cta inline-flex items-center justify-center font-semibold text-white bg-orange-brand hover:bg-orange-hover transition-colors rounded-brand"
          href="{{ route('home') }}#plan">Plan your journey <span aria-hidden="true">↗</span></a></div>
      <button class="mobile-find" type="button" @click="openTripSearch()" aria-label="Find a trip">
      <img class="package-icon-image package-icon-image--search" src="{{ asset('site/assets/icons/search.svg') }}" alt=""></button>
      <button class="menu-toggle" type="button" @click="menuOpen=!menuOpen;mobileSection=null;mobileRegion=null"
        :aria-expanded="menuOpen.toString()" aria-controls="mobile-menu"
        aria-label="Toggle menu"><span></span><span></span><span></span></button>
    </div>
    <div class="header-nav-row">
      <nav class="container desktop-nav" aria-label="Primary navigation">
        <a class="compact-brand" href="{{ route('home') }}" aria-label="Explore Nepal Holidays, back to top"><img
            src="{{ asset('site/assets/logo-mark.png') }}" alt="" width="42" height="42"></a>
        <div class="nav-item cascade" @mouseenter="openNav='trekking';openRegion=trekRegions[0].id"
          @focusout="if(!$el.contains($event.relatedTarget)) openNav=null">
          <button type="button" data-nav-trigger="trekking" @click="openNav='trekking';openRegion=trekRegions[0].id"
            :aria-expanded="(openNav==='trekking').toString()" aria-controls="nav-trekking">Trekking in Nepal <span
              class="nav-chevron" aria-hidden="true"></span></button>
          <div id="nav-trekking" class="nav-panel cascade-panel" x-show="openNav==='trekking'" x-cloak>
            <div class="cascade-heading">TREKKING REGIONS <span x-text="trekRegions.length + ' categories'"></span>
            </div>
            <template x-for="region in trekRegions" :key="region.id">
              <div class="cascade-region" @mouseenter="openRegion=region.id" @focusin="openRegion=region.id">
                <button type="button" @click="openRegion=region.id" :aria-expanded="(openRegion===region.id).toString()"
                  :aria-controls="'region-'+region.id"><span x-text="region.name"></span><span
                    aria-hidden="true">›</span></button>
                <div class="cascade-flyout" :id="'region-'+region.id" x-show="openRegion===region.id" x-cloak>
                  <div class="flyout-heading"><strong x-text="region.name"></strong><span
                      x-text="region.trips.length + ' trek ideas'"></span></div>
                  <div class="flyout-scroll"><template x-for="trip in region.trips" :key="trip"><a
                        href="{{ route('home') }}#plan" @click="chooseMenuTrip(trip)" x-text="trip"></a></template></div>
                  <div class="flyout-note">Choose a trek to add it to your enquiry. Routes and availability
                    need confirmation.</div>
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
            <div class="cascade-heading">TOUR STYLES <span x-text="tourGroups.length + ' categories'"></span></div>
            <template x-for="region in tourGroups" :key="region.id">
              <div class="cascade-region" @mouseenter="openRegion=region.id" @focusin="openRegion=region.id"><button
                  type="button" @click="openRegion=region.id" :aria-expanded="(openRegion===region.id).toString()"
                  :aria-controls="'tour-region-'+region.id"><span x-text="region.name"></span><span
                    aria-hidden="true">›</span></button>
                <div class="cascade-flyout" :id="'tour-region-'+region.id" x-show="openRegion===region.id" x-cloak>
                  <div class="flyout-heading"><strong x-text="region.name"></strong><span
                      x-text="region.trips.length + ' tour ideas'"></span></div>
                  <div class="flyout-scroll"><template x-for="trip in region.trips" :key="trip"><a
                        href="{{ route('home') }}#plan" @click="chooseMenuTrip(trip)" x-text="trip"></a></template></div>
                  <div class="flyout-note">Choose a tour to add it to your enquiry.</div>
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
            <div class="cascade-heading">CLIMBING REGIONS <span x-text="climbingGroups.length + ' categories'"></span>
            </div>
            <template x-for="region in climbingGroups" :key="region.id">
              <div class="cascade-region" @mouseenter="openRegion=region.id" @focusin="openRegion=region.id"><button
                  type="button" @click="openRegion=region.id" :aria-expanded="(openRegion===region.id).toString()"
                  :aria-controls="'climb-region-'+region.id"><span x-text="region.name"></span><span
                    aria-hidden="true">›</span></button>
                <div class="cascade-flyout" :id="'climb-region-'+region.id" x-show="openRegion===region.id" x-cloak>
                  <div class="flyout-heading"><strong x-text="region.name"></strong><span
                      x-text="region.trips.length + ' peak ideas'"></span></div>
                  <div class="flyout-scroll"><template x-for="trip in region.trips" :key="trip"><a
                        href="{{ route('home') }}#plan" @click="chooseMenuTrip(trip)" x-text="trip"></a></template></div>
                  <div class="flyout-note">Climbing plans depend on experience, conditions and permits.</div>
                </div>
              </div>
            </template>
          </div>
        </div>
        <div class="nav-item compact" @mouseenter="openNav='company'"
          @focusout="if(!$el.contains($event.relatedTarget)) openNav=null"><button type="button"
            data-nav-trigger="company" @click="openNav='company'" :aria-expanded="(openNav==='company').toString()"
            aria-controls="nav-company">Company <span class="nav-chevron" aria-hidden="true"></span></button>
          <div id="nav-company" class="nav-panel dropdown-panel" x-show="openNav==='company'" x-cloak><a href="{{ route('about') }}" @click="closeNav()">About Us ↗</a><a href="{{ route('team') }}" @click="closeNav()">Our Team ↗</a><a href="{{ route('home') }}#why-choose" @click="closeNav()">Why travel with us ↗</a><a
              href="{{ route('home') }}#why-nepal" @click="closeNav()">Our approach ↗</a><a href="{{ route('home') }}#intro"
              @click="closeNav()">Why travel
              Nepal ↗</a><a href="{{ route('home') }}#testimonials" @click="closeNav()">Traveller stories ↗</a></div>
        </div>
        <div class="nav-item compact" @mouseenter="openNav='info'"
          @focusout="if(!$el.contains($event.relatedTarget)) openNav=null"><button type="button" data-nav-trigger="info"
            @click="openNav='info'" :aria-expanded="(openNav==='info').toString()" aria-controls="nav-info">Travel Info
            <span class="nav-chevron" aria-hidden="true"></span></button>
          <div id="nav-info" class="nav-panel dropdown-panel" x-show="openNav==='info'" x-cloak><a
              href="{{ route('faq') }}#planning" @click="closeNav()">Best time to visit ↗</a><a
              href="{{ route('faq') }}#trekking" @click="closeNav()">Trekking
              experience ↗</a><a href="{{ route('home') }}#combine-trips" @click="closeNav()">Combining experiences ↗</a><a
              href="{{ route('faq') }}" @click="closeNav()">Frequently asked questions ↗</a></div>
        </div>
        <a class="nav-contact" href="{{ route('contact') }}" @mouseenter="openNav=null">Contact Us <span
            aria-hidden="true">↗</span></a>
        <button class="nav-find" type="button" @click="openTripSearch()" aria-label="Find a trip">
        <img class="package-icon-image package-icon-image--search" src="{{ asset('site/assets/icons/search.svg') }}" alt=""></button>
      </nav>
    </div>
    <nav id="mobile-menu" class="mobile-nav" aria-label="Mobile navigation" x-show="menuOpen" x-cloak>
      <div class="mobile-menu-intro">EXPLORE NEPAL YOUR WAY</div>
      <div class="mobile-nav-group"><button type="button" @click="toggleMobileSection('trekking')"
          :aria-expanded="(mobileSection==='trekking').toString()" aria-controls="mobile-trekking">Trekking in Nepal
          <span aria-hidden="true">+</span></button>
        <div id="mobile-trekking" class="mobile-subnav" x-show="mobileSection==='trekking'" x-cloak>
          <p>Explore trek ideas by region.</p><template x-for="region in trekRegions" :key="region.id">
            <div class="mobile-region"><button type="button" @click="toggleMobileRegion(region.id)"
                :aria-expanded="(mobileRegion===region.id).toString()" :aria-controls="'mobile-region-'+region.id"><span
                  x-text="region.name"></span><span aria-hidden="true">+</span></button>
              <div class="mobile-trip-list" :id="'mobile-region-'+region.id" x-show="mobileRegion===region.id" x-cloak>
                <template x-for="trip in region.trips" :key="trip"><a href="{{ route('home') }}#plan"
                    @click="chooseMenuTrip(trip)" x-text="trip"></a></template>
              </div>
            </div>
          </template>
        </div>
      </div>
      <div class="mobile-nav-group"><button type="button" @click="toggleMobileSection('tours')"
          :aria-expanded="(mobileSection==='tours').toString()" aria-controls="mobile-tours">Tours in Nepal <span
            aria-hidden="true">+</span></button>
        <div id="mobile-tours" class="mobile-subnav" x-show="mobileSection==='tours'" x-cloak>
          <p>Explore tour ideas by theme.</p><template x-for="region in tourGroups" :key="region.id">
            <div class="mobile-region"><button type="button" @click="toggleMobileRegion(region.id)"
                :aria-expanded="(mobileRegion===region.id).toString()" :aria-controls="'mobile-tour-'+region.id"><span
                  x-text="region.name"></span><span aria-hidden="true">+</span></button>
              <div class="mobile-trip-list" :id="'mobile-tour-'+region.id" x-show="mobileRegion===region.id" x-cloak>
                <template x-for="trip in region.trips" :key="trip"><a href="{{ route('home') }}#plan"
                    @click="chooseMenuTrip(trip)" x-text="trip"></a></template>
              </div>
            </div>
          </template>
        </div>
      </div>
      <div class="mobile-nav-group"><button type="button" @click="toggleMobileSection('climbing')"
          :aria-expanded="(mobileSection==='climbing').toString()" aria-controls="mobile-climbing">Peak Climbing Nepal
          <span aria-hidden="true">+</span></button>
        <div id="mobile-climbing" class="mobile-subnav" x-show="mobileSection==='climbing'" x-cloak>
          <p>Explore climbing ideas by region.</p><template x-for="region in climbingGroups" :key="region.id">
            <div class="mobile-region"><button type="button" @click="toggleMobileRegion(region.id)"
                :aria-expanded="(mobileRegion===region.id).toString()" :aria-controls="'mobile-climb-'+region.id"><span
                  x-text="region.name"></span><span aria-hidden="true">+</span></button>
              <div class="mobile-trip-list" :id="'mobile-climb-'+region.id" x-show="mobileRegion===region.id" x-cloak>
                <template x-for="trip in region.trips" :key="trip"><a href="{{ route('home') }}#plan"
                    @click="chooseMenuTrip(trip)" x-text="trip"></a></template>
              </div>
            </div>
          </template>
        </div>
      </div>
      <div class="mobile-nav-group"><button type="button" @click="toggleMobileSection('company')"
          :aria-expanded="(mobileSection==='company').toString()" aria-controls="mobile-company">Company <span
            aria-hidden="true">+</span></button>
        <div id="mobile-company" class="mobile-subnav" x-show="mobileSection==='company'" x-cloak><a href="{{ route('about') }}" @click="menuOpen=false">About Us</a><a href="{{ route('team') }}" @click="menuOpen=false">Our Team</a><a href="{{ route('home') }}#why-choose" @click="menuOpen=false">Why travel with us</a><a
            href="{{ route('home') }}#why-nepal" @click="menuOpen=false">Our approach</a><a href="{{ route('home') }}#intro"
            @click="menuOpen=false">Why Nepal</a><a href="{{ route('home') }}#testimonials" @click="menuOpen=false">Traveller
            stories</a></div>
      </div>
      <div class="mobile-nav-group"><button type="button" @click="toggleMobileSection('info')"
          :aria-expanded="(mobileSection==='info').toString()" aria-controls="mobile-info">Travel Info <span
            aria-hidden="true">+</span></button>
        <div id="mobile-info" class="mobile-subnav" x-show="mobileSection==='info'" x-cloak><a
            href="{{ route('faq') }}#planning" @click="menuOpen=false">Best time to visit</a><a
            href="{{ route('faq') }}#trekking" @click="menuOpen=false">Trekking
            experience</a><a href="{{ route('faq') }}" @click="menuOpen=false">All FAQs</a></div>
      </div>
      <a class="mobile-contact" href="{{ route('contact') }}" @click="menuOpen=false">Contact Us <span aria-hidden="true">↗</span></a>
    </nav>
  </header>
  <main id="main">
    <section class="package-hero" aria-labelledby="package-title">
      <div class="package-hero__inner">
        <nav class="package-hero__breadcrumbs" aria-label="Breadcrumb">
          <a href="{{ route('home') }}">Home</a>
          <span aria-hidden="true">/</span>
          <a href="{{ route('home') }}#expeditions">Trekking in Nepal</a>
          <span aria-hidden="true">/</span>
          <a href="{{ route('home') }}#expeditions">Langtang Region</a>
          <span aria-hidden="true">/</span>
          <span>Langtang Valley Trek</span>
        </nav>

        <div class="package-hero__grid">
          <div class="package-hero__copy">
            <div class="package-hero__badges" aria-label="Trip highlights">
              <span>Classic Valley Trek</span>
              <span>Road Access From Kathmandu</span>
              <span>Tea Houses &amp; Local Lodges</span>
            </div>
            <p class="package-hero__kicker">Langtang Region / 11 Days</p>
            <h1 id="package-title">Langtang Valley Trek</h1>
            <div class="package-hero__actions">
              <a class="package-button package-button--orange" href="#sidebar-booking-form">Book this trek <span aria-hidden="true">&rarr;</span></a>
              <a class="package-text-link" href="#itinerary">View itinerary <span aria-hidden="true">&darr;</span></a>
            </div>
            <div class="package-share" aria-label="Share this trek">
              <span>SHARE THIS TREK</span>
              <a class="package-share__link" href="#" data-share="facebook" target="_blank" rel="noopener noreferrer" aria-label="Share Langtang Valley Trek on Facebook" title="Share on Facebook"><img class="package-icon-image" src="{{ asset('site/assets/icons/facebook.svg') }}" alt=""></a>
              <a class="package-share__link" href="#" data-share="whatsapp" target="_blank" rel="noopener noreferrer" aria-label="Share Langtang Valley Trek on WhatsApp" title="Share on WhatsApp"><img class="package-icon-image" src="{{ asset('site/assets/icons/whatsapp.svg') }}" alt=""></a>
              <a class="package-share__link package-share__email" href="#" data-share="email" aria-label="Share Langtang Valley Trek by email" title="Share by email"><span aria-hidden="true">✉</span></a>
            </div>
          </div>

          <div class="package-hero__media package-gallery" data-package-gallery role="region" aria-label="Nepal journey photo gallery" aria-roledescription="carousel">
            <div class="package-gallery__frame">
              <figure class="package-gallery__slide" role="group" aria-roledescription="slide" aria-label="1 of 3">
                <img src="{{ asset('site/assets/langtang-lirung.webp') }}" alt="Snowy Langtang Lirung and surrounding Himalayan peaks" width="1200" height="675" fetchpriority="high">
                <figcaption><span>Langtang Lirung</span><strong>Mountain views above the valley</strong></figcaption>
              </figure>
              <figure class="package-gallery__slide" role="group" aria-roledescription="slide" aria-label="2 of 3" hidden>
                <img src="{{ asset('site/assets/langtang-kyanjin-village.webp') }}" alt="Kyanjin Gompa village beneath snowy peaks in Langtang Valley" width="1200" height="900" loading="lazy">
                <figcaption><span>Kyanjin Gompa</span><strong>Village life in the high valley</strong></figcaption>
              </figure>
              <figure class="package-gallery__slide" role="group" aria-roledescription="slide" aria-label="3 of 3" hidden>
                <img src="{{ asset('site/assets/kathmandu-stupa.jpg') }}" alt="Boudhanath Stupa with prayer flags in Kathmandu" width="1200" height="800" loading="lazy">
                <figcaption><span>Begin in Kathmandu</span><strong>Culture before the trail</strong></figcaption>
              </figure>
            </div>
            <div class="package-gallery__toolbar" role="group" aria-label="Photo controls">
              <div class="package-gallery__dots" role="group" aria-label="Choose a photo">
                <button type="button" class="is-active" aria-label="Show photo 1: Langtang Lirung" aria-pressed="true" data-package-gallery-dot="0"></button>
                <button type="button" aria-label="Show photo 2: Kyanjin Gompa village" aria-pressed="false" data-package-gallery-dot="1"></button>
                <button type="button" aria-label="Show photo 3: Kathmandu stupa" aria-pressed="false" data-package-gallery-dot="2"></button>
              </div>
              <div class="package-gallery__arrows">
                <button type="button" aria-label="Previous photo" data-package-gallery-prev><span aria-hidden="true">&larr;</span></button>
                <button type="button" aria-label="Next photo" data-package-gallery-next><span aria-hidden="true">&rarr;</span></button>
              </div>
            </div>
          </div>
        </div>

        <div class="package-hero__stats" aria-label="Quick trip facts">
          <div><span><i data-lucide="calendar-days" aria-hidden="true"></i>Duration</span><strong>11 days / 10 nights</strong></div>
          <div><span><i data-lucide="mountain" aria-hidden="true"></i>Max altitude</span><strong>3,870 m</strong></div>
          <div><span><i data-lucide="gauge" aria-hidden="true"></i>Trek grade</span><strong>Moderate</strong></div>
          <div><span><i data-lucide="bed-double" aria-hidden="true"></i>Accommodation</span><strong>Tea houses &amp; lodges</strong></div>
          <div><span><i data-lucide="sun" aria-hidden="true"></i>Best season</span><strong>Mar-May / Sep-Dec</strong></div>
          <div><span><i data-lucide="users-round" aria-hidden="true"></i>Group size</span><strong>2 to 12 trekkers</strong></div>
        </div>
      </div>
    </section>
    <section class="package-layout package-section" aria-label="Langtang Valley Trek details">
      <div class="package-container package-layout__grid" data-aos="fade-up">
        <div class="package-main">
          <nav class="package-subnav" aria-label="Package sections" data-package-subnav>
            <div class="package-subnav__inner">
              <a class="is-active" href="#overview" data-package-tab aria-label="Overview" aria-current="location"><i class="package-tab-icon" data-lucide="compass" aria-hidden="true"></i><span>Overview</span></a>
              <a href="#itinerary" data-package-tab aria-label="Itinerary"><i class="package-tab-icon" data-lucide="list-ordered" aria-hidden="true"></i><span>Itinerary</span></a>
              <a href="#route-map" data-package-tab aria-label="Route map"><i class="package-tab-icon" data-lucide="map" aria-hidden="true"></i><span>Route map</span></a>
              <a href="#elevation" data-package-tab aria-label="Elevation profile"><i class="package-tab-icon" data-lucide="mountain" aria-hidden="true"></i><span class="package-tab-label-full">Elevation profile</span><span class="package-tab-label-short">Elevation</span></a>
              <a href="#dates" data-package-tab aria-label="Departure dates"><i class="package-tab-icon" data-lucide="calendar-days" aria-hidden="true"></i><span class="package-tab-label-full">Departure dates</span><span class="package-tab-label-short">Departures</span></a>
              <a href="#included" data-package-tab aria-label="Inclusions"><i class="package-tab-icon" data-lucide="badge-check" aria-hidden="true"></i><span>Inclusions</span></a>
              <a href="#faq" data-package-tab aria-label="Frequently asked questions"><i class="package-tab-icon" data-lucide="circle-help" aria-hidden="true"></i><span>FAQ</span></a>
              <a href="#reviews" data-package-tab aria-label="Reviews"><i class="package-tab-icon" data-lucide="message-square-text" aria-hidden="true"></i><span>Reviews</span></a>
            </div>
          </nav>
          <section class="package-overview" id="overview" aria-labelledby="overview-title">
            <span class="package-eyebrow">THE ROUTE IN BRIEF</span>
            <h2 id="overview-title">Overview</h2>
            <p class="package-lead">Langtang is a rewarding option when you want a Himalayan trek without a long internal
              flight. The route follows the Langtang Khola from Syabrubesi, through woodland and mountain settlements,
              towards the open high valley and Kyanjin Gompa.</p>
            <p>The itinerary, inclusions, price and departure details below are planning starting points and are confirmed around your dates, group size and trail conditions.</p>
          </section>
          <div class="package-trust" data-aos="fade-up">
            <p class="package-trust-score"><span class="package-trust-stars" aria-hidden="true">*</span><strong>Route fit</strong><span class="package-trust-outof">before confirmation</span></p>
            <p class="package-trust-meta">Talk through walking pace, altitude comfort, inclusions, transport and the best season before this trek is confirmed for your group.</p>
            <a class="package-trust-link" href="#trip-planning">Ask about this route <span
              aria-hidden="true">↗</span></a>
          </div>
          <section class="package-itinerary" id="itinerary" aria-labelledby="itinerary-title">
            <div class="package-section-heading">
              <div><span class="package-eyebrow">DAY BY DAY</span>
                <h2 id="itinerary-title">Day-by-day itinerary</h2>
              </div><span class="package-section-count">11 DAYS / ROUTE OVERVIEW</span>
            </div>
            <div class="package-details-list">
              <details open>
                <summary><span>01</span><strong>Arrival in Kathmandu</strong><small class="package-itinerary__chips"><span>1,350 m</span><i>Rest day</i></small>
                </summary>
                <p>Arrive in Kathmandu, settle into your hotel and use the day to meet your trip team, review the route
                  and prepare for the drive north.</p>
              </details>
              <details>
                <summary><span>02</span><strong>Drive to Syabrubesi</strong><small class="package-itinerary__chips"><span>1,420 m</span><i>8-9 hours by road</i></small></summary>
                <p>Travel from Kathmandu towards Syabrubesi. The road journey is part of the transition from city to
                  trail, with changing landscapes along the way.</p>
              </details>
              <details>
                <summary><span>03</span><strong>Syabrubesi to Changdam</strong><small class="package-itinerary__chips"><span>2,455 m</span><i>5-6 hours walking</i></small></summary>
                <p>Begin walking beside the river and through forested trails towards the first mountain lodges of the
                  valley.</p>
              </details>
              <details>
                <summary><span>04</span><strong>Changdam to Langtang village</strong><small class="package-itinerary__chips"><span>3,480 m</span><i>5-6 hours walking</i></small></summary>
                <p>Continue through woodland and settlements as the valley opens. Walk steadily and allow your body time
                  to adjust to the altitude.</p>
              </details>
              <details>
                <summary><span>05</span><strong>Langtang village to Kyanjin Gompa</strong><small class="package-itinerary__chips"><span>3,870 m</span><i>3-4 hours walking</i></small></summary>
                <p>Reach Kyanjin Gompa, the high point of the route and a natural base for exploring the surrounding
                  valley.</p>
              </details>
              <details>
                <summary><span>06</span><strong>Exploration day at Kyanjin Gompa</strong><small class="package-itinerary__chips"><span>3,870 m</span><i>Short walk / rest</i></small></summary>
                <p>Keep the day flexible for a gentle excursion, local exploration or rest. Any higher viewpoint should
                  be decided with your guide and current conditions in mind.</p>
              </details>
              <details>
                <summary><span>07</span><strong>Return to Lama Hotel</strong><small class="package-itinerary__chips"><span>2,340 m</span><i>6-7 hours walking</i></small></summary>
                <p>Retrace the valley trail downhill through changing forest, taking care on steep and uneven sections.
                </p>
              </details>
              <details>
                <summary><span>08</span><strong>Lama Hotel to Thulo Syabru</strong><small class="package-itinerary__chips"><span>1,900 m</span><i>5-6 hours walking</i></small></summary>
                <p>Cross through forest and village paths towards Thulo Syabru, with time to notice the quieter details
                  of life along the route.</p>
              </details>
              <details>
                <summary><span>09</span><strong>Thulo Syabru to Dhunche</strong><small class="package-itinerary__chips"><span>1,650 m</span><i>4-5 hours walking</i></small></summary>
                <p>Complete the final walking section towards Dhunche and prepare for the road journey back to
                  Kathmandu.</p>
              </details>
              <details>
                <summary><span>10</span><strong>Drive back to Kathmandu</strong><small class="package-itinerary__chips"><span>Road transfer</span><i>Breakfast</i></small></summary>
                <p>Return to Kathmandu by road. Keep the evening open for a final meal or an extra night if your onward
                  plans allow.</p>
              </details>
              <details>
                <summary><span>11</span><strong>Departure</strong><small class="package-itinerary__chips"><span>Kathmandu</span><i>Breakfast</i></small></summary>
                <p>Transfer onward for your next destination, or continue your Nepal journey with a custom extension.
                </p>
              </details>
            </div>
          </section>
          <section class="package-route-map" id="route-map" aria-labelledby="route-map-title">
            <div class="package-section-heading">
              <div><span class="package-eyebrow">ROUTE MAP</span>
                <h2 id="route-map-title">Route map</h2>
              </div><span class="package-section-count">SYABRUBESI TO KYANJIN GOMPA</span>
            </div>
            <figure class="package-route-map__visual">
              <img src="{{ asset('site/assets/routemap.png') }}" alt="Langtang Valley trekking route map from Kathmandu to Kyanjin Gompa" width="1402" loading="lazy">
            </figure>
          </section>
          <section class="package-elevation package-section" id="elevation" aria-labelledby="elevation-title">
            <div class="package-section-heading">
              <div><span class="package-eyebrow">ALTITUDE PROFILE</span>
                <h2 id="elevation-title">Altitude profile</h2>
              </div>
            </div>
            <p class="package-lead">Approximate elevations along the route to Kyanjin Gompa.</p>
            <div class="package-elevation-chart-wrap">
              <canvas id="package-elevation-chart" role="img" aria-label="Line chart showing approximate altitude: Kathmandu 1,350 metres, Syabrubesi 1,420 metres, Langtang Village 3,480 metres, Kyanjin Gompa 3,870 metres, then returning to Kathmandu at 1,350 metres.">
                Approximate route elevations: Kathmandu 1,350 m; Syabrubesi 1,420 m; Langtang Village 3,480 m; Kyanjin Gompa 3,870 m; return to Kathmandu 1,350 m.
              </canvas>
            </div>
          </section>
          <section class="package-dates package-section" id="dates" aria-labelledby="dates-title">
            <div class="package-dates__grid">
              <div>
                <span class="package-eyebrow">DEPARTURE DATES 2026 / 2027</span>
                <h2 id="dates-title">Departure dates</h2>
                <p class="package-lead">Choose a listed walking window or tell us the dates that suit you.</p>
                <p class="package-dates__note">Every departure is subject to guide confirmation, permits, weather, transport and the final group plan.</p>
              </div>
              <div class="package-dates__list" role="list" aria-label="Departure date ideas">
                <article class="package-date-row" role="listitem"><div><span class="package-date-row__season">SPRING 2026</span><strong>14 Mar - 24 Mar</strong><span class="package-date-row__price">From USD 1,180 <small>per person*</small></span></div><span class="package-date-row__status">Available to discuss</span><a href="#sidebar-booking-form" aria-label="Book 14 March 2026 departure">Book <span aria-hidden="true">↗</span></a></article>
                <article class="package-date-row" role="listitem"><div><span class="package-date-row__season">SPRING 2026</span><strong>11 Apr - 21 Apr</strong><span class="package-date-row__price">From USD 1,240 <small>per person*</small></span></div><span class="package-date-row__status">Available to discuss</span><a href="#sidebar-booking-form" aria-label="Book 11 April 2026 departure">Book <span aria-hidden="true">↗</span></a></article>
                <article class="package-date-row" role="listitem"><div><span class="package-date-row__season">AUTUMN 2026</span><strong>03 Oct - 13 Oct</strong><span class="package-date-row__price">From USD 1,320 <small>per person*</small></span></div><span class="package-date-row__status">Available to discuss</span><a href="#sidebar-booking-form" aria-label="Book 3 October 2026 departure">Book <span aria-hidden="true">↗</span></a></article>
                <article class="package-date-row" role="listitem"><div><span class="package-date-row__season">AUTUMN 2027</span><strong>09 Oct - 19 Oct</strong><span class="package-date-row__price">From USD 1,290 <small>per person*</small></span></div><span class="package-date-row__status">Early planning</span><a href="#sidebar-booking-form" aria-label="Book 9 October 2027 departure">Book <span aria-hidden="true">↗</span></a></article>
              </div>
              <p class="package-dates__price-note">* Indicative prices per person. Figures vary with
                group size, season, room type and the final route, and are confirmed in your written quotation.</p>
            </div>
          </section>
          <section class="package-split package-section" id="included" aria-labelledby="included-title">
            <div class="package-split__grid">
              <div><span class="package-eyebrow">WHAT'S INCLUDED</span>
                <h2 id="included-title">Our includes</h2>
                <p class="package-lead">These services can be included in your Langtang trek. Confirm the final arrangement in your written itinerary.</p>
              </div>
              <div class="package-checklists package-checklists--single">
                <div class="package-checklist-card--included">
                  <ul>
                    <li>Arrival and departure transfers, if agreed</li>
                    <li>Road transport for the listed route, if agreed</li>
                    <li>Licensed trekking guide and staff plan</li>
                    <li>Accommodation and meals stated in your final itinerary</li>
                    <li>Required permits and local fees, if included in the quote</li>
                    <li>Basic first-aid and altitude-awareness support</li>
                  </ul>
                </div>
              </div>
            </div>
          </section>
          <section class="package-split package-section" id="excluded" aria-labelledby="excluded-title">
            <div class="package-split__grid">
              <div><span class="package-eyebrow">NOT INCLUDED</span>
                <h2 id="excluded-title">Our excludes</h2>
                <p class="package-lead">Plan for these personal and optional costs separately unless your written itinerary says otherwise.</p>
              </div>
              <div class="package-checklists package-checklists--single">
                <div class="package-checklist-card--excluded">
                  <ul>
                    <li>International flights and Nepal entry visa</li>
                    <li>Travel insurance with high-altitude and evacuation cover</li>
                    <li>Personal gear, medication, drinks and charging</li>
                    <li>Tips and personal expenses</li>
                    <li>Extra nights, upgrades and private transport</li>
                    <li>Any item not written in the confirmed itinerary</li>
                  </ul>
                </div>
              </div>
            </div>
          </section>
          <section class="package-faq package-section" id="faq" aria-labelledby="package-faq-title">
            <div class="package-faq__grid">
              <div><span class="package-eyebrow">CLEAR ANSWERS</span>
                <h2 id="package-faq-title">Frequently asked questions</h2>
              </div>
              <div class="package-info__items">
                <details>
                  <summary>Can I confirm this trip online?</summary>
                  <p>Final dates, availability, price and inclusions are confirmed with the team before any trip is accepted.</p>
                </details>
                <details>
                  <summary>Can the route be shortened or extended?</summary>
                  <p>A route can be discussed around your time, walking pace, season and interests. The final itinerary should
                    be agreed before travel.</p>
                </details>
                <details>
                  <summary>Can I combine Langtang with culture or wildlife?</summary>
                  <p>Yes, a custom plan could discuss time in Kathmandu, another walking route or the lowlands, subject to
                    season and transport time.</p>
                </details>
              </div>
            </div>
          </section>
        </div>
        <aside class="package-sidebar" id="trip-planning" aria-label="Plan this Langtang Valley trek" x-data="packageBookingSidebar()">
          <div class="package-conversion-card">
            <div class="package-conversion-heading">
              <div class="package-price-offer">
                <span class="package-price-offer__label">SPECIAL PRICE <span>Save USD 140</span></span>
                <p class="package-price-offer__was">Was <del>USD 1,320</del></p>
                <p class="package-price-offer__now"><span>From</span> USD 1,180</p>
                <p class="package-price-offer__per-person">per person</p>
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
              <button type="button" :class="sidebarForm === 'inquiry' ? 'is-active' : ''" @click="sidebarForm = 'inquiry'">Send Free Inquiry</button>
              <button type="button" :class="sidebarForm === 'booking' ? 'is-active' : ''" @click="sidebarForm = 'booking'">Plan Booking</button>
            </div>
            <form class="package-conversion-form" id="sidebar-enquiry-form" data-static-form x-show="sidebarForm === 'inquiry'" role="tabpanel">
              <label for="sidebar-enquiry-name">Your full name <b>*</b></label><input id="sidebar-enquiry-name" name="sidebar-enquiry-name" type="text" autocomplete="name" required placeholder="e.g. David Jenkins">
              <div class="package-conversion-form__row"><div><label for="sidebar-enquiry-email">Email address <b>*</b></label><input id="sidebar-enquiry-email" name="sidebar-enquiry-email" type="email" autocomplete="email" required placeholder="david@example.com"></div><div><label for="sidebar-enquiry-phone">WhatsApp / phone <b>*</b></label><input id="sidebar-enquiry-phone" name="sidebar-enquiry-phone" type="tel" autocomplete="tel" required placeholder="+1 555-0199"></div></div>
              <label for="sidebar-enquiry-window">Preferred travel window <b>*</b></label><select id="sidebar-enquiry-window" name="sidebar-enquiry-window" required><option value="">Choose a season or date</option><option value="spring-2027">Spring 2027 (Mar - May)</option><option value="autumn-2026">Autumn 2026 (Oct - Nov)</option><option value="flexible">Flexible dates</option></select>
              <label for="sidebar-enquiry-message">Questions / specific requests</label><textarea id="sidebar-enquiry-message" name="sidebar-enquiry-message" rows="3" placeholder="e.g. Vegetarian diet, private group of 4, slow pacing request..."></textarea>
              <button class="package-conversion-submit" type="submit">Request Custom Plan</button><a class="package-whatsapp-button" href="https://wa.me/?text=I%27m%20interested%20in%20the%20Langtang%20Valley%20Trek." target="_blank" rel="noopener noreferrer">◉ &nbsp; Instant Chat on WhatsApp</a>
              <p class="package-form__status" role="status" hidden>Thank you. Please contact our team by phone or WhatsApp to complete your enquiry.</p>
            </form>
            <form class="package-conversion-form" id="sidebar-booking-form" x-show="sidebarForm === 'booking'" @submit.prevent="saveBookingDraft($event)" role="tabpanel">
              <label for="sidebar-booking-name">Your full name <b>*</b></label><input id="sidebar-booking-name" name="sidebar-booking-name" type="text" autocomplete="name" required placeholder="Your name">
              <div class="package-conversion-form__row"><div><label for="sidebar-booking-email">Email address <b>*</b></label><input id="sidebar-booking-email" name="sidebar-booking-email" type="email" autocomplete="email" required placeholder="you@example.com"></div><div><label for="sidebar-booking-phone">WhatsApp / phone <b>*</b></label><input id="sidebar-booking-phone" name="sidebar-booking-phone" type="tel" autocomplete="tel" required placeholder="+1 555-0199"></div></div>
              <label for="sidebar-booking-window">Preferred travel window <b>*</b></label><select id="sidebar-booking-window" name="travel_window" required><option value="">Choose a season or date</option><option value="spring-2027">Spring 2027 (Mar - May)</option><option value="autumn-2026">Autumn 2026 (Oct - Nov)</option><option value="flexible">Flexible dates</option></select>
              <label for="sidebar-booking-travellers">Number of travellers</label><select id="sidebar-booking-travellers" name="travellers"><option value="1">1 traveller</option><option value="2">2 travellers</option><option value="3">3 travellers</option><option value="4">4 travellers</option><option value="5">5 travellers</option><option value="6+">6 or more travellers</option></select>
              <button class="package-conversion-submit" type="submit">Continue to booking details <span aria-hidden="true">↗</span></button><a class="package-whatsapp-button" href="https://wa.me/?text=I%27m%20ready%20to%20discuss%20booking%20the%20Langtang%20Valley%20Trek." target="_blank" rel="noopener noreferrer">◉ &nbsp; Instant Chat on WhatsApp</a>
              <p class="package-form__status" role="status" hidden></p>
            </form>
          </div>
        </aside>
      </div>
    </section>
    <section class="package-reviews package-section" id="reviews" aria-labelledby="reviews-title">
      <div class="package-container">
        <div class="package-reviews__heading">
          <div><span class="package-eyebrow">TRAVELLER FEEDBACK</span>
            <h2 id="reviews-title">Customer reviews</h2>
          </div>
          <div class="package-reviews__heading-side">
            <p>Feedback from travellers about the Langtang Valley Trek experience.</p>
            <div class="package-review-controls" aria-label="Review controls"><button
                class="package-review-control package-review-prev" type="button" aria-label="Previous review"
                title="Previous review">←</button>
              <div class="package-review-pagination" aria-label="Choose a review"></div><button
                class="package-review-control package-review-next" type="button" aria-label="Next review"
                title="Next review">→</button>
            </div>
          </div>
        </div>
        <div class="swiper package-review-swiper">
          <div class="swiper-wrapper">
            <article class="swiper-slide package-review-card">
              <div class="package-review-card__top"><span>01</span><small>CUSTOMER REVIEW</small></div>
              <blockquote>"A steady first half gives the trek room to breathe before the valley opens near Langtang."
              </blockquote>
              <div class="package-review-card__source"><span aria-hidden="true">—</span>
                <div><strong>Langtang Valley Trek guest</strong><span>Customer feedback</span></div>
              </div>
            </article>
            <article class="swiper-slide package-review-card package-review-card--accent">
              <div class="package-review-card__top"><span>02</span><small>CUSTOMER REVIEW</small></div>
              <blockquote>"Kyanjin Gompa works best when the day stays flexible for weather, energy and views."</blockquote>
              <div class="package-review-card__source"><span aria-hidden="true">—</span>
                <div><strong>Langtang Valley Trek guest</strong><span>Customer feedback</span></div>
              </div>
            </article>
            <article class="swiper-slide package-review-card">
              <div class="package-review-card__top"><span>03</span><small>CUSTOMER REVIEW</small></div>
              <blockquote>"The road approach keeps flights out of the plan, but transport time should be treated with care."
              </blockquote>
              <div class="package-review-card__source"><span aria-hidden="true">—</span>
                <div><strong>Langtang Valley Trek guest</strong><span>Customer feedback</span></div>
              </div>
            </article>
          </div>
        </div>
      </div>
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
