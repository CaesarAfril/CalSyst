<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class temp_calibration extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "temperature_calibration_assets";
    protected $primaryKey = "id";
    protected $fillable = [
        'uuid',
        'date',
        'certificate_number',
        'intial_temp',
        'final_temp',
        'intial_rh',
        'final_rh',
        'asset_uuid',
        'avg_stdev_uut',
        'u1',
        'u2',
        'u3',
        'uc',
        'veff',
        'k',
        'u95'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($temp) {
            $temp->uuid = Str::uuid();
        });
    }

    public function actual_temps()
    {
        return $this->hasMany(actual_temp_calibration::class, 'temp_calibration_uuid', 'uuid');
    }

    public function asset()
    {
        return $this->belongsTo(Assets::class, 'asset_uuid', 'uuid');
    }
}
