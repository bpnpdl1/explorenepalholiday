@extends('layouts.site')

@section('page_title', $siteSetting?->meta_title ?: (($siteSetting?->name ?? config('app.name', 'Explore Nepal Holidays')).' | Treks, Tours & Tailor-Made Journeys'))
@section('meta_description', $siteSetting?->meta_description ?: "Explore Nepal's mountain trails, cultural cities and wild lowlands. Discover handpicked journeys and plan a trip shaped around you.")
@section('og_title', $siteSetting?->og_title ?: $siteSetting?->meta_title ?: $siteSetting?->name)
@section('og_description', $siteSetting?->og_description ?: $siteSetting?->meta_description ?: $siteSetting?->description)
@section('og_image', asset('site/assets/annapurna-sunrise.jpg'))
@section('body_class', 'home-page')

@section('content')
<a class="skip-link" href="#main">Skip to content</a>
  @include('site.partials.header')
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
            <a href="{{ route('packages.index') }}" class="hero-cta-primary">
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
          <form action="{{ route('packages.index') }}" method="GET" class="hero-search-grid">

            <!-- Regions represented in published packages -->
            <div class="hero-search-field">
              <label for="exp-region">Region / Trip Area</label>
              <select id="exp-region" name="region" x-model="expeditionFilters.region" class="hero-select">
                <option value="all">All Regions</option>
                @foreach ($packageRegions as $region)
                  <option value="{{ $region['value'] }}">{{ $region['label'] }}</option>
                @endforeach
              </select>
            </div>

            <!-- Package style from the category model -->
            <div class="hero-search-field">
              <label for="exp-style">Trip Style</label>
              <select id="exp-style" name="style" x-model="expeditionFilters.style" class="hero-select">
                <option value="any">Any Trip Style</option>
                @foreach ($packageStyles as $style)
                  <option value="{{ $style['value'] }}">{{ $style['label'] }}</option>
                @endforeach
              </select>
            </div>

            <!-- Available duration ranges from package duration data -->
            <div class="hero-search-field">
              <label for="exp-duration">Trip Duration</label>
              <select id="exp-duration" name="duration" x-model="expeditionFilters.duration" class="hero-select">
                <option value="any">Any Duration</option>
                @foreach ($packageDurations as $duration)
                  <option value="{{ $duration['value'] }}">{{ $duration['label'] }}</option>
                @endforeach
              </select>
            </div>

            <!-- Seasons assigned to published packages -->
            <div class="hero-search-field">
              <label for="exp-season">Best Season</label>
              <select id="exp-season" name="season" x-model="expeditionFilters.season" class="hero-select">
                <option value="any">Any Season</option>
                @foreach ($packageSeasons as $season)
                  <option value="{{ $season->value }}">{{ $season->label() }}</option>
                @endforeach
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
                <span x-text="getExpeditionFilterLabel('exp-region', expeditionFilters.region)"></span>
                <button type="button" @click="expeditionFilters.region = 'all'; handleExpeditionSearch()" class="hero-filter-pill-remove" aria-label="Remove region filter">&times;</button>
              </span>
            </template>
            <template x-if="expeditionFilters.style !== 'any'">
              <span class="hero-filter-pill">
                <span x-text="getExpeditionFilterLabel('exp-style', expeditionFilters.style)"></span>
                <button type="button" @click="expeditionFilters.style = 'any'; handleExpeditionSearch()" class="hero-filter-pill-remove" aria-label="Remove trip style filter">&times;</button>
              </span>
            </template>
            <template x-if="expeditionFilters.duration !== 'any'">
              <span class="hero-filter-pill">
                <span x-text="getExpeditionFilterLabel('exp-duration', expeditionFilters.duration)"></span>
                <button type="button" @click="expeditionFilters.duration = 'any'; handleExpeditionSearch()" class="hero-filter-pill-remove" aria-label="Remove trip duration filter">&times;</button>
              </span>
            </template>
            <template x-if="expeditionFilters.season !== 'any'">
              <span class="hero-filter-pill">
                <span x-text="getExpeditionFilterLabel('exp-season', expeditionFilters.season)"></span>
                <button type="button" @click="expeditionFilters.season = 'any'; handleExpeditionSearch()" class="hero-filter-pill-remove" aria-label="Remove season filter">&times;</button>
              </span>
            </template>
            <button type="button" @click="resetExpeditionFilters()" class="hero-filter-clear">Clear all</button>
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
          @if ($whyTravelReasons->isNotEmpty())
            @foreach ($whyTravelReasons as $reason)
              <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition duration-300 flex flex-col justify-between">
                <div>
                  <div class="bg-teal-50 p-4 rounded-xl w-fit mx-auto mb-5">
                    <img src="{{ $reason->getFirstMediaUrl('icon') }}" alt="" class="w-8 h-8 object-contain" loading="lazy">
                  </div>
                  <h3 class="text-lg font-bold text-slate-900 mb-2">{{ $reason->title }}</h3>
                  <p class="text-slate-500 text-xs leading-relaxed">{{ $reason->description }}</p>
                </div>
              </div>
            @endforeach
          @else
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition duration-300 flex flex-col justify-between">
              <div>
                <div class="bg-teal-50 text-teal-600 p-4 rounded-xl w-fit mx-auto mb-5"><i data-lucide="heart-pulse" class="w-8 h-8" aria-hidden="true"></i></div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Altitude-aware pacing</h3>
                <p class="text-slate-500 text-xs leading-relaxed">Higher routes need sensible acclimatization days, realistic walking hours and a plan that can flex with weather and energy.</p>
              </div>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition duration-300 flex flex-col justify-between">
              <div>
                <div class="bg-amber-50 text-amber-600 p-4 rounded-xl w-fit mx-auto mb-5"><i data-lucide="bed-double" class="w-8 h-8" aria-hidden="true"></i></div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Comfort matched to route</h3>
                <p class="text-slate-500 text-xs leading-relaxed">Some journeys suit simple teahouses, others call for more comfort in the cities or a private lodge-style approach where available.</p>
              </div>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition duration-300 flex flex-col justify-between">
              <div>
                <div class="bg-emerald-50 text-emerald-600 p-4 rounded-xl w-fit mx-auto mb-5"><i data-lucide="map" class="w-8 h-8" aria-hidden="true"></i></div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Local context first</h3>
                <p class="text-slate-500 text-xs leading-relaxed">Routes make more sense when culture, festivals, transport windows and mountain conditions are considered from the start.</p>
              </div>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition duration-300 flex flex-col justify-between">
              <div>
                <div class="bg-rose-50 text-rose-600 p-4 rounded-xl w-fit mx-auto mb-5"><i data-lucide="leaf" class="w-8 h-8" aria-hidden="true"></i></div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Responsible travel cues</h3>
                <p class="text-slate-500 text-xs leading-relaxed">We make space for crew welfare, lower-impact choices and respectful encounters to be part of the conversation before booking.</p>
              </div>
            </div>
          @endif
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

    <section id="expeditions" class="bg-slate-50 py-16 lg:py-20" aria-labelledby="expeditions-title" x-data="{ activeCategory: 'all' }">
      <div class="max-w-7xl mx-auto px-4 md:px-8">
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-10">
          <div>
            <span class="inline-block text-[11px] font-bold uppercase tracking-widest text-amber-600 mb-3">Featured journeys</span>
            <h2 id="expeditions-title" class="text-2xl lg:text-3xl font-extrabold uppercase text-slate-900 tracking-tight">Nepal trips to compare</h2>
            <p class="text-slate-500 text-sm lg:text-base max-w-2xl mt-3 leading-relaxed">Compare published trips by category, duration, altitude, and starting price. Final details are confirmed with our team.</p>
          </div>
          <div class="journey-tabs flex flex-wrap items-center gap-2" role="group" aria-label="Filter featured packages">
            <button type="button" @click="activeCategory = 'all'" :class="activeCategory === 'all' ? 'bg-slate-900 text-white font-medium shadow' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="px-4 py-2 rounded-lg text-xs font-semibold uppercase tracking-wide transition-all duration-200">All featured</button>
            @foreach ($featuredPackageCategories as $category)
              <button type="button" @click="activeCategory = '{{ $category['value'] }}'" :class="activeCategory === '{{ $category['value'] }}' ? 'bg-slate-900 text-white font-medium shadow' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="px-4 py-2 rounded-lg text-xs font-semibold uppercase tracking-wide transition-all duration-200">{{ $category['label'] }}</button>
            @endforeach
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
          @forelse ($featuredPackages as $package)
            @php
                $categoryKey = $package->subcategory->category->slug;
            @endphp
            <article x-show="activeCategory === 'all' || activeCategory === '{{ $categoryKey }}'" class="rounded-2xl border border-slate-200/80 bg-white shadow-sm hover:shadow-xl transition duration-300 flex flex-col overflow-hidden">
              <a href="{{ route('packages.show', $package) }}" class="relative h-52 overflow-hidden block">
                <img src="{{ $package->getFirstMediaUrl('cover', 'card') ?: $package->getFirstMediaUrl('cover') ?: asset('site/assets/nepal-trail.jpg') }}" alt="{{ $package->name }}" class="w-full h-full object-cover" loading="lazy">
                <span class="absolute top-3 left-3 bg-amber-400 text-amber-950 text-[10px] font-bold uppercase px-2.5 py-1 rounded-full tracking-wide">Featured</span>
                @if ($package->max_altitude_meters)<span class="absolute bottom-3 right-3 bg-slate-900/80 text-white text-[10px] font-bold px-2.5 py-1 rounded-full backdrop-blur-sm">Max {{ number_format($package->max_altitude_meters) }} m</span>@endif
              </a>
              <div class="flex flex-col flex-1 p-5">
                <div class="flex items-center justify-between gap-2 mb-2"><a href="{{ route('subcategories.show', $package->subcategory->slug) }}" class="text-xs font-bold text-slate-700 hover:text-sky-700">{{ $package->subcategory->category->name }} &bull; {{ $package->subcategory->category->destination->name }}</a><span class="text-xs text-amber-600 font-semibold">{{ $package->difficulty ?: 'All levels' }}</span></div>
                <h3 class="text-xl font-bold text-slate-900 line-clamp-1 hover:text-sky-600 transition-colors"><a href="{{ route('packages.show', $package) }}">{{ $package->name }}</a></h3>
                <p class="text-slate-500 text-sm line-clamp-2 mt-2 leading-relaxed">{{ $package->summary }}</p>
                <div class="flex flex-wrap gap-1.5 mt-3">@if ($package->duration_days)<span class="bg-slate-100 text-slate-600 text-[10px] font-medium px-2 py-0.5 rounded-full">{{ $package->duration_days }} days</span>@endif @foreach ($package->seasons->take(2) as $season)<span class="bg-slate-100 text-slate-600 text-[10px] font-medium px-2 py-0.5 rounded-full">{{ $season->season->label() }}</span>@endforeach</div>
                <div class="border-t border-slate-100 mt-auto pt-4 flex items-center justify-between gap-3">
                  <div><div class="text-[10px] uppercase tracking-wider text-slate-400 font-semibold">{{ $package->price_from !== null ? 'From' : 'Ask for price' }}</div>@if ($package->price_from !== null)<div class="text-lg font-extrabold text-slate-900">{{ $package->currency }} {{ number_format((float) $package->price_from, 0) }}</div>@endif</div>
                  <a href="{{ route('packages.show', $package) }}" class="bg-slate-900 hover:bg-slate-800 text-white font-semibold px-4 py-2 rounded-xl text-sm transition">View package</a>
                </div>
              </div>
            </article>
          @empty
            <p class="col-span-full rounded-2xl bg-white p-8 text-center text-slate-600">New journeys are being prepared. Contact our team and we’ll help plan your trip.</p>
          @endforelse
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
          <a href="{{ route('home') }}#journeys" class="relative h-[400px] rounded-2xl border border-slate-800 shadow-xl group cursor-pointer overflow-hidden">
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
          <a href="{{ route('home') }}#journeys" class="relative h-[400px] rounded-2xl border border-slate-800 shadow-xl group cursor-pointer overflow-hidden">
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
          <a href="{{ route('home') }}#journeys" class="relative h-[400px] rounded-2xl border border-slate-800 shadow-xl group cursor-pointer overflow-hidden">
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
          <a href="{{ route('home') }}#journeys" class="relative h-[400px] rounded-2xl border border-slate-800 shadow-xl group cursor-pointer overflow-hidden">
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
          <p class="text-slate-500 max-w-2xl mx-auto text-sm md:text-base">Discover the places and regions that make every journey through Nepal unique.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          @forelse ($destinations as $destination)
            @php
              $destinationImage = $destination->getFirstMediaUrl('cover', 'card')
                  ?: $destination->getFirstMediaUrl('cover')
                  ?: asset('site/assets/annapurna-sunrise.jpg');
              $destinationSummary = $destination->summary
                  ?: \Illuminate\Support\Str::limit(strip_tags($destination->description ?? ''), 150);
            @endphp
            <a href="{{ route('destinations.show', $destination) }}" class="group relative h-[420px] rounded-2xl border border-slate-200/80 shadow-lg overflow-hidden cursor-pointer">
              <img src="{{ $destinationImage }}" alt="{{ $destination->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" loading="lazy">
              <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/50 to-transparent"></div>
              <div class="absolute inset-0 p-6 flex flex-col justify-end text-left z-10">
                <span class="text-amber-400 text-[10px] font-bold uppercase tracking-widest mb-1.5">Explore Nepal</span>
                <h3 class="text-2xl font-bold text-white mb-2">{{ $destination->name }}</h3>
                @if ($destinationSummary !== '')
                  <p class="text-slate-300 text-sm leading-relaxed mb-3">{{ $destinationSummary }}</p>
                @endif
                <span class="text-sky-400 group-hover:text-sky-300 font-semibold text-xs transition flex items-center gap-1">
                  Explore journeys
                  <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                  </svg>
                </span>
              </div>
            </a>
          @empty
            <p class="md:col-span-3 text-center text-slate-500 py-10">New destinations are coming soon. Check back to discover more of Nepal.</p>
          @endforelse
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



    <section id="journeys" class="journeys section" aria-labelledby="journeys-title" x-data="packageListings()">
      <div class="container">
        <div class="section-heading" data-aos="fade-up">
          <div><span class="eyebrow dark">PUBLISHED TRIPS</span><h2 id="journeys-title">Find your next <em>chapter.</em></h2></div>
          <p>Browse current trips across Nepal. Each package page includes its latest details, seasons, and enquiry options.</p>
        </div>
        <div class="filter-row" role="group" aria-label="Filter packages by category">
          <button type="button" @click="activeFilter = 'all'" :class="activeFilter === 'all' ? 'active' : ''" :aria-pressed="(activeFilter === 'all').toString()">All packages</button>
          @foreach ($packageCategories as $category)
            <button type="button" @click="activeFilter = '{{ $category['value'] }}'" :class="activeFilter === '{{ $category['value'] }}' ? 'active' : ''" :aria-pressed="(activeFilter === '{{ $category['value'] }}').toString()">{{ $category['label'] }}</button>
          @endforeach
        </div>
        <p class="result-count" aria-live="polite"><span x-text="visiblePackagesCount()">{{ $packages->count() }}</span> published packages</p>
        <div class="trip-grid">
          @forelse ($packages as $package)
            @php
                $categoryKey = $package->subcategory->category->slug;
            @endphp
            <article class="trip-card" data-package-card data-region="{{ $package->subcategory->slug }}" data-style="{{ $categoryKey }}" data-duration="{{ $package->duration_days }}" data-seasons="{{ $package->seasons->map(fn ($season) => $season->season->value)->implode(',') }}" x-show="matchesPackage($el)">
              <a class="trip-image" href="{{ route('packages.show', $package) }}"><img src="{{ $package->getFirstMediaUrl('cover', 'card') ?: $package->getFirstMediaUrl('cover') ?: asset('site/assets/nepal-trail.jpg') }}" alt="{{ $package->name }}" loading="lazy"><span class="trip-category">{{ $package->subcategory->category->name }}</span></a>
              <div class="trip-content">
                <div class="trip-meta"><span>{{ $package->subcategory->category->destination->name }} / <a href="{{ route('subcategories.show', $package->subcategory->slug) }}">{{ $package->subcategory->name }}</a></span>@if ($package->is_featured)<span>FEATURED</span>@endif</div>
                <h3>{{ $package->name }}</h3>
                <p>{{ $package->summary }}</p>
                <div class="trip-facts"><span>{{ $package->duration_days ? $package->duration_days.' days' : 'Flexible duration' }}</span><span>{{ $package->difficulty ?: 'Ask us' }}</span></div>
                <p class="trip-price">@if ($package->price_from !== null)<span class="trip-price__from">From</span> {{ $package->currency }} {{ number_format((float) $package->price_from, 0) }} @if ($package->price_qualifier)<small>{{ $package->price_qualifier }}</small>@endif @else<span class="trip-price__from">Ask us for pricing</span>@endif</p>
                <a href="{{ route('packages.show', $package) }}">View package <span aria-hidden="true">↗</span></a>
              </div>
            </article>
          @empty
            <p class="trip-search-empty">There are no published packages yet. Please check back soon.</p>
          @endforelse
        </div>
        <p class="trip-search-empty" x-show="visiblePackagesCount() === 0" x-cloak>No published packages match those filters. Try changing your region, style, duration, or season.</p>
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
          @if ($faqs->isNotEmpty())
            @foreach ($faqs as $faq)
              <details id="faq-{{ $faq->id }}">
                <summary><span>{{ sprintf('%02d', $loop->iteration) }}</span><strong>{{ $faq->question }}</strong><span class="plus" aria-hidden="true">+</span></summary>
                <p style="white-space: pre-line;">{{ $faq->answer }}</p>
              </details>
            @endforeach
          @else
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
          @endif
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
  @include('site.partials.footer')
    <div class="floating-actions">
    <a class="back-to-top" href="#top" aria-label="Back to top" title="Back to top" x-show="showBackToTop" x-cloak><img
        src="{{ asset('site/assets/explore-nepal-back-to-top-animated.gif') }}" alt="" width="384" height="384"></a>
    <a class="whatsapp-float" x-show="showBackToTop" x-cloak
      href="https://wa.me/?text=I%27m%20planning%20a%20Nepal%20trip%20with%20Explore%20Nepal%20Holidays."
      target="_blank" rel="noopener noreferrer" aria-label="Share your Nepal trip plans on WhatsApp"
      title="Share your trip plans on WhatsApp"><img class="icon-img icon-img--dark" src="{{ asset('site/assets/icons/whatsapp.svg') }}" alt=""></a>
  </div>
@endsection
