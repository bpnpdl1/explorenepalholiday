@extends('layouts.site')

@section('page_title', 'Why Choose Us | '.($siteSetting?->name ?? config('app.name', 'Explore Nepal Holidays')))
@section('meta_description', 'See how Explore Nepal Holidays helps you plan a thoughtful Nepal journey, with clear pacing, local context and practical preparation.')
@section('og_title', 'Why Choose Us | '.($siteSetting?->name ?? config('app.name', 'Explore Nepal Holidays')))
@section('og_image', asset('site/assets/annapurna-sunrise.jpg'))
@section('body_class', 'bg-paper text-ink font-sans')

@section('content')
<a class="skip-link" href="#main">Skip to content</a>
@include('site.partials.header')

<main id="main">
    <section class="relative isolate overflow-hidden bg-slate-950 text-white" aria-labelledby="why-choose-us-title">
        <img src="{{ asset('site/assets/annapurna-sunrise.jpg') }}" alt="Sunrise over the Himalayan mountains" class="absolute inset-0 -z-20 h-full w-full object-cover" fetchpriority="high">
        <div class="absolute inset-0 -z-10 bg-gradient-to-r from-slate-950/90 via-slate-950/65 to-slate-950/25"></div>
        <div class="container py-20 md:py-28 lg:py-32">
            <nav class="mb-8 flex items-center gap-2 text-sm text-white/75" aria-label="Breadcrumb">
                <a class="transition hover:text-white" href="{{ route('home') }}">Home</a>
                <span aria-hidden="true">/</span>
                <span aria-current="page" class="text-white">Why Choose Us</span>
            </nav>
            <div class="max-w-3xl">
                <span class="mb-4 inline-block text-xs font-bold uppercase tracking-[.2em] text-amber-300">The planning difference</span>
                <h1 id="why-choose-us-title" class="mb-5 font-[Outfit] text-4xl font-extrabold leading-tight text-white md:text-6xl">A Nepal journey shaped around you</h1>
                <p class="max-w-2xl text-base leading-relaxed text-white/85 md:text-lg">Good travel design means clear pacing, realistic routes, honest preparation and local context. Here is what guides the way we help you plan.</p>
                <a href="{{ route('contact') }}" class="mt-8 inline-flex items-center gap-3 rounded-lg bg-amber-400 px-6 py-3 font-bold text-slate-950 transition hover:bg-amber-300">
                    Talk with our team
                    <span aria-hidden="true">&rarr;</span>
                </a>
            </div>
        </div>
    </section>

    <section class="px-4 py-16 md:px-8 md:py-24" aria-labelledby="reasons-title">
        <div class="mx-auto max-w-7xl">
            <header class="mx-auto mb-12 max-w-3xl text-center md:mb-16">
                <span class="mb-3 block text-xs font-bold uppercase tracking-[.18em] text-amber-600">Thoughtful from the start</span>
                <h2 id="reasons-title" class="mb-4 font-[Outfit] text-3xl font-bold tracking-tight text-slate-900 md:text-4xl">Planning built around the details that matter</h2>
                <p class="text-base leading-relaxed text-slate-600">Every trip is different. These principles help us shape useful options and set clear expectations before you travel.</p>
            </header>

            @if ($reasons->isNotEmpty())
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($reasons as $index => $reason)
                        <article class="flex h-full flex-col rounded-2xl border border-slate-200 bg-white p-7 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg md:p-8">
                            <div class="mb-6 flex items-center justify-between">
                                <span class="font-[Outfit] text-sm font-bold tracking-widest text-amber-600">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                                <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-amber-50">
                                    @if ($iconUrl = $reason->getFirstMediaUrl('icon'))
                                        <img src="{{ $iconUrl }}" alt="" class="h-8 w-8 object-contain" loading="lazy">
                                    @else
                                        <svg class="h-7 w-7 text-amber-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3 14.8 9.2 21 12l-6.2 2.8L12 21l-2.8-6.2L3 12l6.2-2.8L12 3Z" />
                                        </svg>
                                    @endif
                                </div>
                            </div>
                            <h3 class="mb-3 font-[Outfit] text-xl font-bold text-slate-900">{{ $reason->title }}</h3>
                            <p class="leading-relaxed text-slate-600">{{ $reason->description }}</p>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-12 text-center">
                    <h3 class="mb-2 font-[Outfit] text-xl font-bold text-slate-900">We are updating this page</h3>
                    <p class="text-slate-600">Contact our team and we will be happy to talk through how we plan Nepal journeys.</p>
                    <a href="{{ route('contact') }}" class="mt-5 inline-flex font-semibold text-amber-700 underline underline-offset-4">Get in touch</a>
                </div>
            @endif
        </div>
    </section>

    <section class="bg-slate-950 px-4 py-14 text-white md:px-8 md:py-20" aria-labelledby="next-step-title">
        <div class="mx-auto flex max-w-6xl flex-col items-start justify-between gap-8 md:flex-row md:items-center">
            <div class="max-w-2xl">
                <span class="mb-3 block text-xs font-bold uppercase tracking-[.18em] text-amber-300">Your trip, your priorities</span>
                <h2 id="next-step-title" class="mb-3 font-[Outfit] text-3xl font-bold md:text-4xl">Start with the Nepal you want to experience</h2>
                <p class="leading-relaxed text-white/75">Share your dates, interests and preferred pace. We will help you explore what could work for your trip.</p>
            </div>
            <a href="{{ route('packages.index') }}" class="inline-flex shrink-0 items-center gap-3 rounded-lg bg-white px-6 py-3 font-bold text-slate-950 transition hover:bg-amber-100">Explore journeys <span aria-hidden="true">&rarr;</span></a>
        </div>
    </section>
</main>

@include('site.partials.footer')

<div class="floating-actions">
    <a class="back-to-top" href="#top" aria-label="Back to top" title="Back to top" x-show="showBackToTop" x-cloak>
        <img src="{{ asset('site/assets/explore-nepal-back-to-top-animated.gif') }}" alt="" width="384" height="384">
    </a>
    <a class="whatsapp-float" href="https://wa.me/?text=I%27m%20planning%20a%20Nepal%20trip%20with%20Explore%20Nepal%20Holidays." target="_blank" rel="noopener noreferrer" aria-label="Share your Nepal trip plans on WhatsApp" title="Share your trip plans on WhatsApp">
        <img class="icon-img icon-img--dark" src="{{ asset('site/assets/icons/whatsapp.svg') }}" alt="">
    </a>
</div>
@endsection
