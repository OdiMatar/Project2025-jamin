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
    /* ======================================================================
       Magazijn — verzorgd UI-thema
       ======================================================================
       Inhoud: tokens → basis → layout → topbar → cards → tabel → knoppen
               → helpers → responsive
    */

    /* ---------- Design tokens ---------- */
    :root{
      /* oppervlakken */
      --bg:           #f6f7fb;
      --surface:      #ffffff;
      --surface-2:    #f9fafc;

      /* tekst & randen */
      --text:         #0f172a;  /* slate-900 */
      --muted:        #64748b;  /* slate-500 */
      --border:       #e5e7eb;  /* gray-200 */

      /* merk (zacht blauw + accent lila) */
      --primary:      #2563eb;  /* blue-600 */
      --primary-700:  #1d4ed8;  /* blue-700 */
      --accent:       #7c3aed;  /* violet-600 (heel subtiel gebruikt) */
      --ring:         rgba(37, 99, 235, .28);

      /* look & feel */
      --thead:        #f3f4f6;
      --shadow:       0 10px 26px rgba(2, 6, 23, .06);
      --radius:       16px;
      --radius-sm:    12px;
    }

    /* ---------- Basis ---------- */
    html,body{height:100%}
    body{
      margin:0; color:var(--text);
      background:
        radial-gradient(1000px 420px at 20% -10%, rgba(124,58,237,.06), transparent 60%),
        radial-gradient(900px 380px at 110% 0%, rgba(37,99,235,.07), transparent 60%),
        var(--bg);
      -webkit-font-smoothing:antialiased; -moz-osx-font-smoothing:grayscale;
    }
    a{text-decoration:none}
    :focus-visible{outline:.25rem solid var(--ring); outline-offset:2px}

    /* ---------- Layout ---------- */
    .wrap{max-width:1200px; margin:2rem auto; padding:0 1rem}

    /* ---------- Topbar ---------- */
    .topbar{
      display:flex; justify-content:flex-end; gap:.6rem;
      background:var(--surface); border:1px solid var(--border);
      border-radius:var(--radius); box-shadow:var(--shadow);
      padding:.75rem 1rem;
    }
    .chip{
      display:inline-flex; align-items:center; gap:.5rem;
      padding:.5rem .9rem; border:1px solid var(--border);
      border-radius:999px; background:#fff; color:var(--text);
      transition:transform .16s, color .16s, border-color .16s;
      font-weight:500;
    }
    .chip:hover{ transform:translateY(-1px); color:var(--primary-700); border-color:#c7d2fe }
    .chip i{ font-size:1rem }

    /* ---------- Cards ---------- */
    .card-root{
      background:var(--surface); border:1px solid var(--border);
      border-radius:var(--radius); box-shadow:var(--shadow); overflow:hidden;
    }
    .card-head{
      padding:1.25rem 1.25rem; border-bottom:1px solid var(--border);
      background:linear-gradient(180deg, #ffffff 0%, var(--surface-2) 100%);
    }
    .card-body{ padding:1.25rem }
    .title{ margin:0; font-weight:800; letter-spacing:.2px }
    .subtitle{ color:var(--muted) }

    /* ---------- Tabel ---------- */
    .table-wrap{ border:1px solid var(--border); border-radius:var(--radius-sm); overflow:hidden }
    table.table{ margin:0 }
    thead th{
      background:var(--thead); border-bottom:1px solid var(--border);
      font-weight:700; color:#111827;
    }
    tbody td{ vertical-align:middle }
    tbody tr:hover{ background:#f8fafc }

    /* ---------- Knoppen / iconen ---------- */
    .btn-outline-primary, .btn-outline-warning{ border-radius:999px }

    /* Vraagtekenknop – rond, helder blauw (zoals je schets) */
    .btn-q{
      --size:2rem;
      width:var(--size); height:var(--size);
      display:inline-flex; align-items:center; justify-content:center;
      border-radius:50%;
      border:1.8px solid var(--primary);
      color:var(--primary); background:#fff;
      font-weight:700; line-height:1;
      transition:transform .16s, box-shadow .16s, background-color .16s, color .16s;
    }
    .btn-q:hover{ transform:translateY(-1px); background:#eef2ff; box-shadow:0 0 0 .18rem rgba(37,99,235,.12) }
    .btn-q:focus{ outline:none; box-shadow:0 0 0 .25rem var(--ring) }
    .btn-q.is-disabled{ border-color:#cbd5e1; color:#94a3b8; background:#f8fafc; cursor:not-allowed }

    /* ---------- Helpers ---------- */
    .mono{ font-family:ui-monospace, Menlo, Consolas, monospace }
    .muted{ color:var(--muted) }
    .dash{ color:#9aa3af }

    /* ---------- Responsive ---------- */
    @media (max-width:576px){
      .card-head{ padding:1rem }
      .card-body{ padding:1rem }
    }
  </style>
</head>
<body>

  {{-- Top navigatie --}}
  <header class="wrap">
    @if (Route::has('login'))
      <nav class="topbar">
        <a href="{{ route('allergeen.index') }}" class="chip"><i class="bi bi-grid-3x3-gap"></i><span>Allergenen</span></a>
        <a href="{{ route('magazijn.index') }}"  class="chip"><i class="bi bi-box"></i><span>Magazijn</span></a>
        @auth
          <a href="{{ url('/dashboard') }}" class="chip"><i class="bi bi-speedometer2"></i><span>Dashboard</span></a>
        @else
          <a href="{{ route('login') }}" class="chip"><i class="bi bi-door-open"></i><span>Log in</span></a>
          @if (Route::has('register'))
            <a href="{{ route('register') }}" class="chip"><i class="bi bi-person-plus"></i><span>Register</span></a>
          @endif
        @endauth
      </nav>
    @endif
  </header>

  {{-- Hoofdinhoud --}}
  <main class="wrap">
    <section class="card-root">
      <header class="card-head">
        <h1 class="title mb-1">{{ $title ?? 'Magazijn' }}</h1>
        <div class="subtitle">Overzicht van voorraad per product</div>
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

                  /* ID’s robuust bepalen (zonder model-binding afhankelijkheid) */
                  $productId     = $product?->Id ?? $product?->id ?? $row->ProductId ?? null;
                  $leverancierId = $product?->LeverancierId ?? $product?->leverancier_id ?? $row->LeverancierId ?? null;

                  $heeftAllergenen = false;                       // vervang later met echte check
                  // IDs
                  $productId     = $product?->Id ?? $product?->id ?? $row->ProductId ?? null;
                  // (leverancierId mag blijven staan als je ‘m elders gebruikt)

                  // ✅ Alleen productId is genoeg om door te klikken
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
                    @if($heeftAllergenen)
                      <span class="badge bg-danger rounded-pill">X</span>
                    @else
                      <button type="button"
                              class="btn btn-sm btn-outline-warning"
                              data-bs-toggle="tooltip"
                              data-bs-title="Geen allergeneninformatie beschikbaar"
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
