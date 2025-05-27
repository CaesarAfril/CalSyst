<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukHiCook extends Model
{
    protected $table = 'produk_hi_cook';

    protected $fillable = ['nama_produk', 'min', 'max', 'blok1_min', 'blok1_max', 'blok2_min', 'blok2_max', 'blok3_min', 'blok3_max', 'blok4_min', 'blok4_max', ];

    public function hiCookValidations()
    {
        return $this->hasMany(Fryer1Validation::class, 'produk_hi_cook_id');
    }
}