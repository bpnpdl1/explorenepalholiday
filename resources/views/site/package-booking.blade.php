@extends('layouts.site')

@php
    $destination = $package->subcategory->category->destination;
    $currency = $package->currency ?: 'USD';
    $travellerOptions = range(
        max(1, (int) ($package->min_group_size ?: 1)),
        max((int) ($package->min_group_size ?: 1), min(20, (int) ($package->max_group_size ?: 6))),
    );
    $whatsAppNumber = preg_replace('/\D+/', '', (string) ($siteSetting?->whatsapp_number ?? ''));
    $whatsAppHref = $whatsAppNumber
        ? 'https://wa.me/'.$whatsAppNumber.'?text='.rawurlencode('I am interested in booking '.$package->name.'.')
        : null;
@endphp

@section('page_title', 'Plan your booking: '.$package->name.' | '.($siteSetting?->name ?? config('app.name')))
@section('meta_description', 'Request a booking for '.$package->name.'. Share your preferred dates and traveller details with our Nepal team.')
@section('og_title', 'Plan your booking: '.$package->name)
@section('og_image', $coverUrl)
@section('body_class', 'package-page booking-page')

@push('page_styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="{{ asset('site/styles/package.css') }}">
    <link rel="stylesheet" href="{{ asset('site/styles/trip-booking.css') }}">
@endpush

@push('page_scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const input = document.querySelector('#departure-date');
            if (input && window.flatpickr) {
                window.flatpickr(input, {
                    altInput: true,
                    altFormat: 'F j, Y',
                    dateFormat: 'Y-m-d',
                    minDate: 'today',
                    disableMobile: true,
                    defaultDate: input.value || null,
                });
            }
        });
    </script>
    <script src="{{ asset('site/scripts/package.js') }}"></script>
@endpush

