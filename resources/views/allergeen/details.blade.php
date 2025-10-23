@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Allergenen voor: {{ $product->Naam }}</h3>
    <p>Barcode: <strong>{{ $product->Barcode }}</strong></p>

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

    <a href="{{ route('magazijn.index') }}" class="btn btn-secondary">Terug</a>
</div>
@endsection
