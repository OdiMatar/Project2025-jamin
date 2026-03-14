@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Overzicht geleverde producten</h1>

        <div class="mb-4">
            <div class="row gx-2 gy-2">
                <div class="col-auto">
                    <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-sm">Home</a>
                </div>
                <div class="col-auto">
                    <a href="{{ route('allergeen.producten.overzicht') }}" class="btn btn-outline-primary btn-sm">Overzicht
                        Allergenen</a>
                </div>
                <div class="col-auto">
                    <a href="{{ route('leveringen.overzicht') }}" class="btn btn-primary btn-sm">Overzicht geleverde
                        producten</a>
                </div>
                <div class="col-auto">
                    <a href="{{ route('allergeen.index') }}" class="btn btn-outline-secondary btn-sm">Allergenen</a>
                </div>
                <div class="col-auto">
                    <a href="{{ route('magazijn.index') }}" class="btn btn-outline-secondary btn-sm">Magazijn</a>
                </div>
                <div class="col-auto">
                    <a href="{{ route('leverancier.index') }}" class="btn btn-outline-secondary btn-sm">Leveranciers</a>
                </div>
                <div class="col-auto">
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm">Dashboard</a>
                </div>
            </div>
        </div>

        <form class="row g-3 align-items-end mb-4" method="get" action="{{ route('leveringen.overzicht') }}">
            <div class="col-auto">
                <label for="start" class="form-label">Startdatum</label>
                <input id="start" name="start" type="date" class="form-control"
                    value="{{ old('start', $startDate ?? '') }}" />
            </div>

            <div class="col-auto">
                <label for="end" class="form-label">Einddatum</label>
                <input id="end" name="end" type="date" class="form-control"
                    value="{{ old('end', $endDate ?? '') }}" />
            </div>

            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Maak selectie</button>
            </div>
        </form>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Naam leverancier</th>
                    <th>Contactpersoon</th>
                    <th>Productnaam</th>
                    <th>Totaal geleverd</th>
                    <th>Specificatie</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $p)
                    <tr>
                        <td>{{ $p->LeverancierNaam }}</td>
                        <td>{{ $p->ContactPersoon }}</td>
                        <td>{{ $p->ProductNaam }}</td>
                        <td>{{ $p->TotaalGeleverd }}</td>
                        <td class="text-center">
                            <a href="{{ route('leverantie.info.show', array_filter(['product' => $p->ProductId, 'start' => $startDate, 'end' => $endDate])) }}"
                                title="Specificatie">
                                ?
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Er zijn geen leveringen geweest van producten in deze
                            periode.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
@endsection
