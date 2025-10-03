<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPerLeverancier extends Model
{
    protected $table = 'ProductPerLeverancier';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = ['LeverancierId', 'ProductId', 'DatumLevering', 'Aantal', 'DatumEerstVolgendeLevering'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductId');
    }
}
