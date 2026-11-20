@extends('layouts.site')

@php
    $destination = $package->subcategory->category->destination;
    $whatsAppNumber = preg_replace('/\D+/', '', (string) ($siteSetting?->whatsapp_number ?? ''));
    $whatsAppHref = $whatsAppNumber
        ? 'https://wa.me/'.$whatsAppNumber.'?text='.rawurlencode('I submitted booking request '.$booking->reference.' for '.$package->name.'.')
        : null;
@endphp

@section('page_title', 'Booking request received | '.$package->name)
@section('meta_description', 'Your booking request for '.$package->name.' has been received.')
@section('meta_robots', 'noindex,nofollow')
@section('og_title', 'Booking request received | '.$package->name)
@section('og_image', $coverUrl)
@section('body_class', 'package-page thank-you-page')

@push('page_styles')
    <link rel="stylesheet" href="{{ asset('site/styles/package.css') }}">
    <link rel="stylesheet" href="{{ asset('site/styles/thank-you.css') }}">
    <link rel="stylesheet" href="{{ asset('site/styles/thank-you-print.css') }}" media="print">
@endpush

@push('page_scripts')
    <script>
        document.querySelector('[data-print-confirmation]')?.addEventListener('click', () => window.print());
    </script>
@endpush

@section('content')
    <a class="skip-link" href="#main">Skip to content</a>
    @include('site.partials.header')

    <section class="thank-you-banner" aria-labelledby="confirmation-banner-title">
        <div class="thank-you-banner__image"><img src="{{ $coverUrl }}" alt="{{ $package->name }}" width="1600" height="900"></div>
        <div class="thank-you-banner__shade" aria-hidden="true"></div>
        <div class="container thank-you-banner__content">
            <nav class="thank-you-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a><span aria-hidden="true">/</span>
                <a href="{{ route('packages.show', $package) }}">{{ $package->name }}</a><span aria-hidden="true">/</span>
                <span>Booking confirmation</span>
            </nav>
            <p>YOUR NEPAL JOURNEY STARTS HERE</p>
            <h1 id="confirmation-banner-title">Booking request received</h1>
            <div>Your {{ $package->name }} request is ready to review below.</div>
        </div>
    </section>

    <main id="main" class="thank-you-main">
        <div class="thank-you-wrap">
            <section id="thank-you-print" class="thank-you-card" aria-labelledby="thank-you-title">
                <div class="thank-you-print-brand">
                    <img src="{{ asset('site/assets/logo-mark.png') }}" alt="">
                    <div>
                        <strong>{{ $siteSetting?->name ?? config('app.name', 'Explore Nepal Holidays') }}</strong>
                        <span>{{ $siteSetting?->address ?: 'Thamel, Kathmandu, Nepal' }}</span>
                    </div>
                </div>
                <div class="thank-you-check" aria-hidden="true">
                    <svg viewBox="0 0 48 48" focusable="false"><path d="m13 25 7 7 16-17"/></svg>
                </div>
                <p class="thank-you-eyebrow">BOOKING SUMMARY</p>
                <h2 id="thank-you-title">Thank you, <span>{{ $booking->customer_name }}</span></h2>
                <p class="thank-you-lead">We received your booking request. Keep the reference number below for your records; our team will contact you to confirm availability and final arrangements.</p>
                <div class="thank-you-reference">
                    <span>YOUR REFERENCE</span>
                    <strong>{{ $booking->reference }}</strong>
                </div>
                <dl class="thank-you-details">
                    <div><dt>Trip</dt><dd>{{ $package->name }}</dd></div>
                    <div>
                        <dt>Preferred departure</dt>
                        <dd>{{ $booking->travel_date->format('F j, Y') }}@if ($booking->departure) · {{ $booking->departure->season->label() }}@endif</dd>
                    </div>
                    <div><dt>Travellers</dt><dd>{{ $booking->guests }} {{ \Illuminate\Support\Str::plural('traveller', $booking->guests) }}</dd></div>
                    <div><dt>Email</dt><dd>{{ $booking->email }}</dd></div>
                    <div><dt>Phone / WhatsApp</dt><dd>{{ $booking->phone }}</dd></div>
                    @if ($booking->country_of_residence)
                        <div><dt>Country</dt><dd>{{ $booking->country_of_residence }}</dd></div>
                    @endif
                    @if ($booking->special_requests)
                        <div class="thank-you-notes"><dt>Your notes</dt><dd>{{ $booking->special_requests }}</dd></div>
                    @endif
                </dl>
            </section>

            <aside class="thank-you-action-column" aria-label="Booking actions">
                <div class="thank-you-payment">
                    <strong>Pay online</strong>
                    <span>Online payment will be available soon. This request does not reserve a departure or take payment.</span>
                </div>
                <div class="thank-you-actions">
                    <button class="thank-you-primary" type="button" disabled title="Online payment will be available soon">Pay now</button>
                    <button class="thank-you-secondary" type="button" data-print-confirmation>Print booking summary</button>
                    @if ($whatsAppHref)
                        <a class="thank-you-secondary thank-you-whatsapp-share" href="{{ $whatsAppHref }}" target="_blank" rel="noopener noreferrer">Message our team on WhatsApp <span aria-hidden="true">&#8599;</span></a>
                    @else
                        <a class="thank-you-secondary" href="{{ route('contact') }}">Contact our team</a>
                    @endif
                    <a class="thank-you-primary" href="{{ route('packages.show', $package) }}">Back to {{ $package->name }}</a>
                    <a class="thank-you-secondary" href="{{ route('home') }}#journeys">Explore more journeys</a>
                </div>
            </aside>
        </div>
    </main>

    @include('site.partials.footer')
@endsection
