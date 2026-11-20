@extends('emails.layouts.base')

@section('title', $adminAlert ? 'New booking request' : 'We received your booking request')
@section('preheader', $adminAlert ? 'A new package booking request needs review.' : 'Your booking request has been received.')

@section('content')
    @if ($adminAlert)
        <p style="margin:0 0 8px;color:#1764a5;font-size:12px;font-weight:bold;letter-spacing:1.2px;text-transform:uppercase;">Booking request</p>
        <h1 style="margin:0 0 12px;color:#0b2b50;font-size:25px;line-height:1.3;">New booking request</h1>
        <p style="margin:0 0 24px;color:#526273;font-size:15px;">Reference <strong>{{ $booking->reference }}</strong> was submitted for <strong>{{ $booking->package?->name ?? 'a package' }}</strong>.</p>
    @else
        <p style="margin:0 0 8px;color:#1764a5;font-size:12px;font-weight:bold;letter-spacing:1.2px;text-transform:uppercase;">Request received</p>
        <h1 style="margin:0 0 12px;color:#0b2b50;font-size:25px;line-height:1.3;">Thanks, {{ $booking->customer_name }}</h1>
        <p style="margin:0 0 14px;color:#526273;font-size:15px;">We've received your booking request for <strong>{{ $booking->package?->name ?? 'your trip' }}</strong>. Our team will contact you to review availability.</p>
        <p style="margin:0 0 24px;padding:12px 14px;border-left:3px solid #e7a93b;background-color:#fff8e8;color:#674c1d;font-size:14px;"><strong>This is a request, not a confirmed booking.</strong> Your reference is {{ $booking->reference }}.</p>
    @endif

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="border:1px solid #e4eaf0;border-radius:8px;border-collapse:separate;">
        <tr><td style="padding:11px 14px;border-bottom:1px solid #e4eaf0;color:#617181;font-size:13px;width:120px;">Package</td><td style="padding:11px 14px;border-bottom:1px solid #e4eaf0;color:#263746;font-size:14px;">{{ $booking->package?->name ?? 'Package booking' }}</td></tr>
        <tr><td style="padding:11px 14px;border-bottom:1px solid #e4eaf0;color:#617181;font-size:13px;">Reference</td><td style="padding:11px 14px;border-bottom:1px solid #e4eaf0;color:#263746;font-size:14px;">{{ $booking->reference }}</td></tr>
        <tr><td style="padding:11px 14px;border-bottom:1px solid #e4eaf0;color:#617181;font-size:13px;">Name</td><td style="padding:11px 14px;border-bottom:1px solid #e4eaf0;color:#263746;font-size:14px;">{{ $booking->customer_name }}</td></tr>
        <tr><td style="padding:11px 14px;border-bottom:1px solid #e4eaf0;color:#617181;font-size:13px;">Email</td><td style="padding:11px 14px;border-bottom:1px solid #e4eaf0;color:#263746;font-size:14px;">{{ $booking->email }}</td></tr>
        <tr><td style="padding:11px 14px;border-bottom:1px solid #e4eaf0;color:#617181;font-size:13px;">Phone</td><td style="padding:11px 14px;border-bottom:1px solid #e4eaf0;color:#263746;font-size:14px;">{{ $booking->phone }}</td></tr>
        <tr><td style="padding:11px 14px;border-bottom:1px solid #e4eaf0;color:#617181;font-size:13px;">Travel date</td><td style="padding:11px 14px;border-bottom:1px solid #e4eaf0;color:#263746;font-size:14px;">{{ $booking->travel_date->format('M j, Y') }}</td></tr>
        <tr><td style="padding:11px 14px;{{ $booking->special_requests ? 'border-bottom:1px solid #e4eaf0;' : '' }}color:#617181;font-size:13px;">Guests</td><td style="padding:11px 14px;{{ $booking->special_requests ? 'border-bottom:1px solid #e4eaf0;' : '' }}color:#263746;font-size:14px;">{{ $booking->guests }}</td></tr>
        @if ($booking->special_requests)<tr><td style="padding:11px 14px;color:#617181;font-size:13px;vertical-align:top;">Trip notes</td><td style="padding:11px 14px;color:#263746;font-size:14px;white-space:pre-line;">{{ $booking->special_requests }}</td></tr>@endif
    </table>

    @if ($adminAlert)
        <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin-top:26px;"><tr><td style="border-radius:6px;background-color:#1764a5;"><a href="{{ route('admin.bookings.show', $booking) }}" style="display:inline-block;padding:12px 18px;color:#ffffff;font-size:14px;font-weight:bold;text-decoration:none;">Review booking</a></td></tr></table>
    @else
        <p style="margin:22px 0 0;color:#718091;font-size:12px;">If you didn't send this booking request, please contact us.</p>
    @endif
@endsection
