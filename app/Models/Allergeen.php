<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Allergeen extends Model
{
    protected $table = 'Allergeen';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = ['Naam'];

    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'ProductPerAllergeen',
            'AllergeenId',
            'ProductId'
        );
    }
}
