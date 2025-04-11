<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Repeatability_scale_calibration extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "repeatability_scale_calibrations";
    protected $primaryKey = "id";
    protected $fillable = [
        'calibration_uuid',
        'weight',
        'average',
        'sd',
        'Urepeat'
    ];

    public function repeatability_scale_calibration()
    {
        return $this->belongsTo(Scale_calibration::class, 'calibration_uuid', 'uuid');
    }

    public function actual_repeatability_scales()
    {
        return $this->hasMany(Actual_repeatability_scale::class);
    }
}
