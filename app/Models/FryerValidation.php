<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FryerValidation extends Model
{
    use HasFactory;

    protected $table = 'fryer_validation';

    protected $fillable = [
        'machine_uuid',
        'fryer_product_id',
        'product_name',
        'ingredient',
        'packaging',
        'machine_name',
        'dimension',
        'target_temperature',
        'start_testing',
        'end_testing',
        'setting_machine_temperature',
        'product_infeed_time',
        'initial_core_temperature',
        'final_core_temperature',
        'batch',
        'cooking_time',
        'machine_name_2',
        'machine_brand_2',
        'machine_type_2',
        'machine_speed_conv_2',
        'machine_capacity_2',
        'location',
        'address',
        'distribution_notes',
        'chart_notes',
        'out_of_range_notes',
        'uniformity_notes',
        'transcription_notes',
        'conclusion',
    ];

    public function validationAsset()
    {
        return $this->belongsTo(Validation_asset::class, 'machine_uuid', 'uuid');
    }

    public function fryerProduct()
    {
        return $this->belongsTo(FryerProduct::class);
    }
}