@extends('layouts.app')

@section('content')
<style>
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
        margin-bottom: .15rem;
    }

    .page-header-subtitle {
        font-size: .98rem;
        opacity: .9;
        margin: 0;
    }

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
        table-layout: fixed; /* belangrijk: kolommen houden breedtes */
    }

    .table-modern thead th {
        font-size: .8rem;
        text-transform: uppercase;
        letter-spacing: .08em;
        font-weight: 700;
        color: #6b7280;
        border: none;
        padding: .4rem 1rem;
        white-space: nowrap;
    }

    .table-modern tbody tr {
        background: #f9fafb;
        box-shadow: 0 8px 16px rgba(15, 23, 42, .06);
        transition: all .18s ease-out;
    }

    .table-modern tbody tr:hover {
        background: #eef2ff;
        transform: translateY(-1px);
    }

    .table-modern tbody td {
        padding: .95rem 1rem;
        border: none;
        vertical-align: middle;
        font-size: .95rem;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
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

    .col-name {
        font-weight: 800;
        color: #111827;
    }

    .pill {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        border-radius: 999px;
        padding: .28rem .7rem;
        font-size: .8rem;
        font-weight: 700;
        border: 1px solid rgba(148, 163, 184, 0.45);
        background: rgba(255,255,255,.75);
        color: #374151;
    }

    .actions {
        display: flex;
        justify-content: center;
        gap: .5rem;
        flex-wrap: wrap;
    }

    .btn-chip-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .35rem;
        padding: .45rem .95rem;
        border-radius: 999px;
        border: none;
        font-size: .82rem;
        font-weight: 800;
        background: #3b82f6;
        color: #fff !important;
        text-decoration: none;
        box-shadow: 0 10px 18px rgba(59, 130, 246, .25);
        white-space: nowrap;
    }

    .btn-chip-primary:hover {
        background: #2563eb;
        transform: translateY(-1px);
        box-shadow: 0 14px 22px rgba(37, 99, 235, .25);
    }

    .btn-ghost {
        margin-top: 1.25rem;
        padding: .55rem 1rem;
        border-radius: 999px;
        border: 1px solid #e5e7eb;
        background: #fff;
        font-size: .88rem;
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        text-decoration: none;
        color: #4b5563;
    }

    .btn-ghost:hover { background: #f3f4f6; }

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

    @media (max-width: 900px) {
        .page-header-card { padding: 1.8rem 1.6rem; }
        .page-header-title { font-size: 2rem; }
        .table-modern thead { display:none; }

        .table-modern, .table-modern tbody, .table-modern tr, .table-modern td {
            display:block;
            width:100%;
        }

        .table-modern tbody tr {
            border-radius: 18px;
            padding: .85rem 1rem;
        }

        .table-modern tbody td {
            white-space: normal;
            overflow: visible;
            text-overflow: clip;
            padding: .25rem 0;
        }
    }
</style>

  <header class="app-header not-has-[nav]:hidden">
    @if (Route::has('login'))
      <nav class="top-nav">
        <a href="{{ route('allergeen.index') }}" class="nav-link-chip"><i class="bi bi-grid-3x3-gap"></i> Allergenen</a>
        <a href="{{ route('magazijn.index') }}"  class="nav-link-chip"><i class="bi bi-box"></i> Magazijn</a>
        <a href="{{ route('leverancier.index') }}" class="nav-link-chip"><i class="bi bi-truck"></i> Leveranciers</a>
        @auth
          <a href="{{ url('/dashboard') }}" class="nav-link-chip"><i class="bi bi-speedometer2"></i> Dashboard</a>
        @else
          <a href="{{ route('login') }}" class="nav-link-chip"><i class="bi bi-door-open"></i> Log in</a>
          @if (Route::has('register'))
            <a href="{{ route('register') }}" class="nav-link-chip"><i class="bi bi-person-plus"></i> Register</a>
          @endif
        @endauth
      </nav>
    @endif
  </header>

@php
    // Fallbacks zodat alles verschijnt, ook als SP kolomnamen net anders zijn
    // (je hoeft je stored procedure dan niet meteen te wijzigen)
    $get = function($obj, $keys, $default = '-') {
        foreach ($keys as $k) {
            if (isset($obj->$k) && $obj->$k !== null && $obj->$k !== '') return $obj->$k;
        }
        return $default;
    };
@endphp

<div class="page-wrapper">
    <section class="page-header-card">
        <div>
            <h1 class="page-header-title">Leveranciers</h1>
            <p class="page-header-subtitle">Overzicht leveranciers (Producten / Details)</p>
        </div>
        <span class="pill">
            <i class="bi bi-truck"></i>
            {{ count($leveranciers) }} leveranciers
        </span>
    </section>

    @if (session('success'))
        <div class="alert-soft-success">
            <i class="bi bi-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <section class="card-surface">
        <table class="table-modern">
            <thead>
            <tr>
                <th style="width: 22%;">Naam</th>
                <th style="width: 20%;">Contactpersoon</th>
                <th style="width: 18%;">Leveranciersnummer</th>
                <th style="width: 14%;">Mobiel</th>
                <th style="width: 12%;">Aantal producten</th>
                <th style="width: 14%; text-align:center;">Acties</th>
            </tr>
            </thead>

            <tbody>
            @foreach($leveranciers as $lev)
                @php
                    $naam = $get($lev, ['Naam','naam']);
                    $contact = $get($lev, ['ContactPersoon','Contactpersoon','contactpersoon']);
                    $nummer = $get($lev, ['LeverancierNummer','Leveranciersnummer','leveranciernummer']);
                    $mobiel = $get($lev, ['Mobiel','mobiel']);
                    $aantal = $get($lev, ['AantalProducten','aantalProducten','Aantal','aantal'], '0');
                @endphp

                <tr>
                    <td class="col-name" title="{{ $naam }}">{{ $naam }}</td>
                    <td title="{{ $contact }}">{{ $contact }}</td>
                    <td><span class="pill"><i class="bi bi-hash"></i> {{ $nummer }}</span></td>
                    <td><span class="pill"><i class="bi bi-telephone"></i> {{ $mobiel }}</span></td>
                    <td><span class="pill"><i class="bi bi-box-seam"></i> {{ $aantal }}</span></td>
                    <td style="text-align:center;">
                        <div class="actions">
                            <a href="{{ route('leverancier.show', $lev->Id) }}" class="btn-chip-primary">
                                <i class="bi bi-box-seam"></i> Producten
                            </a>
                            <a href="{{ route('leverancier.details', $lev->Id) }}" class="btn-chip-primary">
                                <i class="bi bi-pencil-square"></i> Details
                            </a>
                        </div>
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
