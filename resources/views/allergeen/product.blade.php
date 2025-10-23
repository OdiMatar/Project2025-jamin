<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <title>{{ $title ?? 'Overzicht Allergenen' }}</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
  <div class="container">
    <h3 class="mb-1">Overzicht Allergenen</h3>
    <div class="text-muted mb-3">
      <strong>Naam product:</strong> {{ $product->Naam }} &middot;
      <strong>Barcode:</strong> {{ $product->Barcode }}
    </div>

    @if($allergenen->isNotEmpty())
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Naam</th>
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
      <div class="alert alert-success">
        In dit product zitten geen stoffen die een allergische reactie kunnen veroorzaken.
      </div>
      <script>
        setTimeout(() => { window.location.href = "{{ route('magazijn.index') }}"; }, 4000);
      </script>
      <small class="text-muted">Je wordt automatisch teruggestuurd…</small>
    @endif

    <a class="btn btn-outline-secondary mt-3" href="{{ route('magazijn.index') }}">
      Terug naar Overzicht Magazijn
    </a>
  </div>
</body>
</html>
