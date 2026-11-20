@extends('layouts.site')

@section('page_title', 'Guest Reviews | '.($siteSetting?->name ?? config('app.name', 'Explore Nepal Holidays')))
@section('meta_description', 'Read guest stories about trekking and exploring Nepal with Explore Nepal Holidays.')
@section('og_image', asset('site/assets/annapurna-sunrise.jpg'))
@section('body_class', 'bg-paper text-ink font-sans')

@push('page_styles')
<link rel="stylesheet" href="{{ asset('site/styles/about.css') }}">
<link rel="stylesheet" href="{{ asset('site/styles/guest-reviews.css') }}">
@endpush

@section('content')
<a class="skip-link" href="#main">Skip to content</a>
@include('site.partials.header')

<main id="main" class="about-page guest-reviews-page">
    <section class="about-banner guest-reviews-banner" aria-labelledby="reviews-title">
        <div class="container">
            <nav class="about-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a><span aria-hidden="true">/</span><span>Guest reviews</span>
            </nav>
            <h1 id="reviews-title">Guest reviews</h1>
        </div>
    </section>

    <section class="guest-review-intro container" aria-label="Review source">
        <div>
            <span class="guest-reviews-eyebrow">REAL TRAVELLER STORIES</span>
            <h2>Experiences shared in their own words</h2>
            <p>Read travel stories shared by our guests. Each review includes the trip details and a link to its original source when available.</p>
        </div>
        <a class="guest-tripadvisor-link" href="https://www.tripadvisor.in/Attraction_Review-g293890-d19900205-Reviews-Explore_Nepal_Holidays-Kathmandu_Kathmandu_Valley_Bagmati_Zone_Central_Region.html" target="_blank" rel="noopener noreferrer">
            See the Tripadvisor listing <span aria-hidden="true">↗</span>
        </a>
    </section>

    <p class="guest-review-summary container">
        @if ($reviews->total() > 0)
            Showing {{ $reviews->firstItem() }}–{{ $reviews->lastItem() }} of {{ $reviews->total() }} guest {{ \Illuminate\Support\Str::plural('review', $reviews->total()) }}
            <span aria-hidden="true">·</span> {{ number_format($averageRating ?? 0, 1) }} / 5 average rating
        @else
            Guest reviews will appear here as they are added.
        @endif
    </p>

    <section class="guest-review-grid container" aria-label="Guest review excerpts">
        @forelse ($reviews as $review)
            <article class="guest-review-card">
                <div class="guest-review-card-top">
                    <span class="guest-review-stars" aria-label="{{ $review->rating }} out of 5 stars">{{ str_repeat('★', $review->rating) }}<span class="guest-review-stars-empty">{{ str_repeat('☆', 5 - $review->rating) }}</span></span>
                    <span>{{ $review->reviewed_at?->format('F Y') ?? 'Date not listed' }}</span>
                </div>
                <blockquote>{{ $review->review_text }}</blockquote>
                <div class="guest-review-meta">
                    <div class="guest-review-avatar" aria-hidden="true">{{ $review->display_initials }}</div>
                    <div>
                        <strong>{{ $review->reviewer_name }}</strong>
                        <span>{{ $review->trip_name ?: 'Nepal travel experience' }}</span>
                        @if ($review->region_name)
                            <small>{{ $review->region_name }}</small>
                        @endif
                    </div>
                </div>
                @if ($review->source_url)
                    <a class="guest-review-source" href="{{ $review->source_url }}" target="_blank" rel="noopener noreferrer">Read source review <span aria-hidden="true">↗</span></a>
                @endif
            </article>
        @empty
            <div class="guest-review-empty">
                <h2>Reviews are on their way</h2>
                <p>We’re gathering guest stories. Please check back soon, or explore our trips while you’re here.</p>
                <a class="guest-review-source" href="{{ route('home') }}#plan">Start planning a trip <span aria-hidden="true">↗</span></a>
            </div>
        @endforelse
    </section>

    @if ($reviews->hasPages())
        <nav class="guest-review-pagination container" aria-label="Guest review pages">
            @if ($reviews->onFirstPage())
                <span class="guest-review-pagination-disabled" aria-disabled="true">Previous</span>
            @else
                <a href="{{ $reviews->previousPageUrl() }}" rel="prev">Previous</a>
            @endif
            <span aria-current="page">Page {{ $reviews->currentPage() }} of {{ $reviews->lastPage() }}</span>
            @if ($reviews->hasMorePages())
                <a href="{{ $reviews->nextPageUrl() }}" rel="next">Next</a>
            @else
                <span class="guest-review-pagination-disabled" aria-disabled="true">Next</span>
            @endif
        </nav>
    @endif

    <section class="guest-review-cta">
        <div class="container">
            <div>
                <span class="guest-reviews-eyebrow">YOUR NEPAL STORY STARTS HERE</span>
                <h2>Thinking about a journey of your own?</h2>
                <p>Tell us what you would like to see, how much time you have and when you hope to travel.</p>
            </div>
            <a class="header-cta inline-flex items-center justify-center font-semibold text-white bg-orange-brand hover:bg-orange-hover transition-colors rounded-brand" href="{{ route('home') }}#plan">Start planning <span aria-hidden="true">↗</span></a>
        </div>
    </section>
</main>

@include('site.partials.footer')

    <div class="floating-actions">
    <a class="back-to-top" href="#top" aria-label="Back to top" title="Back to top" x-show="showBackToTop" x-cloak><img src="{{ asset('site/assets/explore-nepal-back-to-top-animated.gif') }}" alt="" width="384" height="384"></a>
    <a class="whatsapp-float" href="https://wa.me/?text=I%27m%20planning%20a%20Nepal%20trip%20with%20Explore%20Nepal%20Holidays." target="_blank" rel="noopener noreferrer" aria-label="Share your Nepal trip plans on WhatsApp" title="Share your trip plans on WhatsApp"><img class="icon-img icon-img--dark" src="{{ asset('site/assets/icons/whatsapp.svg') }}" alt=""></a>
</div>
@endsection
