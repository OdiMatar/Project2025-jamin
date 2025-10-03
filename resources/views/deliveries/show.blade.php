@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Levering Informatie – {{ $product->Naam }}</h1>

    {{-- Boven de tabel: leverancier(s) --}}
    @if($suppliers->count() === 1)
        @php $s = $suppliers->first(); @endphp
        <div class="mb-3">
            <strong>Naam leverancier:</strong> {{ $s->Naam }}<br>
            <strong>Contactpersoon leverancier:</strong> {{ $s->ContactPersoon }}<br>
            <strong>Leveranciernummer:</strong> {{ $s->LeverancierNummer }}<br>
            <strong>Mobiel:</strong> {{ $s->Mobiel }}
        </div>
    @elseif($suppliers->count() > 1)
        <div class="mb-3">
            <strong>Leveranciers:</strong>
            <ul class="mb-0">
                @foreach($suppliers as $s)
                    <li>
                        {{ $s->Naam }} — {{ $s->ContactPersoon }} — {{ $s->LeverancierNummer }} — {{ $s->Mobiel }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Scenario_02: geen voorraad --}}
    @if($noStock)
        <div class="alert alert-warning">
            Er is van dit product op dit moment geen voorraad aanwezig,
            de verwachte eerstvolgende levering is:
            <strong>{{ $nextExpected ? \Carbon\Carbon::parse($nextExpected)->format('d-m-Y') : 'onbekend' }}</strong>.
        </div>

        <script>
            setTimeout(function(){
                window.location.href = "{{ route('warehouse.index') }}";
            }, 4000); // 4 seconden
        </script>
    @endif

    {{-- Tabel leveringen --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Datum laatste levering ↑</th>
                <th>Leverancier</th>
                <th>Aantal</th>
                <th>Verwachte eerstvolgende levering</th>
            </tr>
        </thead>
        <tbody>
        @forelse($deliveries as $d)
            <tr>
                <td>{{ \Carbon\Carbon::parse($d->DatumLevering)->format('d-m-Y') }}</td>
                <td>{{ optional($d->leverancier)->Naam ?? '-' }}</td>
                <td>{{ $d->Aantal }}</td>
                <td>
                    {{ $d->DatumEerstVolgendeLevering
                        ? \Carbon\Carbon::parse($d->DatumEerstVolgendeLevering)->format('d-m-Y')
                        : '-' }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4">Geen leveringen gevonden voor dit product.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <a href="{{ route('warehouse.index') }}" class="btn btn-secondary">← Terug naar overzicht</a>
</div>
@endsection
