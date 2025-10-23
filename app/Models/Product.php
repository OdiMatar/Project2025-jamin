<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'Product';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = ['Naam','Barcode','LeverancierId'];

    public function magazijn()
    {
        return $this->hasMany(Magazijn::class, 'ProductId', 'Id');
    }

    public function allergenen()
    {
        return $this->belongsToMany(
            Allergeen::class,
            'ProductPerAllergeen',
            'ProductId',
            'AllergeenId'
        );
    }

    /* ✅ NIEUW: relaties die je controller gebruikt */
    public function leverancier()
    {
        // jouw FK heet LeverancierId en PK bij Leverancier is Id
        return $this->belongsTo(Leverancier::class, 'LeverancierId', 'Id');
    }

    public function leveringen()
    {
        // in jouw leveringen-tabel is de FK waarschijnlijk ProductId
        return $this->hasMany(Levering::class, 'ProductId', 'Id');
    }
}
