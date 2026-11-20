function site() {
  return {
    menuOpen: false,
    tripSearchOpen: false,
    tripSearchQuery: '',
    tripSearchActivity: 'all',
    searchPreviousFocus: null,
    mobileSection: null,
    mobileRegion: null,
    openNav: null,
    openRegion: null,
    searchItems: Array.isArray(window.NEPAL_PACKAGES) ? window.NEPAL_PACKAGES : [],
    activeFilter: 'all',
    selectedTrip: '',
    formSubmitted: false,
    newsletterSubmitted: false,
    showBackToTop: false,
    headerCompact: false,
    testimonialIndex: 0,
    // Testimonial data for the static frontend. Replace with real
    // reviews and source links before using this as production social proof.
    testimonials: [
      {
        name: 'K N',
        initials: 'KN',
        trip: 'Poon Hill and Annapurna Base Camp',
        date: 'September 2026',
        place: 'Annapurna region',
        quote: 'Our trek to Poon Hill with ABC Camp was simply incredible and a true once-in-a-lifetime experience! From start to finish, everything was perfectly organized.',
        image: '/site/assets/annapurna-sunrise.jpg',
        alt: 'Sunrise over the Annapurna mountain range in Nepal'
      },
      {
        name: 'Denver L',
        initials: 'DL',
        trip: 'Kathmandu sightseeing and the Nagarkot trek',
        date: 'December 2025',
        place: 'Kathmandu Valley',
        quote: 'I thoroughly enjoyed my time with my guide Ram Kumar he was very knowledgeable on Nepali history and the landscape of each place we went. Ram made me feel very welcome and made my time in Nepal very easy.',
        image: '/site/assets/kathmandu-stupa.jpg',
        alt: 'Prayer flags and Boudhanath Stupa in Kathmandu'
      },
      {
        name: 'Asier',
        initials: 'AS',
        trip: 'Tsum Valley and Manaslu trek',
        date: 'March 2026',
        place: 'Manaslu and Tsum Valley',
        quote: 'A friend and I completed the Tsum Valley and Manaslu trek (18 days) with them. Our guide Subarna was great, he helped us through the whole trip, providing us with interesting information. He took great care of us and showed flexibility and ability to adapt to our needs.',
        image: '/site/assets/manaslu-trekker.webp',
        alt: 'Trekker facing snow-covered peaks on the Manaslu Circuit'
      }
    ],
    visibleCount() {
      return this.activeFilter === 'all' ? 4 : this.activeFilter === 'trekking' ? 2 : 1;
    },
    updateScrollUI() {
      const scrollY = window.scrollY;
      this.showBackToTop = scrollY > 500;
      if (scrollY > 160) this.headerCompact = true;
      else if (scrollY < 32) this.headerCompact = false;
    },
    openTripSearch() {
      this.searchPreviousFocus = document.activeElement;
      this.tripSearchOpen = true;
      this.openNav = null;
      this.menuOpen = false;
      this.mobileSection = null;
      this.mobileRegion = null;
      this.$nextTick(() => this.$refs.tripSearchInput?.focus());
    },
    closeTripSearch(restoreFocus = true) {
      this.tripSearchOpen = false;
      if (restoreFocus) this.$nextTick(() => this.searchPreviousFocus?.focus());
    },
    filteredSearchTrips() {
      const query = this.tripSearchQuery.trim().toLocaleLowerCase();
      const matching = this.searchItems.filter((trip) => {
        const matchesActivity = this.tripSearchActivity === 'all' || trip.activity === this.tripSearchActivity;
        const matchesQuery = !query || `${trip.name} ${trip.category} ${trip.activity}`.toLocaleLowerCase().includes(query);
        return matchesActivity && matchesQuery;
      });
      return matching.slice(0, 9);
    },
    selectSearchTrip(trip) {
      this.selectedTrip = trip.name;
      this.formSubmitted = false;
      this.tripSearchOpen = false;
      this.tripSearchQuery = '';
      this.tripSearchActivity = 'all';
    },
    trapSearchTab(event) {
      const focusable = [...this.$refs.tripSearchDialog.querySelectorAll('button:not([disabled]), input:not([disabled]), a[href], select:not([disabled])')];
      const first = focusable[0];
      const last = focusable[focusable.length - 1];
      if (event.shiftKey && document.activeElement === first) {
        event.preventDefault();
        last.focus();
      } else if (!event.shiftKey && document.activeElement === last) {
        event.preventDefault();
        first.focus();
      }
    },
    closeNav(restoreFocus = false) {
      const section = this.openNav;
      this.openNav = null;
      this.openRegion = null;
      if (restoreFocus && section) {
        this.$nextTick(() => document.querySelector(`[data-nav-trigger="${section}"]`)?.focus());
      }
    },
    toggleMobileSection(section) {
      this.mobileSection = this.mobileSection === section ? null : section;
      this.mobileRegion = null;
    },
    toggleMobileRegion(region) {
      this.mobileRegion = this.mobileRegion === region ? null : region;
    },
    chooseMenuTrip(trip) {
      this.selectedTrip = trip;
      this.formSubmitted = false;
      this.openNav = null;
      this.openRegion = null;
      this.menuOpen = false;
      this.mobileSection = null;
      this.mobileRegion = null;
    },
    selectTripCard(id, type) {
      this.activeFilter = type;
      this.openNav = null;
      this.menuOpen = false;
      this.$nextTick(() => {
        history.replaceState(null, '', `#${id}`);
        document.getElementById(id)?.scrollIntoView({
          behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth',
          block: 'start'
        });
      });
    },
    closeOverlays() {
      if (this.tripSearchOpen) {
        this.closeTripSearch();
        return;
      }
      if (this.openNav) {
        this.closeNav(true);
        return;
      }
      if (this.menuOpen) {
        this.menuOpen = false;
        this.mobileSection = null;
        this.mobileRegion = null;
        this.$nextTick(() => document.querySelector('.menu-toggle')?.focus());
      }
    },
    changeTestimonial(step) {
      this.testimonialIndex = (this.testimonialIndex + step + this.testimonials.length) % this.testimonials.length;
    },

    // ===== Expedition Hero Search =====
    expeditionFilters: {
      region: 'all',
      comfort: 'any',
      duration: 'any',
      departure: 'any',
    },
    handleExpeditionSearch() {
      console.log('Expedition search:', { ...this.expeditionFilters });
    },
    hasActiveExpeditionFilters() {
      return this.expeditionFilters.region !== 'all' ||
        this.expeditionFilters.comfort !== 'any' ||
        this.expeditionFilters.duration !== 'any' ||
        this.expeditionFilters.departure !== 'any';
    },
    resetExpeditionFilters() {
      this.expeditionFilters = { region: 'all', comfort: 'any', duration: 'any', departure: 'any' };
    },
    getRegionLabel(value) {
      const labels = { everest: 'Everest', annapurna: 'Annapurna', langtang: 'Langtang', manaslu: 'Manaslu', makalu: 'Makalu', kanchenjunga: 'Kanchenjunga' };
      return labels[value] || value;
    },
    getComfortLabel(value) {
      const labels = { comfort: 'Comfort Trek', premium: 'Classic Trek', classic: 'Cultural Tour', camping: 'Remote Camping' };
      return labels[value] || value;
    },
    getDurationLabel(value) {
      const labels = { short: '5–10 Days', medium: '11–18 Days', long: '19–28 Days', extended: '29+ Days' };
      return labels[value] || value;
    },
    getDepartureLabel(value) {
      const labels = { autumn: 'Autumn', spring: 'Spring', winter: 'Winter', monsoon: 'Monsoon' };
      return labels[value] || value;
    },

  };
}

