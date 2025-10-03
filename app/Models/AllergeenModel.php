<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AllergeenModel extends Model
{ 
    protected $table = 'allergenen'; // laten zoals je had
    protected $fillable = ['name', 'description'];
    public $timestamps = false;

    public function sp_GetAllAllergenen()
    {    
        return DB::select('CALL sp_GetAllAllergenen()');
    }

    public function sp_CreateAllergeen($name, $description)
    {
        $result = DB::select('CALL sp_CreateAllergeen(?, ?)', [$name, $description]);
        return $result[0]->id ?? null;
    }

    public function sp_GetAllergeenById($id)
    {
        return DB::selectOne('CALL sp_GetAllergeenById(:id)', ['id' => $id]);
    }

    public function sp_UpdateAllergeen($id, $name, $description)
    {
        $row = DB::selectOne('CALL sp_UpdateAllergeen(:Id, :name, :description)', [
            'Id'          => $id,
            'name'        => $name,
            'description' => $description
        ]);
        return $row->Affected ?? 0;
    }
}
