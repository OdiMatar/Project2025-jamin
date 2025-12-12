@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Levering product</h1>

    <p>
        <strong>Leverancier:</strong> {{ $leverancier->Naam }}<br>
        <strong>Product:</strong> {{ $product->Naam }}
    </p>
    {{-- ✅ happy scenario melding --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>

        {{-- 4 seconden daarna terug naar overzicht geleverde producten --}}
        <script>
            setTimeout(function () {
                window.location.href = "{{ route('leverancier.show', $leverancier->Id) }}";
            }, 4000);
        </script>
    @endif

    <form method="post"
          action="{{ route('leverancier.product.delivery.store', [$leverancier->Id, $product->Id]) }}">
        @csrf

        <div class="mb-3">
            <label for="aantal" class="form-label">Aantal producteenheden</label>
            <input type="number" min="1" class="form-control" id="aantal" name="aantal"
                   value="{{ old('aantal') }}" required>
        </div>

        <div class="mb-3">
            <label for="datum_volgende" class="form-label">Datum eerstvolgende levering</label>
            <input type="date" class="form-control" id="datum_volgende" name="datum_volgende"
                   value="{{ old('datum_volgende') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Sla op</button>
        <a href="{{ route('leverancier.show', $leverancier->Id) }}" class="btn btn-secondary">Terug</a>
        <a href="{{ url('/') }}" class="btn btn-outline-secondary">Home</a>
    </form>
</div>
@endsection
