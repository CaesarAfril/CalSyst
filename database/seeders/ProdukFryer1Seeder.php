<?php

// database/seeders/ProdukFryer1Seeder.php
namespace Database\Seeders;

use App\Models\ProdukFryer1;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProdukFryer1Seeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        $produkList = [
            ['Fiesta Nugget', 155, 165, $now, $now],
            ['Fiesta Stikie', 155, 165, $now, $now],
            ['Fiesta Dino', 155, 165, $now, $now],
            ['Fiesta Pizz ABC', 155, 165, $now, $now],
            ['Fiesta Crispy Bubble', 155, 165, $now, $now],
            ['Fiesta Spicy Nugget', 155, 165, $now, $now],
            ['Champ Nugget', 155, 165, $now, $now],
            ['Champ Stik', 155, 165, $now, $now],
            ['Champ Coin', 155, 165, $now, $now],
            ['Champ ABC', 155, 165, $now, $now],
            ['Champ Nugget Hotz', 155, 165, $now, $now],
            ['Champ Crunchy Nugget', 155, 165, $now, $now],
            ['Akumo Nugget', 155, 165, $now, $now],
            ['Akumo Coin', 155, 165, $now, $now],
            ['Akumo Stik', 150, 160, $now, $now],
            ['Okey Naget', 155, 165, $now, $now],
            ['Okey Stik', 155, 165, $now, $now],
            ['Asimo Nugget', 155, 165, $now, $now],
            ['Asimo Stik', 150, 160, $now, $now],
            ['Fiesta Crispy Bubble Katsu', 150, 160, $now, $now],
            ['PH Stikie', 150, 160, $now, $now],
            ['Umbul Sidomukti Nugget', 155, 165, $now, $now],
            ['Shake Shake Chicken Nugget', 155, 165, $now, $now]
        ];

        foreach ($produkList as $produk) {
            ProdukFryer1::updateOrCreate(
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