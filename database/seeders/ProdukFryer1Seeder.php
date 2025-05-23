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
            ['Fiesta Nugget', 155, 165, 160, 168, $now, $now],
            ['Fiesta Stikie', 155, 165, 160, 168, $now, $now],
            ['Fiesta Dino', 155, 165, 160, 168, $now, $now],
            ['Fiesta Pizz ABC', 155, 165, 160, 168, $now, $now],
            ['Fiesta Crispy Bubble', 155, 165, 160, 168, $now, $now],
            ['Fiesta Spicy Nugget', 155, 165, 160, 168, $now, $now],
            ['Champ Nugget', 155, 165, 160, 168, $now, $now],
            ['Champ Stik', 155, 165, 160, 168, $now, $now],
            ['Champ Coin', 155, 165, 160, 168, $now, $now],
            ['Champ ABC', 155, 165, 160, 168, $now, $now],
            ['Champ Nugget Hotz', 155, 165, 160, 168, $now, $now],
            ['Champ Crunchy Nugget', 155, 165, 160, 168, $now, $now],
            ['Akumo Nugget', 155, 165, 160, 168, $now, $now],
            ['Akumo Coin', 155, 165, 160, 168, $now, $now],
            ['Akumo Stik', 150, 160, 155, 163, $now, $now],
            ['Okey Naget', 155, 165, 160, 168, $now, $now],
            ['Okey Stik', 155, 165, 160, 168, $now, $now],
            ['Asimo Nugget', 155, 165, 160, 168, $now, $now],
            ['Asimo Stik', 150, 160, 155, 163, $now, $now],
            ['Fiesta Crispy Bubble Katsu', 150, 160, 155, 163, $now, $now],
            ['PH Stikie', 150, 160, 160, 168, $now, $now],
            ['Umbul Sidomukti Nugget', 155, 165, 160, 168, $now, $now],
            ['Shake Shake Chicken Nugget', 155, 165, 160, 168, $now, $now]
        ];

        foreach ($produkList as $produk) {
            ProdukFryer1::updateOrCreate(
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