<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Allergenen</title>

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

        /* Header / nav */
        .app-header{max-width:1100px;margin:1.25rem auto 0;padding:0 1rem}
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
        .nav-link-chip:focus{outline:none;box-shadow:0 0 0 .25rem var(--ring)}

        /* Card & header */
        .main-wrap{max-width:1100px;margin:1.25rem auto 3rem;padding:0 1rem}
        .main-card{border-radius:1.25rem;border:1px solid var(--line);background:var(--card);overflow:hidden}
        .header-bar{
            background:linear-gradient(135deg, var(--primary) 0%, #5b9bff 100%);
            color:#fff; padding:1.75rem 1.25rem; position:relative;
            /* FIX 1: houd de glow binnen de header */
            overflow:hidden;
        }
        .header-bar::after{
            content:""; position:absolute; inset:-30% -8% auto auto; width:46%; height:220%;
            background:radial-gradient(closest-side, rgba(255,255,255,.28), transparent 65%);
            transform:rotate(-18deg);
            /* FIX 2: laat dit element geen kliks vangen */
            pointer-events:none;
        }
        .header-title{font-weight:800;letter-spacing:.2px;margin-bottom:.25rem}
        .header-sub{opacity:.95}
        .pill{
            display:inline-flex;align-items:center;gap:.4rem;
            border-radius:999px;background:rgba(255,255,255,.15); color:#fff;
            padding:.35rem .7rem; font-weight:600;
        }

        /* Toolbar */
        .toolbar{display:flex;flex-wrap:wrap;gap:.75rem;align-items:center;justify-content:space-between}
        .search{max-width:380px; flex:1 1 260px}
        .search .form-control{
            border-radius:999px; padding:.6rem .9rem; border:1px solid var(--line);
        }
        .btn-primary{border-radius:999px; padding:.6rem 1rem; box-shadow:0 8px 18px rgba(13,110,253,.18)}
        .btn-primary:hover{transform:translateY(-1px); box-shadow:0 10px 22px rgba(13,110,253,.24)}

        /* Table */
        .table-wrap{border-top:1px solid var(--line)}
        .table{--bs-table-bg:transparent;margin-bottom:0}
        .table thead th{
            background:linear-gradient(180deg, #f8fafc 0%, #eef2ff 100%);
            font-weight:700; color:#0f172a; border-bottom:1px solid var(--line);
            position:sticky; top:0; z-index:2;
        }
        tbody tr{transition:background-color .18s ease}
        tbody tr:hover{background:#f8fbff}
        td,th{vertical-align:middle}
        .cell-name{font-weight:600}
        .cell-desc{color:var(--muted)}
        .row-divider td{padding:0;border-color:transparent}
        .row-divider td .divider{height:1px;background:var(--line);margin:.25rem 0}

        /* ===== Actions (vernieuwd) ===== */
        .action-buttons{display:flex;justify-content:flex-end;gap:.35rem}
        .btn-icon{
            --size:36px;
            width:var(--size); height:var(--size);
            display:inline-flex; align-items:center; justify-content:center;
            border-radius:999px; border:1px solid var(--line);
            background:#fff; transition:.18s; padding:0;
            box-shadow:0 4px 10px rgba(2,6,23,.04);
        }
        .btn-icon:hover{transform:translateY(-1px)}
        .btn-icon:focus{outline:none; box-shadow:0 0 0 .25rem var(--ring)}
        .btn-icon i{font-size:1rem; line-height:1}

        .btn-icon.view{color:var(--primary); border-color:rgba(13,110,253,.25)}
        .btn-icon.edit{color:#b58100; border-color:rgba(255,193,7,.35)}
        .btn-icon.delete{color:#b42318; border-color:rgba(220,53,69,.35); background:#fff}
        .btn-icon.delete:hover{background:#fff0f0}

        /* Labels op grote schermen */
        @media (min-width: 992px){
            .btn-icon .label{display:inline-block; font-size:.8rem; margin-left:.4rem}
            .btn-icon{width:auto; padding:0 .6rem; height:34px; gap:.35rem}
            .btn-icon i{font-size:.95rem}
        }

        /* Empty state */
        .empty-state{ text-align:center; padding:3rem 1rem; color:var(--muted)}
        .empty-state i{font-size:2rem; display:block; margin-bottom:.25rem; opacity:.65}

        /* Toast on mobile */
        @media (max-width:576px){
            .header-bar{padding:1.5rem 1rem}
            .toolbar{gap:.5rem}
            .search{max-width:100%}
        }
    </style>
</head>
<body>

    <!-- ====== Top Navigation ====== -->
    <header class="app-header not-has-[nav]:hidden">
        @if (Route::has('login'))
            <nav class="top-nav d-flex align-items-center justify-content-end">
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

    <!-- ====== Main ====== -->
    <main class="main-wrap">
        <div class="card main-card shadow-lg">

            <!-- Hero -->
            <div class="header-bar">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div>
                        <h1 class="header-title mb-0">{{ $title }}</h1>
                        <p class="header-sub mb-0">Overzicht van alle allergenen</p>
                    </div>
                    @php $totaal = is_countable($allergenen) ? count($allergenen) : 0; @endphp
                    <span class="pill"><i class="bi bi-collection"></i> {{ $totaal }} in totaal</span>
                </div>
            </div>

            <div class="card-body">

                {{-- Success toast --}}
                @if (session('success'))
                    <div class="position-fixed bottom-0 end-0 p-3" style="z-index:1080">
                        <div id="successToast" class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="d-flex">
                                <div class="toast-body">{{ session('success') }}</div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Sluiten"></button>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Toolbar -->
                <div class="toolbar mb-3">
                    <div class="search">
                        <div class="input-group">
                            <span class="input-group-text border-0"><i class="bi bi-search"></i></span>
                            <input id="tableSearch" type="search" class="form-control" placeholder="Zoek op naam of omschrijving…" />
                        </div>
                    </div>
                    <a href="{{ route('allergeen.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Nieuwe Allergeen
                    </a>
                </div>

                <!-- Tabel -->
                <div class="table-responsive table-wrap">
                    <table id="allergenTable" class="table align-middle">
                        <thead>
                            <tr>
                                <th style="width:28%">Naam</th>
                                <th>Omschrijving</th>
                                <th style="width:120px" class="text-end">Acties</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($allergenen as $allergeen)
                            <tr class="data-row">
                                <td class="cell-name">{{ $allergeen->Naam }}</td>
                                <td class="cell-desc">{{ $allergeen->Omschrijving }}</td>
                                <td class="text-end">
                                    <!-- === NIEUWE ACTIES === -->
                                    <div class="action-buttons">
                                        <!-- Details -->
                                        <a href="{{ route('allergeen.show', $allergeen->Id) }}"
                                           class="btn-icon view"
                                           data-bs-toggle="tooltip" data-bs-title="Details">
                                          <i class="bi bi-eye"></i><span class="label">Details</span>
                                        </a>

                                        <!-- Bewerken -->
                                        <a href="{{ route('allergeen.edit', $allergeen->Id) }}"
                                           class="btn-icon edit"
                                           data-bs-toggle="tooltip" data-bs-title="Bewerken">
                                          <i class="bi bi-pencil-square"></i><span class="label">Bewerken</span>
                                        </a>

                                        <!-- Verwijderen -->
                                        <form action="{{ route('allergeen.destroy', $allergeen->Id) }}" method="POST"
                                              onsubmit="return confirm('Weet je zeker dat je dit allergeen wilt verwijderen?')" class="m-0 p-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn-icon delete"
                                                    data-bs-toggle="tooltip" data-bs-title="Verwijderen">
                                                <i class="bi bi-trash"></i><span class="label">Verwijderen</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <tr class="row-divider"><td colspan="3"><div class="divider"></div></td></tr>
                        @empty
                            <tr>
                                <td colspan="3">
                                    <div class="empty-state">
                                        <i class="bi bi-inboxes"></i>
                                        <div class="fw-semibold">Geen allergenen gevonden</div>
                                        <div class="small">Klik op <em>Nieuwe Allergeen</em> om er één toe te voegen.</div>
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

    @if (session('success'))
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const el = document.getElementById('successToast');
        if (el) {
          const toast = new bootstrap.Toast(el);
          setTimeout(() => toast.hide(), 3000);
        }
      });
    </script>
    @endif

    <!-- Tooltips voor de acties + Live filter -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tooltipEls = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipEls.forEach(el => new bootstrap.Tooltip(el));
        });

        (function(){
            const input = document.getElementById('tableSearch');
            const rows  = () => Array.from(document.querySelectorAll('#allergenTable tbody tr.data-row'));
            const dividers = () => Array.from(document.querySelectorAll('#allergenTable tbody tr.row-divider'));

            function filter(){
                const q = (input.value || '').toLowerCase().trim();
                let anyVisible = false;

                rows().forEach((tr, i) => {
                    const naam = tr.querySelector('.cell-name')?.textContent.toLowerCase() || '';
                    const oms  = tr.querySelector('.cell-desc')?.textContent.toLowerCase() || '';
                    const show = !q || naam.includes(q) || oms.includes(q);
                    tr.style.display = show ? '' : 'none';
                    const divider = dividers()[i];
                    if (divider) divider.style.display = show ? '' : 'none';
                    if (show) anyVisible = true;
                });

                const emptyRow = document.querySelector('#allergenTable .empty-state')?.closest('tr');
                if (emptyRow) emptyRow.style.display = anyVisible ? 'none' : '';
            }
            input?.addEventListener('input', filter);
        })();
    </script>
</body>
</html>
