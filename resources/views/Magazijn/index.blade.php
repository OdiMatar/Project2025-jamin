{{-- resources/views/Magazijn/index.blade.php --}}
<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $title ?? 'Magazijn' }}</title>

  @vite(['resources/css/app.css','resources/js/app.js'])
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />

  <style>
    /* ==========================================================================
       Magazijn — nette, consistente inline CSS
       Volgorde: Variabelen → Base → Layout → Header/Nav → Hero → Buttons → Table → Utilities → Responsive
       ========================================================================== */

    /* === Variabelen ========================================================== */
    :root {
      --bg1: #f6f8fc;
      --bg2: #eef2ff;
      --primary: #0d6efd;
      --primary-600: #0b5ed7;
      --text: #0f172a;
      --muted: #6b7280;
      --ring: rgba(13,110,253,.25);
      --card-bg: #ffffff;
      --border-subtle: rgba(2,6,23,.06);
      --thead-from: #f8fafc;
      --thead-to:   #eef2ff;
      --shadow-soft: 0 10px 30px rgba(2,6,23,.05);
      --shadow-btn:  0 8px 18px rgba(13,110,253,.18);
      --shadow-btn-h:0 10px 22px rgba(13,110,253,.24);
    }

    /* === Base / Reset-light ================================================== */
    html, body { height: 100%; }
    body {
      margin: 0;
      color: var(--text);
      background:
        radial-gradient(1200px 600px at 10% -10%, rgba(13,110,253,.08) 0%, transparent 50%),
        radial-gradient(1200px 600px at 110% 10%, rgba(99,102,241,.08) 0%, transparent 50%),
        linear-gradient(135deg, var(--bg1), var(--bg2));
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }
    img, svg { vertical-align: middle; }
    table { border-collapse: separate; border-spacing: 0; }
    :focus-visible { outline: .25rem solid var(--ring); outline-offset: 2px; }

    /* Animatie voorkeuren respecteren */
    @media (prefers-reduced-motion: reduce) {
      * { animation-duration: .001ms !important; animation-iteration-count: 1 !important; transition-duration: .001ms !important; }
    }

    /* === Layout ============================================================== */
    .main-wrap { max-width: 1100px; margin: 1.25rem auto 3rem; padding: 0 1rem; }
    .card-elev { border-radius: 1.25rem; border: 1px solid var(--border-subtle); background: var(--card-bg); }

    /* Achtergrond accenten */
    .blob {
      position: fixed; inset: -8rem auto auto -8rem;
      width: 24rem; height: 24rem; filter: blur(50px); z-index: -1;
      background: radial-gradient(circle at 30% 30%, rgba(13,110,253,.14), transparent 60%);
      animation: float 12s ease-in-out infinite alternate;
    }
    .blob.b2 {
      inset: auto -8rem -8rem auto;
      background: radial-gradient(circle at 70% 70%, rgba(13,110,253,.12), transparent 60%);
      animation-delay: 2.2s;
    }
    @keyframes float { to { transform: translate(18px,24px) scale(1.05); } }

    /* === Header / Navigatie ================================================== */
    .app-header { max-width: 1100px; margin: 1.25rem auto 0; padding: 0 1rem; }
    .top-nav {
      display: flex; align-items: center; justify-content: end; gap: .5rem;
      backdrop-filter: saturate(160%) blur(8px);
      background: rgba(255,255,255,.85);
      border: 1px solid var(--border-subtle);
      box-shadow: var(--shadow-soft);
      border-radius: .85rem; padding: .5rem;
    }
    .nav-link-chip {
      display: inline-flex; align-items: center; gap: .5rem;
      padding: .5rem .9rem; border: 1px solid rgba(2,6,23,.08);
      border-radius: 999px; text-decoration: none; color: #111827;
      transition: all .18s ease; font-weight: 500;
    }
    .nav-link-chip:hover { transform: translateY(-1px); border-color: rgba(13,110,253,.35); color: var(--primary-600); }
    .nav-link-chip:focus { box-shadow: 0 0 0 .25rem var(--ring); outline: none; }

    /* === Hero ================================================================ */
    .hero {
      position: relative; overflow: hidden; color: #fff;
      border-radius: 1.25rem 1.25rem 0 0;
      background: linear-gradient(135deg, var(--primary) 0%, #5b9bff 100%);
      padding: 2rem 1.5rem;
    }
    .hero::after {
      content: ""; position: absolute; inset: -40% -10% auto auto;
      width: 46%; height: 220%;
      background: radial-gradient(closest-side, rgba(255,255,255,.28), transparent 65%);
      transform: rotate(-18deg);
    }
    .page-title { font-weight: 800; letter-spacing: .2px; }
    .subtle { opacity: .95; }

    /* === Buttons ============================================================ */
    .btn-primary { border-radius: 999px; box-shadow: var(--shadow-btn); }
    .btn-primary:hover { transform: translateY(-1px); box-shadow: var(--shadow-btn-h); }
    .btn-outline-warning, .btn-outline-primary { border-radius: 999px; }

    /* === Table ============================================================== */
    .table-wrap { border-top: 1px solid var(--border-subtle); }
    .table thead th {
      position: sticky; top: 0; z-index: 5;
      background: linear-gradient(180deg, var(--thead-from) 0%, var(--thead-to) 100%);
      color: #0f172a; font-weight: 700;
      border-bottom: 1px solid rgba(2,6,23,.08);
    }
    tbody tr { transition: transform .18s ease, background-color .18s ease, box-shadow .18s ease; }
    tbody tr:hover { background: #f8fbff; transform: translateY(-1px); box-shadow: inset 0 2px 12px rgba(2,6,23,.04); }
    td, th { vertical-align: middle; }

    /* === Utilities =========================================================== */
    .text-mono { font-family: ui-monospace, Menlo, Consolas, monospace; }
    .cell-dash { color: #adb5bd; }
    .badge-dash { background: #e9ecef; color: #111827; border: 1px dashed rgba(2,6,23,.15); }
    .empty-state { text-align: center; padding: 3rem 1rem; color: var(--muted); }
    .empty-state i { font-size: 2rem; display: block; margin-bottom: .25rem; opacity: .7; }

    /* === Responsive ========================================================== */
    @media (max-width: 576px) {
      .hero { padding: 1.5rem 1rem; }
    }
  </style>
</head>
<body>
  <div class="blob"></div><div class="blob b2"></div>

  <header class="app-header not-has-[nav]:hidden">
    @if (Route::has('login'))
      <nav class="top-nav">
        <a href="{{ route('allergeen.index') }}" class="nav-link-chip"><i class="bi bi-grid-3x3-gap"></i> Allergenen</a>
        <a href="{{ route('magazijn.index') }}" class="nav-link-chip"><i class="bi bi-box"></i> Magazijn</a>
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

  <div class="main-wrap">
    <div class="card card-elev shadow-lg border-0 rounded-4">
      <div class="hero">
        <h1 class="page-title mb-1">{{ $title ?? 'Magazijn' }}</h1>
        <div class="subtle">Overzicht van voorraad per product</div>
      </div>

      <div class="card-body p-4 p-md-5">
        <div class="table-responsive table-wrap">
          <table class="table table-striped align-middle mb-0">
            <thead>
              <tr>
                <th style="width:14%">Barcode</th>
                <th style="width:24%">Naam</th>
                <th class="text-nowrap" style="width:14%">Verpakkingseenheid</th>
                <th class="text-nowrap" style="width:14%">Aantal aanwezig</th>
                <th class="text-nowrap" style="width:14%">Allergenen Info</th>
                <th class="text-nowrap" style="width:20%">Leverantie Info</th>
              </tr>
            </thead>
            <tbody>
            @forelse($magazijn as $row)
              @php
                $product    = $row->product ?? null;

                $barcode    = $product?->Barcode;
                $naam       = $product?->Naam;
                $verpakking = $row->VerpakkingsEenheid ?? null;
                $aantal     = $row->AantalAanwezig ?? null;

                // Zolang de pivot niet bestaat, op false laten
                $heeftAllergenen = false;

                // Zolang er geen LeverancierId-veld bestaat, op false laten
                $heeftLeverantie = false;
              @endphp

              <tr>
                <td>
                  @if($barcode)
                    <span class="text-mono">{{ $barcode }}</span>
                  @else
                    <span class="cell-dash">—</span>
                  @endif
                </td>

                <td>
                  @if($naam)
                    {{ $naam }}
                  @else
                    <span class="cell-dash">—</span>
                  @endif
                </td>

                <td class="text-nowrap">
                  {{ $verpakking !== null ? number_format((float)$verpakking, 2, ',', '.') : '—' }}
                </td>

                <td class="text-nowrap">
                  {{ $aantal !== null ? $aantal : '—' }}
                </td>

                <td>
                  @if($heeftAllergenen)
                    <span class="badge bg-danger rounded-pill">X</span>
                  @else
                    <button type="button"
                            class="btn btn-sm btn-outline-warning"
                            data-bs-toggle="tooltip"
                            data-bs-title="Geen allergeneninformatie beschikbaar">
                      <i class="bi bi-exclamation-triangle"></i>
                    </button>
                  @endif
                </td>

                <td>
                  @if($heeftLeverantie)
                    <a href="#" class="btn btn-sm btn-outline-primary" tabindex="-1" aria-disabled="true">
                      <i class="bi bi-truck"></i> Info
                    </a>
                  @else
                    <button type="button"
                            class="btn btn-sm btn-outline-warning"
                            data-bs-toggle="tooltip"
                            data-bs-title="Geen leverantie-informatie beschikbaar">
                      <i class="bi bi-exclamation-triangle"></i>
                    </button>
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6">
                  <div class="empty-state">
                    <i class="bi bi-inboxes"></i>
                    <div class="fw-semibold">Geen magazijnregels gevonden</div>
                    <div class="small">Er is nog geen voorraad geregistreerd.</div>
                  </div>
                </td>
              </tr>
            @endforelse
            </tbody>
          </table>
        </div>

        @if(method_exists($magazijn,'links'))
          <div class="mt-3 d-flex justify-content-center">
            {{ $magazijn->links() }}
          </div>
        @endif
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const list = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      list.forEach(el => new bootstrap.Tooltip(el));
    });
  </script>
</body>
</html>
