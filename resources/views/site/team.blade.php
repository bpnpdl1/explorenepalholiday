@extends('layouts.site')

@section('page_title', 'Our Team | '.($siteSetting?->name ?? config('app.name', 'Explore Nepal Holidays')))
@section('meta_description', 'Meet the people and planning approach behind Explore Nepal Holidays, with a focus on thoughtful routes and clear trip details.')
@section('og_image', asset('site/assets/annapurna-sunrise.jpg'))
@section('body_class', 'bg-paper text-ink font-sans')

@push('page_styles')
<link rel="stylesheet" href="{{ asset('site/styles/about.css') }}">
@endpush

@section('content')
<a class="skip-link" href="#main">Skip to content</a>
@include('site.partials.header')

  <!-- About Us content -->
  <main id="main" class="about-page">
    <section class="about-banner" aria-labelledby="team-title">
      <div class="container">
        <nav class="about-breadcrumb" aria-label="Breadcrumb">
          <a href="{{ route('home') }}">Home</a><span aria-hidden="true">/</span><span>Our Team</span>
        </nav>
        <h1 id="team-title">Our Team</h1>
      </div>
    </section>

    <div class="about-content-wrap team-intro-wrap">
      <article class="about-richtext" aria-label="About the Explore Nepal Holidays team">
        <h2>People behind your Nepal journey</h2>
        <p>Every journey begins with understanding what matters to you. We help you think through the places you want to see, the time you have and the pace that feels right, then discuss the practical details that shape a trip.</p>
        <p>We value clear communication, thoughtful preparation and respect for the places and communities you visit. Our aim is to help you feel informed as you compare routes and make your plans.</p>
      </article>
    </div>

    <section class="team-section" aria-labelledby="team-section-title">
      <div class="team-section-inner">
        <header class="team-section-heading">
          <span>MEET THE PEOPLE</span>
          <h2 id="team-section-title">How our team can help</h2>
          <p>Meet the people ready to help you plan your journey.</p>
        </header>
        <div class="team-card-grid">
          @forelse ($teamMembers as $teamMember)
            <article class="team-card">
              @if ($teamMember->getFirstMediaUrl('portrait'))
                <img src="{{ $teamMember->getFirstMediaUrl('portrait') }}" alt="Portrait of {{ $teamMember->name }}" loading="lazy">
              @endif
              <div class="team-card-copy">
                <span>{{ $teamMember->role }}</span>
                <h3>{{ $teamMember->name }}</h3>
                @if ($teamMember->bio)
                  <p>{{ $teamMember->bio }}</p>
                @endif
              </div>
            </article>
          @empty
            <p>Our team profiles are being updated. <a href="{{ route('contact') }}">Contact us</a> to start planning your trip.</p>
          @endforelse
        </div>
      </div>
    </section>

    <div class="about-content-wrap team-closing-wrap">
      <article class="about-richtext">
        <h2>Working together</h2>
        <p>A Nepal itinerary can involve local guides, accommodation hosts, transport providers and other people along the route. Who is involved depends on the journey. We encourage you to ask about the services, arrangements and local support included in your proposed itinerary.</p>
        <p>Good planning is a conversation. Share your questions and interests, and we can talk through options for trekking, culture, wildlife or a tailor-made journey.</p>
        <h2>Start a conversation</h2>
        <p>Tell us what you hope to experience in Nepal. <a href="{{ route('contact') }}">Contact us about your plans</a> and we can discuss possible next steps.</p>
      </article>
    </div>
  </main>

  <!-- Reusable Site Footer -->
  @include('site.partials.footer')

  <!-- Reusable Trip Search Modal Dialog -->
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
