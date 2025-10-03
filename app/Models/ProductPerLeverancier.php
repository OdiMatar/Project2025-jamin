<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class ProductPerLeverancier extends Model
{
    protected $table = 'ProductPerLeverancier';
    protected $primaryKey = 'Id';
    public $timestamps = true;

    const CREATED_AT = 'DatumAangemaakt';
    const UPDATED_AT = 'DatumGewijzigd';

    protected $fillable = [
        'LeverancierId','ProductId','DatumLevering','Aantal','DatumEerstVolgendeLevering','IsActief','Opmerkingen'
    ];

    protected $casts = [
        'DatumLevering' => 'date:Y-m-d',
        'DatumEerstVolgendeLevering' => 'date:Y-m-d',
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
