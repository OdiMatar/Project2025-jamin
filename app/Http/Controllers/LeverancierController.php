<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeverancierController extends Controller
{
    /* ============================================================
       Userstory 1 – overzicht leveranciers
       ============================================================ */
    public function index()
    {
        $leveranciers = DB::select('CALL sp_LeveranciersOverzicht()');

        return view('leveranciers.index', [
            'leveranciers' => $leveranciers,
        ]);
    }

    /* ============================================================
       Userstory 1 – geleverde producten van één leverancier
       ============================================================ */
    public function show($leverancierId)
    {
        $leverancier = DB::table('Leverancier')->where('Id', $leverancierId)->first();

        if (!$leverancier) {
            abort(404);
        }

        $producten = DB::select('CALL sp_GeleverdeProducten(?)', [$leverancierId]);

        if (count($producten) === 0) {
            // unhappy scenario – Wireframe 3
            return view('leveranciers.no-products', [
                'leverancier' => $leverancier,
            ]);
        }

        return view('leveranciers.products', [
            'leverancier' => $leverancier,
            'producten'   => $producten,
        ]);
    }

    /* ============================================================
       Userstory 2 – formulier nieuwe levering (Wireframe 4)
       ============================================================ */
    public function createDelivery($leverancierId, $productId)
    {
        $leverancier = DB::table('Leverancier')->where('Id', $leverancierId)->first();
        $product     = DB::table('Product')->where('Id', $productId)->first();

        if (!$leverancier || !$product) {
            abort(404);
        }

        return view('leveranciers.delivery-create', [
            'leverancier' => $leverancier,
            'product'     => $product,
        ]);
    }

    /* ============================================================
       Userstory 2 – opslag nieuwe levering
       ============================================================ */
    public function storeDelivery(Request $request, $leverancierId, $productId)
    {
        $leverancier = DB::table('Leverancier')->where('Id', $leverancierId)->first();
        $product     = DB::table('Product')->where('Id', $productId)->first();

        if (!$leverancier || !$product) {
            abort(404);
        }

        $data = $request->validate([
            'aantal'         => ['required', 'integer', 'min:1'],
            'datum_volgende' => ['required', 'date'],
        ]);

        DB::statement('SET @p_foutcode = NULL');
        DB::statement(
            'CALL sp_NieuweLevering(?, ?, ?, ?, @p_foutcode)',
            [
                $leverancierId,
                $productId,
                $data['aantal'],
                $data['datum_volgende'],
            ]
        );

        $result   = DB::select('SELECT @p_foutcode AS foutcode');
        $foutcode = $result[0]->foutcode ?? null;

        if ($foutcode === 'PRODUCT_INACTIEF') {
            // UNHAPPY: melding op Levering product (Wireframe-04)
            return redirect()
                ->back()
                ->with('error', "Het product {$product->Naam} van de leverancier {$leverancier->Naam} wordt niet meer geproduceerd");
        }

        // HAPPY: terug naar Geleverde producten (Wireframe-02) met succes-melding
        return redirect()
            ->route('leverancier.show', $leverancierId)
            ->with('success', 'Nieuwe levering is opgeslagen.');
    }
}