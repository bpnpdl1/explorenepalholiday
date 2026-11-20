<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @php
        $defaultMetaDescription = $siteSetting?->meta_description ?: $siteSetting?->description ?: 'Discover Nepal with '.($siteSetting?->name ?? config('app.name', 'Explore Nepal Holidays')).'.';
    @endphp
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0b2b50">
    @hasSection('meta_robots')
        <meta name="robots" content="@yield('meta_robots')">
    @endif
    <meta name="description" content="@yield('meta_description', $defaultMetaDescription)">
    <meta property="og:title" content="@yield('og_title', $siteSetting?->name ?: config('app.name', 'Explore Nepal Holidays'))">
    <meta property="og:description" content="@yield('og_description', $defaultMetaDescription)">
    <meta property="og:image" content="@yield('og_image', asset('site/assets/annapurna-sunrise.jpg'))">
    @if ($siteSetting?->canonical_url && request()->routeIs('home'))
        <link rel="canonical" href="{{ $siteSetting->canonical_url }}">
    @endif
    <title>@yield('page_title', $siteSetting?->meta_title ?: $siteSetting?->name ?: config('app.name', 'Explore Nepal Holidays'))</title>
    <link rel="icon" type="image/png" href="{{ $siteSetting?->favicon_url ?: asset('site/assets/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('site/scripts/tailwind-config.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('site/styles/site.css') }}">
    @stack('page_styles')
    <script defer src="{{ asset('site/scripts/alpine.min.js') }}"></script>
</head>
<body class="antialiased @yield('body_class')" x-data="site()" :class="tripSearchOpen ? 'search-open' : ''" x-init="updateScrollUI()" @scroll.window="updateScrollUI()" @keydown.escape.window="closeOverlays()">
    @if (session('site_inquiry_submitted') || session('newsletter_subscribed') || session('newsletter_unsubscribed'))
        <div class="site-toast" data-site-toast role="status" aria-live="polite" aria-atomic="true">
            <i data-lucide="circle-check" aria-hidden="true"></i>
            <p>{{ session('newsletter_unsubscribed') ? 'You have been unsubscribed from newsletter emails.' : (session('newsletter_welcome_email_failed') ? 'You are subscribed, but we could not send the welcome email. Please try again later.' : (session('newsletter_subscribed') ? 'You are subscribed to Nepal travel updates.' : 'Thanks for your inquiry. Our team will be in touch.')) }}</p>
            <button type="button" data-site-toast-dismiss aria-label="Dismiss notification">&times;</button>
        </div>
    @endif
    @yield('content')
    @include('site.partials.trip-search-modal')

    <script src="{{ asset('site/scripts/site.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="https://unpkg.com/lucide@0.468.0/dist/umd/lucide.min.js"></script>
    @stack('page_scripts')
    <script>
        if (window.lucide) window.lucide.createIcons();
        if (window.AOS) {
            AOS.init({ duration: 700, easing: 'ease-out-quart', once: true, offset: 70, disable: () => window.matchMedia('(prefers-reduced-motion: reduce)').matches });
            if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) document.documentElement.classList.add('aos-ready');
        }
    </script>
</body>
</html>
