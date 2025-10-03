<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';   // pas aan
    protected $primaryKey = 'Id';
    public $timestamps = false;
}
