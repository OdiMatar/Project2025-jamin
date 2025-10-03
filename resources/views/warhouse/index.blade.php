{{-- resources/views/warehouse/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h1 class="mb-0">Overzicht Magazijn Jamin</h1>

        {{-- (optioneel) link naar home / allergenen als je die in de topbar wilt --}}
        <div class="btn-group" role="group" aria-label="Snelle links">
            <a href="{{ route('home') }}" class="btn btn-outline-secondary">Home</a>
            <a href="{{ route('allergeen.index') }}" class="btn btn-outline-secondary">Allergenen</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th scope="col">
                        Barcode
                        <span class="text-muted" title="Oplopend gesorteerd in controller">↑</span>
                    </th>
                    <th scope="col">Product</th>
                    <th scope="col">Verpakkings­eenheid</th>
                    <th scope="col">Aantal aanwezig</th>
                    <th scope="col" class="text-center">Leverantie Info</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $p)
                    @php
                        $wh = $p->warehouse; // kan null zijn
                    @endphp
                    <tr>
                        <td class="font-monospace">{{ $p->Barcode }}</td>
                        <td>{{ $p->Naam }}</td>
                        <td>
                            {{ $wh && !is_null($wh->VerpakkingsEenheid)
                                ? number_format((float)$wh->VerpakkingsEenheid, 2, ',', '.')
                                : '-' }}
                        </td>
                        <td>
                            {{ $wh && !is_null($wh->AantalAanwezig)
                                ? number_format((int)$wh->AantalAanwezig, 0, ',', '.')
                                : '-' }}
                        </td>
                        <td class="text-center">
                            <a
                                href="{{ route('warehouse.product.delivery', $p->Id) }}"
                                class="btn btn-sm btn-outline-primary"
                                aria-label="Leverantie-informatie voor {{ $p->Naam }}"
                                title="Leverantie-informatie"
                            >
                                ❓
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-muted text-center">
                            Er zijn geen producten gevonden.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- (optioneel) plek voor pagination, als je die later toevoegt in de controller --}}
    {{-- <div class="mt-3">{{ $products->links() }}</div> --}}
</div>
@endsection
