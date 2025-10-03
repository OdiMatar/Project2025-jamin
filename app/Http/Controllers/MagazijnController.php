<?php

namespace App\Http\Controllers;

use App\Models\Magazijn;
use Illuminate\Http\Request;

class MagazijnController extends Controller
{
 public function index()
{
    $items = \App\Models\Magazijn::query()
        ->with([
            'product:id,Naam,Barcode',          // basis product velden
            'product.allergenen:id,Naam'        // << relatie die we gaan tonen
        ])
        ->select('id','ProductId','VerpakkingsEenheid','AantalAanwezig')
        ->paginate(25);

    return view('Magazijn.index', [
        'items' => $items,
        'title' => 'Magazijn',
    ]);
}
}
