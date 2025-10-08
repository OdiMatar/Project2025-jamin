<?php

namespace App\Http\Controllers;

use App\Models\Product;

class LeverantieInfoController extends Controller
{
    public function show(Product $product)
    {
        // Leverancier + leveringen direct inladen; sorteren op datum_laatste (oplopend)
        $product->load([
            'leverancier',
            'leveringen' => fn ($q) => $q->orderBy('datum_laatste'),
        ]);

        return view('leveranciers.info', [
            'product'     => $product,
            'leverancier' => $product->leverancier,  // kan null zijn; view vangt dit af
            'leveringen'  => $product->leveringen,
        ]);
    }
}
