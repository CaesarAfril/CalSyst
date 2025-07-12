<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Plant extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "plant";
    protected $primaryKey = "id";
    protected $fillable = [
        'uuid',
        'plant',
        'abbreviaton'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($plant) {
            $plant->uuid = Str::uuid(); // Generate a UUID
        });
    }

    public function users()
    {
        return $this->hasMany(User::class, 'plant_uuid');
    }

    public function assets()
    {
        return $this->hasMany(Assets::class, 'plant_uuid');
    }

    public function validation_assets()
    {
        return $this->hasMany(Validation_asset::class, 'plant_uuid');
    }
}
