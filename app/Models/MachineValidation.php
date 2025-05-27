<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineValidation extends Model
{
    use HasFactory;

    protected $table = 'machine_validation';

    protected $fillable = [
        'machine_uuid',
        'product_validation_id',
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


    public function machine()
    {
        return $this->belongsTo(Machine::class, 'machine_uuid', 'uuid');
    }

    public function productValidation()
    {
        return $this->belongsTo(ProdukValidation::class, 'product_validation_id');
    }
}