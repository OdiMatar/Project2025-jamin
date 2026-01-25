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
        // (jouw bestaande SP)
        $leveranciers = DB::select('CALL sp_LeveranciersOverzicht()');

        return view('leveranciers.index', [
            'leveranciers' => $leveranciers,
        ]);
    }

    /* ============================================================
       Userstory 1 – Leverancier details (Wireframe-03)
       LET OP: jouw show() gebruikte nu "geleverde producten".
       Ik voeg een NIEUWE method toe voor details om verwarring te voorkomen.
       ============================================================ */
    public function details($leverancierId)
    {
        $leverancier = DB::selectOne('CALL sp_LeverancierDetails(?)', [(int)$leverancierId]);

        if (!$leverancier) {
            abort(404);
        }

        return view('leveranciers.details', [
            'leverancier' => $leverancier,
        ]);
    }

    /* ============================================================
       Userstory 1 – Wijzig leverancier (Wireframe-04)
       ============================================================ */
    public function edit($leverancierId)
    {
        $leverancier = DB::selectOne('CALL sp_LeverancierDetails(?)', [(int)$leverancierId]);

        if (!$leverancier) {
            abort(404);
        }

        return view('leveranciers.edit', [
            'leverancier' => $leverancier,
        ]);
    }

    /* ============================================================
       Userstory 1 – Opslaan wijzig leverancier (Happy/Unhappy)
       ============================================================ */
    public function update(Request $request, $leverancierId)
    {
        $data = $request->validate([
            'mobiel'     => ['required', 'string', 'max:15'],
            'straatnaam' => ['nullable', 'string', 'max:50'],
            'huisnummer' => ['nullable', 'string', 'max:10'],
            'postcode'   => ['nullable', 'string', 'max:10'],
            'stad'       => ['nullable', 'string', 'max:50'],
        ]);

        // call SP met OUT params
        DB::statement(
            'CALL sp_LeverancierWijzig(?, ?, ?, ?, ?, ?, @p_success, @p_message)',
            [
                (int)$leverancierId,
                $data['mobiel'],
                $data['straatnaam'] ?? null,
                $data['huisnummer'] ?? null,
                $data['postcode'] ?? null,
                $data['stad'] ?? null,
            ]
        );

        $out = DB::selectOne('SELECT @p_success AS success, @p_message AS message');

        // Zowel happy als unhappy: volgens jouw scenario’s na 3 sec terug naar details
        // (de blade laat de melding zien en doet setTimeout redirect)
        if ((int)($out->success ?? 0) === 1) {
            return redirect()
                ->route('leverancier.details', $leverancierId)
                ->with('success', $out->message);
        }

        return redirect()
            ->route('leverancier.details', $leverancierId)
            ->with('error', $out->message ?? 'Door een technische storing is het niet mogelijk de wijziging door te voeren. Probeer het op een later moment nog eens');
    }

    /* ============================================================
       JOUW BESTAANDE CODE – geleverde producten van één leverancier
       (laat ik intact, maar ik hernoem de route naam in routes straks)
       ============================================================ */
    public function show($leverancierId)
    {
        $leverancier = DB::table('Leverancier')->where('Id', $leverancierId)->first();

        if (!$leverancier) {
            abort(404);
        }

        $producten = DB::select('CALL sp_GeleverdeProducten(?)', [$leverancierId]);

        if (count($producten) === 0) {
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
            return redirect()
                ->back()
                ->with('error', "Het product {$product->Naam} van de leverancier {$leverancier->Naam} wordt niet meer geproduceerd");
        }

        return redirect()
            ->route('leverancier.show', $leverancierId)
            ->with('success', 'Nieuwe levering is opgeslagen.');
    }
}
