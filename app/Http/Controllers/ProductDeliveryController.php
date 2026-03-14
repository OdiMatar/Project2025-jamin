<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductPerLeverancier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductDeliveryController extends Controller
{
    /**
     * Overzicht geleverde producten.
     *
     * Userstory 1: overzicht van alle geleverde producten binnen een tijdvak.
     */
    public function index(Request $request)
    {
        $data = $request->validate([
            'start' => ['nullable', 'date'],
            'end'   => ['nullable', 'date'],
        ]);

        $start = $data['start'] ?? null;
        $end   = $data['end'] ?? null;

        // Voor de query gebruiken we een breed bereik als er geen filter is opgegeven.
        $queryStart = $start ?? '1900-01-01';
        $queryEnd   = $end   ?? now()->format('Y-m-d');

        $products = collect(DB::select('CALL sp_GeleverdeProductenInPeriode(?, ?)', [$queryStart, $queryEnd]));

        return view('deliveries.overview', [
            'products'  => $products,
            // Toon in de UI alleen wat de gebruiker selecteerde (of leeg) 
            'startDate' => $start,
            'endDate'   => $end,
        ]);
    }

    public function show(Request $request, Product $product)
    {
        $data = $request->validate([
            'start' => ['nullable', 'date'],
            'end'   => ['nullable', 'date'],
        ]);

        $start = $data['start'] ?? null;
        $end   = $data['end'] ?? null;

        // Alle leveringen voor dit product (ProductPerLeverancier), evt. gefilterd op tijdvak
        $deliveriesQuery = ProductPerLeverancier::with('leverancier')
            ->where('ProductId', $product->Id)
            ->orderBy('DatumLevering', 'asc');

        if ($start) {
            $deliveriesQuery->where('DatumLevering', '>=', $start);
        }

        if ($end) {
            $deliveriesQuery->where('DatumLevering', '<=', $end);
        }

        $deliveries = $deliveriesQuery->get();

        // Verwachte eerstvolgende levering binnen het tijdvak (indien beschikbaar)
        $nextExpected = $deliveries
            ->filter(fn ($d) => !is_null($d->DatumEerstVolgendeLevering))
            ->sortByDesc('DatumEerstVolgendeLevering')
            ->first()
            ?->DatumEerstVolgendeLevering;

        // Bepaal leverancier(s) (uniek) voor header
        $suppliers = $deliveries->pluck('leverancier')->unique('Id')->values();

        // Voor voorraadmelding gebruiken we het magazijn
        $product->load(['magazijn']);
        $noStock = is_null(optional($product->magazijn)->AantalAanwezig) || (int)optional($product->magazijn)->AantalAanwezig === 0;

        return view('deliveries.show', compact('product','deliveries','nextExpected','suppliers','noStock','start','end'));
    }
}

