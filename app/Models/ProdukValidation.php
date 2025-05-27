<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukValidation extends Model
{
    use HasFactory;

    protected $table = "produk_validation";

    protected $fillable = [
        'machine_uuid',
        'nama_produk',
        'min',
        'max',
    ];

    // Relasi ke machine
    public function machine()
    {
        return $this->belongsTo(Machine::class, 'machine_uuid', 'uuid');
    }

    public function machineValidations()
    {
        return $this->hasMany(MachineValidation::class, 'product_validation_id');
    }
}