<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to {{ config('app.name') }} travel updates</title>
</head>
<body style="margin:0;background:#f4f6f5;color:#223243;font-family:Arial,sans-serif;line-height:1.6">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="padding:32px 12px">
        <tr><td align="center">
            <table role="presentation" width="600" cellspacing="0" cellpadding="0" style="max-width:600px;background:#fff;border-radius:12px;padding:36px">
                <tr><td>
                    <p style="margin:0 0 12px;color:#1764a5;font-size:12px;font-weight:bold;letter-spacing:2px;text-transform:uppercase">{{ config('app.name') }}</p>
                    <h1 style="margin:0 0 18px;color:#0b2b50;font-size:26px;line-height:1.25">A little Nepal in your inbox.</h1>
                    <p>Thanks for subscribing. We’ll send occasional travel ideas and planning notes from Nepal.</p>
                    <p>You can unsubscribe at any time using the link below.</p>
                    <p style="margin:28px 0"><a href="{{ $unsubscribeUrl }}" style="display:inline-block;border-radius:24px;background:#0b2b50;color:#fff;padding:12px 20px;text-decoration:none">Unsubscribe from these emails</a></p>
                    <p style="margin:0;color:#687787;font-size:13px">If you did not subscribe, you can ignore this message.</p>
                </td></tr>
            </table>
        </td></tr>
    </table>
</body>
</html>
