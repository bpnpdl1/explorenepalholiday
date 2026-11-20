@extends('emails.layouts.base')

@section('title', $adminAlert ? 'New website inquiry' : 'We received your inquiry')
@section('preheader', $adminAlert ? 'A visitor sent a new website inquiry.' : 'Your travel inquiry has been received.')

@section('content')
    @if ($adminAlert)
        <p style="margin:0 0 8px;color:#1764a5;font-size:12px;font-weight:bold;letter-spacing:1.2px;text-transform:uppercase;">Website inquiry</p>
        <h1 style="margin:0 0 12px;color:#0b2b50;font-size:25px;line-height:1.3;">New inquiry #{{ $inquiry->id }}</h1>
        <p style="margin:0 0 24px;color:#526273;font-size:15px;">A visitor submitted a travel inquiry through the website.</p>
    @else
        <p style="margin:0 0 8px;color:#1764a5;font-size:12px;font-weight:bold;letter-spacing:1.2px;text-transform:uppercase;">Inquiry received</p>
        <h1 style="margin:0 0 12px;color:#0b2b50;font-size:25px;line-height:1.3;">Thanks, {{ $inquiry->name }}</h1>
        <p style="margin:0 0 24px;color:#526273;font-size:15px;">We've received your travel inquiry. Our team will review it and get back to you.</p>
    @endif

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="border:1px solid #e4eaf0;border-radius:8px;border-collapse:separate;">
        <tr><td style="padding:11px 14px;border-bottom:1px solid #e4eaf0;color:#617181;font-size:13px;width:120px;">Name</td><td style="padding:11px 14px;border-bottom:1px solid #e4eaf0;color:#263746;font-size:14px;">{{ $inquiry->name }}</td></tr>
        <tr><td style="padding:11px 14px;border-bottom:1px solid #e4eaf0;color:#617181;font-size:13px;">Email</td><td style="padding:11px 14px;border-bottom:1px solid #e4eaf0;color:#263746;font-size:14px;">{{ $inquiry->email }}</td></tr>
        @if ($inquiry->phone)<tr><td style="padding:11px 14px;border-bottom:1px solid #e4eaf0;color:#617181;font-size:13px;">Phone</td><td style="padding:11px 14px;border-bottom:1px solid #e4eaf0;color:#263746;font-size:14px;">{{ $inquiry->phone }}</td></tr>@endif
        @if ($inquiry->interest)<tr><td style="padding:11px 14px;border-bottom:1px solid #e4eaf0;color:#617181;font-size:13px;">Interest</td><td style="padding:11px 14px;border-bottom:1px solid #e4eaf0;color:#263746;font-size:14px;">{{ $inquiry->interest }}</td></tr>@endif
        @if ($inquiry->message)<tr><td style="padding:11px 14px;color:#617181;font-size:13px;vertical-align:top;">Message</td><td style="padding:11px 14px;color:#263746;font-size:14px;white-space:pre-line;">{{ $inquiry->message }}</td></tr>@endif
    </table>

    @if ($adminAlert)
        <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin-top:26px;"><tr><td style="border-radius:6px;background-color:#1764a5;"><a href="{{ route('admin.site-inquiries.show', $inquiry) }}" style="display:inline-block;padding:12px 18px;color:#ffffff;font-size:14px;font-weight:bold;text-decoration:none;">Review inquiry</a></td></tr></table>
    @else
        <p style="margin:22px 0 0;color:#718091;font-size:12px;">If you didn't send this inquiry, you can ignore this email.</p>
    @endif
@endsection
