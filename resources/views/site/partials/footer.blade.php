  <footer class="footer" id="footer">
    <div class="footer-main">
      <div class="container footer-main-grid">
        <div class="footer-about">
          <a class="footer-logo" href="{{ route('home') }}#top" aria-label="{{ $siteSetting?->name ?? config('app.name') }}, back to top"><img
              src="{{ $siteSetting?->footer_logo_url ?: asset('site/assets/footer-logo-compact.png') }}" alt="{{ $siteSetting?->name ?? config('app.name', 'Explore Nepal Holidays') }}" width="620" height="207"
              loading="lazy"></a>
          <p>{{ $siteSetting?->description ?: 'For mountain days, meaningful encounters, and all the moments in between. Find your own way into Nepal.' }}</p>
          <a class="footer-plan" href="{{ route('home') }}#plan">Start planning your journey <span aria-hidden="true">↗</span></a>
        </div>
        <nav class="footer-nav" aria-label="Footer exploration links">
          <h2>Explore Nepal</h2>
          <a href="{{ route('about') }}">About Us</a>
          <a href="{{ route('team') }}">Our Team</a>
          <a href="{{ route('approach') }}">Our Approach</a>
          <a href="{{ route('why-choose-us') }}">Why Choose Us</a>
          <a href="{{ route('travel-info.index') }}">Travel Information</a>
          <a href="{{ route('contact') }}">Contact Us</a>
          <a href="{{ route('home') }}#journeys">Featured journeys</a>
          <a href="{{ route('home') }}#expeditions">Flagship expeditions</a>
          <a href="{{ route('home') }}#regions">Regions</a>
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
          <address class="footer-contact">
            @if ($siteSetting?->address)<span>VISIT US</span>{{ $siteSetting->address }}<small>Office address</small>@endif
            @if ($siteSetting?->phone)<span class="footer-contact-label">CALL US</span><a href="tel:{{ preg_replace('/[^0-9+]/', '', $siteSetting->phone) }}">{{ $siteSetting->phone }}</a><small>Trip planning desk</small>@endif
            @if ($siteSetting?->email)<span class="footer-contact-label">EMAIL US</span><a href="mailto:{{ $siteSetting->email }}">{{ $siteSetting->email }}</a>@endif
          </address>
          @if (filled($siteSetting?->social_links) || filled($siteSetting?->whatsapp_number))
          <div class="footer-social" aria-label="Social media">
            <span class="footer-social-label">FIND US ONLINE</span>
            <div class="footer-social-icons">
              @foreach (['facebook' => 'facebook.svg', 'instagram' => 'instagram.svg', 'tiktok' => 'tiktok.svg', 'youtube' => 'youtube.svg'] as $network => $icon)
                @if ($url = data_get($siteSetting?->social_links, $network))
                  <a class="social-icon" href="{{ $url }}" target="_blank" rel="noopener noreferrer" aria-label="{{ ucfirst($network) }}" title="{{ ucfirst($network) }}"><img class="icon-img icon-img--dark" src="{{ asset('site/assets/icons/'.$icon) }}" alt=""></a>
                @endif
              @endforeach
              @if ($siteSetting?->whatsapp_number)
                <a class="social-icon" href="https://wa.me/{{ preg_replace('/\D+/', '', $siteSetting->whatsapp_number) }}" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp" title="WhatsApp"><img class="icon-img icon-img--dark" src="{{ asset('site/assets/icons/whatsapp.svg') }}" alt=""></a>
              @endif
            </div>
          </div>
          @endif
        </div>
      </div>
    </div>
    <div class="footer-resources">
      <div class="container footer-resources-grid">
        <div class="footer-resource-intro"><span class="eyebrow dark">{{ $siteSetting?->footer_resources_eyebrow ?: 'PLAN WITH GOOD INFORMATION' }}</span>
          <h2>{{ $siteSetting?->footer_resources_title ?: 'Nepal travel resources' }}</h2>
          <p>{{ $siteSetting?->footer_resources_description ?: 'External organizations for travel, conservation and trekking guidance.' }}</p>
        </div>
        <div class="resource-logos" aria-label="Independent Nepal travel organizations">
          @foreach ($siteSetting?->footer_resources ?? [] as $resource)
            @php
              $resourceLogo = $resource['logo'] ?? '';
              $resourceLogoUrl = str_starts_with($resourceLogo, '/') ? asset(ltrim($resourceLogo, '/')) : $resourceLogo;
            @endphp
            <a href="{{ $resource['url'] }}" target="_blank" rel="noopener noreferrer" title="{{ $resource['name'] }}">
              <img src="{{ $resourceLogoUrl }}" alt="{{ $resource['alt'] }}" loading="lazy">
            </a>
          @endforeach
        </div>
      </div>
    </div>
    <div class="footer-base">
      <div class="container footer-base-top">
        <div><span class="footer-base-label">{{ $siteSetting?->footer_payment_title ?: 'PAYMENT OPTIONS' }}</span>
          <p>{{ $siteSetting?->footer_payment_description ?: 'Card networks shown as examples. Accepted methods are confirmed before you pay.' }}</p>
        </div>
        <img src="{{ $siteSetting?->footer_payment_options_url ?: asset('site/assets/pay-cards01.svg') }}"
          alt="Examples of common payment card networks" width="276" height="38" loading="lazy">
      </div>
      <div class="container footer-base-bottom"><span>&copy; {{ now()->year }} {{ $siteSetting?->name ?? config('app.name', 'Explore Nepal Holidays') }}.</span><a href="{{ route('home') }}#top">Back to top
          <span aria-hidden="true">↑</span></a></div>
    </div>
  </footer>
