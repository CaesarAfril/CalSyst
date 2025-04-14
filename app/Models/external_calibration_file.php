<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class external_calibration_file extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "external_calibrations";
    protected $primaryKey = "id";
    protected $fillable = [
        'calibration_uuid',
        'progress',
        'path',
        'filename',
        'approval',
        'upload_date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($external) {
            $external->uuid = Str::uuid();
        });
    }
}