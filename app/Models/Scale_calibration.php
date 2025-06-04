<?php

namespace App\Models;

use App\Traits\HasAreaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Scale_calibration extends Model
{
    use HasFactory, SoftDeletes, HasAreaScope;

    protected $table = "scale_calibration_assets";
    protected $primaryKey = "id";
    protected $fillable = [
        'uuid',
        'asset_uuid',
        'certificate_number',
        'date',
        'initial_temp',
        'final_temp',
        'initial_rh',
        'final_rh',
        'max_weight',
        'max_scale',
        'scale_resolution',
        'scale_class',
        'weight_resolution',
        'weight_max',
        'weight_min',
        'k',
        'avg_dev_repeatability',
        'UDrift_weight',
        'Ureadability',
        'U95',
        'expired_date',
        'approval'
    ];

    protected $casts = [
        'expired_date' => 'date',
        'date' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($scale) {
            $scale->uuid = Str::uuid();
        });
    }

    public function asset()
    {
        return $this->belongsTo(Assets::class, 'asset_uuid', 'uuid');
    }

    public function weighing_performances()
    {
        return $this->hasMany(Weighing_performance::class, 'calibration_uuid', 'uuid');
    }

    public function repeatability_scale_calibrations()
    {
        return $this->hasMany(Repeatability_scale_calibration::class, 'calibration_uuid', 'uuid');
    }

    public function eccentricity_scale_calibration()
    {
        return $this->hasOne(Eccentricity_scale_calibration::class, 'calibration_uuid', 'uuid');
    }
}
