<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class actual_temp_calibration extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "actual_temperature_calibration";
    protected $primaryKey = "id";
    protected $fillable = [
        'uuid',
        'set_temp',
        'standar1',
        'standar2',
        'standar3',
        'standar4',
        'standar5',
        'standar6',
        'standar7',
        'aktual1',
        'aktual2',
        'aktual3',
        'aktual4',
        'aktual5',
        'aktual6',
        'aktual7',
        'avgprt',
        'stdevprt',
        'avguut',
        'stdevuut',
        'correction',
        'temp_calibration_uuid',
        'uprt'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($actual) {
            $actual->uuid = Str::uuid();
        });
    }

    public function temp_calibration()
    {
        return $this->belongsTo(temp_calibration::class, 'temp_calibration_uuid', 'uuid');
    }
}
