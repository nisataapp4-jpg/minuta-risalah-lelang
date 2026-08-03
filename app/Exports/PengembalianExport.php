<?php

namespace App\Exports;

use App\Models\Pengembalian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PengembalianExport implements FromCollection, WithHeadings, WithMapping
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

    public function collection()
{
    $query = Pengembalian::with('minuta');

    // Pencarian
    if ($this->search) {

        $search = $this->search;

        $query->where(function ($q) use ($search) {

            $q->where('nama_pengembali', 'like', "%{$search}%")
              ->orWhere('divisi_pengembali', 'like', "%{$search}%")
              ->orWhereHas('minuta', function ($m) use ($search) {

                    $m->where('tahun_risalah', 'like', "%{$search}%")
                      ->orWhere('nomor_risalah', 'like', "%{$search}%")
                      ->orWhere('tanggal_risalah', 'like', "%{$search}%")
                      ->orWhere('pemohon_lelang', 'like', "%{$search}%")
                      ->orWhere('nama_debitur', 'like', "%{$search}%")
                      ->orWhere('objek', 'like', "%{$search}%")
                      ->orWhere('lokasi_gudang', 'like', "%{$search}%")
                      ->orWhere('lokasi_lemari', 'like', "%{$search}%")
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
            ->latest('tanggal_kembali')
            ->get();
}

    public function headings(): array
    {
        return [

    'No',

    'Nama Pengembali',

    'Seksi',

    'Tahun',

    'Lokasi Gudang',

    'Lokasi Lemari',

    'Nomor Risalah',

    'Tanggal Risalah',

    'Pemohon',

    'Debitur',

    'Objek',

    'Jenis',

    'Pejabat',

    'Tanggal Kembali'

];
    }

    public function map($item): array
{
    static $no = 1;

    return [

        $no++,

        $item->nama_pengembali,

        $item->divisi_pengembali,

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

        $item->tanggal_kembali

    ];
}
}