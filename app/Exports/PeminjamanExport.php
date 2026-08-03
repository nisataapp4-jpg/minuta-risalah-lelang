<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PeminjamanExport implements FromCollection, WithHeadings, WithMapping
{
protected $search;
protected $tahunAwal;
protected $tahunAkhir;

public function __construct($search, $tahunAwal, $tahunAkhir)
{
    $this->search = $search;
    $this->tahunAwal = $tahunAwal;
    $this->tahunAkhir = $tahunAkhir;
}
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
{
    $query = Peminjaman::with('minuta');

    // Pencarian
    if ($this->search) {

        $search = $this->search;

        $query->where(function ($q) use ($search) {

            $q->where('nama_peminjam', 'like', "%{$search}%")
              ->orWhere('divisi_peminjam', 'like', "%{$search}%")
              ->orWhereHas('minuta', function ($m) use ($search) {

                    $m->where('tahun_risalah', 'like', "%{$search}%")
                      ->orWhere('nomor_risalah', 'like', "%{$search}%")
                      ->orWhere('tanggal_risalah', 'like', "%{$search}%")
                      ->orWhere('pemohon_lelang', 'like', "%{$search}%")
                      ->orWhere('nama_debitur', 'like', "%{$search}%")
                      ->orWhere('objek', 'like', "%{$search}%")
                      ->orWhere('lokasi_gudang','like',"%{$this->search}%")
                      ->orWhere('lokasi_lemari','like',"%{$this->search}%")
                      ->orWhere('jenis_lelang', 'like', "%{$search}%")
                      ->orWhere('pejabat_lelang', 'like', "%{$search}%");

              });

        });

    }

    // Filter Tahun
    if ($this->tahunAwal) {

        $query->whereHas('minuta', function ($m) {

            $m->where('tahun_risalah', '>=', $this->tahunAwal);

        });

    }

    if ($this->tahunAkhir) {

        $query->whereHas('minuta', function ($m) {

            $m->where('tahun_risalah', '<=', $this->tahunAkhir);

        });

    }

    return $query
            ->latest('tanggal_pinjam')
            ->get();
}

public function headings(): array
{
    return [

        'No',

        'Nama Peminjam',

        'Seksi Peminjam',

        'Tahun Risalah',

        'Lokasi Gudang',

        'Lokasi Lemari',

        'Nomor Risalah',

        'Tanggal Risalah',

        'Pemohon Lelang',

        'Nama Debitur',

        'Objek',

        'Jenis Lelang',

        'Pejabat Lelang',

        'Tanggal Pinjam'

    ];
}

public function map($item): array
{
    static $no = 1;

    return [

        $no++,

        $item->nama_peminjam,

        $item->divisi_peminjam,

        $item->minuta->tahun_risalah,

        $item->minuta->lokasi_gudang,

        $item->minuta->lokasi_lemari,

        $item->minuta->nomor_risalah,

        $item->minuta->tanggal_risalah,

        $item->minuta->pemohon_lelang,

        $item->minuta->nama_debitur,

        $item->minuta->objek,

        $item->minuta->jenis_lelang,

        $item->minuta->pejabat_lelang,

        $item->tanggal_pinjam

    ];
}
}
