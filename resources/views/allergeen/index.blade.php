<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Allergenen</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body { background: linear-gradient(135deg, #f8fafc 0%, #e2eafc 100%); min-height: 100vh; }
        .main-card { border-radius: 1rem; border: none; }
        .header-bar { background: #0d6efd; color: #fff; border-radius: 1rem 1rem 0 0; padding: 2rem 1.5rem 1rem; margin-bottom: 2rem; box-shadow: 0 2px 8px rgba(13,110,253,0.08); }
        .btn-primary { border-radius: 2rem; }
        .table thead th { background: #e9ecef; }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8">
            <div class="card main-card shadow-lg">
                <div class="header-bar">
                    <h1 class="mb-0" style="font-weight: 700;">{{ $title }}</h1>
                    <p class="mb-0" style="font-size: 1.1rem;">Overzicht van alle allergenen</p>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                            <div id="successToast" class="toast align-items-center text-bg-success border-0 show"
                                 role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="d-flex">
                                    <div class="toast-body">
                                        {{ session('success') }}
                                    </div>
                                    <button type="button" class="btn-close btn-close-white me-2 m-auto"
                                            data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="d-flex justify-content-end mb-3">
                        <a href="{{ route('allergeen.create') }}" class="btn btn-primary px-4">
                            <i class="bi bi-plus-circle"></i> Nieuwe Allergeen
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Naam</th>
                                    <th>Omschrijving</th>
                                    <th>Acties</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($allergenen as $allergeen)
                                    <tr>
                                        <td>{{ $allergeen->Naam }}</td>
                                        <td>{{ $allergeen->Omschrijving }}</td>
                                        <td class="text-center">
                                            {{-- Verwijderen --}}
                                            <form action="{{ route('allergeen.destroy', $allergeen->Id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Weet je zeker dat je dit allergeen wilt verwijderen?')">
                                                    <i class="bi bi-trash"></i> Verwijderen
                                                </button>
                                            </form>

                                            {{-- Bewerken (GEEN form nodig, gewoon een link) --}}
                                            <a href="{{ route('allergeen.edit', $allergeen->Id) }}" class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil-square"></i> Bewerken
                                            </a>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Geen allergenen gevonden.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div> <!-- card-body -->
            </div>
        </div>
    </div>
</div>

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
