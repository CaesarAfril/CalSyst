<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbfValidation extends Model
{
    protected $table = 'abf_validation';

    protected $fillable = [
        'start_pengujian',
        'end_pengujian',
        'pengujian',
        'nama_produk',
        'ingredient',
        'kemasan',
        'nama_mesin',
        'dimensi',
        'kapasitas',
        'susunan',
        'isi_rak',
        'penumpukan',
        'target_suhu',
        'set_thermostat',
        'nama_mesin_2',
        'merek_mesin_2',
        'tipe_mesin_2',
        'freon_mesin_2',
        'kapasitas_mesin_2',
        'lokasi',
        'alamat',
        'notes_sebaran',
        'notes_grafik',
        'notes_durasi_spike',
        'notes_spike',
        'notes_tabel_penetrasi',
        'notes_grafik_penetrasi',
        'notes_stagnansi',
        'notes_ketercapaian',
        'kesimpulan',
        'machine_uuid'
    ];

    public function suhuAbfAll()
    {
        return $this->hasMany(SuhuAbfAll::class, 'abf_validation_id');
    }

    public function validation_asset()
    {
        return $this->belongsTo(Validation_asset::class, 'machine_uuid');
    }
}
