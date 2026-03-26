<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductOutOfAssortmentController extends Controller
{
    /**
     * Overzicht producten die uit het assortiment gaan.
     */
    public function index(Request $request)
    {
        $startInput = $request->input('start');
        $endInput = $request->input('end');
        $start = $this->normalizeDateInput($startInput);
        $end = $this->normalizeDateInput($endInput);

        if (($startInput && !$start) || ($endInput && !$end)) {
            return redirect()
                ->route('assortiment.overzicht')
                ->withInput()
                ->with('error', 'Vul een geldige datum in (dd-mm-jjjj of jjjj-mm-dd).');
        }

        if ($start && $end && $start > $end) {
            return redirect()
                ->route('assortiment.overzicht')
                ->withInput()
                ->with('error', 'De einddatum moet op of na de startdatum liggen.');
        }

        $queryStart = $start ?? '1900-01-01';
        $queryEnd = $end ?? '9999-12-31';

        $products = collect(DB::select(
            'CALL sp_ProductenUitAssortimentInPeriode(?, ?)',
            [$queryStart, $queryEnd]
        ));

        return view('assortiment.overview', [
            'products' => $products,
            'startDate' => $start,
            'endDate' => $end,
        ]);
    }

    /**
     * Productdetailpagina voor verwijderen.
     */
    public function show(Request $request, int $product)
    {
        $start = $this->normalizeDateInput($request->input('start'));
        $end = $this->normalizeDateInput($request->input('end'));

        $productData = DB::selectOne('CALL sp_ProductUitAssortimentDetails(?)', [$product]);

        abort_if(!$productData, 404, 'Product niet gevonden.');

        return view('assortiment.product', [
            'product' => $productData,
            'startDate' => $start,
            'endDate' => $end,
        ]);
    }

    /**
     * Verwijder product uit assortiment (met datumcontrole in SP).
     */
    public function destroy(Request $request, int $product)
    {
        $start = $this->normalizeDateInput($request->input('start'));
        $end = $this->normalizeDateInput($request->input('end'));

        $productSnapshot = DB::selectOne('CALL sp_ProductUitAssortimentDetails(?)', [$product]);

        if (!$productSnapshot) {
            return redirect()
                ->route('assortiment.overzicht', array_filter([
                    'start' => $start,
                    'end' => $end,
                ]))
                ->with('error', 'Product niet gevonden');
        }

        DB::statement('CALL sp_VerwijderProductUitAssortiment(?, @p_success, @p_message)', [$product]);
        $result = DB::selectOne('SELECT @p_success AS success, @p_message AS message');

        if ((int)($result->success ?? 0) === 1) {
            return view('assortiment.product', [
                'product' => $productSnapshot,
                'startDate' => $start,
                'endDate' => $end,
                'isDeleted' => true,
                'statusType' => 'success',
                'statusMessage' => $result->message ?? 'Product is succesvol verwijdert',
            ]);
        }

        return view('assortiment.product', [
            'product' => $productSnapshot,
            'startDate' => $start,
            'endDate' => $end,
            'isDeleted' => false,
            'statusType' => 'warning',
            'statusMessage' => $result->message ?? 'Product kan niet worden verwijdert',
        ]);
    }

    private function normalizeDateInput(?string $value): ?string
    {
        if ($value === null || trim($value) === '') {
            return null;
        }

        $raw = trim($value);

        foreach (['Y-m-d', 'd-m-Y', 'd/m/Y'] as $format) {
            try {
                $date = Carbon::createFromFormat($format, $raw);
                if ($date && $date->format($format) === $raw) {
                    return $date->format('Y-m-d');
                }
            } catch (\Throwable) {
                // Probeer volgend formaat.
            }
        }

        try {
            return Carbon::parse($raw)->format('Y-m-d');
        } catch (\Throwable) {
            return null;
        }
    }
}
