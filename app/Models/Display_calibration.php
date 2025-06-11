<?php

namespace App\Models;

use App\Traits\HasAreaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Display_calibration extends Model
{
    use HasFactory, SoftDeletes, HasAreaScope;
    protected $table = "display_calibration_assets";
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

        static::creating(function ($display) {
            $display->uuid = Str::uuid();
        });
    }

    public function actual_displays()
    {
        return $this->hasMany(Actual_display_calibration::class, 'display_calibration_uuid', 'uuid');
    }

    public function asset()
    {
        return $this->belongsTo(Assets::class, 'asset_uuid', 'uuid');
    }

    protected static function defaultRelations(): array
    {
        return [
            'actual_displays',
            'asset'
        ];
    }

    public static function getDisplay(?string $plantUuid = null, ?string $approval = null)
    {
        $query = self::hasArea('asset')->with(self::defaultRelations())->where('approval', $approval);

        if ($plantUuid) {
            $query->whereHas('asset', function ($q) use ($plantUuid) {
                $q->where('plant_uuid', $plantUuid);
            });
        }

        return $query->get();
    }
}
