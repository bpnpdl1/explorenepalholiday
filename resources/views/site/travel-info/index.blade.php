@extends('layouts.site')

@section('page_title', 'Travel Information | '.($siteSetting?->name ?? config('app.name', 'Explore Nepal Holidays')))
@section('meta_description', 'Helpful information for planning a visit to Nepal, choosing a trekking route, and combining travel experiences.')
@section('og_image', asset('site/assets/annapurna-sunrise.jpg'))
@section('body_class', 'bg-paper text-ink font-sans about-page')

@push('page_styles')
<link rel="stylesheet" href="{{ asset('site/styles/about.css') }}">
@endpush

@section('content')
<a class="skip-link" href="#main">Skip to content</a>
@include('site.partials.header')

<main id="main" class="about-page">
    <section class="about-banner" aria-labelledby="travel-info-title">
        <div class="container">
            <nav class="about-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a><span aria-hidden="true">/</span><span>Travel Information</span>
            </nav>
            <h1 id="travel-info-title">Travel Information</h1>
        </div>
    </section>

    <section class="about-content-wrap" aria-label="Travel information topics">
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
            @forelse ($travelInfoPages as $travelInfoPage)
                <article class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="mb-3 font-[Outfit] text-2xl font-bold text-slate-900">{{ $travelInfoPage->title }}</h2>
                    <a class="font-semibold text-amber-700 underline underline-offset-4" href="{{ route('travel-info.show', $travelInfoPage->slug) }}">Read more <span aria-hidden="true">&rarr;</span></a>
                </article>
            @empty
                <p>Travel information pages are being prepared. Please check back soon.</p>
            @endforelse
        </div>
        <p class="mt-8 text-slate-600">Looking for a specific answer? Browse our <a class="font-semibold text-amber-700 underline underline-offset-4" href="{{ route('faq') }}">frequently asked questions</a>.</p>
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
