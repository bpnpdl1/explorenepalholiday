@extends('layouts.site')

@section('page_title', 'Something Went Wrong | Explore Nepal Holidays')
@section('meta_description', 'We are having trouble loading this page. Please try again or explore Nepal Holidays another way.')
@section('meta_robots', 'noindex, follow')
@section('og_image', asset('site/assets/langtang-lirung.webp'))
@section('body_class', 'package-page error-page')

@push('page_styles')
<link rel="stylesheet" href="{{ asset('site/styles/package.css') }}">
<link rel="stylesheet" href="{{ asset('site/styles/error-pages.css') }}">
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
  <main id="main" class="error-main">
    <section class="error-banner" aria-labelledby="error-title">
      <img class="error-banner-image" src="{{ asset('site/assets/langtang-lirung.webp') }}" alt="" width="1600" height="900" fetchpriority="high">
      <div class="error-banner-shade" aria-hidden="true"></div>
      <div class="error-banner-content"><nav aria-label="Breadcrumb"><a href="{{ route('home') }}">Home</a><span aria-hidden="true">/</span><span>500</span></nav><p>ERROR 500</p><h1 id="error-title">A temporary detour</h1><div>We’re having trouble loading this page right now.</div></div>
    </section>
    <section class="error-card" aria-labelledby="error-card-title">
      <h2 id="error-card-title">Let’s get you back on track</h2>
      <p class="error-copy">Something went wrong while loading this page. Please try again in a moment, or return to our journeys.</p>
      <div class="error-actions"><button class="error-primary" type="button" onclick="window.location.reload()">Try again</button><a class="error-secondary" href="{{ route('home') }}">Back to home <span aria-hidden="true">↗</span></a></div>
      <p class="error-help">If this keeps happening, <a href="{{ route('contact') }}">contact our team</a>.</p>
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
