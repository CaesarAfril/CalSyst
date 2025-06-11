<?php

namespace App\Models;

use App\Traits\FilterByPlant;
use App\Traits\HasAreaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class Assets extends Model
{
    use HasFactory, FilterByPlant, SoftDeletes, HasAreaScope;
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
        'standard',
        'expired_date'
    ];

    protected $casts = [
        'expired_date' => 'date',
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
        return $this->hasOne(External_calibration::class, 'asset_uuid', 'uuid')->latestOfMany('date');
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

    protected static function defaultRelations(): array
    {
        return [
            'department',
            'plant',
            'category',
            'latest_external_calibration',
            'latest_temp_calibration',
            'latest_display_calibration',
            'latest_scale_calibration',
        ];
    }

    protected static function applySearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('merk', 'like', "%{$search}%")
                ->orWhere('type', 'like', "%{$search}%")
                ->orWhere('series_number', 'like', "%{$search}%")
                ->orWhere('capacity', 'like', "%{$search}%")
                ->orWhere('range', 'like', "%{$search}%")
                ->orWhere('resolution', 'like', "%{$search}%")
                ->orWhere('correction', 'like', "%{$search}%")
                ->orWhere('uncertainty', 'like', "%{$search}%")
                ->orWhere('standard', 'like', "%{$search}%")
                ->orWhere('location', 'like', "%{$search}%")
                ->orWhere('expired_date', 'like', "%{$search}%");
        })->orWhereHas('category', function ($q) use ($search) {
            $q->where('category', 'like', "%{$search}%");
        })->orWhereHas('department', function ($q) use ($search) {
            $q->where('department', 'like', "%{$search}%");
        })->orWhereHas('plant', function ($q) use ($search) {
            $q->where('plant', 'like', "%{$search}%");
        });
    }

    protected static function filterByPlantUuid($query, ?string $plantUuid)
    {
        return $query->where('plant_uuid', $plantUuid);
    }

    public static function fetchData($search, ?string $plantUuid = null)
    {

        $query = self::hasArea()->FilterByPlant($plantUuid)->with(self::defaultRelations());

        if (!empty($search)) {
            self::applySearch($query, $search);
        }

        return $query;
    }

    public static function fetchTotalAsset(?string $plantUuid = null)
    {
        $query = self::hasArea()->FilterByPlant($plantUuid);

        return $query->count();
    }

    public static function fetchDataDashboard(?string $plantUuid = null)
    {
        $query = self::hasArea()->FilterByPlant($plantUuid)->with(self::defaultRelations());

        return $query->get();
    }

    public static function getExpiringAssets(?string $plantUuid = null, $threeMonthsLater, $sixMonthsLater, $search = null, $sortColumn = 'expired_date', $sortDirection = 'asc'): LengthAwarePaginator
    {
        $query = self::hasArea()->FilterByPlant($plantUuid)
            ->with('category')
            ->join('category', 'category.uuid', '=', 'assets.category_uuid')
            ->select('assets.*')
            ->whereNotNull('assets.expired_date')
            ->whereBetween('assets.expired_date', [$threeMonthsLater, $sixMonthsLater]);

        if (!empty($search)) {
            self::applySearch($query, $search);
        }

        return $query->orderBy($sortColumn, $sortDirection)->paginate(10);
    }

    public static function getExpiredAssets(?string $plantUuid = null, $today, $search = null)
    {
        $query = self::hasArea()->FilterByPlant($plantUuid)->with(self::defaultRelations())
            ->whereNotNull('expired_date')
            ->whereDate('expired_date', '<=', $today);

        if (!empty($search)) {
            self::applySearch($query, $search);
        }

        return $query;
    }

    public static function getCalibratedAsset(?string $plantUuid = null)
    {
        $query = self::hasArea()->FilterByPlant($plantUuid)->with(self::defaultRelations());

        return $query->get();
    }

    public static function getExternalAssetDropdown(?string $plantUuid = null)
    {
        $query = self::hasArea()->FilterByPlant($plantUuid)->whereHas('category', function ($query) {
            $query->where('calibration', 'External');
        });

        return $query;
    }
}
