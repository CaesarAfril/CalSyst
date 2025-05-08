<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuhuAbfAll extends Model
{
    protected $table = 'suhu_abf_all';

    protected $fillable = [
        'abf_validation_id',
        'time',
        'ch1',
        'ch2',
        'ch3',
        'ch4',
        'ch5',
        'ch6',
        'ch7',
        'ch8',
        'ch9',
        'ch10',
        'titik1',
        'titik2',
        'titik3',
        'titik4'
    ];

    public function abfValidation()
    {
        return $this->belongsTo(AbfValidation::class);
    }
}