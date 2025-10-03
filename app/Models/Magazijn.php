<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Magazijn extends Model
{
    protected $table = 'magazijn';   // pas aan als jouw tabel anders heet
    protected $primaryKey = 'Id';    // jouw PK
    public $timestamps = false;

    public function product()
{
    return $this->belongsTo(Product::class, 'ProductId', 'Id');
}

}
