<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HiCookProduct extends Model
{
    use HasFactory;

    protected $table = 'hi_cook_product';

    protected $fillable = [
        'machine_uuid',
        'product_name',
        'min',
        'max',
        'blok1_min',
        'blok1_max',
        'blok2_min',
        'blok2_max',
        'blok3_min',
        'blok3_max',
        'blok4_min',
        'blok4_max',
        'setting_min',
        'setting_max',
    ];

    public function validationAsset()
    {
        return $this->belongsTo(Validation_asset::class, 'machine_uuid', 'uuid');
    }

    public function hiCookValidations()
    {
        return $this->hasMany(HiCookValidation::class);
    }
}