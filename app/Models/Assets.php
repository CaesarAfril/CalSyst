<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Assets extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "assets";
    protected $primaryKey = "id";
    protected $fillable = [
        'uuid',
        'plant_uuid',
        'dept_uuid',
        'location',
        'category_uuid',
        'merk',
        'type',
        'series_number',
        'capacity',
        'range',
        'resolution',
        'correction',
        'uncertainty',
        'standard'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($assets) {
            $assets->uuid = Str::uuid();
        });
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'dept_uuid', 'uuid');
    }

    public function plant()
    {
        return $this->belongsTo(Plant::class, 'plant_uuid', 'uuid');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_uuid', 'uuid');
    }

    public function temp_calibrations()
    {
        return $this->hasMany(temp_calibration::class, 'asset_uuid');
    }

    public function display_calibrations()
    {
        return $this->hasMany(Display_calibration::class, 'asset_uuid');
    }

    public function external_calibrations()
    {
        return $this->hasMany(External_calibration::class, 'asset_uuid');
    }

    public function scale_calibrations()
    {
        return $this->hasMany(Scale_calibration::class, 'asset_uuid');
    }

    public function latest_external_calibration()
    {
        return $this->hasOne(External_calibration::class, 'asset_uuid')->latestOfMany('date');
    }

    public function latest_temp_calibration()
    {
        return $this->hasOne(Temp_calibration::class, 'asset_uuid', 'uuid')->latestOfMany('date');
    }

    public function latest_display_calibration()
    {
        return $this->hasOne(Display_calibration::class, 'asset_uuid', 'uuid')->latestOfMany('date');
    }

    public function latest_scale_calibration()
    {
        return $this->hasOne(Scale_calibration::class, 'asset_uuid', 'uuid')->latestOfMany('date');
    }
}