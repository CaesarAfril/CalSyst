<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuhuFryer1 extends Model
{
    protected $table = 'suhu_fryer_1';
    protected $guarded = [];

    public function fryer1Validation()
    {
        return $this->belongsTo(Fryer1Validation::class);
    }
}