function expeditionTabs() {
  return {
    activeTab: 'all',
    tabs: [
      { id: 'all', label: 'All (6)' },
      { id: 'everest', label: 'Everest' },
      { id: 'annapurna', label: 'Annapurna' },
      { id: 'manaslu', label: 'Manaslu' },
      { id: 'peak', label: 'Peak Climbing' },
    ],
  };
}

// tawk.to test widget. Paste the Property ID and Widget ID from
// Administration → Chat Widget in your tawk.to dashboard below.
(() => {
  const propertyId = 'YOUR_PROPERTY_ID';
  const widgetId = 'YOUR_WIDGET_ID';

  if (propertyId === 'YOUR_PROPERTY_ID' || widgetId === 'YOUR_WIDGET_ID') {
    console.info('[tawk.to] Add your Property ID and Widget ID in scripts/site.js to enable chat.');
    return;
  }

  window.Tawk_API = window.Tawk_API || {};
  window.Tawk_LoadStart = new Date();
  window.Tawk_API.onLoad = () => console.info('[tawk.to] Chat widget loaded.');

  const widgetScript = document.createElement('script');
  widgetScript.async = true;
  widgetScript.src = `https://embed.tawk.to/${propertyId}/${widgetId}`;
  widgetScript.charset = 'UTF-8';
  widgetScript.setAttribute('crossorigin', '*');
  document.head.appendChild(widgetScript);
})();
