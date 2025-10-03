<?php

namespace App\Http\Controllers;

use App\Models\Magazijn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class WarehouseController extends Controller
{
    public function index(Request $request)
    {
        $zoek = $request->string('q')->toString();

        // Bepaal een veilige sorteer-kolom
        $table = (new Magazijn)->getTable();
        $orderCol = Schema::hasColumn($table, 'Barcode') ? 'Barcode'
                 : (Schema::hasColumn($table, 'barcode') ? 'barcode'
                 : (Schema::hasColumn($table, 'EAN') ? 'EAN'
                 : (Schema::hasColumn($table, 'ean') ? 'ean' : (new Magazijn)->getKeyName())));

        $query = Magazijn::query();

        // Alleen zoeken op kolommen die echt bestaan
        if ($zoek !== '') {
            $query->where(function ($q) use ($zoek, $table) {
                if (Schema::hasColumn($table, 'Barcode')) {
                    $q->orWhere('Barcode', 'like', "%{$zoek}%");
                }
                if (Schema::hasColumn($table, 'barcode')) {
                    $q->orWhere('barcode', 'like', "%{$zoek}%");
                }
                if (Schema::hasColumn($table, 'EAN')) {
                    $q->orWhere('EAN', 'like', "%{$zoek}%");
                }
                if (Schema::hasColumn($table, 'Naam')) {
                    $q->orWhere('Naam', 'like', "%{$zoek}%");
                }
                if (Schema::hasColumn($table, 'naam')) {
                    $q->orWhere('naam', 'like', "%{$zoek}%");
                }
            });
        }

        $items = $query->orderBy($orderCol)->paginate(15)->withQueryString();

        return view('magazijn.index', [
            'items' => $items,
            'zoek'  => $zoek,
            'orderCol' => $orderCol,
        ]);
    }
}
