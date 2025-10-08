<?php

namespace App\Http\Controllers;

use App\Models\Magazijn;
use Illuminate\Http\Request;

class MagazijnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $magazijn = \App\Models\Magazijn::query()
        ->with([
            'product:Id,Naam,Barcode', // <-- allergenen tijdelijk weg
        ])
        ->select('Id','ProductId','VerpakkingsEenheid','AantalAanwezig')
        ->paginate(25)
        ->withQueryString();

    return view('Magazijn.index', [
        'title' => 'Magazijn',
        'magazijn' => $magazijn,
    ]);
}
}