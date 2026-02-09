<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AsesorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'nama' => 'Ahmad Asesor',
            'email' => 'Ahmad@gmail.com',
            'password' => Hash::make('ahmad123'),
            'role' => 'asesor',
            'no_hp' => '081234567891',
            'status_aktif' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
