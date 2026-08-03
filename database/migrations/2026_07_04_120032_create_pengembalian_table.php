<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengembalian', function (Blueprint $table) {

            $table->id();

            $table->foreignId('minuta_id')
                  ->constrained('minuta')
                  ->cascadeOnDelete();

            $table->string('nama_pengembali');

            $table->string('divisi_pengembali');

            $table->dateTime('tanggal_kembali');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengembalian');
    }
};