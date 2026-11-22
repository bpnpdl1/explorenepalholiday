@extends('layouts.site')

@section('page_title', $travelInfoPage->title.' | '.($siteSetting?->name ?? config('app.name', 'Explore Nepal Holidays')))
@section('meta_description', \Illuminate\Support\Str::limit(trim(strip_tags($travelInfoPage->content)), 155))
@section('og_title', $travelInfoPage->title.' | '.($siteSetting?->name ?? config('app.name', 'Explore Nepal Holidays')))
@section('og_image', asset('site/assets/annapurna-sunrise.jpg'))
@section('body_class', 'bg-paper text-ink font-sans about-page')

@push('page_styles')
<link rel="stylesheet" href="{{ asset('site/styles/about.css') }}">
@endpush

@section('content')
<a class="skip-link" href="#main">Skip to content</a>
@include('site.partials.header')

<main id="main" class="about-page">
    <section class="about-banner" aria-labelledby="travel-info-page-title">
        <div class="container">
            <nav class="about-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a><span aria-hidden="true">/</span><a href="{{ route('travel-info.index') }}">Travel Information</a><span aria-hidden="true">/</span><span>{{ $travelInfoPage->title }}</span>
            </nav>
            <h1 id="travel-info-page-title">{{ $travelInfoPage->title }}</h1>
        </div>
    </section>
    <div class="about-content-wrap">
        <x-rich-content :html="$travelInfoPage->content" class="about-richtext" aria-label="{{ $travelInfoPage->title }}" />
    </div>
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
