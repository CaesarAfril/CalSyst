<?php

namespace App\Models;

use App\Traits\HasAreaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Department extends Model
{
    use HasFactory, SoftDeletes, HasAreaScope;
    protected $table = "department";
    protected $primaryKey = "id";
    protected $fillable = [
        'uuid',
        'department'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($department) {
            $department->uuid = Str::uuid(); // Generate a UUID
        });
    }

    public function users()
    {
        return $this->hasMany(User::class, 'dept_uuid', 'uuid');
    }

    public function assets()
    {
        return $this->hasMany(Assets::class, 'dept_uuid', 'uuid');
    }

    public function validation_assets()
    {
        return $this->hasMany(Validation_asset::class, 'dept_uuid', 'uuid');
    }

    public static function fetchdataSidebar(?string $plantUuid = null)
    {
        $query = self::with('validation_assets')->hasArea('validation_assets')
            ->whereHas('validation_assets')
            ->whereNull('deleted_at');

        if ($plantUuid) {
            $query->whereHas('validation_assets', function ($q) use ($plantUuid) {
                $q->where('plant_uuid', $plantUuid);
            });
        }

        return $query->get();
    }
}
