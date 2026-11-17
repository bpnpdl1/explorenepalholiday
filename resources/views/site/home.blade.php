@extends('layouts.site')

@section('page_title', 'Explore Nepal Holidays | Treks, Tours & Tailor-Made Journeys')
@section('meta_description', "Explore Nepal's mountain trails, cultural cities and wild lowlands. Discover handpicked journeys and plan a trip shaped around you.")
@section('og_image', asset('site/assets/annapurna-sunrise.jpg'))
@section('body_class', 'home-page')

@section('content')
<a class="skip-link" href="#main">Skip to content</a>
  <div class="topbar">
    <div class="container topbar-inner"><span>20 Years Experience</span><a
        href="https://wa.me/9779800000000" target="_blank" rel="noopener noreferrer">+977-9800000000 · WhatsApp ↗</a></div>
  </div>
  <header class="site-header" :class="headerCompact ? 'is-compact' : ''" @mouseleave="openNav=null">
    <div class="container header-primary">
      <a class="brand" href="#top" aria-label="Explore Nepal Holidays, home"><span class="brand-mark"><img
            src="{{ asset('site/assets/logo-mark.png') }}" alt="" width="78" height="63"></span><span class="brand-name">EXPLORE
          <small>NEPAL HOLIDAYS</small></span></a>
      <div class="header-actions flex items-center gap-3"><button
          class="header-find inline-flex items-center gap-2 font-medium transition-colors" type="button"
          @click="openTripSearch()">
          <img class="icon-img icon-img--light" src="{{ asset('site/assets/icons/search.svg') }}" alt="">Find a Trip</button><a
          class="header-cta inline-flex items-center justify-center font-semibold text-white bg-orange-brand hover:bg-orange-hover transition-colors rounded-brand"
          href="#plan">Plan your journey <span aria-hidden="true">↗</span></a></div>
      <button class="mobile-find" type="button" @click="openTripSearch()" aria-label="Find a trip">
      <img class="icon-img icon-img--light" src="{{ asset('site/assets/icons/search.svg') }}" alt=""></button>
      <button class="menu-toggle" type="button" @click="menuOpen=!menuOpen;mobileSection=null;mobileRegion=null"
        :aria-expanded="menuOpen.toString()" aria-controls="mobile-menu"
        aria-label="Toggle menu"><span></span><span></span><span></span></button>
    </div>
    <div class="header-nav-row">
      <nav class="container desktop-nav" aria-label="Primary navigation">
        <a class="compact-brand" href="#top" aria-label="Explore Nepal Holidays, back to top"><img
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
                  <div class="flyout-scroll"><template x-for="trip in region.trips" :key="trip"><a href="{{ route('packages.show') }}" x-text="trip"></a></template></div>
                  <div class="flyout-note">Open a trek to see itinerary highlights. Routes and availability
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
                  <div class="flyout-scroll"><template x-for="trip in region.trips" :key="trip"><a href="{{ route('packages.show') }}" x-text="trip"></a></template></div>
                  <div class="flyout-note">Open a tour to see itinerary highlights.</div>
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
                  <div class="flyout-scroll"><template x-for="trip in region.trips" :key="trip"><a href="{{ route('packages.show') }}" x-text="trip"></a></template></div>
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
              href="#why-nepal" @click="closeNav()">Our approach ↗</a><a href="#why-choose" @click="closeNav()">Why choose us ↗</a><a href="{{ route('home') }}#testimonials" @click="closeNav()">Guest reviews ↗</a></div>
        </div>
        <div class="nav-item compact" @mouseenter="openNav='info'"
          @focusout="if(!$el.contains($event.relatedTarget)) openNav=null"><button type="button" data-nav-trigger="info"
            @click="openNav='info'" :aria-expanded="(openNav==='info').toString()" aria-controls="nav-info">Travel Info
            <span class="nav-chevron" aria-hidden="true"></span></button>
          <div id="nav-info" class="nav-panel dropdown-panel" x-show="openNav==='info'" x-cloak><a href="{{ route('faq') }}#planning"
              @click="closeNav()">Best time to visit ↗</a><a href="{{ route('faq') }}#trekking" @click="closeNav()">Trekking
              experience ↗</a><a href="#combine-trips" @click="closeNav()">Combining experiences ↗</a><a href="{{ route('faq') }}"
              @click="closeNav()">Frequently asked questions ↗</a></div>
        </div>
        <a class="nav-contact" href="{{ route('contact') }}" @mouseenter="openNav=null">Contact Us <span aria-hidden="true">↗</span></a>
        <button class="nav-find" type="button" @click="openTripSearch()" aria-label="Find a trip">
        <img class="icon-img icon-img--light" src="{{ asset('site/assets/icons/search.svg') }}" alt=""></button>
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
                <template x-for="trip in region.trips" :key="trip"><a href="{{ route('packages.show') }}"
                    x-text="trip"></a></template>
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
                <template x-for="trip in region.trips" :key="trip"><a href="{{ route('packages.show') }}"
                    x-text="trip"></a></template>
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
                <template x-for="trip in region.trips" :key="trip"><a href="{{ route('packages.show') }}"
                    x-text="trip"></a></template>
              </div>
            </div>
          </template>
        </div>
      </div>
      <div class="mobile-nav-group"><button type="button" @click="toggleMobileSection('company')"
          :aria-expanded="(mobileSection==='company').toString()" aria-controls="mobile-company">Company <span
            aria-hidden="true">+</span></button>
        <div id="mobile-company" class="mobile-subnav" x-show="mobileSection==='company'" x-cloak><a href="{{ route('about') }}" @click="menuOpen=false">About Us</a><a href="{{ route('team') }}" @click="menuOpen=false">Our Team</a><a href="{{ route('home') }}#why-choose" @click="menuOpen=false">Why travel with us</a><a href="#why-nepal"
            @click="menuOpen=false">Our approach</a><a href="#why-choose" @click="menuOpen=false">Why choose us</a><a
            href="{{ route('home') }}#testimonials" @click="menuOpen=false">Guest reviews</a></div>
      </div>
      <div class="mobile-nav-group"><button type="button" @click="toggleMobileSection('info')"
          :aria-expanded="(mobileSection==='info').toString()" aria-controls="mobile-info">Travel Info <span
            aria-hidden="true">+</span></button>
        <div id="mobile-info" class="mobile-subnav" x-show="mobileSection==='info'" x-cloak><a href="{{ route('faq') }}#planning"
            @click="menuOpen=false">Best time to visit</a><a href="{{ route('faq') }}#trekking" @click="menuOpen=false">Trekking
            experience</a><a href="{{ route('faq') }}" @click="menuOpen=false">All FAQs</a></div>
      </div>
      <a class="mobile-contact" href="{{ route('contact') }}" @click="menuOpen=false">Contact Us <span aria-hidden="true">↗</span></a>
    </nav>
  </header>
  <main id="main">
    <section class="hero hero--expedition" id="top" aria-labelledby="hero-title">
      <!-- Background Image -->
      <div class="hero-bg-image">
        <img src="{{ asset('site/assets/annapurna-sunrise.jpg') }}" alt="" width="1400" height="933" fetchpriority="high" aria-hidden="true">
      </div>
      <!-- Dark Gradient Overlays -->
      <div class="hero-bg-shade"></div>
      <div class="hero-bg-shade-right"></div>
      <div class="hero-bg-vignette"></div>

      <!-- Main Content -->
      <div class="container hero-expedition-inner">
        <div class="hero-expedition-copy">

          <!-- Main Headline -->
          <h1 id="hero-title" class="hero-fade-up-delay-1">
            Nepal journeys
            <span class="hero-headline-shimmer">shaped around</span>
            <span>the way you travel</span>
          </h1>

          <!-- Subheadline -->
          <p class="hero-fade-up-delay-2">
            Explore Nepal's trails, cities and wildlife. Find a journey that fits your pace, then enquire to make it yours.
          </p>

          <!-- Hero actions -->
          <div class="hero-fade-up-delay-3 hero-expedition-ctas">
            <a href="#journeys" class="hero-cta-primary">
              Explore journeys
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
              </svg>
            </a>
            <a href="#why-nepal" class="hero-cta-secondary">
              <span>Plan a custom trip</span>
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
              </svg>
            </a>
          </div>

        </div>
      </div>

      <!-- Search / Filter Widget -->
      <div class="container hero-search-container">
        <div class="hero-search-card">
          <form @submit.prevent="handleExpeditionSearch()" class="hero-search-grid">

            <!-- Destination Region -->
            <div class="hero-search-field">
              <label for="exp-region">Destination Region</label>
              <select id="exp-region" x-model="expeditionFilters.region" class="hero-select">
                <option value="all">All Regions</option>
                <option value="everest">Everest Region</option>
                <option value="annapurna">Annapurna Region</option>
                <option value="langtang">Langtang Region</option>
                <option value="manaslu">Manaslu Region</option>
                <option value="makalu">Makalu Region</option>
                <option value="kanchenjunga">Kanchenjunga Region</option>
              </select>
            </div>

            <!-- Expedition Comfort Tier -->
            <div class="hero-search-field">
              <label for="exp-comfort">Trip Style</label>
              <select id="exp-comfort" x-model="expeditionFilters.comfort" class="hero-select">
                <option value="any">Any Trip Style</option>
                <option value="comfort">Comfort Trek</option>
                <option value="premium">Classic Trek</option>
                <option value="classic">Cultural Tour</option>
                <option value="camping">Remote Camping</option>
              </select>
            </div>

            <!-- Trek Duration -->
            <div class="hero-search-field">
              <label for="exp-duration">Trek Duration</label>
              <select id="exp-duration" x-model="expeditionFilters.duration" class="hero-select">
                <option value="any">Any Duration</option>
                <option value="short">Short (5–10 Days)</option>
                <option value="medium">Medium (11–18 Days)</option>
                <option value="long">Long (19–28 Days)</option>
                <option value="extended">Extended (29+ Days)</option>
              </select>
            </div>

            <!-- Departure Window -->
            <div class="hero-search-field">
              <label for="exp-departure">Best Season</label>
              <select id="exp-departure" x-model="expeditionFilters.departure" class="hero-select">
                <option value="any">Any Season</option>
                <option value="autumn-2026">Autumn (Oct - Nov)</option>
                <option value="spring-2027">Spring (Mar - Apr)</option>
                <option value="winter-2026">Winter (Dec - Feb)</option>
                <option value="monsoon-2027">Monsoon (Jun - Sep)</option>
              </select>
            </div>

            <!-- CTA Button -->
            <div class="hero-search-field hero-search-submit">
              <label class="hero-search-label-hidden">Search</label>
              <button type="submit" class="hero-search-btn">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Explore Trips
              </button>
            </div>

          </form>

          <!-- Active Filters Summary -->
          <div x-show="hasActiveExpeditionFilters()" x-cloak class="hero-active-filters">
            <span class="hero-active-filters-label">Active filters:</span>
            <template x-if="expeditionFilters.region !== 'all'">
              <span class="hero-filter-pill">
                <span x-text="getRegionLabel(expeditionFilters.region)"></span>
                <button @click="expeditionFilters.region = 'all'" class="hero-filter-pill-remove">&times;</button>
              </span>
            </template>
            <template x-if="expeditionFilters.comfort !== 'any'">
              <span class="hero-filter-pill">
                <span x-text="getComfortLabel(expeditionFilters.comfort)"></span>
                <button @click="expeditionFilters.comfort = 'any'" class="hero-filter-pill-remove">&times;</button>
              </span>
            </template>
            <template x-if="expeditionFilters.duration !== 'any'">
              <span class="hero-filter-pill">
                <span x-text="getDurationLabel(expeditionFilters.duration)"></span>
                <button @click="expeditionFilters.duration = 'any'" class="hero-filter-pill-remove">&times;</button>
              </span>
            </template>
            <template x-if="expeditionFilters.departure !== 'any'">
              <span class="hero-filter-pill">
                <span x-text="getDepartureLabel(expeditionFilters.departure)"></span>
                <button @click="expeditionFilters.departure = 'any'" class="hero-filter-pill-remove">&times;</button>
              </span>
            </template>
            <button @click="resetExpeditionFilters()" class="hero-filter-clear">Clear all</button>
          </div>

        </div>
      </div>
    </section>

    <section id="why-choose" class="bg-slate-50 text-slate-900 py-20 px-4 md:px-8" aria-labelledby="why-choose-title">
      <div class="max-w-7xl mx-auto">

        <!-- Section Header -->
        <div class="text-center mb-14">
          <span class="text-amber-500 text-xs font-bold tracking-widest uppercase mb-2 block">The planning difference</span>
          <h2 id="why-choose-title" class="text-3xl lg:text-4xl font-extrabold tracking-tight text-slate-900 mb-3">Why Travelers Choose Explore Nepal Holidays</h2>
          <p class="text-slate-500 max-w-2xl mx-auto text-sm md:text-base">Good travel design is not decoration. It is clear pacing, realistic routes, honest preparation and enough local context to choose well.</p>
        </div>

        <!-- 4-Column Feature Card Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

          <!-- Card 1: Medical Logs -->
          <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition duration-300 flex flex-col justify-between">
            <div>
              <div class="bg-teal-50 text-teal-600 p-4 rounded-xl w-fit mx-auto mb-5">
                <i data-lucide="heart-pulse" class="w-8 h-8" aria-hidden="true"></i>
              </div>
              <h3 class="text-lg font-bold text-slate-900 mb-2">Altitude-aware pacing</h3>
              <p class="text-slate-500 text-xs leading-relaxed">Higher routes need sensible acclimatization days, realistic walking hours and a plan that can flex with weather and energy.</p>
            </div>
          </div>

          <!-- Card 2 -->
          <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition duration-300 flex flex-col justify-between">
            <div>
              <div class="bg-amber-50 text-amber-600 p-4 rounded-xl w-fit mx-auto mb-5">
                <i data-lucide="bed-double" class="w-8 h-8" aria-hidden="true"></i>
              </div>
              <h3 class="text-lg font-bold text-slate-900 mb-2">Comfort matched to route</h3>
              <p class="text-slate-500 text-xs leading-relaxed">Some journeys suit simple teahouses, others call for more comfort in the cities or a private lodge-style approach where available.</p>
            </div>
          </div>

          <!-- Card 3 -->
          <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition duration-300 flex flex-col justify-between">
            <div>
              <div class="bg-emerald-50 text-emerald-600 p-4 rounded-xl w-fit mx-auto mb-5">
                <i data-lucide="map" class="w-8 h-8" aria-hidden="true"></i>
              </div>
              <h3 class="text-lg font-bold text-slate-900 mb-2">Local context first</h3>
              <p class="text-slate-500 text-xs leading-relaxed">Routes make more sense when culture, festivals, transport windows and mountain conditions are considered from the start.</p>
            </div>
          </div>

          <!-- Card 4: Porter Welfare -->
          <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition duration-300 flex flex-col justify-between">
            <div>
              <div class="bg-rose-50 text-rose-600 p-4 rounded-xl w-fit mx-auto mb-5">
                <i data-lucide="leaf" class="w-8 h-8" aria-hidden="true"></i>
              </div>
              <h3 class="text-lg font-bold text-slate-900 mb-2">Responsible travel cues</h3>
              <p class="text-slate-500 text-xs leading-relaxed">We make space for crew welfare, lower-impact choices and respectful encounters to be part of the conversation before booking.</p>
            </div>
          </div>

        </div>

        <!-- Lead Guide Banner -->
        <div class="bg-slate-950 text-white rounded-2xl p-6 md:p-8 shadow-2xl flex flex-col md:flex-row items-center justify-between gap-6 max-w-5xl mx-auto mt-12 border border-slate-800">
          <!-- Left: Guide Info -->
          <div class="flex items-center gap-5">
            <img src="{{ asset('site/assets/everest-hikers.jpg') }}" alt="Pasang Nuru Sherpa" class="w-16 h-16 rounded-xl object-cover border border-slate-700 shadow-md" loading="lazy">
            <div>
              <span class="text-amber-400 text-[11px] font-bold tracking-widest uppercase">Start with a conversation</span>
              <h3 class="text-xl font-extrabold text-white">Tell us what kind of Nepal you want</h3>
              <p class="text-slate-400 text-xs mt-1 font-medium">Trekking, culture, wildlife, family travel or a balanced custom itinerary.</p>
            </div>
          </div>
          <!-- Right: CTA Button -->
          <a href="#plan" class="bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold px-6 py-3 rounded-xl text-sm transition-all duration-200 shadow-lg flex items-center gap-2 whitespace-nowrap">
            Send an enquiry
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
          </a>
        </div>

      </div>
    </section>

    <section id="expeditions" class="bg-slate-50 py-16 lg:py-20" aria-labelledby="expeditions-title" x-data="expeditionTabs()">
      <div class="max-w-7xl mx-auto px-4 md:px-8">

        <!-- Section Header -->
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-10">
          <div>
            <span class="inline-block text-[11px] font-bold uppercase tracking-widest text-amber-600 mb-3">Featured journey ideas</span>
            <h2 id="expeditions-title" class="text-2xl lg:text-3xl font-extrabold uppercase text-slate-900 tracking-tight">Nepal trips to compare</h2>
            <p class="text-slate-500 text-sm lg:text-base max-w-2xl mt-3 leading-relaxed">A curated set of trek and peak-climbing concepts with useful cues for region, duration, altitude and starting price. Final routes, inclusions and dates are confirmed during enquiry.</p>
          </div>

          <!-- Filter Tabs -->
          <div class="journey-tabs flex flex-wrap items-center gap-2">
            <template x-for="tab in tabs" :key="tab.id">
              <button
                @click="activeTab = tab.id"
                :class="activeTab === tab.id
                  ? 'bg-slate-900 text-white font-medium shadow'
                  : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                class="px-4 py-2 rounded-lg text-xs font-semibold uppercase tracking-wide transition-all duration-200"
                x-text="tab.label">
              </button>
            </template>
          </div>
        </div>

        <!-- Card Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">

          <!-- Card 1: Everest Base Camp -->
          <article x-show="activeTab === 'all' || activeTab === 'everest'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="rounded-2xl border border-slate-200/80 bg-white shadow-sm hover:shadow-xl transition duration-300 flex flex-col overflow-hidden">
            <!-- Image -->
            <div class="relative h-52 overflow-hidden">
              <img src="{{ asset('site/assets/everest-hikers.jpg') }}" alt="Everest Base Camp trek" class="w-full h-full object-cover" loading="lazy">
              <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
              <!-- Top Left Badges -->
              <div class="absolute top-3 left-3 flex flex-wrap gap-1.5">
                <span class="bg-amber-400 text-amber-900 text-[10px] font-bold uppercase px-2.5 py-1 rounded-full tracking-wide">Classic route</span>
                <span class="bg-slate-900/70 text-white text-[10px] font-semibold px-2.5 py-1 rounded-full backdrop-blur-sm">Detailed itinerary</span>
              </div>
              <!-- Altitude Badge -->
              <span class="absolute bottom-3 right-3 bg-slate-900/80 text-white text-[10px] font-bold px-2.5 py-1 rounded-full backdrop-blur-sm">Max 5,555m</span>
            </div>
            <!-- Body -->
            <div class="flex flex-col flex-1 p-5">
              <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-700">16 Days &bull; Everest Region</span>
                <span class="text-xs text-amber-500 font-semibold">Popular</span>
              </div>
              <h3 class="text-xl font-bold text-slate-900 line-clamp-1 hover:text-sky-600 transition-colors">Everest Base Camp Trek</h3>
              <p class="text-slate-500 text-sm line-clamp-2 mt-2 leading-relaxed">The classic high-altitude trek through Sherpa heartland to the foot of the world's highest peak.</p>
              <div class="flex flex-wrap gap-1.5 mt-3">
                <span class="bg-slate-100 text-slate-600 text-[10px] font-medium px-2 py-0.5 rounded-full">Sherpa villages</span>
                <span class="bg-slate-100 text-slate-600 text-[10px] font-medium px-2 py-0.5 rounded-full">Kala Patthar Sunrise</span>
                <span class="bg-slate-100 text-slate-600 text-[10px] font-medium px-2 py-0.5 rounded-full">Altitude planning</span>
              </div>
              <!-- Footer -->
              <div class="border-t border-slate-100 mt-auto pt-4 flex items-center justify-between">
                <div>
                  <div class="text-[10px] uppercase tracking-wider text-slate-400 font-semibold">From</div>
                  <div class="text-lg font-extrabold text-slate-900">$2,490 <span class="text-xs font-medium text-slate-400">USD</span></div>
                </div>
                <a href="{{ route('packages.show') }}" class="bg-sky-600 hover:bg-sky-700 text-white font-semibold px-4 py-2 rounded-xl text-sm transition">View itinerary</a>
              </div>
            </div>
          </article>

          <!-- Card 2: Annapurna Base Camp -->
          <article x-show="activeTab === 'all' || activeTab === 'annapurna'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="rounded-2xl border border-slate-200/80 bg-white shadow-sm hover:shadow-xl transition duration-300 flex flex-col overflow-hidden">
            <div class="relative h-52 overflow-hidden">
              <img src="{{ asset('site/assets/annapurna-sunrise.jpg') }}" alt="Annapurna Base Camp trek" class="w-full h-full object-cover" loading="lazy">
              <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
              <div class="absolute top-3 left-3 flex flex-wrap gap-1.5">
                <span class="bg-emerald-400 text-emerald-900 text-[10px] font-bold uppercase px-2.5 py-1 rounded-full tracking-wide">Top High Pass</span>
                <span class="bg-slate-900/70 text-white text-[10px] font-semibold px-2.5 py-1 rounded-full backdrop-blur-sm">Natural Hot Springs</span>
              </div>
              <span class="absolute bottom-3 right-3 bg-slate-900/80 text-white text-[10px] font-bold px-2.5 py-1 rounded-full backdrop-blur-sm">Max 4,130m</span>
            </div>
            <div class="flex flex-col flex-1 p-5">
              <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-700">14 Days &bull; Annapurna Region</span>
                <span class="text-xs text-amber-500 font-semibold">Scenic</span>
              </div>
              <h3 class="text-xl font-bold text-slate-900 line-clamp-1 hover:text-sky-600 transition-colors">Annapurna Base Camp Trek</h3>
              <p class="text-slate-500 text-sm line-clamp-2 mt-2 leading-relaxed">A natural amphitheatre of towering peaks, rhododendron forests and traditional Gurung villages.</p>
              <div class="flex flex-wrap gap-1.5 mt-3">
                <span class="bg-slate-100 text-slate-600 text-[10px] font-medium px-2 py-0.5 rounded-full">Hot Springs at Jhinu</span>
                <span class="bg-slate-100 text-slate-600 text-[10px] font-medium px-2 py-0.5 rounded-full">Machhapuchhre View</span>
              </div>
              <div class="border-t border-slate-100 mt-auto pt-4 flex items-center justify-between">
                <div>
                  <div class="text-[10px] uppercase tracking-wider text-slate-400 font-semibold">From</div>
                  <div class="text-lg font-extrabold text-slate-900">$1,890 <span class="text-xs font-medium text-slate-400">USD</span></div>
                </div>
                <a href="{{ route('packages.show') }}" class="bg-slate-900 hover:bg-slate-800 text-white font-semibold px-4 py-2 rounded-xl text-sm transition">View itinerary</a>
              </div>
            </div>
          </article>

          <!-- Card 3: Manaslu Circuit -->
          <article x-show="activeTab === 'all' || activeTab === 'manaslu'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="rounded-2xl border border-slate-200/80 bg-white shadow-sm hover:shadow-xl transition duration-300 flex flex-col overflow-hidden">
            <div class="relative h-52 overflow-hidden">
              <img src="{{ asset('site/assets/manaslu-trekker.webp') }}" alt="Trekker facing snowy peaks on the Manaslu Circuit" width="1200" height="927" class="w-full h-full object-cover" loading="lazy">
              <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
              <div class="absolute top-3 left-3 flex flex-wrap gap-1.5">
                <span class="bg-orange-400 text-orange-900 text-[10px] font-bold uppercase px-2.5 py-1 rounded-full tracking-wide">Wilderness Permit</span>
                <span class="bg-slate-900/70 text-white text-[10px] font-semibold px-2.5 py-1 rounded-full backdrop-blur-sm">Restricted Area</span>
              </div>
              <span class="absolute bottom-3 right-3 bg-slate-900/80 text-white text-[10px] font-bold px-2.5 py-1 rounded-full backdrop-blur-sm">Max 5,160m</span>
            </div>
            <div class="flex flex-col flex-1 p-5">
              <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-700">18 Days &bull; Manaslu Region</span>
                <span class="text-xs text-amber-500 font-semibold">Remote</span>
              </div>
              <h3 class="text-xl font-bold text-slate-900 line-clamp-1 hover:text-sky-600 transition-colors">Manaslu Circuit Trek</h3>
              <p class="text-slate-500 text-sm line-clamp-2 mt-2 leading-relaxed">A remote and dramatic circuit around the world's 8th highest peak, crossing the challenging Larkya La pass.</p>
              <div class="flex flex-wrap gap-1.5 mt-3">
                <span class="bg-slate-100 text-slate-600 text-[10px] font-medium px-2 py-0.5 rounded-full">Larkya La Pass</span>
                <span class="bg-slate-100 text-slate-600 text-[10px] font-medium px-2 py-0.5 rounded-full">Tsum Valley Extension</span>
              </div>
              <div class="border-t border-slate-100 mt-auto pt-4 flex items-center justify-between">
                <div>
                  <div class="text-[10px] uppercase tracking-wider text-slate-400 font-semibold">From</div>
                  <div class="text-lg font-extrabold text-slate-900">$2,190 <span class="text-xs font-medium text-slate-400">USD</span></div>
                </div>
                <a href="{{ route('packages.show') }}" class="bg-slate-900 hover:bg-slate-800 text-white font-semibold px-4 py-2 rounded-xl text-sm transition">View itinerary</a>
              </div>
            </div>
          </article>

          <!-- Card 4: Island Peak Climbing -->
          <article x-show="activeTab === 'all' || activeTab === 'peak'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="rounded-2xl border border-slate-200/80 bg-white shadow-sm hover:shadow-xl transition duration-300 flex flex-col overflow-hidden">
            <div class="relative h-52 overflow-hidden">
              <img src="{{ asset('site/assets/island-peak-climbers.webp') }}" alt="Climbers on a snowy trail in the Everest region at dusk" width="800" height="800" class="w-full h-full object-cover" loading="lazy">
              <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
              <div class="absolute top-3 left-3 flex flex-wrap gap-1.5">
                <span class="bg-amber-400 text-amber-900 text-[10px] font-bold uppercase px-2.5 py-1 rounded-full tracking-wide">#1 Best Seller</span>
                <span class="bg-slate-900/70 text-white text-[10px] font-semibold px-2.5 py-1 rounded-full backdrop-blur-sm">Climbing skills</span>
              </div>
              <span class="absolute bottom-3 right-3 bg-slate-900/80 text-white text-[10px] font-bold px-2.5 py-1 rounded-full backdrop-blur-sm">Max 6,189m</span>
            </div>
            <div class="flex flex-col flex-1 p-5">
              <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-700">20 Days &bull; Everest Region</span>
                <span class="text-xs text-amber-500 font-semibold">Technical</span>
              </div>
              <h3 class="text-xl font-bold text-slate-900 line-clamp-1 hover:text-sky-600 transition-colors">Island Peak Climbing</h3>
              <p class="text-slate-500 text-sm line-clamp-2 mt-2 leading-relaxed">Nepal's most popular trekking peak — a perfect introduction to Himalayan mountaineering.</p>
              <div class="flex flex-wrap gap-1.5 mt-3">
                <span class="bg-slate-100 text-slate-600 text-[10px] font-medium px-2 py-0.5 rounded-full">Glacier Training</span>
                <span class="bg-slate-100 text-slate-600 text-[10px] font-medium px-2 py-0.5 rounded-full">Summit Certificate</span>
              </div>
              <div class="border-t border-slate-100 mt-auto pt-4 flex items-center justify-between">
                <div>
                  <div class="text-[10px] uppercase tracking-wider text-slate-400 font-semibold">From</div>
                  <div class="text-lg font-extrabold text-slate-900">$2,890 <span class="text-xs font-medium text-slate-400">USD</span></div>
                </div>
                <a href="{{ route('packages.show') }}" class="bg-sky-600 hover:bg-sky-700 text-white font-semibold px-4 py-2 rounded-xl text-sm transition">View itinerary</a>
              </div>
            </div>
          </article>

          <!-- Card 5: Everest Three Passes -->
          <article x-show="activeTab === 'all' || activeTab === 'everest'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="rounded-2xl border border-slate-200/80 bg-white shadow-sm hover:shadow-xl transition duration-300 flex flex-col overflow-hidden">
            <div class="relative h-52 overflow-hidden">
              <img src="{{ asset('site/assets/1670824549-nepal-everest-base-camp-trek.jpg') }}" alt="Everest Three Passes trek" class="w-full h-full object-cover" loading="lazy">
              <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
              <div class="absolute top-3 left-3 flex flex-wrap gap-1.5">
                <span class="bg-emerald-400 text-emerald-900 text-[10px] font-bold uppercase px-2.5 py-1 rounded-full tracking-wide">Top High Pass</span>
                <span class="bg-slate-900/70 text-white text-[10px] font-semibold px-2.5 py-1 rounded-full backdrop-blur-sm">Three 5,000m Passes</span>
              </div>
              <span class="absolute bottom-3 right-3 bg-slate-900/80 text-white text-[10px] font-bold px-2.5 py-1 rounded-full backdrop-blur-sm">Max 5,545m</span>
            </div>
            <div class="flex flex-col flex-1 p-5">
              <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-700">21 Days &bull; Everest Region</span>
                <span class="text-xs text-amber-500 font-semibold">Advanced</span>
              </div>
              <h3 class="text-xl font-bold text-slate-900 line-clamp-1 hover:text-sky-600 transition-colors">Everest Three Passes Trek</h3>
              <p class="text-slate-500 text-sm line-clamp-2 mt-2 leading-relaxed">The ultimate Everest region trek — crossing Kongma La, Cho La and Renjo La in one epic journey.</p>
              <div class="flex flex-wrap gap-1.5 mt-3">
                <span class="bg-slate-100 text-slate-600 text-[10px] font-medium px-2 py-0.5 rounded-full">Gokyo Lakes</span>
                <span class="bg-slate-100 text-slate-600 text-[10px] font-medium px-2 py-0.5 rounded-full">Cho La Glacier</span>
              </div>
              <div class="border-t border-slate-100 mt-auto pt-4 flex items-center justify-between">
                <div>
                  <div class="text-[10px] uppercase tracking-wider text-slate-400 font-semibold">From</div>
                  <div class="text-lg font-extrabold text-slate-900">$2,790 <span class="text-xs font-medium text-slate-400">USD</span></div>
                </div>
                <a href="{{ route('packages.show') }}" class="bg-slate-900 hover:bg-slate-800 text-white font-semibold px-4 py-2 rounded-xl text-sm transition">View itinerary</a>
              </div>
            </div>
          </article>

          <!-- Card 6: Mera Peak Climbing -->
          <article x-show="activeTab === 'all' || activeTab === 'peak'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="rounded-2xl border border-slate-200/80 bg-white shadow-sm hover:shadow-xl transition duration-300 flex flex-col overflow-hidden">
            <div class="relative h-52 overflow-hidden">
              <img src="{{ asset('site/assets/mera-peak.webp') }}" alt="Snow-covered peaks in the Mera Peak area" width="1067" height="1600" class="w-full h-full object-cover" loading="lazy">
              <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
              <div class="absolute top-3 left-3 flex flex-wrap gap-1.5">
                <span class="bg-orange-400 text-orange-900 text-[10px] font-bold uppercase px-2.5 py-1 rounded-full tracking-wide">Wilderness Permit</span>
                <span class="bg-slate-900/70 text-white text-[10px] font-semibold px-2.5 py-1 rounded-full backdrop-blur-sm">Highest Trekking Peak</span>
              </div>
              <span class="absolute bottom-3 right-3 bg-slate-900/80 text-white text-[10px] font-bold px-2.5 py-1 rounded-full backdrop-blur-sm">Max 6,476m</span>
            </div>
            <div class="flex flex-col flex-1 p-5">
              <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-700">18 Days &bull; Everest Region</span>
                <span class="text-xs text-amber-500 font-semibold">Expedition</span>
              </div>
              <h3 class="text-xl font-bold text-slate-900 line-clamp-1 hover:text-sky-600 transition-colors">Mera Peak Climbing</h3>
              <p class="text-slate-500 text-sm line-clamp-2 mt-2 leading-relaxed">Nepal's highest trekking peak with panoramic views of five 8,000m giants from the summit.</p>
              <div class="flex flex-wrap gap-1.5 mt-3">
                <span class="bg-slate-100 text-slate-600 text-[10px] font-medium px-2 py-0.5 rounded-full">Panoramic Summit</span>
                <span class="bg-slate-100 text-slate-600 text-[10px] font-medium px-2 py-0.5 rounded-full">Glacier Skills</span>
              </div>
              <div class="border-t border-slate-100 mt-auto pt-4 flex items-center justify-between">
                <div>
                  <div class="text-[10px] uppercase tracking-wider text-slate-400 font-semibold">From</div>
                  <div class="text-lg font-extrabold text-slate-900">$2,590 <span class="text-xs font-medium text-slate-400">USD</span></div>
                </div>
                <a href="{{ route('packages.show') }}" class="bg-slate-900 hover:bg-slate-800 text-white font-semibold px-4 py-2 rounded-xl text-sm transition">View itinerary</a>
              </div>
            </div>
          </article>

        </div>

      </div>
    </section>

    <section id="regions" class="bg-slate-950 text-white py-20 px-4 md:px-8" aria-labelledby="regions-title">
      <div class="max-w-7xl mx-auto">

        <!-- Section Header -->
        <div class="text-center mb-12">
          <span class="text-amber-400 text-xs font-bold tracking-widest uppercase mb-2 block">Geographic Diversity</span>
          <h2 id="regions-title" class="text-3xl lg:text-4xl font-extrabold tracking-tight text-white mb-3">Explore Nepal by Region</h2>
          <p class="text-slate-400 max-w-2xl mx-auto text-sm md:text-base">From the soaring 8,000-meter giants of the Khumbu to the forbidden walled kingdom of Upper Mustang</p>
        </div>

        <!-- 4-Column Card Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

          <!-- Card 1: Everest Region -->
          <a href="{{ route('packages.show') }}" class="relative h-[400px] rounded-2xl border border-slate-800 shadow-xl group cursor-pointer overflow-hidden">
            <img src="{{ asset('site/assets/everest-hikers.jpg') }}" alt="Everest Region" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" loading="lazy">
            <div class="bg-gradient-to-t from-slate-950 via-slate-950/60 to-transparent absolute inset-0"></div>
            <div class="absolute inset-0 p-6 flex flex-col justify-end text-left z-10">
              <span class="text-amber-400 text-[10px] font-bold uppercase tracking-widest mb-1.5">Solukhumbu</span>
              <h3 class="text-xl font-bold text-white mb-2">Everest Region</h3>
              <p class="text-slate-400 text-sm leading-relaxed mb-3">High trails, Sherpa villages, monasteries and classic views toward Everest.</p>
              <span class="text-sky-400 group-hover:text-sky-300 font-semibold text-xs transition flex items-center gap-1">
                Explore region
                <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
              </span>
            </div>
          </a>

          <!-- Card 2: Annapurna Sanctuary -->
          <a href="{{ route('packages.show') }}" class="relative h-[400px] rounded-2xl border border-slate-800 shadow-xl group cursor-pointer overflow-hidden">
            <img src="{{ asset('site/assets/annapurna-sunrise.jpg') }}" alt="Annapurna Sanctuary" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" loading="lazy">
            <div class="bg-gradient-to-t from-slate-950 via-slate-950/60 to-transparent absolute inset-0"></div>
            <div class="absolute inset-0 p-6 flex flex-col justify-end text-left z-10">
              <span class="text-emerald-400 text-[10px] font-bold uppercase tracking-widest mb-1.5">Gandaki Province</span>
              <h3 class="text-xl font-bold text-white mb-2">Annapurna Sanctuary</h3>
              <p class="text-slate-400 text-sm leading-relaxed mb-3">Lush rhododendron valleys, Poon Hill sunrises, and Thorong La Pass.</p>
              <span class="text-sky-400 group-hover:text-sky-300 font-semibold text-xs transition flex items-center gap-1">
                Explore region
                <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
              </span>
            </div>
          </a>

          <!-- Card 3: Manaslu & Tsum -->
          <a href="{{ route('packages.show') }}" class="relative h-[400px] rounded-2xl border border-slate-800 shadow-xl group cursor-pointer overflow-hidden">
            <img src="{{ asset('site/assets/manaslu-birendra-lake.webp') }}" alt="Turquoise Birendra Lake below snowy mountains near Samagaun" width="1200" height="800" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" loading="lazy">
            <div class="bg-gradient-to-t from-slate-950 via-slate-950/60 to-transparent absolute inset-0"></div>
            <div class="absolute inset-0 p-6 flex flex-col justify-end text-left z-10">
              <span class="text-orange-400 text-[10px] font-bold uppercase tracking-widest mb-1.5">Restricted Wilderness</span>
              <h3 class="text-xl font-bold text-white mb-2">Manaslu &amp; Tsum</h3>
              <p class="text-slate-400 text-sm leading-relaxed mb-3">Pure tranquility, ancient Tibetan monasteries, and Larkya La pass.</p>
              <span class="text-sky-400 group-hover:text-sky-300 font-semibold text-xs transition flex items-center gap-1">
                Explore region
                <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
              </span>
            </div>
          </a>

          <!-- Card 4: Langtang & Helambu -->
          <a href="{{ route('packages.show') }}" class="relative h-[400px] rounded-2xl border border-slate-800 shadow-xl group cursor-pointer overflow-hidden">
            <img src="{{ asset('site/assets/langtang-kyanjin-village.webp') }}" alt="Kyanjin Gompa village beneath the mountains of Langtang Valley" width="1200" height="900" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" loading="lazy">
            <div class="bg-gradient-to-t from-slate-950 via-slate-950/60 to-transparent absolute inset-0"></div>
            <div class="absolute inset-0 p-6 flex flex-col justify-end text-left z-10">
              <span class="text-sky-400 text-[10px] font-bold uppercase tracking-widest mb-1.5">Pasang Lamu Gateway</span>
              <h3 class="text-xl font-bold text-white mb-2">Langtang &amp; Helambu</h3>
              <p class="text-slate-400 text-sm leading-relaxed mb-3">Glacier-carved valleys, sacred high lakes, and authentic Tamang culture.</p>
              <span class="text-sky-400 group-hover:text-sky-300 font-semibold text-xs transition flex items-center gap-1">
                Explore region
                <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
              </span>
            </div>
          </a>

        </div>

      </div>
    </section>

    <section id="destinations" class="bg-white py-20 px-4 md:px-8" aria-labelledby="destinations-title">
      <div class="max-w-7xl mx-auto">

        <!-- Section Header -->
        <div class="text-center mb-12">
          <span class="text-amber-500 text-xs font-bold tracking-widest uppercase mb-2 block">Where to Go</span>
          <h2 id="destinations-title" class="text-3xl lg:text-4xl font-extrabold tracking-tight text-slate-900 mb-3">Destinations</h2>
          <p class="text-slate-500 max-w-2xl mx-auto text-sm md:text-base">Beyond Nepal, we also craft journeys across the Himalayan plateau and the kingdom of Bhutan.</p>
        </div>

        <!-- 3-Column Destination Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

          <!-- Card 1: Nepal -->
          <a href="#journeys" class="group relative h-[420px] rounded-2xl border border-slate-200/80 shadow-lg overflow-hidden cursor-pointer">
            <img src="{{ asset('site/assets/annapurna-sunrise.jpg') }}" alt="Nepal Himalayan panorama" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" loading="lazy">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/50 to-transparent"></div>
            <div class="absolute inset-0 p-6 flex flex-col justify-end text-left z-10">
              <span class="text-amber-400 text-[10px] font-bold uppercase tracking-widest mb-1.5">The Himalayan Kingdom</span>
              <h3 class="text-2xl font-bold text-white mb-2">Nepal</h3>
              <p class="text-slate-300 text-sm leading-relaxed mb-3">World-class trekking, ancient cities, wildlife lowlands and the highest peaks on Earth.</p>
              <span class="text-sky-400 group-hover:text-sky-300 font-semibold text-xs transition flex items-center gap-1">
                Explore journeys
                <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
              </span>
            </div>
          </a>

          <!-- Card 2: Tibet Tours -->
          <a href="#plan" class="group relative h-[420px] rounded-2xl border border-slate-200/80 shadow-lg overflow-hidden cursor-pointer">
            <img src="{{ asset('site/assets/kathmandu-stupa.jpg') }}" alt="Tibetan Buddhist stupa with prayer flags" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" loading="lazy">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/50 to-transparent"></div>
            <div class="absolute inset-0 p-6 flex flex-col justify-end text-left z-10">
              <span class="text-orange-400 text-[10px] font-bold uppercase tracking-widest mb-1.5">The Roof of the World</span>
              <h3 class="text-2xl font-bold text-white mb-2">Tibet Tours</h3>
              <p class="text-slate-300 text-sm leading-relaxed mb-3">Sacred monasteries, vast high-altitude landscapes and the spiritual heart of the Himalayas.</p>
              <span class="text-sky-400 group-hover:text-sky-300 font-semibold text-xs transition flex items-center gap-1">
                Plan a Tibet journey
                <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
              </span>
            </div>
          </a>

          <!-- Card 3: Bhutan Tours -->
          <a href="#plan" class="group relative h-[420px] rounded-2xl border border-slate-200/80 shadow-lg overflow-hidden cursor-pointer">
            <img src="{{ asset('site/assets/everest-hikers.jpg') }}" alt="Bhutan Himalayan landscape" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" loading="lazy">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/50 to-transparent"></div>
            <div class="absolute inset-0 p-6 flex flex-col justify-end text-left z-10">
              <span class="text-emerald-400 text-[10px] font-bold uppercase tracking-widest mb-1.5">The Last Shangri-La</span>
              <h3 class="text-2xl font-bold text-white mb-2">Bhutan Tours</h3>
              <p class="text-slate-300 text-sm leading-relaxed mb-3">Dramatic fortresses, pristine valleys and a kingdom measured by Gross National Happiness.</p>
              <span class="text-sky-400 group-hover:text-sky-300 font-semibold text-xs transition flex items-center gap-1">
                Plan a Bhutan journey
                <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
              </span>
            </div>
          </a>

        </div>

      </div>
    </section>



    <section id="reviews" class="bg-slate-50 text-slate-900 py-20 px-4 md:px-8" aria-labelledby="reviews-title">
      <div class="max-w-7xl mx-auto">

        <!-- Section Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-12">
          <!-- Left: Titles -->
          <div>
            <span class="text-amber-500 text-xs font-bold tracking-widest uppercase mb-2 block">Unfiltered Proof</span>
            <h2 id="reviews-title" class="text-3xl lg:text-4xl font-extrabold tracking-tight text-slate-900">Guest Stories</h2>
          </div>
          <!-- Right: Overall Rating Badge -->
          <div class="bg-amber-50/80 border border-amber-200/60 rounded-2xl p-4 flex items-center gap-4 text-center shadow-sm">
            <div>
              <div class="text-3xl font-extrabold text-slate-900">4.9</div>
              <div class="text-amber-400 text-xs mt-0.5">★★★★★</div>
              <div class="text-[10px] tracking-wider font-semibold text-slate-600 block mt-1">Traveler satisfaction</div>
            </div>
          </div>
        </div>

        <!-- 3-Column Testimonial Card Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

          <!-- Card 1: Marcus & Claire Vance -->
          <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition duration-300 flex flex-col justify-between">
            <div>
              <!-- Top Meta Row -->
              <div class="flex items-center justify-between">
                <span class="text-amber-400 text-xs">★★★★★</span>
                <span class="text-slate-400 text-xs">Nov 2025</span>
              </div>
              <!-- Quote Heading -->
              <h3 class="text-base font-bold text-slate-900 mt-4 mb-2">"The route felt ambitious, but well paced"</h3>
              <!-- Review Body -->
              <p class="text-slate-500 text-xs leading-relaxed">We wanted an Everest route that felt ambitious but still thoughtful. The itinerary gave us time to settle into the trail, enjoy Namche, and keep the mountain days manageable.</p>
            </div>
            <!-- Card Footer -->
            <div class="flex items-center justify-between mt-4 pt-4 border-t border-slate-100">
              <div>
                <div class="font-bold text-slate-900 text-xs">Marcus &amp; Claire Vance</div>
                <div class="text-slate-400 text-[11px]">United Kingdom</div>
              </div>
              <span class="bg-emerald-50 text-emerald-700 text-[11px] font-medium px-2.5 py-1 rounded-md">EBC Trek</span>
            </div>
          </div>

          <!-- Card 2: David & Sarah Henderson -->
          <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition duration-300 flex flex-col justify-between">
            <div>
              <!-- Top Meta Row -->
              <div class="flex items-center justify-between">
                <span class="text-amber-400 text-xs">★★★★★</span>
                <span class="text-slate-400 text-xs">Oct 2025</span>
              </div>
              <!-- Quote Heading -->
              <h3 class="text-base font-bold text-slate-900 mt-4 mb-2">"First flight out to Lukla &amp; pristine safety management"</h3>
              <!-- Review Body -->
              <p class="text-slate-500 text-xs leading-relaxed">Their airport connections and standby slots ensure you don't get trapped by Lukla weather. The food was fresh, hot, and hygienic. Our guide Dawa was patient with our 12-year-old son the whole trail.</p>
            </div>
            <!-- Card Footer -->
            <div class="flex items-center justify-between mt-4 pt-4 border-t border-slate-100">
              <div>
                <div class="font-bold text-slate-900 text-xs">David &amp; Sarah Henderson</div>
                <div class="text-slate-400 text-[11px]">Australia</div>
              </div>
              <span class="bg-emerald-50 text-emerald-700 text-[11px] font-medium px-2.5 py-1 rounded-md">EBC Family</span>
            </div>
          </div>

          <!-- Card 3: Jens Lindqvist -->
          <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition duration-300 flex flex-col justify-between">
            <div>
              <!-- Top Meta Row -->
              <div class="flex items-center justify-between">
                <span class="text-amber-400 text-xs">★★★★★</span>
                <span class="text-slate-400 text-xs">April 2025</span>
              </div>
              <!-- Quote Heading -->
              <h3 class="text-base font-bold text-slate-900 mt-4 mb-2">"True Sherpa heritage and respect for the mountains"</h3>
              <!-- Review Body -->
              <p class="text-slate-500 text-xs leading-relaxed">You immediately sense the difference when booking with native Sherpas. Our porter had lightweight, proper mountain gear, and our guide treated the monasteries and trails with sacred respect. 10/10 recommendation.</p>
            </div>
            <!-- Card Footer -->
            <div class="flex items-center justify-between mt-4 pt-4 border-t border-slate-100">
              <div>
                <div class="font-bold text-slate-900 text-xs">Jens Lindqvist</div>
                <div class="text-slate-400 text-[11px]">Sweden</div>
              </div>
              <span class="bg-emerald-50 text-emerald-700 text-[11px] font-medium px-2.5 py-1 rounded-md">Annapurna Circuit</span>
            </div>
          </div>

        </div>

      </div>
    </section>

    <section id="why-nepal" class="story section">
      <div class="container story-grid">
        <div class="story-visual" data-aos="fade-right"><img src="{{ asset('site/assets/photo-1544735716-392fe2489ffa.avif') }}"
            alt="Trekkers passing a prayer-flagged stupa beneath snow-covered Himalayan peaks" width="1200" height="800" loading="lazy" decoding="async">
          <div class="story-tag">THE BEST STORIES<br>START ON THE ROAD.</div>
        </div>
        <div class="story-copy" data-aos="fade-left"><span class="eyebrow dark">THE WAY WE SEE IT</span>
          <h2>Take the road.<br><em>Feel the place.</em></h2>
          <p>A great journey makes room for wonder, conversation, and the unexpected. These are the things we want you
            to have space for, whether you are walking for two weeks or exploring a city for two days.</p>
          <div class="story-points">
            <div><span>01</span>
              <div>
                <h3>Go beyond the postcard</h3>
                <p>Find meaningful moments in Nepal's streets, villages, landscapes and everyday life.</p>
              </div>
            </div>
            <div><span>02</span>
              <div>
                <h3>Travel at your pace</h3>
                <p>Choose an active challenge, a slower cultural journey, or a little of both.</p>
              </div>
            </div>
            <div><span>03</span>
              <div>
                <h3>Make it yours</h3>
                <p>Tell us what matters to you and we can discuss a journey shaped around it.</p>
              </div>
            </div>
          </div><a class="btn btn-navy" href="#plan">Let's plan something memorable ↗</a>
        </div>
      </div>
    </section>



    <section id="journeys" class="journeys section" aria-labelledby="journeys-title">
      <div class="container">
        <div class="section-heading" data-aos="fade-up">
          <div><span class="eyebrow dark">THE JOURNEY IS THE REWARD</span>
            <h2 id="journeys-title">Find your next <em>chapter.</em></h2>
          </div>
          <p>Mountain paths, living heritage, and the wilder side of Nepal. Start with the kind of experience that
            speaks to you.</p>
        </div>
        <div class="filter-row" role="group" aria-label="Filter journeys"><button type="button"
            :class="activeFilter==='all' ? 'active' : ''" @click="activeFilter='all'"
            :aria-pressed="(activeFilter==='all').toString()">All journeys</button><button type="button"
            :class="activeFilter==='trekking' ? 'active' : ''" @click="activeFilter='trekking'"
            :aria-pressed="(activeFilter==='trekking').toString()">Trekking</button><button type="button"
            :class="activeFilter==='culture' ? 'active' : ''" @click="activeFilter='culture'"
            :aria-pressed="(activeFilter==='culture').toString()">Culture</button><button type="button"
            :class="activeFilter==='wildlife' ? 'active' : ''" @click="activeFilter='wildlife'"
            :aria-pressed="(activeFilter==='wildlife').toString()">Wildlife</button></div>
        <p class="result-count" aria-live="polite" x-text="visibleCount() + ' journeys'">4 journeys</p>
        <div class="trip-grid">
          <article id="trip-annapurna" class="trip-card" x-show="activeFilter==='all'||activeFilter==='trekking'">
            <div class="trip-image"><img src="{{ asset('site/assets/annapurna-sunrise.jpg') }}"
                alt="Sunrise reaching snowy peaks in the Annapurna region" width="1400" height="933"
                loading="lazy"><span class="trip-category">MOUNTAIN TREK</span></div>
            <div class="trip-content">
              <div class="trip-meta"><span>ANNAPURNA REGION</span><span>01 / 04</span></div>
              <h3>Annapurna Sanctuary</h3>
              <p>Walk through rhododendron forest and mountain villages into a spectacular natural amphitheatre.</p>
              <div class="trip-facts"><span>◷ &nbsp; 10–14 days*</span><span>↗ &nbsp; Challenging</span></div>
              <p class="trip-price"><span class="trip-price__from">From</span> USD 1,240
                <small>per person*</small></p><a href="{{ route('packages.show') }}">View this itinerary ↗</a>
            </div>
          </article>
          <article id="trip-everest" class="trip-card" x-show="activeFilter==='all'||activeFilter==='trekking'">
            <div class="trip-image"><img src="{{ asset('site/assets/everest-hikers.jpg') }}"
                alt="Hikers on a trail in Nepal's Everest region" width="1200" height="800" loading="lazy"><span
                class="trip-category">ICONIC TREK</span></div>
            <div class="trip-content">
              <div class="trip-meta"><span>EVEREST REGION</span><span>02 / 04</span></div>
              <h3>Everest Base Camp</h3>
              <p>Follow the trail through Sherpa communities, high valleys, and extraordinary Himalayan scenery.</p>
              <div class="trip-facts"><span>◷ &nbsp; 12–16 days*</span><span>↗ &nbsp; Challenging</span></div>
              <p class="trip-price"><span class="trip-price__from">From</span> USD 1,690
                <small>per person*</small></p><a href="{{ route('packages.show') }}">View this itinerary ↗</a>
            </div>
          </article>
          <article id="trip-valley" class="trip-card" x-show="activeFilter==='all'||activeFilter==='culture'">
            <div class="trip-image"><img src="{{ asset('site/assets/kathmandu-stupa.jpg') }}"
                alt="Boudhanath Stupa and prayer flags in Kathmandu" width="1200" height="800" loading="lazy"><span
                class="trip-category">CULTURAL JOURNEY</span></div>
            <div class="trip-content">
              <div class="trip-meta"><span>KATHMANDU VALLEY</span><span>03 / 04</span></div>
              <h3>Valley &amp; Heritage</h3>
              <p>Slow down among old city squares, sacred spaces, artisan lanes, and living traditions.</p>
              <div class="trip-facts"><span>◷ &nbsp; 4–7 days*</span><span>↗ &nbsp; Easy going</span></div>
              <p class="trip-price"><span class="trip-price__from">From</span> USD 620
                <small>per person*</small></p><a href="{{ route('packages.show') }}">View this itinerary ↗</a>
            </div>
          </article>
          <article id="trip-chitwan" class="trip-card" x-show="activeFilter==='all'||activeFilter==='wildlife'">
            <div class="trip-image"><img src="{{ asset('site/assets/chitwan-rhinos.jpg') }}"
                alt="Two one-horned rhinoceroses in Chitwan National Park" width="1200" height="800"
                loading="lazy"><span class="trip-category">WILDLIFE ESCAPE</span></div>
            <div class="trip-content">
              <div class="trip-meta"><span>CHITWAN LOWLANDS</span><span>04 / 04</span></div>
              <h3>Into the Wild</h3>
              <p>Trade mountain air for river mornings, forest walks, and the rich wildlife of the Terai.</p>
              <div class="trip-facts"><span>◷ &nbsp; 3–5 days*</span><span>↗ &nbsp; Easy going</span></div>
              <p class="trip-price"><span class="trip-price__from">From</span> USD 480
                <small>per person*</small></p><a href="{{ route('packages.show') }}">View this itinerary ↗</a>
            </div>
          </article>
        </div>
        <p class="price-note">* Journey lengths and starting prices are indicative per person and depend on group size,
          season and the route you choose. Routes, inclusions and availability are confirmed when you enquire.</p>
      </div>
    </section>

    <section id="faq" class="faq section" aria-labelledby="faq-title">
      <div class="container faq-grid">
        <div class="faq-intro" data-aos="fade-right"><span class="eyebrow dark">FREQUENTLY ASKED QUESTIONS</span>
          <h2 id="faq-title">Good questions.<br><em>Clear answers.</em></h2>
          <p>A few things to know as you explore a trip through Nepal. Specific routes and arrangements can be discussed
            when you enquire.</p><a class="text-link" href="#plan">Explore the enquiry form <span
              aria-hidden="true">↗</span></a>
        </div>
        <div class="faq-side">
          <div class="faq-list" data-aos="fade-left">
          <details id="best-time">
            <summary><span>01</span><strong>When is a good time to visit Nepal?</strong><span class="plus"
                aria-hidden="true">+</span></summary>
            <p>Spring and autumn are popular for many treks. Cities and lowland areas can be rewarding at other times
              too. The best season depends on your route and what you want to experience.</p>
          </details>
          <details id="trek-experience">
            <summary><span>02</span><strong>Do I need trekking experience?</strong><span class="plus"
                aria-hidden="true">+</span></summary>
            <p>It depends on the route. Some walks suit first-time trekkers who prepare well; longer or higher routes
              call for stronger fitness and experience.</p>
          </details>
          <details>
            <summary><span>03</span><strong>How do I choose the right trek?</strong><span class="plus"
                aria-hidden="true">+</span></summary>
            <p>Start with your available days, walking experience, comfort with altitude, and the landscapes you most
              want to see. Those details help narrow the options.</p>
          </details>
          <details id="combine-trips">
            <summary><span>04</span><strong>Can I combine trekking, culture and wildlife?</strong><span class="plus"
                aria-hidden="true">+</span></summary>
            <p>Yes, a mixed journey can include a trek, time in Kathmandu and a visit to the lowlands. Travel time and
              season help determine a sensible order.</p>
          </details>
          <details>
            <summary><span>05</span><strong>Are the menu trips ready to book?</strong><span class="plus"
                aria-hidden="true">+</span></summary>
            <p>The listed trip names are enquiry topics. Routes, dates, prices and availability are confirmed before a
              trip is offered.</p>
          </details>
          <details>
            <summary><span>06</span><strong>What happens when I use the enquiry form?</strong><span class="plus"
                aria-hidden="true">+</span></summary>
            <p>The form collects the details needed to shape your enquiry. Final submission should be connected to email
              or a CRM before launch.</p>
          </details>
          </div>
        </div>
      </div>
    </section>

    <section id="plan" class="plan-section" aria-labelledby="plan-title">
      <div class="container plan-grid" data-aos="fade-up">
        <div><span class="eyebrow light-eye">YOUR NEXT STORY IS WAITING</span>
          <h2 id="plan-title">Let's make it<br><em>unforgettable.</em></h2>
          <p>Dreaming of a trek? Curious about a slower journey? Tell us what is on your mind and start shaping your
            Nepal story.</p>
          <p class="plan-small">Share your dates, interests and travel style so our team can recommend the right route.</p>
        </div>
        <form class="plan-card" @submit.prevent="formSubmitted=true"><span class="plan-card-top">TELL US WHAT YOU HAVE
            IN MIND <span>✦</span></span><label for="guest-name">Your name <span>*</span></label><input id="guest-name"
            name="name" type="text" autocomplete="name" required placeholder="Your name"><label for="guest-email">Email
            address <span>*</span></label><input id="guest-email" name="email" type="email" autocomplete="email"
            required placeholder="you@example.com"><label for="guest-interest">I'm interested in</label><input
            id="guest-interest" name="interest" type="text" x-model="selectedTrip"
            placeholder="A trek, tour or place"><label for="guest-message">What would you like to
            experience?</label><textarea id="guest-message" name="message" rows="3"
            placeholder="Your ideas, dates or questions"></textarea><button class="btn btn-orange" type="submit">Send
            enquiry ↗</button>
          <p class="form-confirmation" role="status" x-show="formSubmitted" x-cloak>Thank you. Please contact our team
            by phone or email to complete your enquiry.</p>
        </form>
      </div>
    </section>

    <section id="newsletter" class="newsletter" aria-labelledby="newsletter-title">
      <div class="container newsletter-grid" data-aos="fade-up">
        <div class="newsletter-copy"><span class="eyebrow dark">NOTES FROM NEPAL</span>
          <h2 id="newsletter-title">A little Nepal in <em>your inbox.</em></h2>
          <p>Journey ideas, places to discover, and thoughtful travel notes from Nepal.</p>
        </div>
        <form class="newsletter-form" @submit.prevent="newsletterSubmitted=true"><label for="newsletter-email">Your
            email address</label>
          <div class="newsletter-field"><input id="newsletter-email" name="newsletter-email" type="email"
              autocomplete="email" required placeholder="you@example.com" @input="newsletterSubmitted=false"><button
              type="submit">Join newsletter <span aria-hidden="true">↗</span></button></div>
          <p class="newsletter-note">Occasional travel notes, planning tips and seasonal journey ideas.</p>
          <p class="newsletter-confirmation" role="status" x-show="newsletterSubmitted" x-cloak>Thank you for your interest in Nepal travel updates.</p>
        </form>
      </div>
    </section>
  </main>
  <footer class="footer" id="footer">
    <div class="footer-main">
      <div class="container footer-main-grid">
        <div class="footer-about">
          <a class="footer-logo" href="#top" aria-label="Explore Nepal Holidays, back to top"><img
              src="{{ asset('site/assets/footer-logo-compact.png') }}" alt="Explore Nepal Holidays" width="620" height="207"
              loading="lazy"></a>
          <p>For mountain days, meaningful encounters, and all the moments in between. Find your own way into Nepal.</p>
          <a class="footer-plan" href="#plan">Start planning your journey <span aria-hidden="true">↗</span></a>
        </div>
        <nav class="footer-nav" aria-label="Footer exploration links">
          <h2>Explore Nepal</h2>
          <a href="{{ route('about') }}">About Us</a>
          <a href="{{ route('team') }}">Our Team</a>
          <a href="{{ route('home') }}#why-choose">Why travel with us</a>
          <a href="{{ route('contact') }}">Contact Us</a>
          <a href="#journeys">Featured journeys</a>
          <a href="#expeditions">Flagship expeditions</a>
          <a href="#regions">Regions</a>
          <a href="#why-choose">Why choose us</a>
          <a href="{{ route('home') }}#testimonials">Guest reviews</a>
          <a href="#newsletter">Newsletter</a>
          <a href="{{ route('faq') }}">FAQs</a>
        </nav>
        <nav class="footer-nav" aria-label="Footer planning links">
          <h2>Plan your trip</h2>
          <a href="#journeys" @click="activeFilter='trekking'">Trekking journeys</a>
          <a href="#journeys" @click="activeFilter='culture'">Culture &amp; heritage</a>
          <a href="#journeys" @click="activeFilter='wildlife'">Wildlife escapes</a>
          <a href="#plan">Tell us your ideas</a>
        </nav>
        <div class="footer-contact-card">
          <h2>Contact</h2>
          <address class="footer-contact"><span>VISIT US</span>Thamel, Kathmandu, Nepal <small>Office address</small><span class="footer-contact-label">CALL US</span><a href="tel:+9779800000000">+977
              980-000-0000</a><small>Trip planning desk</small></address>
          <div class="footer-social" aria-label="Social media">
            <span class="footer-social-label">FIND US ONLINE</span>
            <div class="footer-social-icons">
              <span class="social-icon social-pending" role="img" aria-label="Facebook profile link pending"
                title="Facebook profile link pending"><img class="icon-img icon-img--dark" src="{{ asset('site/assets/icons/facebook.svg') }}" alt=""></span>
              <span class="social-icon social-pending" role="img" aria-label="Instagram profile link pending"
                title="Instagram profile link pending"><img class="icon-img icon-img--dark" src="{{ asset('site/assets/icons/instagram.svg') }}" alt=""></span>
              <span class="social-icon social-pending" role="img" aria-label="TikTok profile link pending"
                title="TikTok profile link pending"><img class="icon-img icon-img--dark" src="{{ asset('site/assets/icons/tiktok.svg') }}" alt=""></span>
              <span class="social-icon social-pending" role="img" aria-label="YouTube channel link pending"
                title="YouTube channel link pending"><img class="icon-img icon-img--dark" src="{{ asset('site/assets/icons/youtube.svg') }}" alt=""></span>
              <a class="social-icon"
                href="https://wa.me/?text=I%27m%20planning%20a%20Nepal%20trip%20with%20Explore%20Nepal%20Holidays."
                target="_blank" rel="noopener noreferrer" aria-label="Share your Nepal trip plans on WhatsApp"
                title="Share your trip plans on WhatsApp"><img class="icon-img icon-img--dark" src="{{ asset('site/assets/icons/whatsapp.svg') }}" alt=""></a>
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
        <img class="icon-img icon-img--light" src="{{ asset('site/assets/icons/search.svg') }}" alt="">
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
            class="trip-search-result" href="{{ route('packages.show') }}"><span
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
    <a class="whatsapp-float" x-show="showBackToTop" x-cloak
      href="https://wa.me/?text=I%27m%20planning%20a%20Nepal%20trip%20with%20Explore%20Nepal%20Holidays."
      target="_blank" rel="noopener noreferrer" aria-label="Share your Nepal trip plans on WhatsApp"
      title="Share your trip plans on WhatsApp"><img class="icon-img icon-img--dark" src="{{ asset('site/assets/icons/whatsapp.svg') }}" alt=""></a>
  </div>
@endsection
