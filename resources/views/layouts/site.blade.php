<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0b2b50">
    <meta name="description" content="@yield('meta_description', 'Discover Nepal with Explore Nepal Holidays.')">
    <meta property="og:title" content="@yield('page_title', config('app.name', 'Explore Nepal Holidays'))">
    <meta property="og:description" content="@yield('meta_description', 'Discover Nepal with Explore Nepal Holidays.')">
    <meta property="og:image" content="@yield('og_image', asset('site/assets/annapurna-sunrise.jpg'))">
    <title>@yield('page_title', config('app.name', 'Explore Nepal Holidays'))</title>
    <link rel="icon" type="image/png" href="{{ asset('site/assets/favicon.png') }}">
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
    @yield('content')

    <script src="{{ asset('site/scripts/menu-data.js') }}"></script>
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
