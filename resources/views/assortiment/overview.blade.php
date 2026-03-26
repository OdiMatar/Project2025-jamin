@extends('layouts.app')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h1 class="mb-0">Overzicht producten uit het assortiment</h1>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary">Terug naar home</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form class="row g-3 align-items-end mb-4" method="get" action="{{ route('assortiment.overzicht') }}">
        <div class="col-auto">
            <label for="start" class="form-label">Startdatum</label>
            <input id="start" name="start" type="date" class="form-control" value="{{ old('start', $startDate ?? '') }}">
        </div>

        <div class="col-auto">
            <label for="end" class="form-label">Einddatum</label>
            <input id="end" name="end" type="date" class="form-control" value="{{ old('end', $endDate ?? '') }}">
        </div>

        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Maak selectie</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>Naam leverancier</th>
                    <th>Contactpersoon</th>
                    <th>Stad</th>
                    <th>Productnaam</th>
                    <th>Einddatum levering</th>
                    <th>Verwijder</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>{{ $product->LeverancierNaam ?? '-' }}</td>
                        <td>{{ $product->ContactPersoon ?? '-' }}</td>
                        <td>{{ $product->Stad ?? '-' }}</td>
                        <td>{{ $product->ProductNaam }}</td>
                        <td>{{ \Carbon\Carbon::parse($product->EinddatumLevering)->format('d-m-Y') }}</td>
                        <td>
                            <a href="{{ route('assortiment.product.show', array_merge(['product' => $product->ProductId], array_filter(['start' => $startDate, 'end' => $endDate]))) }}"
                                class="btn btn-outline-danger btn-sm" title="Verwijder product">
                                X
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Geen producten gevonden in dit tijdvak.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

