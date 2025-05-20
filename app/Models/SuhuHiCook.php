<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuhuHiCook extends Model
{
    protected $table = 'suhu_hi_cook';
    protected $guarded = [];

    public function hiCookValidation()
    {
        return $this->belongsTo(HiCookValidation::class);
    }
}