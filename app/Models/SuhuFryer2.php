<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuhuFryer2 extends Model
{
     protected $table = 'suhu_fryer_2';
    protected $guarded = [];

    public function fryer2Validation()
    {
        return $this->belongsTo(Fryer2Validation::class);
    }
}