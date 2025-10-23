<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductAllergeenController extends Controller
{
    public function show(Product $product)
    {
        // Allergenen gesorteerd op Naam
        $allergenen = $product->allergenen()->orderBy('Naam', 'asc')->get();

        return view('Allergenen.product', [
            'title'      => 'Overzicht Allergenen',
            'product'    => $product,
            'allergenen' => $allergenen,
        ]);
    }
}
