<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukFryer2 extends Model
{
    protected $table = 'produk_fryer_2';

    protected $fillable = ['nama_produk', 'min', 'max', 'setting_min', 'setting_max'];

    public function fryer2Validations()
    {
        return $this->hasMany(Fryer2Validation::class, 'produk_fryer_2_id');
    }
}