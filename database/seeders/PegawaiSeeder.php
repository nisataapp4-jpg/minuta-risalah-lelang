<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PegawaiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pegawai')->insert([
            [
                'nip' => '198801012010121001',
                'nama_pegawai' => 'Nisaul Bilad Ismi',
                'seksi' => 'Seksi Lelang',
                'username' => 'nisa_admin',
                'password' => Hash::make('password123'),
                'role' => 'Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nip' => '199002152014021002',
                'nama_pegawai' => 'Siti Rahma',
                'seksi' => 'Seksi Lelang',
                'username' => 'siti_pegawai',
                'password' => Hash::make('password123'),
                'role' => 'Pegawai',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}