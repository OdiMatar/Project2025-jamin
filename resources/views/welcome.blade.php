<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jamin App</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            font-family: 'Instrument Sans', sans-serif;
        }

        body {
            background-image: url("https://mecaluxnl.cdnwm.com/documents/20128/441291/Zona+expedicion-Almac%C3%A9n+empresa+distribuci%C3%B3n-es_ES.jpg/ca7e829b-1d94-ccaa-5dcb-72dfc21c4991?t=1563271123000&e=jpg");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #1b1b18;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            backdrop-filter: blur(2px);
            z-index: 0;
        }

        .page {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 920px;
            padding: 2.5rem 1.5rem;
            text-align: center;
        }

        .page-header {
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
            padding: 0.35rem 0.5rem;
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 999px;
            background: rgba(0, 0, 0, 0.22);
            backdrop-filter: blur(10px);
            align-items: center;
            justify-content: flex-end;
        }

        .page-header .btn {
            min-width: 110px;
            border-radius: 999px;
            font-weight: 600;
        }

        .btn-brand {
            background: rgba(255, 255, 255, 0.92);
            color: #1b1b18;
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 12px 22px rgba(0, 0, 0, 0.16);
        }

        .btn-brand:hover {
            background: rgba(255, 255, 255, 0.98);
        }

        .btn-alt {
            border: 1px solid rgba(255, 255, 255, 0.65);
            color: rgba(255, 255, 255, 0.95);
        }

        .btn-alt:hover {
            background: rgba(255, 255, 255, 0.12);
            color: #ffffff;
        }

        .card {
            max-width: 780px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.88);
            border-radius: 1.25rem;
            box-shadow: 0 18px 42px rgba(0, 0, 0, 0.26);
            padding: 2.5rem 2rem;
        }

        .card h1 {
            font-size: 2.3rem;
            font-weight: 800;
            margin-bottom: 0.9rem;
        }

        .card p {
            color: #334155;
            margin-bottom: 1.75rem;
            line-height: 1.55;
        }

        .buttons {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 0.75rem;
        }

        .buttons .btn {
            min-width: 190px;
            border-radius: 0.85rem;
            font-weight: 600;
        }

        @media (max-width: 576px) {
            .card {
                padding: 2rem 1.25rem;
            }

            .card h1 {
                font-size: 1.9rem;
            }
        }
    </style>
</head>

<body>
    <div class="page">
        <div class="page-header">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-alt btn-sm">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-alt btn-sm">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-alt btn-sm">Register</a>
                    @endif
                @endauth
            @endif
        </div>

        <div class="card">
            <h1>Welkom bij het Magazijnportaal</h1>
            <p>Beheer eenvoudig je magazijn, allergenen en leveringen vanuit één centrale omgeving.</p>

            <div class="buttons">
                <a href="{{ route('assortiment.overzicht') }}" class="btn btn-alt btn-lg">Overzicht producten uit het
                    assortiment</a>
                <a href="{{ route('allergeen.producten.overzicht') }}" class="btn btn-alt btn-lg">Overzicht
                    Allergenen</a>
                <a href="{{ route('leveringen.overzicht') }}" class="btn btn-brand btn-lg">Overzicht geleverde
                    producten</a>
                <a href="{{ route('allergeen.index') }}" class="btn btn-alt btn-lg">Allergenen</a>
                <a href="{{ route('magazijn.index') }}" class="btn btn-alt btn-lg">Magazijn</a>
                <a href="{{ route('leverancier.index') }}" class="btn btn-alt btn-lg">Leveranciers</a>
            </div>
        </div>
    </div>
</body>

</html>
