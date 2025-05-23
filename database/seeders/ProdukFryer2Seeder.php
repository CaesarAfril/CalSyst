<?php

// database/seeders/ProdukFryer2Seeder.php

namespace Database\Seeders;

use App\Models\ProdukFryer2;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProdukFryer2Seeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        $produkList = [
            ['Fiesta Nugget', 160, 170, null, null, $now, $now],
            ['Fiesta Stikie', 160, 170, null, null, $now, $now],
            ['Fiesta Dino', 160, 170, null, null, $now, $now],
            ['Fiesta Pizz ABC', 155, 165, 154, 162, $now, $now],
            ['Fiesta Crispy Bubble', 160, 170, null, null, $now, $now],
            ['Fiesta Spicy Nugget', 160, 170, null, null, $now, $now],
            ['Champ Nugget', 160, 170, 159, 167, $now, $now],
            ['Champ Stik', 160, 170, 159, 167, $now, $now],
            ['Champ Coin', 160, 170, 159, 167, $now, $now],
            ['Champ ABC', 160, 170, 159, 167, $now, $now],
            ['Champ Nugget Hotz', 160, 170, 159, 167, $now, $now],
            ['Champ Crunchy Nugget', 160, 170, 159, 167, $now, $now],
            ['Akumo Nugget', 155, 165, 154, 162, $now, $now],
            ['Akumo Coin', 160, 170, 159, 167, $now, $now],
            ['Akumo Stik', 160, 170, 159, 167, $now, $now],
            ['Okey Naget', 160, 170, 159, 167, $now, $now],
            ['Okey Stik', 160, 170, 159, 167, $now, $now],
            ['Asimo Nugget', 160, 170, 159, 167, $now, $now],
            ['Asimo Stik', 140, 150, 139, 147, $now, $now],
            ['PH Stikie', 155, 165, 159, 167, $now, $now],
            ['Umbul Sidomukti Nugget', 160, 170, 159, 167, $now, $now],
            ['Shake Shake Chicken Nugget', 160, 170, 159, 167, $now, $now]
        ];

        foreach ($produkList as $produk) {
            ProdukFryer2::updateOrCreate(
                ['nama_produk' => $produk[0]],
                [
                    'min' => $produk[1],
                    'max' => $produk[2],
                    'setting_min' => $produk[3],
                    'setting_max' => $produk[4],
                    'created_at' => $produk[5],
                    'updated_at' => $produk[6]
                ]
            );
        }
    }
}