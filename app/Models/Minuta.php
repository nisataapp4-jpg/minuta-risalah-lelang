<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Minuta extends Model
{
    // Tambahkan di sini
    protected $table = 'minuta';

    protected $fillable = [
        'tahun_risalah',
        'nomor_risalah',
        'tanggal_risalah',
        'pemohon_lelang',
        'nama_debitur',
        'objek',
        'jenis_lelang',
        'pejabat_lelang',
        'lokasi_gudang',
        'lokasi_lemari',
        'dipinjam',
    ];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'minuta_id');
    }

    public function pengembalian()
{
    return $this->hasMany(Pengembalian::class, 'minuta_id');
}

public function getLokasiAttribute()
{
    if (!$this->lokasi_gudang) {
        return '';
    }

    if (!$this->lokasi_lemari) {
        return $this->lokasi_gudang;
    }

    return $this->lokasi_gudang . ' (' . $this->lokasi_lemari . ')';
}

}