function packageBookingSidebar() {
  return {
    sidebarForm: 'inquiry',
    saveBookingDraft(event) {
      const form = event.currentTarget;
      if (!form.reportValidity()) return;
      const data = new FormData(form);
      const draft = {
        tripId: '114',
        name: data.get('sidebar-booking-name'),
        email: data.get('sidebar-booking-email'),
        phone: data.get('sidebar-booking-phone'),
        travelWindow: data.get('travel_window'),
        travellers: data.get('travellers'),
        savedAt: new Date().toISOString()
      };
      try {
        window.localStorage.setItem('enhBookingDraft', JSON.stringify(draft));
        const status = form.querySelector('.package-form__status');
        if (status) {
          status.textContent = 'Your trip details are saved as a draft in this browser. No booking has been submitted.';
          status.hidden = false;
          status.setAttribute('tabindex', '-1');
          status.focus();
        }
      } catch (_error) {
        const status = form.querySelector('.package-form__status');
        if (status) {
          status.textContent = 'We could not save your details in this browser. Check your browser storage settings and try again.';
          status.hidden = false;
          status.focus();
        }
      }
    }
  };
}

(() => {
  if (window.lucide) window.lucide.createIcons();

  const elevationCanvas = document.querySelector('#package-elevation-chart');
  if (elevationCanvas && window.Chart) {
    const context = elevationCanvas.getContext('2d');
    const areaFill = context.createLinearGradient(0, 0, 0, 300);
    areaFill.addColorStop(0, 'rgba(23, 100, 165, 0.28)');
    areaFill.addColorStop(1, 'rgba(23, 100, 165, 0.02)');

    new window.Chart(context, {
      type: 'line',
      data: {
        labels: ['Kathmandu', 'Syabrubesi', 'Langtang', 'Kyanjin Gompa', 'Kathmandu'],
        datasets: [{
          label: 'Approximate altitude',
          data: [1350, 1420, 3480, 3870, 1350],
          borderColor: '#1764a5',
          backgroundColor: areaFill,
          borderWidth: 3,
          fill: true,
          tension: 0.35,
          pointRadius: 4,
          pointHoverRadius: 6,
          pointBackgroundColor: '#1764a5',
          pointBorderColor: '#fff',
          pointBorderWidth: 2
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: { intersect: false, mode: 'index' },
        plugins: {
          legend: { display: false },
          tooltip: {
            callbacks: {
              label: (context) => `${context.parsed.y.toLocaleString()} m`
            }
          }
        },
        scales: {
          x: {
            grid: { display: false },
            ticks: {
              color: '#536878',
              maxRotation: 0,
              minRotation: 0,
              maxTicksLimit: 5,
              autoSkip: false,
              callback(value, index) {
                if (this.chart.width >= 480) return this.getLabelForValue(value);
                return ['Kathmandu', 'Syabrubesi', 'Langtang', 'Kyanjin', 'Return'][index];
              },
              font: { family: 'DM Sans', size: (context) => context.chart.width < 480 ? 8 : 11 }
            }
          },
          y: {
            min: 1000,
            max: 4200,
            title: { display: true, text: 'Altitude (m)', color: '#536878', font: { family: 'DM Sans', size: 11 } },
            ticks: {
              stepSize: 1000,
              color: '#536878',
              callback: (value) => `${Number(value).toLocaleString()} m`,
              font: { family: 'DM Sans', size: (context) => context.chart.width < 480 ? 9 : 11 },
              maxTicksLimit: 4
            },
            grid: { color: 'rgba(8, 37, 63, 0.09)' }
          }
        }
      }
    });
  }

  if (window.AOS) {
    AOS.init({
      duration: 700,
      easing: 'ease-out-quart',
      once: true,
      offset: 70,
      disable: () => window.matchMedia('(prefers-reduced-motion: reduce)').matches
    });
    if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
      document.documentElement.classList.add('aos-ready');
    }
  }

  const gallery = document.querySelector('[data-package-gallery]');
  if (gallery) {
    const slides = [...gallery.querySelectorAll('.package-gallery__slide')];
    const dots = [...gallery.querySelectorAll('[data-package-gallery-dot]')];
    const frame = gallery.querySelector('.package-gallery__frame');
    let activeIndex = 0;
    let pointerStart = null;

    const showSlide = (index) => {
      activeIndex = (index + slides.length) % slides.length;
      slides.forEach((slide, slideIndex) => {
        slide.hidden = slideIndex !== activeIndex;
      });
      dots.forEach((dot, dotIndex) => {
        const selected = dotIndex === activeIndex;
        dot.classList.toggle('is-active', selected);
        dot.setAttribute('aria-pressed', String(selected));
      });
    };

    gallery.querySelector('[data-package-gallery-prev]').addEventListener('click', () => showSlide(activeIndex - 1));
    gallery.querySelector('[data-package-gallery-next]').addEventListener('click', () => showSlide(activeIndex + 1));
    dots.forEach((dot, index) => dot.addEventListener('click', () => showSlide(index)));

    gallery.addEventListener('keydown', (event) => {
      if (event.key === 'ArrowLeft' || event.key === 'ArrowRight') {
        event.preventDefault();
        showSlide(activeIndex + (event.key === 'ArrowRight' ? 1 : -1));
      }
    });

    frame.addEventListener('pointerdown', (event) => {
      if (event.pointerType !== 'mouse') pointerStart = { x: event.clientX, y: event.clientY };
    });
    frame.addEventListener('pointerup', (event) => {
      if (!pointerStart) return;
      const x = event.clientX - pointerStart.x;
      const y = event.clientY - pointerStart.y;
      pointerStart = null;
      if (Math.abs(x) > 45 && Math.abs(x) > Math.abs(y) * 1.2) {
        showSlide(activeIndex + (x < 0 ? 1 : -1));
      }
    });
    frame.addEventListener('pointercancel', () => { pointerStart = null; });

    // Keep the hero gallery moving for visitors, while pausing when they
    // interact with it or when the page is not visible.
    if (slides.length > 1 && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
      window.setInterval(() => {
        if (!document.hidden && !gallery.matches(':hover') && !gallery.contains(document.activeElement)) {
          showSlide(activeIndex + 1);
        }
      }, 5000);
    }
  }

  const reviewElement = document.querySelector('.package-review-swiper');
  if (reviewElement && window.Swiper) {
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    new window.Swiper(reviewElement, {
      a11y: {
        enabled: true,
        containerMessage: 'Trip reviews from Explore Nepal Holidays',
        slideLabelMessage: 'Review {{index}} of {{slidesLength}}'
      },
      autoplay: reducedMotion ? false : {
        delay: 7000,
        disableOnInteraction: false,
        pauseOnMouseEnter: true
      },
      keyboard: { enabled: true },
      loop: true,
      navigation: {
        nextEl: '.package-review-next',
        prevEl: '.package-review-prev'
      },
      pagination: {
        el: '.package-review-pagination',
        clickable: true,
        bulletElement: 'button',
        renderBullet(index, className) {
          return `<button class="${className}" type="button" aria-label="Show review ${index + 1}"></button>`;
        }
      },
      slidesPerView: 1,
      spaceBetween: 16,
      breakpoints: {
        601: { slidesPerView: 2 },
        1000: { slidesPerView: 3 }
      },
      speed: reducedMotion ? 0 : 700
    });
  }

  const forms = document.querySelectorAll('[data-static-form]');

  const packageTabs = document.querySelectorAll('[data-package-tab]');
  const shareUrl = encodeURIComponent(window.location.href);
  document.querySelectorAll('[data-share]').forEach((link) => {
    const shareType = link.dataset.share;
    const shareLinks = {
      facebook: `https://www.facebook.com/sharer/sharer.php?u=${shareUrl}`,
      linkedin: `https://www.linkedin.com/sharing/share-offsite/?url=${shareUrl}`,
      whatsapp: `https://wa.me/?text=${encodeURIComponent(document.title + ' ' + window.location.href)}`,
      email: `mailto:?subject=${encodeURIComponent(document.title)}&body=${encodeURIComponent('I thought you might like this trek: ' + window.location.href)}`
    };
    link.href = shareLinks[shareType] || '#';
  });

  const packageNav = document.querySelector('[data-package-subnav]');
  const packageSections = [...packageTabs]
    .map((tab) => document.getElementById(tab.hash.slice(1)))
    .filter(Boolean);

  if (packageNav && packageTabs.length && packageSections.length) {
    const siteHeader = document.querySelector('.site-header');
    let navFrame = 0;
    let activeSectionId = packageNav.querySelector('[data-package-tab].is-active')?.hash.slice(1) || '';
    let pendingSectionId = '';

    const revealPackageTab = (tab) => {
      const navRect = packageNav.getBoundingClientRect();
      const tabRect = tab.getBoundingClientRect();
      const edgePadding = 10;
      let nextScrollLeft = packageNav.scrollLeft;
      if (tabRect.left < navRect.left + edgePadding) {
        nextScrollLeft -= navRect.left + edgePadding - tabRect.left;
      } else if (tabRect.right > navRect.right - edgePadding) {
        nextScrollLeft += tabRect.right - (navRect.right - edgePadding);
      } else {
        return;
      }
      packageNav.scrollTo({
        left: nextScrollLeft,
        behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth'
      });
    };

    const setActivePackageSection = (sectionId) => {
      const activeTab = [...packageTabs].find((tab) => tab.hash === `#${sectionId}`);
      if (!activeTab || activeSectionId === sectionId) return;
      activeSectionId = sectionId;

      packageTabs.forEach((tab) => {
        const active = tab === activeTab;
        tab.classList.toggle('is-active', active);
        if (active) tab.setAttribute('aria-current', 'location');
        else tab.removeAttribute('aria-current');
      });

      revealPackageTab(activeTab);
    };

    const navigateToPackageSection = (target, { updateHistory = false, moveFocus = false, behavior } = {}) => {
      const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
      const headerIsSticky = siteHeader && getComputedStyle(siteHeader).position === 'sticky';
      const headerHeight = headerIsSticky ? siteHeader.getBoundingClientRect().height : 0;
      const navHeight = packageNav.getBoundingClientRect().height;
      const targetTop = window.scrollY + target.getBoundingClientRect().top - headerHeight - navHeight - 14;

      pendingSectionId = target.id;
      setActivePackageSection(target.id);
      if (moveFocus) {
        target.setAttribute('tabindex', '-1');
        target.focus({ preventScroll: true });
      }
      if (updateHistory && window.location.hash !== `#${target.id}`) {
        window.history.pushState(null, '', `#${target.id}`);
      }
      window.scrollTo({
        top: Math.max(0, targetTop),
        behavior: behavior || (reducedMotion ? 'auto' : 'smooth')
      });
      schedulePackageNavUpdate();
    };

    const updatePackageNav = () => {
      navFrame = 0;
      const headerIsSticky = siteHeader && getComputedStyle(siteHeader).position === 'sticky';
      const headerHeight = headerIsSticky ? siteHeader.getBoundingClientRect().height : 0;
      const navHeight = packageNav.getBoundingClientRect().height;
      document.documentElement.style.setProperty('--package-header-offset', `${headerHeight}px`);
      document.documentElement.style.setProperty('--package-subnav-height', `${navHeight}px`);
      packageNav.classList.toggle(
        'is-stuck',
        window.scrollY > 0 && packageNav.getBoundingClientRect().top <= headerHeight + 1
      );

      const activationLine = headerHeight + navHeight + 18;
      const atPageEnd = window.scrollY + window.innerHeight >= document.documentElement.scrollHeight - 2;
      let current = null;
      if (pendingSectionId) {
        const pendingSection = document.getElementById(pendingSectionId);
        if (!pendingSection || pendingSection.getBoundingClientRect().top <= activationLine || atPageEnd) {
          pendingSectionId = '';
        } else {
          current = pendingSection;
        }
      }
      if (!current) {
        current = packageSections[0];
        for (const section of packageSections) {
          if (section.getBoundingClientRect().top <= activationLine) current = section;
          else break;
        }
      }
      if (atPageEnd) {
        current = packageSections[packageSections.length - 1];
      }
      if (current) setActivePackageSection(current.id);
    };

    const schedulePackageNavUpdate = () => {
      if (!navFrame) navFrame = window.requestAnimationFrame(updatePackageNav);
    };

    packageTabs.forEach((tab) => {
      tab.addEventListener('click', (event) => {
        if (event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return;
        const target = document.getElementById(tab.hash.slice(1));
        if (!target) return;
        event.preventDefault();
        navigateToPackageSection(target, { updateHistory: true, moveFocus: true });
      });
    });

    window.addEventListener('popstate', () => {
      const targetId = window.location.hash.slice(1);
      const target = packageSections.find((section) => section.id === targetId);
      if (target) navigateToPackageSection(target, { behavior: 'auto' });
      else schedulePackageNavUpdate();
    });

    window.addEventListener('scroll', schedulePackageNavUpdate, { passive: true });
    window.addEventListener('resize', schedulePackageNavUpdate, { passive: true });
    if ('ResizeObserver' in window && siteHeader) {
      new ResizeObserver(schedulePackageNavUpdate).observe(siteHeader);
    }
    schedulePackageNavUpdate();
  }

  forms.forEach((form) => {
    const status = form.querySelector('.package-form__status');
    if (!status) return;

    form.addEventListener('submit', (event) => {
      event.preventDefault();
      status.textContent = 'This demo form does not send your details. Contact us on WhatsApp to continue.';
      status.hidden = false;
      status.setAttribute('tabindex', '-1');
      status.focus();
    });
  });
})();
