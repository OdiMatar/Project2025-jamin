{{-- resources/views/Magazijn/index.blade.php --}}
<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{{ $title ?? 'Magazijn' }}</title>

  @vite(['resources/css/app.css','resources/js/app.js'])
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />

  <style>
    /* =========================================================
       Magazijn – matcht het thema van Allergenen (blauw/violet)
       en behoudt klikbaarheid van alle elementen.
       ========================================================= */

    /* --- Tokens --- */
    :root{
      --surface:#ffffff;
      --surface-2:#f9fafc;

      --text:#0f172a;
      --muted:#667085;
      --border:rgba(2,6,23,.10);

      --brand-1:#4f46e5; /* indigo-600 */
      --brand-2:#7c3aed; /* violet-600 */
      --ring:rgba(79,70,229,.28);

      --thead-from:#f6f7ff;
      --thead-to:#eef2ff;
      --row-hover:#f5f6ff;

      --shadow-soft:0 14px 34px rgba(2,6,23,.10);
      --shadow-card:0 12px 26px rgba(2,6,23,.08);

      --radius-xl:22px;
      --radius:14px;
      --radius-sm:10px;
    }

    /* --- Basis + achtergrond --- */
    html,body{height:100%}
    body{
      margin:0; color:var(--text);
      background:
        radial-gradient(1200px 520px at 12% -10%, rgba(124,58,237,.12), transparent 60%),
        radial-gradient(1100px 520px at 106% 0%, rgba(34,211,238,.10), transparent 60%),
        linear-gradient(180deg, #f7f8fc, #eef2ff);
      -webkit-font-smoothing:antialiased; -moz-osx-font-smoothing:grayscale;
    }
    a{text-decoration:none}
    :focus-visible{outline:.26rem solid var(--ring); outline-offset:2px}

    /* Blobs (decoratie) — nooit klikken blokkeren */
    .blob{
      position:fixed; inset:-12rem auto auto -12rem; width:28rem; height:28rem;
      background: radial-gradient(circle at 40% 40%, rgba(167,139,250,.18), transparent 60%);
      filter: blur(56px); z-index:-1; animation: float 16s ease-in-out infinite alternate;
      pointer-events:none;
    }
    .blob.b2{
      inset:auto -12rem -10rem auto;
      background: radial-gradient(circle at 60% 60%, rgba(34,211,238,.16), transparent 60%);
      animation-delay:2.2s; pointer-events:none;
    }
    @keyframes float { to { transform: translate(22px,28px) scale(1.045); } }

    /* --- Topbar (chips zoals Allergenen) --- */
    .app-header{ max-width:1120px; margin:1.25rem auto 0; padding:0 1rem; }
    .top-nav{
      display:flex; justify-content:flex-end; gap:.6rem;
      backdrop-filter:saturate(160%) blur(10px);
      background:rgba(255,255,255,.82);
      border:1px solid var(--border);
      border-radius:var(--radius);
      box-shadow:var(--shadow-card);
      padding:.65rem .8rem;
    }
    .nav-link-chip{
      display:inline-flex; align-items:center; gap:.55rem;
      padding:.52rem .95rem; border:1px solid rgba(2,6,23,.10);
      border-radius:999px; color:#111827; background:#fff;
      transition:transform .16s, border-color .16s, color .16s, box-shadow .16s;
      font-weight:600;
    }
    .nav-link-chip:hover{
      transform:translateY(-1px);
      border-color:#c7d2fe; color:#1f3ad9;
      box-shadow:0 6px 18px rgba(31,58,217,.12);
    }
    .nav-link-chip:focus{ box-shadow:0 0 0 .26rem var(--ring) }

    /* --- Layout + container (card) --- */
    .main-wrap{ max-width:1120px; margin:1.25rem auto 3rem; padding:0 1rem; }
    .card-shell{
      border:1px solid var(--border);
      border-radius:var(--radius-xl);
      background:var(--surface);
      box-shadow:var(--shadow-soft);
      overflow:hidden;
      position:relative;
      z-index:0; /* eigen stacking-context */
    }

    /* --- Hero (blauwe kop) --- */
    .card-head.hero{
      position:relative; color:#fff;
      background: radial-gradient(120% 160% at 110% -10%, rgba(167,139,250,.35), transparent 40%),
                  linear-gradient(135deg, var(--brand-1) 0%, var(--brand-2) 100%);
      padding:2rem 1.6rem 1.4rem;
      border-bottom:0;
      overflow:hidden;           /* clip binnen de card */
    }
    .card-head.hero::after{
      content:""; position:absolute; inset:-40% -12% auto auto; width:44%; height:220%;
      background: radial-gradient(closest-side, rgba(255,255,255,.25), transparent 65%);
      transform: rotate(-18deg);
      pointer-events:none;       /* <<< voorkomt klikblokkade */
    }
    .hero-title{ font-weight:900; letter-spacing:.2px; margin:0; position:relative; z-index:1 }
    .hero-sub{ opacity:.95; font-size:1.05rem; position:relative; z-index:1 }

    .card-body{ padding:1.35rem; position:relative; z-index:1 }

    /* --- Tabel --- */
    .table-wrap{ border:1px solid var(--border); border-radius:var(--radius); overflow:hidden; position:relative; z-index:1 }
    table.table{ margin:0 }
    thead th{
      background: linear-gradient(180deg, var(--thead-from) 0%, var(--thead-to) 100%);
      border-bottom:1px solid var(--border); font-weight:800; color:#111827;
      position:sticky; top:0; z-index:2;
    }
    tbody td{ vertical-align:middle }
    tbody tr:hover{ background:var(--row-hover) }

    /* --- Knoppen --- */
    .btn-outline-warning{ border-radius:999px }
    .btn-q{
      --size:2rem;
      width:var(--size); height:var(--size);
      display:inline-flex; align-items:center; justify-content:center;
      border-radius:50%;
      border:1.8px solid #4f46e5;
      color:#4f46e5; background:#fff;
      font-weight:700; line-height:1;
      transition:transform .16s, box-shadow .16s, background-color .16s, color .16s;
      position:relative; z-index:1;   /* blijft boven decoratieve lagen */
    }
    .btn-q:hover{ transform:translateY(-1px); background:#eef2ff; box-shadow:0 0 0 .18rem rgba(79,70,229,.12) }
    .btn-q.is-disabled{ border-color:#cbd5e1; color:#94a3b8; background:#f8fafc; cursor:not-allowed }

    /* Helpers */
    .mono{ font-family:ui-monospace, Menlo, Consolas, monospace }
    .muted{ color:var(--muted) }
    .dash{ color:#9aa3af }

    /* Responsive */
    @media (max-width:576px){
      .card-body{ padding:1rem }
      .card-head.hero{ padding:1.6rem 1rem 1.1rem }
    }
  </style>
</head>
<body>
  <div class="blob"></div>
  <div class="blob b2"></div>

  {{-- Top navigatie (chips) --}}
  <header class="app-header not-has-[nav]:hidden">
    @if (Route::has('login'))
      <nav class="top-nav">
        <a href="{{ route('allergeen.index') }}" class="nav-link-chip"><i class="bi bi-grid-3x3-gap"></i> Allergenen</a>
        <a href="{{ route('magazijn.index') }}"  class="nav-link-chip"><i class="bi bi-box"></i> Magazijn</a>
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

  {{-- Hoofdinhoud --}}
  <main class="main-wrap">
    <section class="card-shell">
      <header class="card-head hero">
        <h1 class="hero-title mb-1">{{ $title ?? 'Magazijn' }}</h1>
        <div class="hero-sub">Overzicht van voorraad per product</div>
      </header>

      <div class="card-body">
        <div class="table-wrap table-responsive">
          <table class="table align-middle mb-0">
            <thead>
              <tr>
                <th style="width:16%">Barcode</th>
                <th style="width:26%">Naam</th>
                <th class="text-nowrap" style="width:14%">Verpakkingseenheid</th>
                <th class="text-nowrap" style="width:14%">Aantal aanwezig</th>
                <th class="text-nowrap" style="width:14%">Allergenen Info</th>
                <th class="text-nowrap" style="width:16%">Leverantie Info</th>
              </tr>
            </thead>

            <tbody>
              @forelse($magazijn as $row)
                @php
                  $product       = $row->product ?? null;

                  $barcode       = $product?->Barcode;
                  $naam          = $product?->Naam;
                  $verpakking    = $row->VerpakkingsEenheid ?? null;
                  $aantal        = $row->AantalAanwezig ?? null;

                  $productId     = $product?->Id ?? $product?->id ?? $row->ProductId ?? null;

                  $heeftAllergenen = $product?->allergenen()->exists(); // ✅ check op relatie
                  $heeftLeverantie = !empty($productId);
                @endphp

                <tr>
                  <td>
                    @if($barcode) <span class="mono">{{ $barcode }}</span>
                    @else <span class="dash">—</span> @endif
                  </td>

                  <td>
                    @if($naam) {{ $naam }}
                    @else <span class="dash">—</span> @endif
                  </td>

                  <td class="text-nowrap">
                    {{ $verpakking !== null ? number_format((float)$verpakking, 2, ',', '.') : '—' }}
                  </td>

                  <td class="text-nowrap">
                    {{ $aantal !== null ? $aantal : '—' }}
                  </td>

                 <td>
  @if($productId)
    <a href="{{ route('magazijn.allergenen.show', $productId) }}"
       class="btn btn-sm {{ $heeftAllergenen ? 'btn-outline-danger' : 'btn-outline-warning' }}"
       aria-label="Allergeneninformatie bekijken"
       title="Allergeneninformatie">
      @if($heeftAllergenen)
                <i class="bi bi-x-octagon-fill"></i>
              @else
                <i class="bi bi-exclamation-triangle"></i>
              @endif
            </a>
          @else
            {{-- ongewijzigde disabled weergave --}}
            <button type="button"
                    class="btn btn-sm btn-outline-warning disabled"
                    aria-disabled="true"
                    aria-label="Geen allergeneninformatie">
              <i class="bi bi-exclamation-triangle"></i>
            </button>
          @endif
        </td>


                  <td>
                    @if($heeftLeverantie)
                      <a href="{{ route('leverantie.info.show', ['product' => $productId]) }}"
                         class="btn-q"
                         title="Leverantie info"
                         aria-label="Toon leveringsinformatie">?</a>
                    @else
                      <span class="btn-q is-disabled"
                            data-bs-toggle="tooltip"
                            data-bs-title="Geen leverantie-informatie beschikbaar"
                            aria-label="Geen leverantie-informatie">?</span>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="text-center py-5">
                    <div class="muted mb-1"><i class="bi bi-inboxes"></i></div>
                    <div class="fw-semibold">Geen magazijnregels gevonden</div>
                    <div class="muted small">Er is nog geen voorraad geregistreerd.</div>
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
    </section>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const tips = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      tips.forEach(el => new bootstrap.Tooltip(el));
    });
  </script>
</body>
</html>
