<?php

// database/seeders/ProdukHiCookSeeder.php

namespace Database\Seeders;

use App\Models\ProdukHiCook;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProdukHiCookSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        $produkList = [
            ['Fiesta Spicy Wing', 205, 215, $now, $now],
            ['Fiesta Spicy Chick', 205, 215, $now, $now],
            ['Fiesta Fried Chicken', 165, 170, $now, $now],
            ['Fiesta Hot & Crispy Fried Chicken', 165, 170, $now, $now],
            ['PH NOCW MW & WS', 190, 210, $now, $now],
        ];

        foreach ($produkList as $produk) {
            ProdukHiCook::updateOrCreate(
                ['nama_produk' => $produk[0]],
                [
                    'min' => $produk[1],
                    'max' => $produk[2],
                    'blok1_min' => $produk[3],
                    'blok1_max' => $produk[4],
                    'blok2_min' => $produk[5],
                    'blok2_max' => $produk[6],
                    'blok3_min' => $produk[7],
                    'blok3_max' => $produk[8],
                    'blok4_min' => $produk[9],
                    'blok4_max' => $produk[10],
                    'created_at' => $produk[11],
                    'updated_at' => $produk[12]
                ]
            );
        }
    }
}