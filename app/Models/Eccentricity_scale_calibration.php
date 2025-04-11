<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Eccentricity_scale_calibration extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "eccentricity_scale_calibrations";
    protected $primaryKey = "id";
    protected $fillable = [
        'calibration_uuid',
        'weight',
        'average',
        'uecc'
    ];

    public function eccentricity_scale_calibration()
    {
        $this->belongsTo(Scale_calibration::class, 'calibration_uuid', 'uuid');
    }

    public function actual_eccentricity_scale()
    {
        return $this->hasMany(Actual_eccentricity_scale::class, 'eccentricity_id', 'id');
    }
}
