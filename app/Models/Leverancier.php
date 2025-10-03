<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leverancier extends Model
{
    protected $table = 'Leverancier';
    protected $primaryKey = 'Id';
    public $timestamps = true;

    const CREATED_AT = 'DatumAangemaakt';
    const UPDATED_AT = 'DatumGewijzigd';

    protected $fillable = ['Naam','ContactPersoon','LeverancierNummer','Mobiel','IsActief','Opmerkingen'];
}
