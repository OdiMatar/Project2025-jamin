<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AllergeenModel;

class AllergeenController extends Controller
{
    public function __construct(private AllergeenModel $allergeenModel) {}

    public function index()
    {
        $allergenen = $this->allergeenModel->sp_GetAllAllergenen();
        return view('allergeen.index', [
            'title' => 'Allergenen',
            'allergenen' => $allergenen,
        ]);
    }

    public function create()
    {
        return view('allergeen.create', ['title' => 'Voeg een Nieuwe Allergeen toe']);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:30',
            'description' => 'required|string|max:80',
        ]);

        DB::select('CALL sp_CreateAllergeen(?, ?)', [
            $data['name'], $data['description']
        ]);

        return redirect()->route('allergeen.index')
            ->with('success', 'Allergeen is succesvol toegevoegd.');
    }

    public function destroy($id)
    {
        $res = DB::select('CALL sp_DeleteAllergeen(?)', [(int)$id]);
        $affected = $res[0]->Affected ?? 0;

        return redirect()->route('allergeen.index')
            ->with('success', $affected > 0
                ? 'Geen allergeen gevonden met dit ID.'
                : 'Allergeen is succesvol verwijderd.');
    }

    public function edit ($id)
    {
        $allergeen = $this->allergeenModel->sp_GetAllergeenById($id);
        abort_if(!$allergeen, 404);
        return view('allergeen.edit', [
            'title' => 'Bewerk Allergeen',
            'allergeen' => $allergeen,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated  = $request->validate([
            'Naam' => 'required|string|max:30',
            'Omschrijving' => 'required|string|max:80',
        ]);

        $affected = $this->allergeenModel
            ->sp_UpdateAllergeen($id, $validated['Naam'], $validated['Omschrijving']);

        if ($affected === 0) {
            return back()->with('error','Er Bestaat geen allergeen met dit ID.');
        }

        return redirect()->route('allergeen.index')
            ->with('success','Allergeen is succesvol bijgewerkt.');
    }
}
