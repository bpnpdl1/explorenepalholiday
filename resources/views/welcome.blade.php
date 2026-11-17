<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#102b3f">
    <title>{{ config('app.name', 'Explore Nepal Holidays') }}</title>
    <style>
        :root { color-scheme: light; font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }
        * { box-sizing: border-box; }
        body { min-height: 100vh; margin: 0; color: #163246; background: #f4f7f8; }
        .welcome-page { min-height: 100vh; display: grid; place-items: center; padding: 32px 20px; background: radial-gradient(ellipse at 78% 20%, rgba(80, 157, 151, .22), transparent 38%), linear-gradient(140deg, #eef4f3 0%, #f8f7f1 55%, #e8f0f4 100%); }
        .welcome-card { width: min(100%, 1080px); overflow: hidden; display: grid; grid-template-columns: 1.1fr .9fr; background: white; border: 1px solid rgba(22, 50, 70, .08); border-radius: 24px; box-shadow: 0 28px 80px rgba(22, 50, 70, .12); }
        .welcome-copy { padding: clamp(36px, 7vw, 80px); display: flex; flex-direction: column; justify-content: center; }
        .brand { display: inline-flex; align-items: center; gap: 11px; color: #147d78; font-size: 15px; font-weight: 700; letter-spacing: .02em; text-decoration: none; }
        .brand-mark { width: 38px; height: 38px; display: grid; place-items: center; color: white; background: #147d78; border-radius: 12px; font-size: 21px; }
        .eyebrow { margin: 46px 0 12px; color: #147d78; font-size: 12px; font-weight: 700; letter-spacing: .16em; text-transform: uppercase; }
        h1 { max-width: 560px; margin: 0; color: #163246; font-size: clamp(38px, 5vw, 62px); line-height: 1.06; letter-spacing: -.045em; }
        .description { max-width: 470px; margin: 22px 0 30px; color: #647782; font-size: 17px; line-height: 1.75; }
        .admin-link { width: fit-content; display: inline-flex; align-items: center; gap: 10px; padding: 13px 19px; color: white; background: #147d78; border-radius: 9px; font-size: 14px; font-weight: 650; text-decoration: none; transition: background .2s ease, transform .2s ease; }
        .admin-link:hover { color: white; background: #106863; transform: translateY(-1px); }
        .welcome-art { min-height: 540px; position: relative; overflow: hidden; display: flex; align-items: end; padding: 40px; color: white; background: linear-gradient(180deg, rgba(13, 48, 63, .06), rgba(13, 48, 63, .75)), linear-gradient(148deg, #8ebbb6 2%, #4e8887 35%, #264e63 68%, #152d46 100%); }
        .mountain { position: absolute; inset: 0; width: 100%; height: 100%; }
        .art-caption { position: relative; z-index: 1; max-width: 280px; }
        .art-caption strong { display: block; margin-bottom: 7px; font-size: 18px; }
        .art-caption span { color: rgba(255,255,255,.78); font-size: 14px; line-height: 1.6; }
        @media (max-width: 760px) { .welcome-card { grid-template-columns: 1fr; } .welcome-art { min-height: 250px; } .eyebrow { margin-top: 34px; } }
    </style>
</head>
<body>
    <main class="welcome-page">
        <div class="welcome-card">
            <section class="welcome-copy">
                <a class="brand" href="{{ route('home') }}">
                    <span class="brand-mark" aria-hidden="true">⌁</span>
                    <span>{{ config('app.name', 'Explore Nepal Holidays') }}</span>
                </a>
                <p class="eyebrow">Journeys made memorable</p>
                <h1>Find your next adventure in Nepal.</h1>
                <p class="description">Explore Himalayan trails, rich culture, and unforgettable experiences with Explore Nepal Holidays.</p>
                <a class="admin-link" href="{{ route('login') }}">Administrator sign in <span aria-hidden="true">→</span></a>
            </section>
            <aside class="welcome-art" aria-label="Illustration of the Himalayan mountains">
                <svg class="mountain" viewBox="0 0 700 720" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
                    <circle cx="545" cy="142" r="56" fill="#f4d9a3" opacity=".9" />
                    <path d="M0 500 147 295l77 100L375 173l214 327 111-119v339H0Z" fill="#789f9d" opacity=".75" />
                    <path d="m184 391 191-218 155 237-113-81-44 39-52-72-58 90Z" fill="#e8efea" opacity=".95" />
                    <path d="m0 557 184-166 91 111 111-103 140 105 91-97 89 94v216H0Z" fill="#3c6973" />
                    <path d="m0 610 165-126 106 88 145-99 141 110 89-65 60 58v151H0Z" fill="#1d4259" />
                    <path d="M0 672c113-39 173-19 261 9 111 35 205 31 439-32v172H0Z" fill="#122d45" />
                </svg>
                <div class="art-caption">
                    <strong>From the Himalayas to the Terai</strong>
                    <span>Thoughtful trips, local knowledge, and a Nepal experience to remember.</span>
                </div>
            </aside>
        </div>
    </main>
</body>
</html>
