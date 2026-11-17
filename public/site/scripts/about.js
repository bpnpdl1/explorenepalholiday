(() => {
      const reviewElement = document.querySelector('.about-review-swiper');
      if (reviewElement && window.Swiper) {
        const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        new window.Swiper(reviewElement, {
          a11y: {
            enabled: true,
            containerMessage: 'Client reviews from Explore Nepal Holidays',
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
            nextEl: '.about-review-next',
            prevEl: '.about-review-prev'
          },
          pagination: {
            el: '.about-review-pagination',
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
    })();
