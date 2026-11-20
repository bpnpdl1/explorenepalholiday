<div class="trip-search-backdrop" x-show="tripSearchOpen" x-cloak @click.self="closeTripSearch()"
    @keydown.tab="trapSearchTab($event)" @keydown.escape.stop="closeTripSearch()">
    <section class="trip-search-dialog" x-ref="tripSearchDialog" role="dialog" aria-modal="true"
        aria-labelledby="trip-search-title" aria-describedby="trip-search-description">
        <button class="trip-search-close" type="button" @click="closeTripSearch()" aria-label="Close trip search">&times;</button>
        <div class="trip-search-heading">
            <span class="eyebrow dark">{{ strtoupper($siteSetting?->name ?? config('app.name', 'Explore Nepal Holidays')) }}</span>
            <h2 id="trip-search-title">Where would you like to go?</h2>
            <p id="trip-search-description">
                <span x-text="searchItems.length"></span> published packages to explore. Search by trip name, region, or category.
            </p>
        </div>
        <label class="trip-search-input">
            <img class="icon-img icon-img--light" src="{{ asset('site/assets/icons/search.svg') }}" alt="">
            <span class="sr-only">Search published packages</span>
            <input x-ref="tripSearchInput" type="search" x-model.debounce.150ms="tripSearchQuery"
                :placeholder="searchItems.length ? 'Try ' + searchItems[0].name : 'Search trips and destinations'"
                autocomplete="off">
        </label>
        <div class="trip-search-filters" role="group" aria-label="Filter by package category">
            <button type="button" @click="tripSearchActivity='all'"
                :aria-pressed="(tripSearchActivity === 'all').toString()"
                :class="tripSearchActivity === 'all' ? 'active' : ''">All packages</button>
            <template x-for="activity in searchActivities()" :key="activity">
                <button type="button" :aria-pressed="(tripSearchActivity === activity).toString()"
                    :class="tripSearchActivity === activity ? 'active' : ''"
                    @click="tripSearchActivity = activity" x-text="activity"></button>
            </template>
        </div>
        <div class="trip-search-results-head">
            <span x-text="tripSearchQuery ? 'SEARCH RESULTS' : 'PUBLISHED PACKAGES'">PUBLISHED PACKAGES</span>
            <span x-text="filteredSearchTrips().length + ' packages'"></span>
        </div>
        <div class="trip-search-results" aria-live="polite">
            <template x-for="trip in filteredSearchTrips()" :key="trip.url">
                <a class="trip-search-result" :href="trip.url" @click="closeTripSearch(false)">
                    <span class="trip-search-result-meta">
                        <span x-text="trip.activity"></span><span x-text="trip.category"></span>
                    </span>
                    <strong x-text="trip.name"></strong>
                    <span class="trip-search-result-arrow" aria-hidden="true">&#8599;</span>
                </a>
            </template>
            <p class="trip-search-empty" x-show="filteredSearchTrips().length === 0" x-cloak
                x-text="searchItems.length ? 'No packages match that search. Try another name or category.' : 'There are no published packages yet. Please check back soon.'">
                There are no published packages yet. Please check back soon.
            </p>
        </div>
        <p class="trip-search-note">Package details and available dates are shown on each trip page.</p>
    </section>
</div>
