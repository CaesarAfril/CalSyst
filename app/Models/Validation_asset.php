<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Validation_asset extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "validation_assets";
    protected $primaryKey = "id";
    protected $fillable = [
        'uuid',
        'plant_uuid',
        'dept_uuid',
        'location',
        'machine_uuid',
        'detail'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($validation_asset) {
            $validation_asset->uuid = Str::uuid();
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

    public function machine()
    {
        return $this->belongsTo(Machine::class, 'machine_uuid', 'uuid');
    }

    public function fryerProducts()
    {
        return $this->hasMany(FryerProduct::class, 'machine_uuid', 'uuid');
    }

    public function hiCookProducts()
    {
        return $this->hasMany(HiCookProduct::class, 'machine_uuid', 'uuid');
    }

    public function fryerValidations()
    {
        return $this->hasMany(FryerValidation::class, 'machine_uuid', 'uuid');
    }

    public function hiCookValidations()
    {
        return $this->hasMany(HiCookValidation::class, 'machine_uuid', 'uuid');
    }
}