@extends('layouts.site')

@section('page_title', 'Contact Us | Explore Nepal Holidays')
@section('meta_description', 'Contact Explore Nepal Holidays about your Nepal travel plans. View a Kathmandu map and use the enquiry form preview to share your questions.')
@section('og_image', asset('site/assets/annapurna-sunrise.jpg'))
@section('body_class', 'bg-paper text-ink font-sans')

@push('page_styles')
<link rel="stylesheet" href="{{ asset('site/styles/about.css') }}">
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
            <a href="{{ route('home') }}#regions" @click="closeNav()">Why travel Nepal ↗</a>
            <a href="{{ route('home') }}#reviews" @click="closeNav()">Traveller stories ↗</a>
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
        <a class="nav-contact" href="{{ route('contact') }}" aria-current="page" @mouseenter="openNav=null">Contact Us <span aria-hidden="true">↗</span></a>
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
          <a href="{{ route('home') }}#regions" @click="menuOpen=false">Why Nepal</a>
          <a href="{{ route('home') }}#reviews" @click="menuOpen=false">Traveller stories</a>
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
      <a class="mobile-contact font-semibold text-white bg-orange-brand" href="{{ route('contact') }}" aria-current="page" @click="menuOpen=false">Contact Us <span aria-hidden="true">↗</span></a>
    </nav>
  </header>

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
          <span>EXPLORE NEPAL HOLIDAYS</span>
          <h2 id="contact-details-title">Company contact details</h2>
        </header>
        <div class="contact-details-grid">
          <article class="contact-detail">
            <h3>Location</h3>
            <p>Kathmandu, Nepal</p>
            <small>Specific office address and post box have not been supplied.</small>
          </article>
          <article class="contact-detail">
            <h3>Email</h3>
            <p>Not supplied</p>
          </article>
          <article class="contact-detail">
            <h3>Phone</h3>
            <p>Not supplied</p>
          </article>
          <article class="contact-detail">
            <h3>Mobile / WhatsApp</h3>
            <p>Not supplied</p>
          </article>
          <article class="contact-detail">
            <h3>Emergency call</h3>
            <p>Not supplied</p>
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
          <a href="{{ route('contact') }}" aria-current="page">Contact Us</a>
          <a href="{{ route('home') }}#journeys">Featured journeys</a>
          <a href="{{ route('home') }}#journeys">Ways to travel</a>
          <a href="{{ route('home') }}#why-nepal">Our approach</a>
          <a href="{{ route('home') }}#reviews">Traveller stories</a>
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
          <div class="footer-contact">
            <span>PLAN YOUR TRIP</span>
            <a href="{{ route('home') }}#plan">Share your travel ideas</a>
            <small>Dates, interests and your preferred pace are a good place to start.</small>
          </div>
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
