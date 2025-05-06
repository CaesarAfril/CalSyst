<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class PersebaranSuhuImport implements ToCollection
{
    public $suhuAwal = [];
    public $suhuAkhir = [];
    public $jamAwal = null;
    public $jamAkhir = null;

    public function collection(Collection $rows)
    {
        // Cek baris ke-2 (index 1) untuk suhu awal
        if (isset($rows[1])) {
            $this->suhuAwal = $rows[1]->slice(1)->toArray();
        }

        // Cek baris ke-3 (index 2) untuk jam awal
        if (isset($rows[2]) && isset($rows[2][5])) {  // Jam awal is in column F (index 5)
            $this->jamAwal = $rows[2][5];
        }

        // Cek baris ke-4 (index 3) untuk suhu akhir
        if (isset($rows[3])) {
            $this->suhuAkhir = $rows[3]->slice(1)->toArray();
        }

        // Cek baris ke-5 (index 4) untuk jam akhir
        if (isset($rows[4]) && isset($rows[4][5])) {  // Jam akhir is in column F (index 5)
            $this->jamAkhir = $rows[4][5];
        }
    }
}