@extends('layouts.site')

@section('page_title', 'Newsletter preferences | '.($siteSetting?->name ?? config('app.name', 'Explore Nepal Holidays')))
@section('meta_robots', 'noindex, nofollow')
@section('body_class', 'bg-paper text-ink font-sans')

@section('content')
<a class="skip-link" href="#main">Skip to content</a>
@include('site.partials.header')

<main id="main" class="about-page">
    <section class="about-banner" aria-labelledby="newsletter-unsubscribe-title">
        <div class="container">
            <nav class="about-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a><span aria-hidden="true">/</span><span>Newsletter preferences</span>
            </nav>
            <h1 id="newsletter-unsubscribe-title">Newsletter preferences</h1>
        </div>
    </section>

    <section class="contact-details-section" aria-labelledby="newsletter-unsubscribe-heading">
        <div class="contact-details-inner">
            <header class="contact-details-heading">
                @if ($isSubscribed)
                    <span>We’ll respect your inbox</span>
                    <h2 id="newsletter-unsubscribe-heading">Unsubscribe from travel emails?</h2>
                    <p>You can unsubscribe from Explore Nepal Holidays newsletter emails. This will not affect booking or inquiry updates.</p>
                @else
                    <span>Preference saved</span>
                    <h2 id="newsletter-unsubscribe-heading">You are already unsubscribed</h2>
                    <p>You will not receive newsletter emails from Explore Nepal Holidays.</p>
                @endif
            </header>

            @if ($isSubscribed)
                <form method="POST" action="{{ $unsubscribeUrl }}" class="newsletter-unsubscribe-form">
                    @csrf
                    <button class="newsletter-unsubscribe-button" type="submit">Unsubscribe from newsletter</button>
                    <a href="{{ route('home') }}">Keep my subscription</a>
                </form>
            @else
                <p><a href="{{ route('home') }}">Return to the website</a></p>
            @endif
        </div>
    </section>
</main>

@include('site.partials.footer')
@endsection

@push('page_styles')
<link rel="stylesheet" href="{{ asset('site/styles/about.css') }}">
<style>
    .newsletter-unsubscribe-form { display: flex; align-items: center; gap: 1.25rem; flex-wrap: wrap; }
    .newsletter-unsubscribe-form a { color: #1764a5; text-decoration: underline; text-underline-offset: .2em; }
    .newsletter-unsubscribe-button { border: 0; border-radius: 999px; background: #0b2b50; color: #fff; cursor: pointer; font: inherit; font-weight: 700; padding: .85rem 1.25rem; }
    .newsletter-unsubscribe-button:hover { background: #1764a5; }
    .newsletter-unsubscribe-button:focus-visible, .newsletter-unsubscribe-form a:focus-visible { outline: 3px solid #e9954a; outline-offset: 3px; }
</style>
@endpush
