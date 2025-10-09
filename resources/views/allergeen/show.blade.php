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
    :root{ --bg1:#f6f8fc; --bg2:#e8eefc; --primary:#0d6efd; --text:#1f2937; --card-bg:#fff; --ring:rgba(13,110,253,.25);}
    body{
      background: radial-gradient(1200px 600px at 10% -10%, var(--bg2) 0%, transparent 50%),
                  radial-gradient(1200px 600px at 110% 10%, #eef2ff 0%, transparent 50%),
                  linear-gradient(135deg, var(--bg1), #eef2ff);
      color:var(--text);
      -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale;
    }
    .main-wrap{ max-width: 900px; margin:2rem auto; padding:0 1rem;}
    .card.main{ border-radius:1.25rem; border:1px solid rgba(15,23,42,.06); background:var(--card-bg);}
    .header-bar{
      border-radius:1.25rem 1.25rem 0 0;
      background: linear-gradient(135deg, var(--primary) 0%, #5b9bff 100%);
      color:#fff; padding:1.75rem 1.25rem; position:relative; overflow:hidden;
    }
    .header-bar::after{
      content:""; position:absolute; inset:-40% -10% auto auto; width:46%; height:220%;
      background: radial-gradient(closest-side, rgba(255,255,255,.28), transparent 65%);
      transform: rotate(-18deg);
    }
    .section-title{ font-weight:700; margin-bottom:.5rem;}
    .muted{ color:#6b7280;}
  </style>
</head>
<body>
  <main class="main-wrap">
    <div class="card main shadow-lg">
      <div class="header-bar">
        <h1 class="h3 mb-0"><i class="bi bi-eye"></i> {{ $title }}</h1>
      </div>

      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <a href="{{ route('allergeen.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Terug naar overzicht
          </a>
          <div class="d-flex gap-2">
            <a href="{{ route('allergeen.edit', $allergeen->Id) }}" class="btn btn-warning">
              <i class="bi bi-pencil-square"></i> Bewerken
            </a>
            <form action="{{ route('allergeen.destroy', $allergeen->Id) }}" method="POST"
                  onsubmit="return confirm('Weet je zeker dat je dit allergeen wilt verwijderen?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger">
                <i class="bi bi-trash"></i> Verwijderen
              </button>
            </form>
          </div>
        </div>

        <div class="row g-4">
          <div class="col-12">
            <div class="border rounded-4 p-3 h-100">
              <div class="section-title">Basisgegevens</div>
              <dl class="row mb-0">
                <dt class="col-4 col-md-3">Naam</dt>
                <dd class="col-8 col-md-9">{{ $allergeen->Naam }}</dd>

                <dt class="col-4 col-md-3">Omschrijving</dt>
                <dd class="col-8 col-md-9">{{ $allergeen->Omschrijving }}</dd>

                <dt class="col-4 col-md-3">DatumGewijzigd</dt>
                <dd class="col-8 col-md-9">{{ $allergeen->DatumGewijzigd}}</dd>
              </dl>
            </div>
          </div>

          {{-- Voorbeeldsectie: gekoppelde producten (indien later gewenst) --}}
          {{-- 
          <div class="col-12">
            <div class="border rounded-4 p-3">
              <div class="section-title">Gekoppelde producten</div>
              @if(isset($products) && $products->isNotEmpty())
                <ul class="mb-0">
                  @foreach($products as $p)
                    <li>{{ $p->Naam }}</li>
                  @endforeach
                </ul>
              @else
                <div class="muted">Geen producten gekoppeld.</div>
              @endif
            </div>
          </div>
          --}}
        </div>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
