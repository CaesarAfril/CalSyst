<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Department extends Model
{
    use HasFactory;
    use SoftDeletes;
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
        return $this->hasMany(User::class, 'dept_uuid');
    }

    public function assets()
    {
        return $this->hasMany(Assets::class, 'dept_uuid');
    }

    public function validation_assets()
    {
        return $this->hasMany(Validation_asset::class, 'dept_uuid');
    }
}
