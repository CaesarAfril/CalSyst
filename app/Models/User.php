<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'username',
        'name',
        'email',
        'password',
        'role_uuid',
        'plant_uuid',
        'dept_uuid',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->uuid = $user->uuid ?? Str::uuid()->toString();
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

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_uuid', 'uuid');
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole('Admin');
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('Admin Plant');
    }

    public function isCalibrator(): bool
    {
        return $this->hasRole('Kalibrator');
    }
}
