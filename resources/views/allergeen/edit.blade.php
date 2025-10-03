<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Bewerk Allergeen</title>
</head>
<body class="bg-light">

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-6">

            <div class="card shadow-lg rounded-4">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">{{ $title ?? 'Bewerk Allergeen' }}</h4>
                </div>

                <div class="card-body p-4">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('allergeen.update', $allergeen->Id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="naam" class="form-label">Naam</label>
                            <input type="text" id="naam" name="Naam" 
                                class="form-control @error('Naam') is-invalid @enderror"
                                value="{{ old('Naam', $allergeen->Naam) }}" required>
                            @error('Naam')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="omschrijving" class="form-label">Omschrijving</label>
                            <textarea id="omschrijving" name="Omschrijving" rows="3"
                                class="form-control @error('Omschrijving') is-invalid @enderror"
                                required>{{ old('Omschrijving', $allergeen->Omschrijving) }}</textarea>
                            @error('Omschrijving')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('allergeen.index') }}" class="btn btn-outline-secondary">
                                Annuleren
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Opslaan
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
