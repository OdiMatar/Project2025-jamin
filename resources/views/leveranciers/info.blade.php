@extends('layouts.app')

@section('content')
<div class="container py-4">
  <h1 class="h4 mb-3">Leveringsinformatie</h1>

  {{-- Leverancier header --}}
  <div class="card mb-4">
    <div class="card-body row g-3">
      <div class="col-md-6"><b>Naam leverancier:</b> {{ $leverancier->Naam ?? '—' }}</div>
      <div class="col-md-6"><b>Contactpersoon:</b> {{ $leverancier->ContactPersoon ?? '—' }}</div>
      <div class="col-md-6"><b>Leverancier nummer:</b> {{ $leverancier->LeverancierNummer ?? '—' }}</div>
      <div class="col-md-6"><b>Mobiel:</b> {{ $leverancier->Mobiel ?? '—' }}</div>
    </div>
  </div>

  {{-- Tabel met leveringen --}}
  <div class="card">
    <div class="card-header">
      Product: {{ $product->naam ?? $product->Naam ?? '—' }}
    </div>
    <div class="card-body p-0">
      @if($leveringen->isEmpty())
        <div class="p-3 text-muted">
          Er is van dit product op dit moment geen voorraad aanwezig,
          de verwachte eerstvolgende levering is: —.
        </div>
      @else
        <table class="table mb-0">
          <thead>
            <tr>
              <th>Naam product</th>
              <th>Datum laatste levering</th>
              <th>Aantal</th>
              <th>Eerstvolgende levering</th>
            </tr>
          </thead>
          <tbody>
            @foreach($leveringen as $lev)
              <tr>
                <td>{{ $product->naam ?? $product->Naam }}</td>
                <td>{{ optional($lev->datum_laatste)->format('d-m-Y') }}</td>
                <td>{{ $lev->aantal }}</td>
                <td>{{ optional($lev->verwachte_eerstvolgende)->format('d-m-Y') }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>
  </div>

  <a href="{{ route('magazijn.index') }}" class="btn btn-link mt-3">← Terug naar Magazijn</a>
</div>
@endsection
