<?php

namespace App\Models;

use App\Traits\FilterByPlant;
use App\Traits\HasAreaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class temp_calibration extends Model
{
    use HasFactory, SoftDeletes, HasAreaScope, FilterByPlant;
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
        'u95',
        'expired_date',
        'approval'
    ];

    protected $casts = [
        'expired_date' => 'date',
        'date' => 'date',
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

    protected static function defaultRelations(): array
    {
        return [
            'actual_temps',
            'asset'
        ];
    }

    public static function getTemperature(?string $plantUuid = null, ?string $approval = null)
    {
        $query = self::with(self::defaultRelations())->hasArea('asset')->FilterByPlant($plantUuid, 'asset')->where('approval', $approval);

        return $query->get();
    }
}
