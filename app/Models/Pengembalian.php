<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    protected $table = 'pengembalian';

    protected $fillable = [

        'minuta_id',

        'nama_pengembali',

        'divisi_pengembali',

        'tanggal_kembali',

    ];

    /**
     * Relasi ke tabel minuta
     */
    public function minuta()
    {
        return $this->belongsTo(Minuta::class, 'minuta_id');
    }
}