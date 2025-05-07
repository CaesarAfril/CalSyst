<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ABF_suhu;

class ABFSuhuSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['titik_pengukuran' => 'Tink 1', 'waktu' => '16:20:00', 'suhu' => -5.0],
            ['titik_pengukuran' => 'Tink 2', 'waktu' => '16:21:00', 'suhu' => -3.0],
            ['titik_pengukuran' => 'Tink 3', 'waktu' => '16:22:00', 'suhu' => 0.0],
            ['titik_pengukuran' => 'Tink 4', 'waktu' => '16:23:00', 'suhu' => 2.0],
            ['titik_pengukuran' => 'Tink 5', 'waktu' => '16:24:00', 'suhu' => 5.0],
            ['titik_pengukuran' => 'Tink 6', 'waktu' => '16:25:00', 'suhu' => 3.0],
            ['titik_pengukuran' => 'Tink 7', 'waktu' => '16:26:00', 'suhu' => 1.0],
            ['titik_pengukuran' => 'Tink 8', 'waktu' => '16:27:00', 'suhu' => 4.0],
            ['titik_pengukuran' => 'Tink 9', 'waktu' => '16:28:00', 'suhu' => 6.0],
            ['titik_pengukuran' => 'T19', 'waktu' => '16:29:00', 'suhu' => 8.0],
        ];

        ABF_suhu::insert($data);
    }
}