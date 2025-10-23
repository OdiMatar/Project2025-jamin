@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>{{ $product->Naam }}</h3>
    <p>Barcode: <strong>{{ $product->Barcode }}</strong></p>

    <div class="alert alert-success">
        In dit product zitten geen stoffen die een allergische reactie kunnen veroorzaken.
    </div>

    <script>
        setTimeout(() => {
            window.location.href = "{{ route('magazijn.index') }}";
        }, 4000);
    </script>

    <small class="text-muted">Je wordt automatisch teruggestuurd...</small>
</div>
@endsection
