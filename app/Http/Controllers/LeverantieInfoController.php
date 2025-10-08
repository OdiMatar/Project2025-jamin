<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Leverancier;
use App\Models\Levering;
use Illuminate\Support\Facades\DB;

class LeverantieInfoController extends Controller
{
    public function show($productId)
    {
        // Product via jouw PK 'Id'
        $product = Product::where('Id', $productId)->firstOrFail();

        // Leverancier bepalen:
        // 1) rechtstreeks van Product (als die kolom ooit wordt toegevoegd),
        // 2) anders laatste Levering,
        // 3) anders laatste ProductPerLeverancier.
        $leverancierId =
            ($product->LeverancierId ?? null)
            ?? Levering::where('ProductId', $product->Id)
                ->orderByDesc('DatumLaatste')
                ->value('LeverancierId')
            ?? DB::table('ProductPerLeverancier')
                ->where('ProductId', $product->Id)
                ->orderByDesc('DatumLevering')
                ->value('LeverancierId');

        $leverancier = $leverancierId
            ? Leverancier::where('Id', $leverancierId)->first()
            : null;

        // Alle leveringen van dit product in oplopende volgorde (user story)
        $leveringen = Levering::where('ProductId', $product->Id)
            ->orderBy('DatumLaatste', 'asc')
            ->get();

        // Meest recente verwachte datum (voor Scenario_02)
        $verwachte = Levering::where('ProductId', $product->Id)
            ->orderByDesc('VerwachteEerstvolgende')
            ->value('VerwachteEerstvolgende');

        return view('leveranciers.info', [
            'product'     => $product,
            'leverancier' => $leverancier,   // kan null zijn
            'leveringen'  => $leveringen,    // reeds gesorteerd
            'verwachte'   => $verwachte,     // kan null zijn
        ]);
    }
}
