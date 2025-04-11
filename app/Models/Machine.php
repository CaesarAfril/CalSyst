<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Machine extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "machines";
    protected $primaryKey = "id";
    protected $fillable = [
        'uuid',
        'machine_name'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($machine) {
            $machine->uuid = Str::uuid();
        });
    }

    public function validation_assets()
    {
        return $this->hasMany(Validation_asset::class, 'machine_uuid');
    }
}
