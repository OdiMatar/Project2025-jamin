{{-- resources/views/Magazijn/index.blade.php --}}

<table class="table table-hover align-middle">
    <thead>
        <tr>
            <th>Barcode</th>
            <th>Naam</th>
            <th>Verpakkingseenheid</th>
            <th>Aantal aanwezig</th>
            <th class="text-center">Allergenen Info</th>
            <th class="text-center">Leverantie Info</th>
        </tr>
    </thead>
    <tbody>
    @foreach($items as $row)
        @php
            $p = $row->product;
            $hasAllergen = $p && $p->allergenen && $p->allergenen->isNotEmpty();
        @endphp
        <tr>
            <td>{{ $p->Barcode ?? '—' }}</td>
            <td>{{ $p->Naam ?? '—' }}</td>
            <td>{{ number_format($row->VerpakkingsEenheid, 2) }}</td>
            <td>{{ $row->AantalAanwezig }}</td>

            {{-- Allergenen: ✓ / ✗ + optionele modal --}}
            <td class="text-center">
                @if($hasAllergen)
                    <button class="btn btn-outline-success btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#al-{{ $row->id }}">
                        ✓ Bekijk
                    </button>

                    <div class="modal fade" id="al-{{ $row->id }}" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Allergenen — {{ $p->Naam }}</h5>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                          </div>
                          <div class="modal-body">
                            <ul class="mb-0">
                              @foreach($p->allergenen as $al)
                                  <li>{{ $al->Naam }}</li>
                              @endforeach
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                @else
                    <span class="badge text-bg-danger">✗</span>
                @endif
            </td>

            {{-- Leverantie Info: vul in zoals jouw leverancierrelation heet --}}
            <td class="text-center">
                {{-- voorbeeld/placeholder --}}
                <span class="text-muted">?</span>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{ $items->links() }}

