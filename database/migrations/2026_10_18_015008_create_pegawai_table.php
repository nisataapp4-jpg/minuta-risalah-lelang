<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->nullable();
            $table->string('nama_pegawai');
            $table->string('seksi');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('role')->default('Pegawai'); // Pilihan: Admin / Pegawai
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};