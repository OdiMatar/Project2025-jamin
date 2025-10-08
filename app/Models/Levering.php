<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Levering extends Model
{
    // ✅ pas dit aan aan je echte tabel- en kolomnamen
    protected $table = 'Levering';          // of 'Leveringen' als jouw tabel zo heet
    protected $primaryKey = 'Id';           // alleen als je Id als PK gebruikt
    public $timestamps = false;

    protected $fillable = [
        'ProductId', 'LeverancierId',
        'DatumLaatste', 'Aantal', 'VerwachteEerstvolgende'
    ];

    protected $casts = [
        'DatumLaatste'           => 'date',
        'VerwachteEerstvolgende' => 'date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductId', 'Id');
    }

    public function leverancier()
    {
        return $this->belongsTo(Leverancier::class, 'LeverancierId', 'Id');
    }
}
