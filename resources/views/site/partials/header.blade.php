  <script>
    window.NEPAL_NAVIGATION = @js($navigationCategories);
    window.NEPAL_PACKAGES = @js($packageSearchItems);
  </script>
  <div class="topbar" id="top">
    <div class="container topbar-inner"><span>{{ $siteSetting?->tagline ?: 'Thoughtful journeys across Nepal' }}</span>@if ($siteSetting?->whatsapp_number)<a href="https://wa.me/{{ preg_replace('/\D+/', '', $siteSetting->whatsapp_number) }}" target="_blank" rel="noopener noreferrer">{{ $siteSetting->whatsapp_number }} &middot; WhatsApp</a>@endif</div>
  </div>
  <header class="site-header" :class="headerCompact ? 'is-compact' : ''" @mouseleave="openNav=null">
    <div class="container header-primary">
      <a class="brand" href="{{ route('home') }}#top" aria-label="{{ $siteSetting?->name ?? config('app.name') }}, home"><span class="brand-mark"><img
            src="{{ $siteSetting?->logo_url ?: asset('site/assets/logo-mark.png') }}" alt="" width="78" height="63"></span><span class="brand-name">{{ $siteSetting?->name ?? config('app.name', 'Explore Nepal Holidays') }}</span></a>
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
        <a class="compact-brand" href="{{ route('home') }}#top" aria-label="{{ $siteSetting?->name ?? config('app.name') }}, back to top"><img
            src="{{ $siteSetting?->logo_url ?: asset('site/assets/logo-mark.png') }}" alt="" width="42" height="42"></a>
        @foreach ($navigationCategories as $navKey => $navCategory)
          @php($firstSubcategoryId = $navCategory['subcategories'][0]['id'] ?? '')
          <div class="nav-item cascade {{ $navKey }}-cascade" @mouseenter="openNav='{{ $navKey }}';openRegion='{{ $firstSubcategoryId }}'"
            @focusout="if(!$el.contains($event.relatedTarget)) openNav=null">
            <button type="button" data-nav-trigger="{{ $navKey }}" @click="openNav='{{ $navKey }}';openRegion='{{ $firstSubcategoryId }}'"
              :aria-expanded="(openNav==='{{ $navKey }}').toString()" aria-controls="nav-{{ $navKey }}">{{ $navCategory['label'] }} <span class="nav-chevron" aria-hidden="true"></span></button>
            <div id="nav-{{ $navKey }}" class="nav-panel cascade-panel {{ $navKey === 'tours' ? 'tour-cascade' : ($navKey === 'climbing' ? 'climbing-cascade' : '') }}" x-show="openNav==='{{ $navKey }}'" x-cloak>
              <div class="cascade-heading">{{ $navCategory['heading'] }} <span>{{ count($navCategory['subcategories']) }} categories</span></div>
              @forelse ($navCategory['subcategories'] as $subcategory)
                <div class="cascade-region" @mouseenter="openRegion='{{ $subcategory['id'] }}'" @focusin="openRegion='{{ $subcategory['id'] }}'">
                  <button type="button" @click="openRegion='{{ $subcategory['id'] }}'" :aria-expanded="(openRegion==='{{ $subcategory['id'] }}').toString()" aria-controls="region-{{ $subcategory['id'] }}">
                    <span>{{ $subcategory['name'] }}</span><span aria-hidden="true">›</span>
                  </button>
                  <div class="cascade-flyout" id="region-{{ $subcategory['id'] }}" x-show="openRegion==='{{ $subcategory['id'] }}'" x-cloak>
                    <div class="flyout-heading"><strong><a href="{{ $subcategory['url'] }}">Explore {{ $subcategory['name'] }}</a></strong><span>{{ count($subcategory['packages']) }} {{ $navCategory['item_label'] }}</span></div>
                    <div class="flyout-scroll">
                      @forelse ($subcategory['packages'] as $package)
                        <a href="{{ $package['url'] }}">{{ $package['name'] }}</a>
                      @empty
                        <p class="flyout-note mb-0">No published packages in this subcategory yet.</p>
                      @endforelse
                    </div>
                  </div>
                </div>
              @empty
                <p class="flyout-note mb-0">{{ $navCategory['empty_message'] }}</p>
              @endforelse
            </div>
          </div>
        @endforeach
        <div class="nav-item compact" @mouseenter="openNav='company'"
          @focusout="if(!$el.contains($event.relatedTarget)) openNav=null"><button type="button"
            data-nav-trigger="company" @click="openNav='company'" :aria-expanded="(openNav==='company').toString()"
            aria-controls="nav-company">Company <span class="nav-chevron" aria-hidden="true"></span></button>
          <div id="nav-company" class="nav-panel dropdown-panel" x-show="openNav==='company'" x-cloak><a href="{{ route('about') }}" @click="closeNav()">About Us ↗</a><a href="{{ route('team') }}" @click="closeNav()">Our Team ↗</a><a href="{{ route('why-choose-us') }}" @click="closeNav()" @if (request()->routeIs('why-choose-us')) aria-current="page" @endif>Why Choose Us ↗</a><a
              href="{{ route('approach') }}" @click="closeNav()" @if (request()->routeIs('approach')) aria-current="page" @endif>Our approach ↗</a><a href="{{ route('guest-reviews') }}" @click="closeNav()" @if (request()->routeIs('guest-reviews')) aria-current="page" @endif>Guest reviews ↗</a></div>
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
      @foreach ($navigationCategories as $navKey => $navCategory)
        <div class="mobile-nav-group">
          <button type="button" @click="toggleMobileSection('{{ $navKey }}')"
            :aria-expanded="(mobileSection==='{{ $navKey }}').toString()" aria-controls="mobile-{{ $navKey }}">{{ $navCategory['label'] }} <span aria-hidden="true">+</span></button>
          <div id="mobile-{{ $navKey }}" class="mobile-subnav" x-show="mobileSection==='{{ $navKey }}'" x-cloak>
            <p>{{ $navCategory['intro'] }}</p>
            @forelse ($navCategory['subcategories'] as $subcategory)
              <div class="mobile-region">
                <button type="button" @click="toggleMobileRegion('{{ $subcategory['id'] }}')"
                  :aria-expanded="(mobileRegion==='{{ $subcategory['id'] }}').toString()" aria-controls="mobile-region-{{ $subcategory['id'] }}">
                  <span>{{ $subcategory['name'] }}</span><span aria-hidden="true">+</span>
                </button>
                <div class="mobile-trip-list" id="mobile-region-{{ $subcategory['id'] }}" x-show="mobileRegion==='{{ $subcategory['id'] }}'" x-cloak>
                  <a class="mobile-subcategory-link" href="{{ $subcategory['url'] }}" @click="menuOpen=false;mobileSection=null;mobileRegion=null">Explore {{ $subcategory['name'] }}</a>
                  @forelse ($subcategory['packages'] as $package)
                    <a href="{{ $package['url'] }}" @click="menuOpen=false;mobileSection=null;mobileRegion=null">{{ $package['name'] }}</a>
                  @empty
                    <p class="mobile-trip-empty">No published packages yet.</p>
                  @endforelse
                </div>
              </div>
            @empty
              <p>{{ $navCategory['empty_message'] }}</p>
            @endforelse
          </div>
        </div>
      @endforeach
      <div class="mobile-nav-group"><button type="button" @click="toggleMobileSection('company')"
          :aria-expanded="(mobileSection==='company').toString()" aria-controls="mobile-company">Company <span
            aria-hidden="true">+</span></button>
        <div id="mobile-company" class="mobile-subnav" x-show="mobileSection==='company'" x-cloak><a href="{{ route('about') }}" @click="menuOpen=false">About Us</a><a href="{{ route('team') }}" @click="menuOpen=false">Our Team</a><a href="{{ route('why-choose-us') }}" @click="menuOpen=false" @if (request()->routeIs('why-choose-us')) aria-current="page" @endif>Why Choose Us</a><a href="{{ route('approach') }}" @click="menuOpen=false" @if (request()->routeIs('approach')) aria-current="page" @endif>Our Approach</a><a
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
