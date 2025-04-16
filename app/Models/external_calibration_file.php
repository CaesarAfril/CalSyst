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

    protected $table = "external_calibration_files";
    protected $primaryKey = "id";
    protected $fillable = [
        'calibration_uuid',
        'progress',
        'path',
        'filename',
        'approval',
        'upload_date',
        'notes',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($external) {
            $external->uuid = Str::uuid();
        });
    }

    public function calibration()
    {
        return $this->belongsTo(External_calibration::class, 'calibration_uuid', 'uuid');
    }

   
}