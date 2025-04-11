<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Actual_repeatability_scale extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "actual_repeatability_scale_calibrations";
    protected $primaryKey = "id";
    protected $fillable = [
        'repeatability_id',
        'shown',
        'correction'
    ];

    public function repeatability_scale_calibration()
    {
        return $this->belongsTo(Repeatability_scale_calibration::class);
    }
}
