<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuhuFryerMarel extends Model
{
    protected $table = 'suhu_fryer_marel';
    protected $guarded = [];

    public function fryerMarelValidation()
    {
        return $this->belongsTo(FryerMarelValidation::class);
    }
}