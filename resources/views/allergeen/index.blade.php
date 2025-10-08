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
        /* ====== Base ====== */
        :root {
            --bg1: #f6f8fc;
            --bg2: #e8eefc;
            --primary: #0d6efd;
            --primary-600: #0b5ed7;
            --text: #1f2937;
            --muted: #6b7280;
            --card-bg: #ffffff;
            --ring: rgba(13, 110, 253, 0.25);
        }
        html, body { height: 100%; }
        body {
            background: radial-gradient(1200px 600px at 10% -10%, var(--bg2) 0%, transparent 50%),
                        radial-gradient(1200px 600px at 110% 10%, #eef2ff 0%, transparent 50%),
                        linear-gradient(135deg, var(--bg1), #eef2ff);
            color: var(--text);
            -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale;
        }

        /* Subtle animated background accents */
        .blob {
            position: fixed; inset: -10rem auto auto -10rem; width: 25rem; height: 25rem;
            background: radial-gradient(circle at 30% 30%, rgba(13, 110, 253, .15), transparent 60%);
            filter: blur(50px); z-index: -1; animation: float 12s ease-in-out infinite alternate;
        }
        .blob.b2 { inset: auto -10rem -10rem auto; background: radial-gradient(circle at 70% 70%, rgba(13, 110, 253, .12), transparent 60%); animation-delay: 2.5s; }
        @keyframes float { to { transform: translate(20px, 30px) scale(1.05); } }

        /* ====== Header/Nav ====== */
        .app-header { max-width: 1100px; margin: 1.25rem auto 0; padding: 0 1rem; }
        .top-nav {
            backdrop-filter: saturate(160%) blur(8px);
            background: rgba(255,255,255,.8);
            border: 1px solid rgba(15, 23, 42, .06);
            box-shadow: 0 10px 30px rgba(2, 6, 23, .05);
            border-radius: .85rem; padding: .5rem; gap: .5rem;
        }
        .nav-link-chip {
            display: inline-flex; align-items: center; gap: .5rem; padding: .5rem .9rem;
            border: 1px solid rgba(15, 23, 42, .08); border-radius: 999px; text-decoration: none;
            color: #111827; transition: all .2s ease; font-weight: 500;
        }
        .nav-link-chip:focus { outline: none; box-shadow: 0 0 0 .25rem var(--ring); }
        .nav-link-chip:hover { transform: translateY(-1px); border-color: rgba(13,110,253,.35); color: var(--primary-600); }

        /* ====== Card ====== */
        .main-wrap { max-width: 1100px; margin: 1.25rem auto 3rem; padding: 0 1rem; }
        .main-card { border-radius: 1.25rem; border: 1px solid rgba(15, 23, 42, .06); background: var(--card-bg); }
        .header-bar {
            border-radius: 1.25rem 1.25rem 0 0;
            background: linear-gradient(135deg, var(--primary) 0%, #5b9bff 100%);
            color: #fff; padding: 2rem 1.5rem 1.5rem; position: relative; overflow: hidden;
        }
        .header-bar::after {
            content: ""; position: absolute; inset: -40% -10% auto auto; width: 46%; height: 220%;
            background: radial-gradient(closest-side, rgba(255,255,255,.28), transparent 65%);
            transform: rotate(-18deg);
        }
        .header-title { font-weight: 800; letter-spacing: .2px; }
        .header-sub { opacity: .95; font-size: 1.05rem; }

        /* ====== Buttons ====== */
        .btn-primary { border-radius: 999px; padding: .6rem 1rem; box-shadow: 0 8px 18px rgba(13,110,253,.18); }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 10px 22px rgba(13,110,253,.24); }
        .btn-warning.btn-sm, .btn-danger.btn-sm { border-radius: 999px; padding: .35rem .75rem; }
        .btn-warning { color: #111827; }

        /* ====== Table ====== */
        .table-wrap { border-top: 1px solid rgba(15, 23, 42, .06); }
        .table { --bs-table-bg: transparent; }
        .table thead th {
            background: linear-gradient(180deg, #f8fafc 0%, #eef2ff 100%);
            font-weight: 700; color: #0f172a; border-bottom: 1px solid rgba(15, 23, 42, .08);
            position: sticky; top: 0; z-index: 5;
        }
        tbody tr { transition: transform .18s ease, background-color .18s ease, box-shadow .18s ease; }
        tbody tr:hover { background: #f8fbff; transform: translateY(-1px); box-shadow: 0 2px 12px rgba(2,6,23,.04) inset; }
        td, th { vertical-align: middle; }
        .actions { display: flex; gap: .5rem; justify-content: center; flex-wrap: wrap; }

        /* ====== Empty state ====== */
        .empty-state {
            text-align: center; padding: 3rem 1rem; color: var(--muted);
        }
        .empty-state i { font-size: 2rem; display: block; margin-bottom: .25rem; opacity: .6; }

        /* ====== Toast spacing on mobile ====== */
        @media (max-width: 576px) {
            .header-bar { padding: 1.5rem 1rem; }
            .btn-primary { width: 100%; }
        }
    </style>
</head>
<body>
    <div class="blob"></div>
    <div class="blob b2"></div>

    <!-- ====== Top Navigation (uses existing Blade routes/auth) ====== -->
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
            <div class="header-bar">
                <h1 class="mb-1 header-title">{{ $title }}</h1>
                <p class="mb-0 header-sub">Overzicht van alle allergenen</p>
            </div>

            <div class="card-body">
                {{-- Success toast (on the same Blade session check) --}}
                @if (session('success'))
                    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1080">
                        <div id="successToast" class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="d-flex">
                                <div class="toast-body">{{ session('success') }}</div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Sluiten"></button>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('allergeen.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Nieuwe Allergeen
                    </a>
                </div>

                <div class="table-responsive table-wrap">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th style="width: 20%">Naam</th>
                                <th>Omschrijving</th>
                                <th style="width: 26%" class="text-center">Acties</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($allergenen as $allergeen)
                                <tr>
                                    <td class="fw-semibold">{{ $allergeen->Naam }}</td>
                                    <td class="text-muted">{{ $allergeen->Omschrijving }}</td>
                                    <td>
                                        <div class="actions">
                                            <form action="{{ route('allergeen.destroy', $allergeen->Id) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je dit allergeen wilt verwijderen?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash"></i> Verwijderen
                                                </button>
                                            </form>
                                            <a href="{{ route('allergeen.edit', $allergeen->Id) }}" class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil-square"></i> Bewerken
                                            </a>
                                        </div>
                                    </td>
                                </tr>
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
</body>
</html>