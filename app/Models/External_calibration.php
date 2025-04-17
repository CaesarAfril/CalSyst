<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class External_calibration extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "external_calibrations";
    protected $primaryKey = "id";
    protected $fillable = [
        'uuid',
        'date',
        'asset_uuid',
        'status',
        'next_calibration_date',
        'progress_status',
        'certificate_date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($external) {
            $external->uuid = Str::uuid();
        });
    }

    public function asset()
    {
        return $this->belongsTo(Assets::class, 'asset_uuid', 'uuid');
    }

    public function calibrations()
    {
        return $this->hasMany(external_calibration_file::class, 'calibration_uuid', 'uuid');
    }

    public function latestCalibrationFile()
    {
        return $this->hasOne(external_calibration_file::class, 'calibration_uuid', 'uuid')->latest('id');
    }
}