# Newsletter email on SMTP

Newsletter subscriptions and consent remain in the local database. No queue worker, scheduled command, cron job, or external contact-list service is required. On a new subscription or resubscription, Laravel sends one welcome email synchronously through the configured SMTP mailer. A failed send is logged, the subscription is retained, and a later form submission can retry the welcome email.

## Local development with MailHog

Start MailHog, then use these values in `.env`:

```dotenv
MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_TIMEOUT=8
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_SCHEME=null
MAIL_FROM_ADDRESS="hello@example.test"
MAIL_FROM_NAME="Explore Nepal Holidays"
```

Open MailHog's web inbox to inspect the welcome message and unsubscribe link. If the app runs in a container, use the MailHog service hostname instead of `127.0.0.1`.

## cPanel hosting

Keep the application mailer set to `smtp`, and set `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, and `MAIL_SCHEME` to the SMTP values supplied by the cPanel host or mailbox provider. Set `MAIL_FROM_ADDRESS` to an address authorized by that mailbox. `MAIL_TIMEOUT` defaults to 8 seconds to bound SMTP waiting during a web request. Store these values in the hosting environment or `.env`; do not commit production credentials.

Mail is delivered in the web request because this hosting setup does not rely on a queue worker or cron. If SMTP is unavailable, the local consent record is still saved, a failure is logged, and the page tells the subscriber the welcome email could not be sent. The unsubscribe link in the welcome message opens a confirmation page; its signed, CSRF-protected form performs the unsubscribe. Tokens are encrypted at rest and rotated on resubscription, so an old link cannot unsubscribe a later subscription.
