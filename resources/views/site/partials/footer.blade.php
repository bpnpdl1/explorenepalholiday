  <footer class="footer" id="footer">
    <div class="footer-main">
      <div class="container footer-main-grid">
        <div class="footer-about">
          <a class="footer-logo" href="{{ route('home') }}#top" aria-label="Explore Nepal Holidays, back to top"><img
              src="{{ asset('site/assets/footer-logo-compact.png') }}" alt="Explore Nepal Holidays" width="620" height="207"
              loading="lazy"></a>
          <p>For mountain days, meaningful encounters, and all the moments in between. Find your own way into Nepal.</p>
          <a class="footer-plan" href="{{ route('home') }}#plan">Start planning your journey <span aria-hidden="true">↗</span></a>
        </div>
        <nav class="footer-nav" aria-label="Footer exploration links">
          <h2>Explore Nepal</h2>
          <a href="{{ route('about') }}">About Us</a>
          <a href="{{ route('team') }}">Our Team</a>
          <a href="{{ route('home') }}#why-choose">Why travel with us</a>
          <a href="{{ route('contact') }}">Contact Us</a>
          <a href="{{ route('home') }}#journeys">Featured journeys</a>
          <a href="{{ route('home') }}#expeditions">Flagship expeditions</a>
          <a href="{{ route('home') }}#regions">Regions</a>
          <a href="{{ route('home') }}#why-choose">Why choose us</a>
          <a href="{{ route('guest-reviews') }}">Guest reviews</a>
          <a href="{{ route('home') }}#newsletter">Newsletter</a>
          <a href="{{ route('faq') }}">FAQs</a>
        </nav>
        <nav class="footer-nav" aria-label="Footer planning links">
          <h2>Plan your trip</h2>
          <a href="{{ route('home') }}#journeys" @click="activeFilter='trekking'">Trekking journeys</a>
          <a href="{{ route('home') }}#journeys" @click="activeFilter='culture'">Culture &amp; heritage</a>
          <a href="{{ route('home') }}#journeys" @click="activeFilter='wildlife'">Wildlife escapes</a>
          <a href="{{ route('home') }}#plan">Tell us your ideas</a>
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
      <div class="container footer-base-bottom"><span>© 2026 Explore Nepal Holidays.</span><a href="{{ route('home') }}#top">Back to top
          <span aria-hidden="true">↑</span></a></div>
    </div>
  </footer>
