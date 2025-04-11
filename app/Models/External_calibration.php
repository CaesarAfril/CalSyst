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
        'path',
        'filename',
        'status',
        'next_calibration_date'
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
}
