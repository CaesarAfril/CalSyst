<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actual_eccentricity_scale extends Model
{
    use HasFactory;

    protected $table = "actual_eccentricity_scale_calibrations";
    protected $primaryKey = "id";
    protected $fillable = [
        'eccentricity_id',
        'shown',
        'correction',
        'absolute_correction'
    ];

    public function eccentricity_scale_calibration()
    {
        return $this->belongsTo(Eccentricity_scale_calibration::class);
    }
}
