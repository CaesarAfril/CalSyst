<?php

// database/seeders/ProdukFryerMarelSeeder.php

namespace Database\Seeders;

use App\Models\ProdukFryerMarel;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProdukFryerMarelSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();
        
        $produkList = [
            ['Fiesta Karage', 155, 170, $now, $now],
            ['Fiesta Spicy Karage', 155, 170, $now, $now],
            ['Fiesta Crispy Crunch', 155, 170, $now, $now],
            ['Fiesta Schnitzel', 165, 170, $now, $now],
            ['Fiesta Pok-Pok', 155, 170, $now, $now],
            ['Champ Crunchy Hotzz', 155, 170, $now, $now],
            ['Fiesta Fried Chicken', 155, 165, $now, $now],
            ['Fiesta Hot & Crispy Fried Chicken', 155, 165, $now, $now],
            ['Gojek Karage', 155, 170, $now, $now],
            ['Gojek Chicken Pok-Pok', 150, 152, $now, $now],
            ['Gojek Chicken Katsu', 160, 170, $now, $now],
            ['Hangry Ayam Goreng Paha', 155, 160, $now, $now],
            ['Hangry Ayam Goreng Dada', 155, 160, $now, $now],
            ['Hangry Chicken Katsu', 160, 165, $now, $now],
            ['J.Co Schnitzel', 165, 170, $now, $now],
            ['Umbul Sidomukti Chicken Pok Pok', 155, 170, $now, $now],
            ['Tumpeng Mini Karage', 150, 155, $now, $now],
            ['AEON Chicken Karage', 150, 170, $now, $now],
            ['Shake Shake Pop Bites', 150, 152, $now, $now],
            ['VCI Dada Fillet Crispy', 155, 160, $now, $now]
        ];

        foreach ($produkList as $produk) {
            ProdukFryerMarel::updateOrCreate(
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