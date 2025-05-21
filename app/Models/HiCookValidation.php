<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HiCookValidation extends Model
{
    protected $table = 'hi_cook_validation';

    protected $fillable = [
        'produk_hi_cook_id',
        'nama_produk',
        'ingredient',
        'kemasan',
        'nama_mesin',
        'dimensi',
        'target_suhu',
        'start_pengujian',
        'end_pengujian',
        'setting_suhu_mesin',
        'waktu_produk_infeed',
        'suhu_awal_inti',
        'suhu_akhir_inti',
        'batch',
        'waktu_pemasakan',
        'nama_mesin_2',
        'merek_mesin_2',
        'tipe_mesin_2',
        'speed_conv_mesin_2',
        'kapasitas_mesin_2',
        'lokasi',
        'alamat',
        'notes_sebaran',
        'notes_grafik',
        'notes_luar_range',
        'notes_keseragaman',
        'notes_rekaman',
        'kesimpulan',
    ];

    public function suhuHiCook()
    {
        return $this->hasMany(SuhuHiCook::class);
    }

    public function produk()
    {
        return $this->belongsTo(ProdukHiCook::class, 'produk_hi_cook_id');
    }
}