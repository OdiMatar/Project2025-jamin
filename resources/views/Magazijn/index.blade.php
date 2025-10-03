@extends('layouts.app')

@section('title', 'Magazijn')

@section('content')
    <h1 style="margin:0 0 12px">Magazijn</h1>

    {{-- Zoekformulier --}}
    <form method="get" class="mb-3">
        <input type="text" name="q" value="{{ $zoek }}" placeholder="Zoek (barcode, EAN, naam)..." />
        <button class="btn" type="submit">Zoeken</button>
    </form>

    <p class="mb-3" style="color:#666">
        Gesorteerd op: <strong>{{ $orderCol }}</strong>
    </p>

    <table>
        <thead>
        <tr>
            <th>Id</th>
            <th>ProductId</th>
            {{-- voeg hier kolommen toe die je echt in je DB hebt --}}
            @if(isset($items[0]) && isset($items[0]->Barcode)) <th>Barcode</th> @endif
            @if(isset($items[0]) && isset($items[0]->EAN))     <th>EAN</th>     @endif
            @if(isset($items[0]) && isset($items[0]->Naam))    <th>Naam</th>    @endif
            @if(isset($items[0]) && isset($items[0]->VerpakkingsEenheid)) <th>VerpakkingsEenheid</th> @endif
            @if(isset($items[0]) && isset($items[0]->AantalAanwezig))     <th>Aantal aanwezig</th>   @endif
        </tr>
        </thead>
        <tbody>
        @forelse ($items as $row)
            <tr>
                <td>{{ $row->Id }}</td>
                <td>{{ $row->ProductId }}</td>
                @isset($row->Barcode)             <td>{{ $row->Barcode }}</td> @endisset
                @isset($row->EAN)                 <td>{{ $row->EAN }}</td> @endisset
                @isset($row->Naam)                <td>{{ $row->Naam }}</td> @endisset
                @isset($row->VerpakkingsEenheid)  <td>{{ $row->VerpakkingsEenheid }}</td> @endisset
                @isset($row->AantalAanwezig)      <td>{{ $row->AantalAanwezig }}</td> @endisset
            </tr>
        @empty
            <tr>
                <td colspan="8" style="text-align:center;color:#777">Geen resultaten</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div class="mb-3" style="margin-top:12px">
        {{ $items->links() }}
    </div>
@endsection
