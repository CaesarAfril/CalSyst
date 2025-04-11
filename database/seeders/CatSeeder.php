<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'category' => 'timbangan'
        ]);

        Category::create([
            'category' => 'thermometer'
        ]);
        Category::create([
            'category' => 'display suhu'
        ]);
    }
}
