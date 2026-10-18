<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil seeder pegawai yang baru saja kita buat di sini:
        $this->call(PegawaiSeeder::class);
    }
}