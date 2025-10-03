<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class AllergeenModel extends Model
{
    protected $table = 'allergenen';
    public $timestamps = false;

    public function sp_GetAllAllergenen(): Collection
    {
        $rows = DB::select('CALL sp_GetAllAllergenen()');

        return collect($rows)->map(function ($r) {
            // ID normaliseren
            $r->id = $r->id
                ?? ($r->ID
                ?? ($r->Id
                ?? ($r->AllergeenID
                ?? ($r->allergeen_id ?? null))));

            // Naam/Omschrijving normaliseren
            $r->name = $r->name ?? ($r->Naam ?? null);
            $r->description = $r->description ?? ($r->Omschrijving ?? null);

            return $r;
        });
    }

    public function sp_CreateAllergeen(string $name, string $description): ?int
    {
        $result = DB::select('CALL sp_CreateAllergeen(?, ?)', [$name, $description]);

        if (empty($result)) {
            return null;
        }

        $row = (object) $result[0];
        $newId = $row->id ?? ($row->NewID ?? ($row->ID ?? null));

        return $newId !== null ? (int) $newId : null;
    }
}
