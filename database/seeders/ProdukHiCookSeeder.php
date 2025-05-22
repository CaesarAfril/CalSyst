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
            ['PH NOCW MW', 190, 210, $now, $now],
            ['PH NOCW WS', 190, 210, $now, $now]
        ];

        foreach ($produkList as $produk) {
            ProdukHiCook::updateOrCreate(
                ['nama_produk' => $produk[0]],
                [
                    'min' => $produk[1],
                    'max' => $produk[2],
                    'created_at' => $produk[3],
                    'updated_at' => $produk[4]
                ]
            );
        }
    }
}