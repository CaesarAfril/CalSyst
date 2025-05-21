<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukFryer1 extends Model
{
    protected $table = 'produk_fryer_1';

    protected $fillable = ['nama_produk','min','max'];

    public function fryer1Validations()
    {
        return $this->hasMany(Fryer1Validation::class, 'produk_fryer_1_id');
    }
}