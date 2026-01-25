@extends('layouts.app')

@section('content')
    <style>
        .page-wrapper {
            max-width: 920px;
            margin: 0 auto;
            padding: 2.5rem 1.25rem 3rem;
        }

        .page-header-card {
            background: radial-gradient(circle at top left, #4f9cff, #3a57ff);
            border-radius: 26px;
            padding: 2.2rem 2.4rem;
            color: #fff;
            box-shadow: 0 18px 35px rgba(46, 78, 255, 0.35);
            margin-bottom: 1.75rem;
        }

        .page-header-title {
            font-size: 2.2rem;
            font-weight: 800;
            letter-spacing: .02em;
            margin-bottom: .25rem;
        }

        .page-header-subtitle {
            font-size: .95rem;
            opacity: .9;
        }

        .card-surface {
            background: rgba(255, 255, 255, 0.92);
            border-radius: 24px;
            padding: 1.75rem 1.75rem 1.9rem;
            box-shadow:
                0 12px 30px rgba(15, 23, 42, 0.08),
                0 0 0 1px rgba(148, 163, 184, 0.18);
        }

        .details-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        .details-table tr {
            background: #f9fafb;
            box-shadow: 0 8px 16px rgba(15, 23, 42, .06);
        }

        .details-table td {
            padding: .85rem 1rem;
            border: none;
            vertical-align: middle;
            font-size: .95rem;
        }

        .details-table td:first-child {
            width: 35%;
            font-weight: 700;
            color: #111827;
            border-top-left-radius: 14px;
            border-bottom-left-radius: 14px;
        }

        .details-table td:last-child {
            border-top-right-radius: 14px;
            border-bottom-right-radius: 14px;
        }

        .btn-chip-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .45rem;
            padding: .55rem 1.1rem;
            border-radius: 999px;
            border: none;
            font-size: .9rem;
            font-weight: 700;
            background: #3b82f6;
            color: #fff !important;
            text-decoration: none;
            box-shadow: 0 10px 18px rgba(59, 130, 246, .35);
            cursor: pointer;
        }

        .btn-chip-primary:hover {
            background: #2563eb;
            transform: translateY(-1px);
            box-shadow: 0 14px 22px rgba(37, 99, 235, .35);
        }

        .btn-ghost {
            padding: .55rem 1rem;
            border-radius: 999px;
            border: 1px solid #e5e7eb;
            background: #fff;
            font-size: .9rem;
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            text-decoration: none;
            color: #4b5563;
        }

        .btn-ghost:hover {
            background: #f3f4f6;
        }

        .actions-row {
            margin-top: 1.3rem;
            display: flex;
            gap: .75rem;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
        }

        .alert-soft-success {
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

        .alert-soft-error {
            margin-bottom: 1rem;
            border-radius: 999px;
            padding: .6rem 1rem;
            font-size: .9rem;
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid rgba(185, 28, 28, .18);
            display: inline-flex;
            align-items: center;
            gap: .5rem;
        }

        @media (max-width: 768px) {
            .page-header-card {
                padding: 1.8rem 1.6rem;
            }

            .page-header-title {
                font-size: 2rem;
            }

            .card-surface {
                padding: 1.2rem 1.2rem 1.5rem;
            }

            .details-table td:first-child {
                width: 45%;
            }

            .actions-row {
                justify-content: flex-start;
            }
        }
    </style>

    <div class="page-wrapper">
        <section class="page-header-card">
            <h1 class="page-header-title">Leverancier Details</h1>
            <div class="page-header-subtitle">
                {{ $leverancier->Naam }} ({{ $leverancier->LeverancierNummer }})
            </div>
        </section>

        {{-- meldingen + na 3 sec terug naar details (scenario eis) --}}
        @if (session('success'))
            <div class="alert-soft-success">
                <i class="bi bi-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
            <script>
                setTimeout(() => {
                    window.location.href = "{{ route('leverancier.details', $leverancier->Id) }}";
                }, 3000);
            </script>
        @endif

        @if (session('error'))
            <div class="alert-soft-error">
                <i class="bi bi-exclamation-triangle"></i>
                <span>{{ session('error') }}</span>
            </div>
            <script>
                setTimeout(() => {
                    window.location.href = "{{ route('leverancier.details', $leverancier->Id) }}";
                }, 3000);
            </script>
        @endif

        <section class="card-surface">
            <table class="details-table">
                <tr><td>Naam</td><td>{{ $leverancier->Naam }}</td></tr>
                <tr><td>Contactpersoon</td><td>{{ $leverancier->ContactPersoon }}</td></tr>
                <tr><td>Leveranciernummer</td><td>{{ $leverancier->LeverancierNummer }}</td></tr>
                <tr><td>Mobiel</td><td>{{ $leverancier->Mobiel }}</td></tr>
                <tr><td>Straatnaam</td><td>{{ $leverancier->Straatnaam ?? '-' }}</td></tr>
                <tr><td>Huisnummer</td><td>{{ $leverancier->Huisnummer ?? '-' }}</td></tr>
                <tr><td>Postcode</td><td>{{ $leverancier->Postcode ?? '-' }}</td></tr>
                <tr><td>Stad</td><td>{{ $leverancier->Stad ?? '-' }}</td></tr>
            </table>

            <div class="actions-row">
                <a class="btn-chip-primary" href="{{ route('leverancier.edit', $leverancier->Id) }}">
                    <i class="bi bi-pencil-square"></i>
                    Wijzig
                </a>

                <div style="display:flex; gap:.6rem; flex-wrap:wrap;">
                    <a class="btn-ghost" href="{{ route('leverancier.index') }}">
                        <i class="bi bi-arrow-left"></i> Terug
                    </a>
                    <a class="btn-ghost" href="{{ url('/') }}">
                        <i class="bi bi-house"></i> Home
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection
