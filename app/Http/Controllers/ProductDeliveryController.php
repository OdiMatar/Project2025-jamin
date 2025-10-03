<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductDeliveryController extends Controller
{
    public function show(Product $product)
    {
        $product->load(['warehouse', 'deliveries.leverancier']);

        // Alle leveringen van dit product, oplopend op DatumLevering
        $deliveries = $product->deliveries()
            ->with('leverancier')
            ->orderBy('DatumLevering', 'asc')
            ->get();

        // Verwachte eerstvolgende levering: neem de meest recente (grootste) 'DatumEerstVolgendeLevering' die niet null is
        $nextExpected = $deliveries
            ->filter(fn ($d) => !is_null($d->DatumEerstVolgendeLevering))
            ->sortByDesc('DatumEerstVolgendeLevering')
            ->first()
            ?->DatumEerstVolgendeLevering;

        // Bepaal leveranciers (uniek) voor header
        $suppliers = $deliveries->pluck('leverancier')->unique('Id')->values();

        // Scenario_02: geen voorraad (NULL of 0) => melding + 4 sec redirect
        $noStock = is_null(optional($product->warehouse)->AantalAanwezig) || (int)optional($product->warehouse)->AantalAanwezig === 0;

        return view('deliveries.show', compact('product','deliveries','nextExpected','suppliers','noStock'));
    }
}
