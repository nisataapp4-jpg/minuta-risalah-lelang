<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::table('minuta', function (Blueprint $table) {

        $table->string('lokasi_gudang')->nullable()->after('tahun_risalah');

        $table->string('lokasi_lemari')->nullable()->after('lokasi_gudang');

    });
}

public function down(): void
{
    Schema::table('minuta', function (Blueprint $table) {

        $table->dropColumn([
            'lokasi_gudang',
            'lokasi_lemari'
        ]);

    });
}
};
