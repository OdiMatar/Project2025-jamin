<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jamin</title>
    <!-- Bootstrap CSS toegevoegd -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>{{ $title }}</h1>
        <!-- Foutmeldingen toegevoegd -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('allergeen.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="Inputname" class="form-label">Naam</label>
                <input name="name" type= "text" class="form-control" id="Inputname" aria-describedby="namehelp">
                <div id="namehelp" class="form-text">Voer de naam van het allergeen in.</div>
            </div>
            <div class="mb-3">
                <label for="InputDescription" class="form-label">Omschrijving</label>
                <input name="description" type="text" class= "form-control" id="InputDescription" aria-describedby="descriptionhelp">
                <div id="descriptionhelp" class="form-text">Voer een korte omschrijving van het allergeen in.</div>
            </div>
            <button type="submit" class="btn btn-primary">Verzend</button>
        </form>
    </div>
    <!-- Bootstrap JS toegevoegd (optioneel) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>