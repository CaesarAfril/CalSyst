<?php

namespace App\Models;

use App\Traits\HasAreaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class External_calibration extends Model
{
    use HasFactory, SoftDeletes, HasAreaScope;

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

    public static function fetchExternalData()
    {
        $user = Auth::user();
        if ($user->hasAnyRole(['Admin Plant', 'User'])) {
            return self::HasArea('asset')->with(['asset', 'latestCalibrationFile'])
                ->where('status', 1)
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        return self::with(['asset', 'latestCalibrationFile'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public static function fetchExternalCalibrationDashboard(?string $plantUuid = null)
    {
        $query = self::hasArea('asset')
            ->with(['asset', 'latestCalibrationFile'])
            ->where('status', NULL);

        if ($plantUuid) {
            $query->whereHas('asset', function ($q) use ($plantUuid) {
                $q->where('plant_uuid', $plantUuid);
            });
        }

        return $query->get();
    }
}
