@extends('emails.layouts.base')

@section('title', 'Welcome to '.config('app.name').' travel updates')
@section('preheader', 'Thanks for subscribing to travel ideas and planning notes from Nepal.')

@section('content')
    <p style="margin:0 0 8px;color:#1764a5;font-size:12px;font-weight:bold;letter-spacing:1.2px;text-transform:uppercase;">Newsletter subscription</p>
    <h1 style="margin:0 0 12px;color:#0b2b50;font-size:25px;line-height:1.3;">A little Nepal in your inbox.</h1>
    <p style="margin:0 0 16px;color:#526273;font-size:15px;">Thanks for subscribing. We'll send occasional travel ideas and planning notes from Nepal.</p>
    <p style="margin:0 0 24px;color:#526273;font-size:15px;">You can unsubscribe at any time using the button below.</p>
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin:0 0 22px;"><tr><td style="border-radius:6px;background-color:#1764a5;"><a href="{{ $unsubscribeUrl }}" style="display:inline-block;padding:12px 18px;color:#ffffff;font-size:14px;font-weight:bold;text-decoration:none;">Unsubscribe</a></td></tr></table>
    <p style="margin:0;color:#718091;font-size:12px;">If you didn't subscribe, you can ignore this message.</p>
@endsection
