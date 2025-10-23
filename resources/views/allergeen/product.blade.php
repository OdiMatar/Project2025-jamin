<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{{ $title ?? 'Overzicht Allergenen' }}</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

  <style>
    :root{
      --brand:#1a73e8;      /* zelfde vibe als Leverancier */
      --border:rgba(2,6,23,.10);
      --card-bg:#fff;
    }
    body{
      background:
        radial-gradient(1100px 520px at 8% -10%, #e9f0ff 0%, transparent 55%),
        radial-gradient(1100px 520px at 110% 0%, #eef2ff 0%, transparent 55%),
        linear-gradient(180deg, #f6f8fc, #eef2ff);
    }
    .page-wrap{max-width:1100px; margin:0 auto; padding:24px 16px 48px;}
    .header-bar{
      background: var(--brand);
      color:#fff;
      padding:14px 18px;
      border-radius:14px;
      font-weight:700;
      box-shadow:0 6px 18px rgba(26,115,232,.25);
      margin-bottom:18px;
    }
    .card-like{
      background:var(--card-bg);
      border:1px solid var(--border);
      border-radius:14px;
      box-shadow:0 10px 26px rgba(2,6,23,.06);
    }
    .info-box{
      padding:16px 18px;
      border-bottom:1px solid var(--border);
      border-radius:14px 14px 0 0;
    }
    .table-wrap{ padding:0; }
    .table thead th{
      background:#f7f9ff;
      border-bottom:1px solid var(--border);
      font-weight:700;
    }
    .btn-back{
      border-radius:999px;
      padding:.55rem 1rem;
    }
  </style>
</head>
<body>
  <main class="page-wrap">
    <!-- Blauwe balk zoals Leverancier -->
    <div class="header-bar">Allergenen</div>

    <!-- Info + tabel in card -->
    <div class="card-like">
      <div class="info-box">
        <div class="row g-3 align-items-center">
          <div class="col">
            <div><strong>Naam product:</strong> {{ $product->Naam ?? '—' }}</div>
            <div><strong>Barcode:</strong> {{ $product->Barcode ?? '—' }}</div>
          </div>
        </div>
      </div>

      <div class="table-wrap">
        @if($allergenen->isNotEmpty())
          <table class="table table-striped mb-0">
            <thead>
              <tr>
                <th style="width:28%">Naam</th>
                <th>Omschrijving</th>
              </tr>
            </thead>
            <tbody>
              @foreach($allergenen as $a)
                <tr>
                  <td>{{ $a->Naam }}</td>
                  <td>{{ $a->Omschrijving }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @else
          <div class="p-3">
            <div class="alert alert-success mb-0">
              In dit product zitten geen stoffen die een allergische reactie kunnen veroorzaken.
            </div>
            <script>
              setTimeout(() => { window.location.href = "{{ route('magazijn.index') }}"; }, 4000);
            </script>
          </div>
        @endif
      </div>
    </div>

    <div class="mt-3">
      <a href="{{ route('magazijn.index') }}" class="btn btn-outline-secondary btn-back">
        ← Terug naar Magazijn
      </a>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
