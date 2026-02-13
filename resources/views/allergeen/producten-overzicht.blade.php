<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />

    <style>
        :root{
            --bg1:#f6f8fc; --bg2:#eef2ff; --card:#ffffff;
            --text:#0f172a; --muted:#6b7280;
            --primary:#0d6efd; --primary-600:#0b5ed7; --ring:rgba(13,110,253,.25);
            --line:rgba(15,23,42,.08);
        }
        html,body{height:100%}
        body{
            background:
                radial-gradient(1200px 600px at 10% -10%, #e8eefc 0%, transparent 50%),
                radial-gradient(1200px 600px at 110% 10%, #f2f4ff 0%, transparent 50%),
                linear-gradient(135deg, var(--bg1), var(--bg2));
            color:var(--text);
            -webkit-font-smoothing:antialiased; -moz-osx-font-smoothing:grayscale;
        }

        .app-header{max-width:1200px;margin:1.25rem auto 0;padding:0 1rem}
        .top-nav{
            backdrop-filter:saturate(160%) blur(8px);
            background:rgba(255,255,255,.85);
            border:1px solid var(--line); border-radius:.85rem;
            box-shadow:0 10px 30px rgba(2,6,23,.05); padding:.5rem; gap:.5rem;
        }
        .nav-link-chip{
            display:inline-flex;align-items:center;gap:.5rem;padding:.5rem .9rem;
            border:1px solid var(--line);border-radius:999px;text-decoration:none;
            color:#111827;font-weight:500;transition:.2s;
        }
        .nav-link-chip:hover{transform:translateY(-1px);color:var(--primary-600);border-color:rgba(13,110,253,.35)}

        .main-wrap{max-width:1200px;margin:1.25rem auto 3rem;padding:0 1rem}
        .main-card{border-radius:1.25rem;border:1px solid var(--line);background:var(--card);overflow:hidden}
        .header-bar{
            background:linear-gradient(135deg, var(--primary) 0%, #5b9bff 100%);
            color:#fff; padding:1.75rem 1.25rem; position:relative; overflow:hidden;
        }
        .header-bar::after{
            content:""; position:absolute; inset:-30% -8% auto auto; width:46%; height:220%;
            background:radial-gradient(closest-side, rgba(255,255,255,.28), transparent 65%);
            transform:rotate(-18deg); pointer-events:none;
        }
        .header-title{font-weight:800;letter-spacing:.2px;margin-bottom:.25rem}
        .pill{
            display:inline-flex;align-items:center;gap:.4rem;
            border-radius:999px;background:rgba(255,255,255,.15); color:#fff;
            padding:.35rem .7rem; font-weight:600;
        }

        .filter-section{
            background:#f8fafc; padding:1.5rem; border-bottom:1px solid var(--line);
        }
        .filter-form{display:flex;gap:1rem;align-items:end;flex-wrap:wrap}
        .form-group{flex:1;min-width:250px}
        .form-label{font-weight:600;margin-bottom:.5rem;display:block}
        .form-select{
            border-radius:.5rem; padding:.6rem .9rem; border:1px solid var(--line);
            background:#fff;
        }
        .btn-filter{
            border-radius:.5rem; padding:.6rem 1.5rem;
            background:var(--primary); color:#fff; border:none;
            font-weight:600; transition:.2s;
        }
        .btn-filter:hover{background:var(--primary-600);transform:translateY(-1px)}

        .table-wrap{border-top:1px solid var(--line)}
        .table{--bs-table-bg:transparent;margin-bottom:0}
        .table thead th{
            background:linear-gradient(180deg, #f8fafc 0%, #eef2ff 100%);
            font-weight:700; color:#0f172a; border-bottom:1px solid var(--line);
            position:sticky; top:0; z-index:2;
        }
        tbody tr{transition:background-color .18s ease}
        tbody tr:hover{background:#f8fbff}
        .cell-name{font-weight:600}
        .cell-allergenen{color:#d97706;font-size:.9rem}
        .cell-leverancier{color:var(--muted);font-size:.9rem}
        .btn-info-icon{
            width:36px; height:36px;
            display:inline-flex; align-items:center; justify-content:center;
            border-radius:999px; border:1px solid rgba(13,110,253,.25);
            background:#fff; color:var(--primary); transition:.18s;
        }
        .btn-info-icon:hover{transform:translateY(-1px);background:#f0f7ff}

        .empty-state{text-align:center; padding:3rem 1rem; color:var(--muted)}
        .empty-state i{font-size:2rem; display:block; margin-bottom:.5rem; opacity:.65}
    </style>
</head>
<body>

    <!-- Navigation -->
    <header class="app-header">
        @if (Route::has('login'))
            <nav class="top-nav d-flex align-items-center justify-content-end">
                <a href="{{ route('home') }}" class="nav-link-chip"><i class="bi bi-house"></i> Home</a>
                <a href="{{ route('allergeen.producten.overzicht') }}" class="nav-link-chip"><i class="bi bi-exclamation-triangle"></i> Overzicht Allergenen</a>
                <a href="{{ route('allergeen.index') }}" class="nav-link-chip"><i class="bi bi-grid-3x3-gap"></i> Allergenen Beheer</a>
                <a href="{{ route('magazijn.index') }}" class="nav-link-chip"><i class="bi bi-box"></i> Magazijn</a>
                <a href="{{ route('leverancier.index') }}" class="nav-link-chip"><i class="bi bi-truck"></i> Leveranciers</a>
                @auth
                    <a href="{{ url('/dashboard') }}" class="nav-link-chip"><i class="bi bi-speedometer2"></i> Dashboard</a>
                @endauth
            </nav>
        @endif
    </header>

    <!-- Main -->
    <main class="main-wrap">
        <div class="card main-card shadow-lg">

            <!-- Header -->
            <div class="header-bar">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div>
                        <h1 class="header-title mb-0">{{ $title }}</h1>
                        <p class="mb-0" style="opacity:.95">Producten met allergenen en leveranciersinformatie</p>
                    </div>
                    @php $totaal = is_countable($producten) ? count($producten) : 0; @endphp
                    <span class="pill"><i class="bi bi-collection"></i> {{ $totaal }} producten</span>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <form method="GET" action="{{ route('allergeen.producten.overzicht') }}" class="filter-form">
                    <div class="form-group">
                        <label for="allergeen_id" class="form-label">
                            <i class="bi bi-funnel"></i> Allergeen:
                        </label>
                        <select name="allergeen_id" id="allergeen_id" class="form-select">
                            <option value="">-- Alle allergenen --</option>
                            @foreach($alleAllergenen as $allergeen)
                                <option value="{{ $allergeen->Id }}" 
                                    {{ $geselecteerdAllergeenId == $allergeen->Id ? 'selected' : '' }}>
                                    {{ $allergeen->Naam }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-filter">
                        <i class="bi bi-check-circle"></i> Maak Selectie
                    </button>
                </form>
            </div>

            <!-- Table -->
            <div class="card-body p-0">
                <div class="table-responsive table-wrap">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Naam Product</th>
                                <th>Naam Allergeen</th>
                                <th>Omschrijving</th>
                                <th>Aantal Aanwezig</th>
                                <th>Info</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($producten as $product)
                            <tr>
                                <td class="cell-name">{{ $product->ProductNaam }}</td>
                                <td class="cell-allergenen">
                                    <i class="bi bi-exclamation-triangle-fill"></i>
                                    {{ $product->Allergenen }}
                                </td>
                                <td class="cell-leverancier">
                                    @if($product->LeverancierNaam)
                                        Dit product bevat allergeen
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $product->AantalAanwezig ?? 'N/A' }}</td>
                                <td>
                                    @if($product->LeverancierNaam)
                                        <button type="button" 
                                                class="btn-info-icon" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#infoModal{{ $product->ProductId }}"
                                                title="Leverancier info">
                                            <i class="bi bi-info-circle"></i>
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="infoModal{{ $product->ProductId }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            <i class="bi bi-truck"></i> Leverancier Informatie
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>Product:</strong> {{ $product->ProductNaam }}</p>
                                                        <p><strong>Leverancier:</strong> {{ $product->LeverancierNaam }}</p>
                                                        <p><strong>Contactpersoon:</strong> {{ $product->ContactPersoon }}</p>
                                                        <p><strong>Mobiel:</strong> 
                                                            <a href="tel:{{ $product->Mobiel }}">{{ $product->Mobiel }}</a>
                                                        </p>
                                                        <p><strong>Leverancier Nummer:</strong> {{ $product->LeverancierNummer }}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sluiten</button>
                                                        <a href="tel:{{ $product->Mobiel }}" class="btn btn-primary">
                                                            <i class="bi bi-telephone"></i> Bel Nu
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <i class="bi bi-inbox"></i>
                                        <div class="fw-semibold">Geen producten gevonden</div>
                                        <div class="small">Selecteer een allergeen of probeer een andere filter.</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
