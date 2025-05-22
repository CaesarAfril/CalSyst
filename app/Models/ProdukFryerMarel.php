<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukFryerMarel extends Model
{
    protected $table = 'produk_fryer_marel';

    protected $fillable = ['nama_produk', 'min', 'max'];

    public function fryerMarelValidations()
    {
        return $this->hasMany(FryerMarelValidation::class, 'produk_fryer_marel_id');
    }
}