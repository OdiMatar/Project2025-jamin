<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Jamin')</title>

    {{-- Als je Vite/Tailwind gebruikt, laat dit staan. Anders kun je het weghalen. --}}
    @vite(['resources/css/app.css','resources/js/app.js'])

    <style>
        /* simpele fallback styling als je geen Vite/Tailwind hebt */
        body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; margin:0; }
        .container { max-width: 1100px; margin: 24px auto; padding: 0 16px; }
        header { background:#111; color:#fff; }
        header .nav { display:flex; gap:12px; align-items:center; padding:12px 16px; }
        header a { color:#fff; text-decoration:none; padding:6px 10px; border-radius:6px; }
        header a:hover { background:#222; }
        table { width:100%; border-collapse: collapse; }
        th, td { border:1px solid #e5e5e5; padding:8px 10px; text-align:left; }
        th { background:#fafafa; }
        .mb-3{ margin-bottom:1rem; }
        .btn { padding:8px 12px; border:1px solid #ccc; border-radius:6px; cursor:pointer; background:#fff; }
        .btn:hover { background:#f5f5f5; }
        input[type="text"]{ padding:8px 10px; border:1px solid #ccc; border-radius:6px; min-width:260px; }
        footer { color:#777; font-size:12px; padding:16px; text-align:center; }
    </style>

    @stack('head')
</head>
<body>
<header>
    <nav class="nav">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('allergeen.index') }}">Allergenen</a>
        <a href="{{ route('warehouse.index') }}">Magazijn</a>

        <div style="margin-left:auto"></div>
        @auth
            <a href="{{ route('dashboard') }}">Dashboard</a>
        @else
            <a href="{{ route('login') }}">Log in</a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}">Registreren</a>
            @endif
        @endauth
    </nav>
</header>

<main class="container">
    @yield('content')
</main>

<footer>
    © {{ date('Y') }} — Jamin
</footer>

@stack('scripts')
</body>
</html>
