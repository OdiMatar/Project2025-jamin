@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Geleverde producten</h1>

    <p>
        <strong>Naam leverancier:</strong> {{ $leverancier->Naam }}<br>
        <strong>Contactpersoon:</strong> {{ $leverancier->ContactPersoon }}<br>
        <strong>Leverancier nr:</strong> {{ $leverancier->LeverancierNummer }}<br>
        <strong>Mobiel:</strong> {{ $leverancier->Mobiel }}
    </p>

    <div class="alert alert-info mt-4">
        Dit bedrijf heeft tot nu toe geen producten geleverd aan Jamin.
    </div>

    {{-- Na 3 seconden terug naar overzicht leveranciers --}}
    <script>
        setTimeout(function () {
            window.location.href = "{{ route('leverancier.index') }}";
        }, 3000);
    </script>
</div>
@endsection
