@extends('layouts.site')

@section('page_title', 'About Us | '.($siteSetting?->name ?? config('app.name', 'Explore Nepal Holidays')))
@section('meta_description', 'Get to know Explore Nepal Holidays and our approach to trekking, culture, wildlife and tailor-made journeys across Nepal.')
@section('og_image', asset('site/assets/annapurna-sunrise.jpg'))
@section('body_class', 'bg-paper text-ink font-sans about-page')

@push('page_styles')
<link rel="stylesheet" href="{{ asset('site/styles/about.css') }}">
@endpush

@push('page_scripts')
<script src="{{ asset('site/scripts/about.js') }}"></script>
@endpush

@section('content')
<a class="skip-link" href="#main">Skip to content</a>
@include('site.partials.header')

<main id="main" class="about-page">
    <section class="about-banner" aria-label="About Explore Nepal Holidays">
        <div class="container">
            <nav class="about-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a><span aria-hidden="true">/</span><span>About Us</span>
            </nav>
        </div>
    </section>
    <div class="about-content-wrap">
        <x-rich-content :html="$aboutPage->content" class="about-richtext" aria-label="About Explore Nepal Holidays" />
    </div>

    <section class="about-reviews" aria-labelledby="about-reviews-title">
        <div class="about-reviews-inner">
            <header class="about-reviews-heading">
                <div>
                    <span class="about-reviews-eyebrow">GUEST REVIEWS</span>
                    <h2 id="about-reviews-title">Experiences shared by our travelers</h2>
                </div>
                <div class="about-reviews-heading-side">
                    <p>Read recent reviews from guests who have explored Nepal with us.</p>
                    @if ($guestReviews->count() > 1)
                        <div class="about-review-controls" aria-label="Review controls">
                            <button class="about-review-control about-review-prev" type="button" aria-label="Previous review" title="Previous review">&larr;</button>
                            <div class="about-review-pagination" aria-label="Choose a review"></div>
                            <button class="about-review-control about-review-next" type="button" aria-label="Next review" title="Next review">&rarr;</button>
                        </div>
                    @endif
                </div>
            </header>

            @if ($guestReviews->isNotEmpty())
                <div class="swiper about-review-swiper">
                    <div class="swiper-wrapper">
                        @foreach ($guestReviews as $guestReview)
                            <article class="swiper-slide about-review-card">
                                <div class="about-review-card__top">
                                    <span>{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                    <small>{{ $guestReview->reviewed_at?->format('M Y') ?? 'Guest review' }}</small>
                                </div>
                                <blockquote>{{ $guestReview->review_text }}</blockquote>
                                <div class="about-review-card__source">
                                    <span aria-hidden="true">&mdash;</span>
                                    <div>
                                        <strong>{{ $guestReview->reviewer_name }}</strong>
                                        <span>{{ $guestReview->trip_name ?: 'Nepal travel experience' }}@if ($guestReview->region_name) &middot; {{ $guestReview->region_name }}@endif</span>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            @else
                <p class="about-review-empty">Guest reviews will appear here as they are added.</p>
            @endif
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
