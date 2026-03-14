<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Leverancier;
use App\Models\Levering;
use App\Models\ProductPerLeverancier;
use Illuminate\Support\Facades\DB;

class LeverantieInfoController extends Controller
{
    public function show($productId)
    {
        // Product via jouw PK 'Id'
        $product = Product::where('Id', $productId)->firstOrFail();

        // Query parameters voor het tijdvak (optioneel)
        $start = request()->query('start');
        $end   = request()->query('end');

        // Alle leveringen van dit product uit ProductPerLeverancier (user story)
        $leveringenQuery = ProductPerLeverancier::with('leverancier')
            ->where('ProductId', $product->Id)
            ->orderBy('DatumLevering', 'asc');

        if ($start) {
            $leveringenQuery->where('DatumLevering', '>=', $start);
        }

        if ($end) {
            $leveringenQuery->where('DatumLevering', '<=', $end);
        }

        $leveringen = $leveringenQuery->get();

        // Bepaal leverancier vanuit de (eventueel gefilterde) leveringen
        $leverancier = $leveringen->first()?->leverancier;

        // Meest recente verwachte datum (voor Scenario_02)
        $verwachte = $leveringen
            ->filter(fn ($d) => !is_null($d->DatumEerstVolgendeLevering))
            ->sortByDesc('DatumEerstVolgendeLevering')
            ->first()?->DatumEerstVolgendeLevering;

        return view('leveranciers.info', [
            'product'     => $product,
            'leverancier' => $leverancier,   // kan null zijn
            'leveringen'  => $leveringen,    // reeds gesorteerd
            'verwachte'   => $verwachte,     // kan null zijn
        ]);
    }
}

