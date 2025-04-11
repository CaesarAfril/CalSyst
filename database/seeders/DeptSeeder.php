<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DeptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::create([
            'department' => 'Laboratorium'
        ]);

        Department::create([
            'department' => 'Breadcrumb'
        ]);
        Department::create([
            'department' => 'Further'
        ]);
        Department::create([
            'department' => 'Sausage'
        ]);
        Department::create([
            'department' => 'Warehouse'
        ]);
        Department::create([
            'department' => 'Slaughterhouse'
        ]);
        Department::create([
            'department' => 'Quality Control'
        ]);
    }
}
