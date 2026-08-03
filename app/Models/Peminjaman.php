<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    protected $fillable = [
        'minuta_id',
        'tanggal_pinjam',
        'nama_peminjam',
        'divisi_peminjam',
    ];

    public function minuta()
    {
        return $this->belongsTo(Minuta::class, 'minuta_id');
    }
}