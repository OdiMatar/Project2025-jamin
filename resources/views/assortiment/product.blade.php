@extends('layouts.app')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h1 class="mb-0">Product</h1>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary">Terug naar home</a>
    </div>

    @if (!empty($statusMessage))
        <div class="alert alert-{{ ($statusType ?? 'warning') === 'success' ? 'success' : 'warning' }}">
            {{ $statusMessage }}
        </div>
    @elseif (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-warning">{{ session('error') }}</div>
    @endif

    <div class="table-responsive mb-3">
        <table class="table table-bordered align-middle">
            <tbody>
                <tr>
                    <th style="width: 260px;">Naam product</th>
                    <td>{{ $product->ProductNaam }}</td>
                </tr>
                <tr>
                    <th>Barcode</th>
                    <td>{{ $product->Barcode }}</td>
                </tr>
                <tr>
                    <th>Bevat gluten</th>
                    <td>{{ $product->BevatGluten }}</td>
                </tr>
                <tr>
                    <th>Bevat gelatine</th>
                    <td>{{ $product->BevatGelatine }}</td>
                </tr>
                <tr>
                    <th>Bevat AZO-kleurstof</th>
                    <td>{{ $product->BevatAzoKleurstof }}</td>
                </tr>
                <tr>
                    <th>Bevat lactose</th>
                    <td>{{ $product->BevatLactose }}</td>
                </tr>
                <tr>
                    <th>Bevat soja</th>
                    <td>{{ $product->BevatSoja }}</td>
                </tr>
                <tr>
                    <th>Einddatum levering</th>
                    <td>{{ \Carbon\Carbon::parse($product->EinddatumLevering)->format('d-m-Y') }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="d-flex flex-wrap gap-2">
        @if (!($isDeleted ?? false))
            <form method="post" action="{{ route('assortiment.product.destroy', ['product' => $product->ProductId]) }}">
                @csrf
                <input type="hidden" name="start" value="{{ $startDate }}">
                <input type="hidden" name="end" value="{{ $endDate }}">
                <button type="submit" class="btn btn-danger">Verwijder</button>
            </form>
        @endif

        <a href="{{ route('assortiment.overzicht', array_filter(['start' => $startDate, 'end' => $endDate])) }}"
            class="btn btn-outline-primary">
            Terug naar overzicht
        </a>
    </div>
@endsection
