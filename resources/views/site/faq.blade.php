@extends('layouts.site')

@section('page_title', 'FAQs | '.($siteSetting?->name ?? config('app.name', 'Explore Nepal Holidays')))
@section('meta_description', 'Answers to common questions about planning trips, trekking and booking with Explore Nepal Holidays.')
@section('og_image', asset('site/assets/annapurna-sunrise.jpg'))
@section('body_class', 'bg-paper text-ink font-sans')

@push('page_styles')
<link rel="stylesheet" href="{{ asset('site/styles/about.css') }}">
<link rel="stylesheet" href="{{ asset('site/styles/faq.css') }}">
@endpush

@push('page_scripts')
@php
    $faqStructuredData = [
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => $faqSchema,
    ];
@endphp
<script type="application/ld+json">@json($faqStructuredData)</script>
@endpush

@section('content')
<a class="skip-link" href="#main">Skip to content</a>
@include('site.partials.header')

<main id="main" class="faq-page about-page">
    <section class="about-banner" aria-labelledby="faq-page-title">
        <div class="container">
            <nav class="about-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a><span aria-hidden="true">/</span><span>FAQs</span>
            </nav>
            <h1 id="faq-page-title">Frequently asked questions</h1>
        </div>
    </section>

    @if ($faqGroups->isNotEmpty())
        <nav class="faq-page-topics" aria-label="FAQ topics">
            <div class="container">
                @foreach ($faqGroups as $group)
                    <a href="#{{ $group['category']->value }}">{{ $group['category']->label() }}</a>
                @endforeach
            </div>
        </nav>
    @endif

    <div class="container faq-page-content">
        @forelse ($faqGroups as $group)
            @php($faqNumber = 0)
            <section class="faq-page-group" id="{{ $group['category']->value }}" aria-labelledby="{{ $group['category']->value }}-title">
                <div class="faq-page-group__intro">
                    <span class="eyebrow dark">{{ $group['category']->eyebrow() }}</span>
                    <h2 id="{{ $group['category']->value }}-title">{{ $group['category']->label() }}</h2>
                    <p>{{ $group['category']->description() }}</p>
                </div>
                <div class="faq-list">
                    @foreach ($group['faqs'] as $faq)
                        @php($faqNumber++)
                        <details>
                            <summary>
                                <span>{{ str_pad((string) $faqNumber, 2, '0', STR_PAD_LEFT) }}</span>
                                <strong>{{ $faq->question }}</strong>
                                <span class="plus" aria-hidden="true">+</span>
                            </summary>
                            <p>{!! nl2br(e($faq->answer)) !!}</p>
                        </details>
                    @endforeach
                </div>
            </section>
        @empty
            <section class="faq-page-empty" aria-labelledby="faq-empty-title">
                <h2 id="faq-empty-title">We are updating our answers</h2>
                <p>In the meantime, contact our team and we will help with your Nepal travel questions.</p>
                <a href="{{ route('contact') }}">Contact our team</a>
            </section>
        @endforelse

        <section class="faq-page-contact" aria-labelledby="faq-contact-title">
            <div>
                <span class="eyebrow light-eye">Still have a question?</span>
                <h2 id="faq-contact-title">We can help you plan the details.</h2>
                <p>Tell us what you are considering, and our team can help you explore the next steps.</p>
            </div>
            <a class="faq-page-cta" href="{{ route('contact') }}">Contact our team <span aria-hidden="true">&rarr;</span></a>
        </section>
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
