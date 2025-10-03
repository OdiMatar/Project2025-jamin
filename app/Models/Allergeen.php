<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Allergeen extends Model
{
    // Zet dit exact zoals jouw DB de tabel noemt
    protected $table = 'Allergeen';   // jouw CREATE TABLE heet zo
    protected $primaryKey = 'Id';     // in jouw schema is PK 'Id'
    public $timestamps = false;

    protected $fillable = ['Naam', 'Omschrijving'];
}
