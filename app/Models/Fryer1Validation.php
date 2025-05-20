<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fryer1Validation extends Model
{
    protected $table = 'fryer_1_validation';

    protected $fillable = [
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

    public function suhuFryer1()
    {
        return $this->hasMany(SuhuFryer1::class);
    }
}