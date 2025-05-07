<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class PenetrasiSuhuImport implements ToCollection
{
    public $suhuAwalPenetrasi = [];
    public $suhuAkhirPenetrasi = [];

    public function collection(Collection $rows)
    {
        // Cek baris ke-2 (index 1) untuk suhu awal
        if (isset($rows[1])) {
            $this->suhuAwalPenetrasi = $rows[1]->slice(1)->toArray();
        }

        // Cek baris ke-4 (index 3) untuk suhu akhir
        if (isset($rows[3])) {
            $this->suhuAkhirPenetrasi = $rows[3]->slice(1)->toArray();
        }
    }
}