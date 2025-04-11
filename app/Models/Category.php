<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "category";
    protected $primaryKey = "id";
    protected $fillable = [
        'uuid',
        'category',
        'calibration'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $category->uuid = Str::uuid();
        });
    }

    public function assets()
    {
        return $this->hasMany(Assets::class, 'category');
    }
}
