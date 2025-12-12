@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Geleverde producten</h1>

    {{-- ✅ happy scenario melding --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <p>
        <strong>Naam leverancier:</strong> {{ $leverancier->Naam }}<br>
        <strong>Contactpersoon:</strong> {{ $leverancier->ContactPersoon }}<br>
        <strong>Leverancier nr:</strong> {{ $leverancier->LeverancierNummer }}<br>
        <strong>Mobiel:</strong> {{ $leverancier->Mobiel }}
    </p>

    <table class="table table-striped mt-3">
        <thead>
        <tr>
       <th>Naam product</th>
        <th>Aantal in magazijn</th>
        <th>Verpakkings­eenheid</th>
        <th>Laatste levering</th>
        <th>Verwachte eerstvolgende levering</th> {{-- nieuw --}}
        <th>Nieuwe levering</th>
        </tr>
        </thead>
        <tbody>
        @foreach($producten as $p)
                <td>{{ $p->ProductNaam }}</td>
                <td>{{ $p->AantalAanwezig ?? 0 }}</td>
                <td>{{ $p->VerpakkingsEenheid }}</td>
                <td>{{ $p->LaatsteLevering }}</td>
                <td>{{ $p->VerwachteEerstvolgende }}</td> {{-- nieuw --}}
                <td class="text-center">
                    <a href="{{ route('leverancier.product.delivery.create', [$leverancier->Id, $p->ProductId]) }}"
                    class="btn btn-sm btn-success">
                        +
                    </a>
                </td>
            </tr>

        @endforeach
        </tbody>
    </table>

    <a href="{{ route('leverancier.index') }}" class="btn btn-secondary">Terug</a>
    <a href="{{ url('/') }}" class="btn btn-outline-secondary">Home</a>
</div>
@endsection
