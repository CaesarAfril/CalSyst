<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Weighing_performance extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "weighing_performance_calibrations";
    protected $primaryKey = "id";
    protected $fillable = [
        'calibration_uuid',
        'total',
        'weight_1',
        'weight_2',
        'show',
        'correction',
        'Uweightstd',
        'Ubouyancy',
        'UC',
        'U95'
    ];

    public function weighing_performance()
    {
        return $this->belongsTo(Scale_calibration::class, 'calibration_uuid', 'uuid');
    }
}
