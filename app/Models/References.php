<?php

namespace App\Models;

use App\Traits\HasAreaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class References extends Model
{
    use HasFactory, HasAreaScope, SoftDeletes;

    protected $table = "references";
    protected $primaryKey = "id";
    protected $fillable = [
        'uuid',
        'document_name',
        'filename',
        'path'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($reference) {
            $reference->uuid = Str::uuid();
        });
    }
}
