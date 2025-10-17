@extends('layouts.app')

{{-- Zorgt dat de blauwe balk "Leverancier" toont i.p.v. "Jamin" --}}
@section('brand', 'Leverancier')

@section('content')
<style>
  /* zachte, nette terugknop */
  .btn-back {
    display:inline-flex; align-items:center; gap:.5rem;
    padding:.5rem 1rem; border-radius:999px;
    border:1px solid #e5e7eb; background:#fff; color:#0f172a;
    transition:transform .15s, box-shadow .15s, border-color .15s, background-color .15s;
    text-decoration:none;
  }
  .btn-back:hover { transform:translateY(-1px); background:#f8fafc; border-color:#cbd5e1; box-shadow:0 6px 18px rgba(15,23,42,.06) }
  .btn-back:focus { outline: .25rem solid rgba(37,99,235,.25); outline-offset: 2px }
</style>

<div class="container py-4">

  <h1 class="h4 mb-4">Leveringsinformatie</h1>

  {{-- Kop met leveranciergegevens --}}
  <div class="card mb-4">
    <div class="card-body">
      <div class="row g-3">
        <div class="col-md-6">
          <strong>Naam leverancier:</strong> {{ $leverancier->Naam ?? '—' }}
        </div>
        <div class="col-md-6">
          <strong>Contactpersoon leverancier:</strong> {{ $leverancier->ContactPersoon ?? '—' }}
        </div>
        <div class="col-md-6">
          <strong>Leverancier nummer:</strong> {{ $leverancier->LeverancierNummer ?? '—' }}
        </div>
        <div class="col-md-6">
          <strong>Mobiel:</strong> {{ $leverancier->Mobiel ?? '—' }}
        </div>
      </div>
    </div>
  </div>
  {{-- Tabel met leveringen --}}
<div class="card">
  <div class="card-header">
    Product: {{ $product->Naam ?? $product->naam ?? '—' }}
  </div>

  <div class="card-body p-0">
    @if($leveringen->isEmpty())
      @php
        // Lijst leeg → toon eind 2025
        $fallbackEind2025 = \Illuminate\Support\Carbon::create(2025, 12, 31)->format('d-m-Y');
      @endphp
      <div class="p-3">
        Er is van dit product op dit moment geen voorraad aanwezig,
        de verwachte eerstvolgende levering is: <strong>{{ $fallbackEind2025 }}</strong>.
      </div>

      <script>
        setTimeout(() => { window.location.href = "{{ route('magazijn.index') }}"; }, 4000);
      </script>
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
          @php $hadZero = false; @endphp

          @foreach($leveringen as $lev)
            @php
              // Zorg dat we numeriek vergelijken, ook als '0' als string komt
              $aantal = (int)($lev->Aantal ?? 0);
            @endphp

            @if($aantal === 0)
              @php
                // Gebruik DB-datum indien aanwezig, anders eind 2025
                $verwachteDatum = $lev->VerwachteEerstvolgende
                    ? \Illuminate\Support\Carbon::parse($lev->VerwachteEerstvolgende)
                    : \Illuminate\Support\Carbon::create(2025, 12, 31);

                $verwachteText = $verwachteDatum->format('d-m-Y');
                $hadZero = true;
              @endphp
              <tr>
                <td colspan="4" class="text-center text-danger fw-semibold">
                  Er is van dit product op dit moment geen voorraad aanwezig,
                  de verwachte eerstvolgende levering is <strong>{{ $verwachteText }}</strong>.
                </td>
              </tr>
            @else
              <tr>
                <td>{{ $product->Naam ?? $product->naam }}</td>
                <td>{{ optional(\Illuminate\Support\Carbon::parse($lev->DatumLaatste))->format('d-m-Y') }}</td>
                <td>{{ $lev->Aantal }}</td>
                <td>
                  @php
                    $volgende = $lev->VerwachteEerstvolgende
                      ? \Illuminate\Support\Carbon::parse($lev->VerwachteEerstvolgende)->format('d-m-Y')
                      : \Illuminate\Support\Carbon::create(2025, 12, 31)->format('d-m-Y');
                  @endphp
                  {{ $volgende }}
                </td>
              </tr>
            @endif
          @endforeach
        </tbody>
      </table>

      {{-- Redirect slechts één keer als er (minstens één) Aantal==0 was --}}
      @if($hadZero)
        <script>
          if (!window.__didRedirectMagazijn) {
            window.__didRedirectMagazijn = true;
            setTimeout(() => {
              window.location.href = "{{ route('magazijn.index') }}";
            }, 4000);
          }
        </script>
      @endif
    @endif
  </div>
</div>


  {{-- Mooie terugknop onderaan --}}
  <div class="mt-3">
    <a href="{{ route('magazijn.index') }}" class="btn-back" aria-label="Terug naar Magazijn">
      <i class="bi bi-arrow-left"></i>
      Terug naar Magazijn
    </a>
  </div>
</div>
@endsection
