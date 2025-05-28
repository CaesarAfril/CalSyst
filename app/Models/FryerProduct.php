<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FryerProduct extends Model
{
    use HasFactory;

    protected $table = 'fryer_product';

    protected $fillable = [
        'machine_uuid',
        'product_name',
        'min',
        'max',
        'setting_min',
        'setting_max',
    ];

    public function validationAsset()
    {
        return $this->belongsTo(Validation_asset::class, 'machine_uuid', 'uuid');
    }

    public function fryerValidations()
    {
        return $this->hasMany(FryerValidation::class);
    }
}