@section('content')
    <a class="skip-link" href="#main">Skip to content</a>
    @include('site.partials.header')

    <section class="booking-banner" aria-labelledby="booking-title">
        <div class="booking-banner__image"><img src="{{ $coverUrl }}" alt="{{ $package->name }} landscape" width="1600" height="900"></div>
        <div class="booking-banner__shade" aria-hidden="true"></div>
        <div class="container booking-banner__content">
            <nav class="booking-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a><span aria-hidden="true">/</span>
                <a href="{{ route('packages.show', $package) }}">{{ $package->name }}</a><span aria-hidden="true">/</span>
                <span>Booking request</span>
            </nav>
            <p class="booking-eyebrow">YOUR NEPAL JOURNEY STARTS HERE</p>
            <h1 id="booking-title">Plan your booking</h1>
            <p>Share your preferred dates and traveller details. Our local team will confirm availability and the final trip arrangements with you.</p>
        </div>
    </section>

    <main id="main" class="booking-main">
        <div class="container">
            <div class="booking-layout">
                <form class="booking-form" action="{{ route('packages.bookings.store', $package) }}" method="POST">
                    @csrf
                    <section class="booking-card" aria-labelledby="trip-heading">
                        <div class="booking-section-heading"><span class="booking-step">01</span><div><h2 id="trip-heading">Your trip</h2><p>Check the package selected for your request.</p></div></div>
                        <div class="booking-trip-selected">
                            <img src="{{ $coverUrl }}" alt="{{ $package->name }}" width="160" height="110">
                            <div>
                                <span class="booking-tag">{{ strtoupper($destination->name) }}{{ $package->duration_days ? ' · '.$package->duration_days.' DAYS' : '' }}</span>
                                <h3>{{ $package->name }}</h3>
                                <a href="{{ route('packages.show', $package) }}">View itinerary and trip details <span aria-hidden="true">↗</span></a>
                            </div>
                        </div>
                    </section>

                    <section class="booking-card" aria-labelledby="dates-heading">
                        <div class="booking-section-heading"><span class="booking-step">02</span><div><h2 id="dates-heading">Dates and group size</h2><p>These details help us check the right arrangements for you.</p></div></div>
                        <div class="booking-fields">
                            <div class="booking-field">
                                <label for="departure-date">Preferred departure date <span>*</span></label>
                                <input id="departure-date" name="travel_date" type="date" required min="{{ now()->toDateString() }}" value="{{ old('travel_date', $selectedDeparture?->starts_on?->toDateString()) }}" autocomplete="off" aria-describedby="travel-date-help">
                                <small id="travel-date-help">@if ($selectedDeparture) Selected {{ $selectedDeparture->season->label() }} departure: {{ $selectedDeparture->starts_on->format('M j, Y') }}. You can change this date. @else Your date is a request; our team will confirm availability. @endif</small>
                                @error('travel_date') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="booking-field">
                                <label for="travellers">Number of travellers <span>*</span></label>
                                <select id="travellers" name="guests" required>
                                    <option value="">Select group size</option>
                                    @foreach ($travellerOptions as $travellers)
                                        <option value="{{ $travellers }}" @selected((string) old('guests') === (string) $travellers)>{{ $travellers }} {{ \Illuminate\Support\Str::plural('traveller', $travellers) }}</option>
                                    @endforeach
                                </select>
                                @error('guests') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="booking-field booking-field--full">
                                <label for="trip-notes">Anything else we should know?</label>
                                <textarea id="trip-notes" name="special_requests" rows="3" maxlength="10000" placeholder="Special requests, flexibility with dates, or questions">{{ old('special_requests') }}</textarea>
                                @error('special_requests') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    </section>

                    <section class="booking-card" aria-labelledby="contact-heading">
                        <div class="booking-section-heading"><span class="booking-step">03</span><div><h2 id="contact-heading">Your contact details</h2><p>We’ll use these details to reply about your booking.</p></div></div>
                        <div class="booking-fields">
                            <div class="booking-field">
                                <label for="full-name">Full name <span>*</span></label>
                                <input id="full-name" name="customer_name" type="text" autocomplete="name" required value="{{ old('customer_name') }}" placeholder="As shown on your passport">
                                @error('customer_name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="booking-field">
                                <label for="email">Email address <span>*</span></label>
                                <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}" placeholder="you@example.com">
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="booking-field">
                                <label for="phone">WhatsApp / phone <span>*</span></label>
                                <input id="phone" name="phone" type="tel" autocomplete="tel" required value="{{ old('phone') }}" placeholder="Country code and number">
                                @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="booking-field">
                                <label for="country">Country of residence</label>
                                <input id="country" name="country_of_residence" autocomplete="country-name" value="{{ old('country_of_residence') }}" placeholder="Your country">
                                @error('country_of_residence') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                        <label class="booking-consent"><input type="checkbox" name="consent" value="1" required @checked(old('consent'))><span>I agree that Explore Nepal Holidays may use these details to respond to my booking request. <b>*</b></span></label>
                        @error('consent') <small class="text-danger">{{ $message }}</small> @enderror
                        <button class="booking-submit" type="submit">Send booking request <span aria-hidden="true">↗</span></button>
                        <p class="booking-privacy">This request does not reserve a departure or take payment. We’ll confirm availability and provide the final quote before you decide.</p>
                    </section>
                </form>

                <aside class="booking-summary" aria-label="Trip summary">
                    <div class="booking-summary-image"><img src="{{ $coverUrl }}" alt="{{ $package->name }} landscape" width="500" height="300"></div>
                    <div class="booking-summary-body">
                        <p class="booking-eyebrow">TRIP SUMMARY</p>
                        <h2>{{ $package->name }}</h2>
                        <dl>
                            @if ($package->duration_days)<div><dt>Duration</dt><dd>{{ $package->duration_days }} days{{ $package->duration_nights ? ' / '.$package->duration_nights.' nights' : '' }}</dd></div>@endif
                            <div><dt>Destination</dt><dd>{{ $destination->name }}, Nepal</dd></div>
                            <div><dt>Starting price</dt><dd>@if ($package->price_from !== null)From {{ $currency }} {{ number_format((float) $package->price_from, 0) }}<small>{{ $package->price_qualifier ?: 'per person' }}</small>@else Request a quote @endif</dd></div>
                            @if ($package->difficulty)<div><dt>Difficulty</dt><dd>{{ $package->difficulty }}</dd></div>@endif
                        </dl>
                        <div class="booking-deposit-note"><span aria-hidden="true">✓</span><p><strong>Clear quote before payment</strong><br>We’ll confirm your trip total and payment details directly with you.</p></div>
                        <a class="booking-summary-link" href="{{ route('contact') }}">See contact information ↗</a>
                    </div>
                </aside>
            </div>
            <p class="booking-help">Prefer to talk first?
                @if ($whatsAppHref)<a href="{{ $whatsAppHref }}" target="_blank" rel="noopener noreferrer">Message us on WhatsApp ↗</a>
                @else <a href="{{ route('contact') }}">Contact our team ↗</a>@endif
            </p>
        </div>
    </main>

    @include('site.partials.footer')
@endsection
