  <div class="topbar">
    <div class="container topbar-inner"><span>20 Years Experience</span><a
        href="https://wa.me/9779800000000" target="_blank" rel="noopener noreferrer">+977-9800000000 · WhatsApp ↗</a></div>
  </div>
  <header class="site-header" :class="headerCompact ? 'is-compact' : ''" @mouseleave="openNav=null">
    <div class="container header-primary">
      <a class="brand" href="{{ route('home') }}#top" aria-label="Explore Nepal Holidays, home"><span class="brand-mark"><img
            src="{{ asset('site/assets/logo-mark.png') }}" alt="" width="78" height="63"></span><span class="brand-name">EXPLORE
          <small>NEPAL HOLIDAYS</small></span></a>
      <div class="header-actions flex items-center gap-3"><button
          class="header-find inline-flex items-center gap-2 font-medium transition-colors" type="button"
          @click="openTripSearch()">
          <img class="icon-img icon-img--light" src="{{ asset('site/assets/icons/search.svg') }}" alt="">Find a Trip</button><a
          class="header-cta inline-flex items-center justify-center font-semibold text-white bg-orange-brand hover:bg-orange-hover transition-colors rounded-brand"
          href="{{ route('home') }}#plan">Plan your journey <span aria-hidden="true">↗</span></a></div>
      <button class="mobile-find" type="button" @click="openTripSearch()" aria-label="Find a trip">
      <img class="icon-img icon-img--light" src="{{ asset('site/assets/icons/search.svg') }}" alt=""></button>
      <button class="menu-toggle" type="button" @click="menuOpen=!menuOpen;mobileSection=null;mobileRegion=null"
        :aria-expanded="menuOpen.toString()" aria-controls="mobile-menu"
        aria-label="Toggle menu"><span></span><span></span><span></span></button>
    </div>
    <div class="header-nav-row">
      <nav class="container desktop-nav" aria-label="Primary navigation">
        <a class="compact-brand" href="{{ route('home') }}#top" aria-label="Explore Nepal Holidays, back to top"><img
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
              href="{{ route('home') }}#why-nepal" @click="closeNav()">Our approach ↗</a><a href="{{ route('home') }}#why-choose" @click="closeNav()">Why choose us ↗</a><a href="{{ route('guest-reviews') }}" @click="closeNav()" @if (request()->routeIs('guest-reviews')) aria-current="page" @endif>Guest reviews ↗</a></div>
        </div>
        <div class="nav-item compact" @mouseenter="openNav='info'"
          @focusout="if(!$el.contains($event.relatedTarget)) openNav=null"><button type="button" data-nav-trigger="info"
            @click="openNav='info'" :aria-expanded="(openNav==='info').toString()" aria-controls="nav-info">Travel Info
            <span class="nav-chevron" aria-hidden="true"></span></button>
          <div id="nav-info" class="nav-panel dropdown-panel" x-show="openNav==='info'" x-cloak><a href="{{ route('faq') }}#planning"
              @click="closeNav()">Best time to visit ↗</a><a href="{{ route('faq') }}#trekking" @click="closeNav()">Trekking
              experience ↗</a><a href="{{ route('home') }}#combine-trips" @click="closeNav()">Combining experiences ↗</a><a href="{{ route('faq') }}"
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
        <div id="mobile-company" class="mobile-subnav" x-show="mobileSection==='company'" x-cloak><a href="{{ route('about') }}" @click="menuOpen=false">About Us</a><a href="{{ route('team') }}" @click="menuOpen=false">Our Team</a><a href="{{ route('home') }}#why-choose" @click="menuOpen=false">Why travel with us</a><a href="{{ route('home') }}#why-nepal"
            @click="menuOpen=false">Our approach</a><a href="{{ route('home') }}#why-choose" @click="menuOpen=false">Why choose us</a><a
            href="{{ route('guest-reviews') }}" @click="menuOpen=false" @if (request()->routeIs('guest-reviews')) aria-current="page" @endif>Guest reviews</a></div>
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
