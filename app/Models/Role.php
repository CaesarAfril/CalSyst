<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Role extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "role";
    protected $primaryKey = "id";
    protected $fillable = [
        'uuid',
        'role'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($role) {
            $role->uuid = Str::uuid(); // Generate a UUID
        });
    }

    public function users()
    {
        return $this->hasMany(User::class, 'role_uuid');
    }
}
