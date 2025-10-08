<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leverancier extends Model
{
    protected $table = 'Leverancier';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = ['Naam','ContactPersoon','LeverancierNummer','Mobiel','IsActief','Opmerkingen'];

    public function producten()
    {
        return $this->hasMany(Product::class, 'leverancier_id', 'Id');
    }
}
