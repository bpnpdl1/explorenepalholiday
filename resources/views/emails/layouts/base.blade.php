<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <title>@yield('title', config('app.name'))</title>
</head>
<body style="margin:0;padding:0;background-color:#f2f5f8;color:#263746;font-family:Arial,Helvetica,sans-serif;line-height:1.6;-webkit-text-size-adjust:100%;">
    <div style="display:none!important;visibility:hidden;opacity:0;color:transparent;height:0;width:0;overflow:hidden;mso-hide:all;">
        @yield('preheader', config('app.name'))
    </div>
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color:#f2f5f8;">
        <tr>
            <td align="center" style="padding:32px 12px;">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0" style="width:100%;max-width:600px;">
                    <tr>
                        <td style="padding:21px 28px;background-color:#0b2b50;border-radius:12px 12px 0 0;">
                            <p style="margin:0;color:#ffffff;font-size:17px;font-weight:bold;letter-spacing:.3px;">{{ config('app.name') }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:32px 28px;background-color:#ffffff;border:1px solid #e4eaf0;border-top:0;">
                            @yield('content')
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:20px 28px;background-color:#f8fafc;border:1px solid #e4eaf0;border-top:0;border-radius:0 0 12px 12px;">
                            <p style="margin:0 0 5px;color:#617181;font-size:12px;">Sent by {{ config('app.name') }}.</p>
                            <p style="margin:0;font-size:12px;">
                                <a href="{{ rtrim(config('app.url'), '/') }}" style="color:#1764a5;text-decoration:underline;">Visit our website</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
