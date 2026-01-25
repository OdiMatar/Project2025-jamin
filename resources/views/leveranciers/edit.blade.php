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

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: .9rem 1.1rem;
            align-items: center;
        }

        .form-grid label {
            font-weight: 600;
            color: #111827;
            font-size: .95rem;
        }

        .input-modern {
            width: 100%;
            border-radius: 14px;
            border: 1px solid #e5e7eb;
            padding: .65rem .9rem;
            background: #fff;
            outline: none;
        }

        .input-modern:focus {
            border-color: rgba(59,130,246,.65);
            box-shadow: 0 0 0 4px rgba(59,130,246,.14);
        }

        .input-disabled {
            background: #f3f4f6;
            color: #6b7280;
        }

        .field-error {
            grid-column: 2 / 3;
            color: #b91c1c;
            font-size: .85rem;
            margin-top: -.5rem;
        }

        .actions-row {
            margin-top: 1.4rem;
            display: flex;
            gap: .75rem;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
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

        .hint {
            font-size: .82rem;
            color: #6b7280;
            margin-top: .25rem;
            grid-column: 2 / 3;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            .field-error, .hint {
                grid-column: 1 / 2;
            }
            .actions-row {
                justify-content: flex-start;
            }
        }
    </style>

    <div class="page-wrapper">
        <section class="page-header-card">
            <h1 class="page-header-title">Wijzig Leveranciergegevens</h1>
            <div class="page-header-subtitle">
                Leverancier: <strong>{{ $leverancier->Naam }}</strong> ({{ $leverancier->LeverancierNummer }})
            </div>
        </section>

        <section class="card-surface">
            <form method="POST" action="{{ route('leverancier.update', $leverancier->Id) }}">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    {{-- Niet-wijzigbaar (zoals wireframe: je mag ze tonen maar niet editten) --}}
                    <label>Naam</label>
                    <input class="input-modern input-disabled" value="{{ $leverancier->Naam }}" disabled>

                    <label>Contactpersoon</label>
                    <input class="input-modern input-disabled" value="{{ $leverancier->ContactPersoon }}" disabled>

                    <label>Leveranciernummer</label>
                    <input class="input-modern input-disabled" value="{{ $leverancier->LeverancierNummer }}" disabled>

                    {{-- Wijzigbaar --}}
                    <label for="mobiel">Mobiel</label>
                    <input id="mobiel" name="mobiel" class="input-modern"
                           value="{{ old('mobiel', $leverancier->Mobiel) }}" placeholder="06-12345678">
                    @error('mobiel')
                        <div class="field-error">{{ $message }}</div>
                    @else
                        <div class="hint">Voorbeeld: 06-39398825</div>
                    @enderror

                    <label for="straatnaam">Straatnaam</label>
                    <input id="straatnaam" name="straatnaam" class="input-modern"
                           value="{{ old('straatnaam', $leverancier->Straatnaam) }}" placeholder="Straatnaam">
                    @error('straatnaam') <div class="field-error">{{ $message }}</div> @enderror

                    <label for="huisnummer">Huisnummer</label>
                    <input id="huisnummer" name="huisnummer" class="input-modern"
                           value="{{ old('huisnummer', $leverancier->Huisnummer) }}" placeholder="10A">
                    @error('huisnummer') <div class="field-error">{{ $message }}</div> @enderror

                    <label for="postcode">Postcode</label>
                    <input id="postcode" name="postcode" class="input-modern"
                           value="{{ old('postcode', $leverancier->Postcode) }}" placeholder="1234AB">
                    @error('postcode') <div class="field-error">{{ $message }}</div> @enderror

                    <label for="stad">Stad</label>
                    <input id="stad" name="stad" class="input-modern"
                           value="{{ old('stad', $leverancier->Stad) }}" placeholder="Utrecht">
                    @error('stad') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <div class="actions-row">
                    <button type="submit" class="btn-chip-primary">
                        <i class="bi bi-save2"></i>
                        Sla op
                    </button>

                    <div style="display:flex; gap:.6rem; flex-wrap:wrap;">
                        <a class="btn-ghost" href="{{ route('leverancier.details', $leverancier->Id) }}">
                            <i class="bi bi-arrow-left"></i> Terug
                        </a>

                        <a class="btn-ghost" href="{{ route('leverancier.index') }}">
                            <i class="bi bi-truck"></i> Overzicht
                        </a>

                        <a class="btn-ghost" href="{{ url('/') }}">
                            <i class="bi bi-house"></i> Home
                        </a>
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection
