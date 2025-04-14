<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => 'konig',
            'name' => 'Afril Caesar Muhammad Hanif',
            'email' => 'afril.hanif@cp.co.id',
            'email_verified_at' => now(),
            'password' => bcrypt('stutjack7217'),
            'role_uuid' => '2f01c48a-675c-47a8-b517-8a32eb9d05cd'
        ]);
        User::create([
            'username' => 'yosi.pratama',
            'name' => 'Yosi Pratama',
            'email' => 'yosi.pratama@cp.co.id',
            'email_verified_at' => now(),
            'password' => bcrypt('cpi12345'),
            'role_uuid' => '954cb4a4-9f74-4dc4-93ce-56546a0b7f36'
        ]);
        User::create([
            'username' => 'tukang.kalibrasi',
            'name' => 'Fahbi Basharo',
            'email' => 'fahbi.basharo@cp.co.id',
            'email_verified_at' => now(),
            'password' => bcrypt('cpi12345'),
            'role_uuid' => '954cb4a4-9f74-4dc4-93ce-56546a0b7f36'
        ]);
    }
}