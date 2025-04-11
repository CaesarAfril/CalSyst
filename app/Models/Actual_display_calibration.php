<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Actual_display_calibration extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "actual_display_calibration";
    protected $primaryKey = "id";
    protected $fillable = [
        'uuid',
        'set_temp',
        'standar1',
        'standar2',
        'standar3',
        'standar4',
        'standar5',
        'aktual1',
        'aktual2',
        'aktual3',
        'aktual4',
        'aktual5',
        'avgprt',
        'stdevprt',
        'avguut',
        'stdevuut',
        'correction',
        'display_calibration_uuid',
        'uprt'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($actual) {
            $actual->uuid = Str::uuid();
        });
    }

    public function display_calibration()
    {
        return $this->belongsTo(Display_calibration::class, 'display_calibration_uuid', 'uuid');
    }
}
