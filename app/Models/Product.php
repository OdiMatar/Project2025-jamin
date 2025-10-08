<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'Product';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'Naam',
        'Barcode',
        'LeverancierId',
    ];

    public function magazijn()
    {
        return $this->hasMany(Magazijn::class, 'ProductId', 'Id');
    }

    public function allergenen()
    {
        // Pas zo nodig de pivot-tabel/kolommen aan je schema aan
        return $this->belongsToMany(
            Allergeen::class,
            'ProductAllergeen',   // pivot
            'ProductId',          // fk naar Product in pivot
            'AllergeenId'         // fk naar Allergeen in pivot
        );
    }
}
