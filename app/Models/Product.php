<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // <<< pas deze 3 regels aan naar jouw échte tabel/kolom-namen >>>
    protected $table = 'Product';     // of 'producten' – exact zoals je tabel heet
    protected $primaryKey = 'Id';
    public $timestamps = false;       // je hebt geen created_at/updated_at

    // (optioneel) kolommen die je invult
    protected $fillable = ['Naam', 'Barcode'];

    // relaties (optioneel)
    public function allergenen()
    {
        // pivot heet bij jou: ProductPerAllergeen met kolommen ProductId / AllergeenId
        return $this->belongsToMany(AllergeenModel::class,
            'ProductPerAllergeen', 'ProductId', 'AllergeenId');
    }
}
