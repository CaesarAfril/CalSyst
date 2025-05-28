<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HiCookTemperature extends Model
{
    use HasFactory;

    protected $table = 'hi_cook_temperature';

    // protected $fillable = [
    //     'hi_cook_validation_id',
    //     'time',
    //     'speed',
    //     'ch1',
    //     'ch2',
    //     'ch3',
    //     'ch4',
    //     'ch5',
    //     'ch6',
    //     'ch7',
    //     'ch8',
    //     'ch9',
    //     'ch10',
    //     'display_machine',
    // ];

    protected $guarded = [];

    public function hiCookValidation()
    {
        return $this->belongsTo(HiCookValidation::class);
    }
}