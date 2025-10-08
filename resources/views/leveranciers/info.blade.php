@extends('layouts.app')

@section('content')
<div class="container py-4">
  <h1 class="h4 mb-4">Leveringsinformatie</h1>

  {{-- Kop met leveranciergegevens --}}
  <div class="card mb-4">
    <div class="card-body">
      <div class="row g-3">
        <div class="col-md-6"><strong>Naam leverancier:</strong> {{ $leverancier->Naam ?? '—' }}</div>
        <div class="col-md-6"><strong>Contactpersoon leverancier:</strong> {{ $leverancier->ContactPersoon ?? '—' }}</div>
        <div class="col-md-6"><strong>Leverancier nummer:</strong> {{ $leverancier->LeverancierNummer ?? '—' }}</div>
        <div class="col-md-6"><strong>Mobiel:</strong> {{ $leverancier->Mobiel ?? '—' }}</div>
      </div>
    </div>
  </div>

  {{-- Tabel / melding volgens scenario's --}}
  <div class="card">
    <div class="card-header">
      Product: {{ $product->Naam ?? $product->naam ?? '—' }}
    </div>

    <div class="card-body p-0">
      @if($leveringen->isEmpty())
        {{-- Scenario_02: geen voorraad → melding + redirect na 4s --}}
        @php
          $verwachteText = optional(\Illuminate\Support\Carbon::parse($verwachte))->format('d-m-Y') ?? '30-04-2023';
        @endphp
        <div class="p-3">
          Er is van dit product op dit moment geen voorraad aanwezig,
          de verwachte eerstvolgende levering is: <strong>{{ $verwachteText }}</strong>.
        </div>

        <script>
          setTimeout(() => { window.location.href = "{{ route('magazijn.index') }}"; }, 4000);
        </script>
      @else
        {{-- Scenario_01: tabel met leveringen, oplopend op Datum laatste levering --}}
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
                <td>{{ $product->Naam ?? $product->naam }}</td>
                <td>{{ optional(\Illuminate\Support\Carbon::parse($lev->DatumLaatste))->format('d-m-Y') }}</td>
                <td>{{ $lev->Aantal }}</td>
                <td>{{ optional(\Illuminate\Support\Carbon::parse($lev->VerwachteEerstvolgende))->format('d-m-Y') }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>
  </div>

  <a class="btn btn-link mt-3" href="{{ route('magazijn.index') }}">← Terug naar Magazijn</a>
</div>
@endsection
