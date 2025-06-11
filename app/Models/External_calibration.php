<?php

namespace App\Models;

use App\Traits\FilterByPlant;
use App\Traits\HasAreaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class External_calibration extends Model
{
    use HasFactory, SoftDeletes, HasAreaScope, FilterByPlant;

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
        return $this->hasOne(external_calibration_file::class, 'calibration_uuid', 'uuid')->latestOfMany('id');
    }

    protected static function defaultRelations(): array
    {
        return [
            'asset',
            'latestCalibrationFile'
        ];
    }

    public static function fetchExternalData(?string $plantUuid = null)
    {
        $user = Auth::user();
        $query = self::hasArea('asset')->FilterByPlant($plantUuid, 'asset')->with(self::defaultRelations())
            ->orderBy('created_at', 'desc');
        if ($user->hasAnyRole(['Admin Plant', 'User'])) {
            $query->where('status', 1);
        }

        return $query;
    }

    public static function fetchExternalCalibrationDashboard(?string $plantUuid = null)
    {
        $query = self::hasArea('asset')->FilterByPlant($plantUuid, 'asset')
            ->with(self::defaultRelations())
            ->where('status', NULL);

        return $query->get();
    }
}
