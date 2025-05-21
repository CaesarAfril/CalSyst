<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukHiCook extends Model
{
    protected $table = 'produk_hi_cook';

    protected $fillable = ['nama_produk', 'min', 'max'];

    public function hiCookValidations()
    {
        return $this->hasMany(Fryer1Validation::class, 'produk_hi_cook_id');
    }
}