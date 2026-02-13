<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Overzicht Leverancier Gegevens</title>

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

        .app-header{max-width:900px;margin:1.25rem auto 0;padding:0 1rem}
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

        .main-wrap{max-width:900px;margin:1.25rem auto 3rem;padding:0 1rem}
        .main-card{border-radius:1.25rem;border:1px solid var(--line);background:var(--card);overflow:hidden;box-shadow:0 10px 30px rgba(2,6,23,.08)}
        
        .header-bar{
            background:linear-gradient(135deg, #0d6efd 0%, #5b9bff 100%);
            color:#fff; padding:2rem 1.5rem; position:relative; overflow:hidden;
        }
        .header-bar::after{
            content:""; position:absolute; inset:-30% -8% auto auto; width:46%; height:220%;
            background:radial-gradient(closest-side, rgba(255,255,255,.28), transparent 65%);
            transform:rotate(-18deg); pointer-events:none;
        }
        .header-title{font-weight:800;font-size:1.75rem;margin-bottom:.5rem}
        .header-subtitle{opacity:.95;font-size:1rem}

        .info-section{padding:2rem 1.5rem}
        .info-table{width:100%;border-collapse:separate;border-spacing:0 .75rem}
        .info-table tr{background:#f8fafc;border-radius:.5rem}
        .info-table td{padding:1rem 1.25rem;border:none}
        .info-table td:first-child{
            font-weight:700;color:#475569;width:200px;
            border-radius:.5rem 0 0 .5rem;
        }
        .info-table td:last-child{
            color:#0f172a;border-radius:0 .5rem .5rem 0;
        }

        .alert-warning{
            background:#fff3cd;border:1px solid #ffc107;border-radius:.75rem;
            padding:1.25rem;margin:1.5rem 0;display:flex;align-items:center;gap:1rem;
        }
        .alert-warning i{font-size:1.5rem;color:#856404}

        .btn-back{
            display:inline-flex;align-items:center;gap:.5rem;
            padding:.75rem 1.5rem;background:var(--primary);color:#fff;
            border-radius:.5rem;text-decoration:none;font-weight:600;
            transition:.2s;border:none;
        }
        .btn-back:hover{background:var(--primary-600);transform:translateY(-1px);color:#fff}

        .btn-call{
            display:inline-flex;align-items:center;gap:.5rem;
            padding:.75rem 1.5rem;background:#10b981;color:#fff;
            border-radius:.5rem;text-decoration:none;font-weight:600;
            transition:.2s;margin-left:.5rem;
        }
        .btn-call:hover{background:#059669;transform:translateY(-1px);color:#fff}
    </style>
</head>
<body>

    <!-- Navigation -->
    <header class="app-header">
        <nav class="top-nav d-flex align-items-center justify-content-end">
            <a href="{{ route('home') }}" class="nav-link-chip"><i class="bi bi-house"></i> Home</a>
            <a href="{{ route('allergeen.producten.overzicht') }}" class="nav-link-chip"><i class="bi bi-arrow-left"></i> Terug</a>
        </nav>
    </header>

    <!-- Main -->
    <main class="main-wrap">
        <div class="card main-card">

            <!-- Header -->
            <div class="header-bar">
                <h1 class="header-title">
                    <i class="bi bi-building"></i> Overzicht Leverancier Gegevens
                </h1>
                <p class="header-subtitle mb-0">Contactinformatie voor product: {{ $product->ProductNaam }}</p>
            </div>

            <!-- Info Section -->
            <div class="info-section">
                
                @if($leverancier)
                    <table class="info-table">
                        <tr>
                            <td><i class="bi bi-building"></i> Naam Leverancier</td>
                            <td>{{ $leverancier->LeverancierNaam }}</td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-person"></i> Contactpersoon</td>
                            <td>{{ $leverancier->ContactPersoon }}</td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-telephone"></i> Mobiel</td>
                            <td>
                                <a href="tel:{{ $leverancier->Mobiel }}" style="color:#0d6efd;text-decoration:none">
                                    {{ $leverancier->Mobiel }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-geo-alt"></i> Stad</td>
                            <td>{{ $leverancier->Stad ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-signpost"></i> Straat</td>
                            <td>{{ $leverancier->Straatnaam ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-hash"></i> Huisnummer</td>
                            <td>{{ $leverancier->Huisnummer ?? '-' }}</td>
                        </tr>
                    </table>

                    @if(!$leverancier->Stad || !$leverancier->Straatnaam || !$leverancier->Huisnummer)
                        <div class="alert-warning">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <div>
                                <strong>Let op:</strong> Er zijn geen adresgegevens bekend voor deze leverancier.
                            </div>
                        </div>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('allergeen.producten.overzicht') }}" class="btn-back">
                            <i class="bi bi-arrow-left"></i> Terug naar overzicht
                        </a>
                        <a href="tel:{{ $leverancier->Mobiel }}" class="btn-call">
                            <i class="bi bi-telephone-fill"></i> Bel leverancier
                        </a>
                    </div>

                @else
                    <div class="alert-warning">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <div>
                            <strong>Geen leverancier gevonden</strong> voor dit product.
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('allergeen.producten.overzicht') }}" class="btn-back">
                            <i class="bi bi-arrow-left"></i> Terug naar overzicht
                        </a>
                    </div>
                @endif

            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
