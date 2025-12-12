@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <title>{{ $title ?? 'Leveranciers' }}</title>

  @vite(['resources/css/app.css','resources/js/app.js'])
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
</head>
<body>
    
</body>
</html>
<header class="app-header not-has-[nav]:hidden">
    @if (Route::has('login'))
        <nav class="top-nav">
            <a href="{{ route('allergeen.index') }}" class="nav-link-chip">
                <i class="bi bi-grid-3x3-gap"></i> Allergenen
            </a>
            <a href="{{ route('magazijn.index') }}" class="nav-link-chip">
                <i class="bi bi-box"></i> Magazijn
            </a>
            <a href="{{ route('leverancier.index') }}" class="nav-link-chip">
                <i class="bi bi-truck"></i> Leveranciers
            </a>
            @auth
                <a href="{{ url('/dashboard') }}" class="nav-link-chip">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="nav-link-chip">
                    <i class="bi bi-door-open"></i> Log in
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="nav-link-chip">
                        <i class="bi bi-person-plus"></i> Register
                    </a>
                @endif
            @endauth
        </nav>
    @endif
</header>

@section('content')
    <style>
        /* --- Layout --- */
        .page-wrapper {
            max-width: 1120px;
            margin: 0 auto;
            padding: 2.5rem 1.25rem 3rem;
        }

        .page-header-card {
            background: radial-gradient(circle at top left, #4f9cff, #3a57ff);
            border-radius: 26px;
            padding: 2.5rem 2.75rem;
            color: #fff;
            box-shadow: 0 18px 35px rgba(46, 78, 255, 0.35);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 2rem;
            margin-bottom: 1.75rem;
        }

        .page-header-title {
            font-size: 2.4rem;
            font-weight: 800;
            letter-spacing: .03em;
            margin-bottom: .35rem;
        }

        .page-header-subtitle {
            font-size: .98rem;
            opacity: .9;
        }

        .page-header-meta {
            display: inline-flex;
            align-items: center;
            gap: .75rem;
            background: rgba(255, 255, 255, 0.14);
            border-radius: 999px;
            padding: .7rem 1.3rem;
            font-size: .85rem;
            backdrop-filter: blur(8px);
        }

        .page-header-meta-icon {
            width: 32px;
            height: 32px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .14);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        /* --- Cards / tabel --- */
        .card-surface {
            background: rgba(255, 255, 255, 0.92);
            border-radius: 24px;
            padding: 1.5rem 1.75rem 1.75rem;
            box-shadow:
                0 12px 30px rgba(15, 23, 42, 0.08),
                0 0 0 1px rgba(148, 163, 184, 0.18);
        }

        .table-modern {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        .table-modern thead th {
            font-size: .8rem;
            text-transform: uppercase;
            letter-spacing: .08em;
            font-weight: 600;
            color: #6b7280;
            border: none;
            padding-bottom: .4rem;
        }

        .table-modern tbody tr {
            background: #f9fafb;
            box-shadow: 0 8px 16px rgba(15, 23, 42, .06);
        }

        .table-modern tbody tr td:first-child,
        .table-modern thead th:first-child {
            border-top-left-radius: 14px;
            border-bottom-left-radius: 14px;
        }

        .table-modern tbody tr td:last-child,
        .table-modern thead th:last-child {
            border-top-right-radius: 14px;
            border-bottom-right-radius: 14px;
        }

        .table-modern tbody td {
            padding: .85rem 1rem;
            border: none;
            vertical-align: middle;
            font-size: .95rem;
        }

        .table-modern tbody tr:hover {
            background: #eef2ff;
            transform: translateY(-1px);
            transition: all .18s ease-out;
        }

        .col-name {
            font-weight: 600;
            color: #111827;
        }

        .text-muted-sm {
            font-size: .78rem;
            color: #9ca3af;
        }

        /* --- Buttons / actions --- */
        .btn-chip-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .35rem;
            padding: .4rem .9rem;
            border-radius: 999px;
            border: none;
            font-size: .8rem;
            font-weight: 600;
            background: #3b82f6;
            color: #fff !important;
            text-decoration: none;
            box-shadow: 0 10px 18px rgba(59, 130, 246, .35);
        }

        .btn-chip-primary:hover {
            background: #2563eb;
            transform: translateY(-1px);
            box-shadow: 0 14px 22px rgba(37, 99, 235, .35);
        }

        .btn-ghost {
            margin-top: 1.25rem;
            padding: .55rem 1rem;
            border-radius: 999px;
            border: 1px solid #e5e7eb;
            background: #fff;
            font-size: .85rem;
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            text-decoration: none;
            color: #4b5563;
        }

        .btn-ghost:hover {
            background: #f3f4f6;
        }

        .alert-soft-success {
            margin-top: 1.25rem;
            margin-bottom: 1rem;
            border-radius: 999px;
            padding: .6rem 1rem;
            font-size: .9rem;
            background: #ecfdf3;
            color: #166534;
            border: 1px solid rgba(22, 163, 74, .18);
            display: inline-flex;
            align-items: center;
            gap: .5rem;
        }

        @media (max-width: 768px) {
            .page-header-card {
                flex-direction: column;
                align-items: flex-start;
                padding: 1.8rem 1.6rem;
            }

            .page-header-title {
                font-size: 2rem;
            }

            .card-surface {
                padding: 1.2rem 1.2rem 1.5rem;
            }

            .table-modern thead {
                display: none;
            }

            .table-modern,
            .table-modern tbody,
            .table-modern tr,
            .table-modern td {
                display: block;
                width: 100%;
            }

            .table-modern tbody tr {
                border-radius: 18px;
                padding: .75rem .9rem;
            }

            .table-modern tbody td {
                padding: .15rem 0;
            }

            .table-modern tbody td:last-child {
                margin-top: .4rem;
            }
        }
    </style>

    

    <div class="page-wrapper">
        {{-- Header kaart zoals bij Allergenen/Magazijn --}}
        <section class="page-header-card">
            <div>
                <h1 class="page-header-title">Leveranciers</h1>
        </section>

        {{-- Eventuele success-melding in zachte stijl --}}
        @if (session('success'))
            <div class="alert-soft-success">
                <i class="bi bi-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- Content card met moderne tabel --}}
        <section class="card-surface">
            <table class="table-modern">
                <thead>
                <tr>
                    <th>Naam</th>
                    <th>Contactpersoon</th>
                    <th>Leveranciersnummer</th>
                    <th>Mobiel</th>
                    <th>Aantal producten</th>
                    <th style="text-align: center;">Acties</th>
                </tr>
                </thead>
                <tbody>
                @foreach($leveranciers as $lev)
                    <tr>
                        <td class="col-name">{{ $lev->Naam }}</td>
                        <td>{{ $lev->ContactPersoon }}</td>
                        <td>{{ $lev->LeverancierNummer }}</td>
                        <td>{{ $lev->Mobiel }}</td>
                        <td>{{ $lev->AantalProducten }}</td>
                        <td style="text-align: center;">
                            <a href="{{ route('leverancier.show', $lev->Id) }}"
                               class="btn-chip-primary"
                               title="Toon geleverde producten">
                                <i class="bi bi-box-seam"></i>
                                <span>Producten</span>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <a href="{{ url('/') }}" class="btn-ghost">
                <i class="bi bi-arrow-left"></i>
                Terug naar home
            </a>
        </section>
    </div>
@endsection
