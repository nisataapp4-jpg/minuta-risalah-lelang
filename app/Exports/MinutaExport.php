<?php

namespace App\Exports;

use App\Models\Minuta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MinutaExport implements FromCollection, WithHeadings, WithMapping
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
    $query = Minuta::where('dipinjam', false);

    if ($this->search) {

        $query->where(function ($q) {

            $q->where('tahun_risalah', 'like', "%{$this->search}%")
              ->orWhere('nomor_risalah', 'like', "%{$this->search}%")
              ->orWhere('tanggal_risalah', 'like', "%{$this->search}%")
              ->orWhere('pemohon_lelang', 'like', "%{$this->search}%")
              ->orWhere('nama_debitur', 'like', "%{$this->search}%")
              ->orWhere('objek', 'like', "%{$this->search}%")
              ->orWhere('lokasi_gudang', 'like', "%{$this->search}%")
              ->orWhere('lokasi_lemari', 'like', "%{$this->search}%")
              ->orWhere('jenis_lelang', 'like', "%{$this->search}%")
              ->orWhere('pejabat_lelang', 'like', "%{$this->search}%");

        });

    }

    if ($this->tahunAwal && $this->tahunAkhir) {

        $query->whereBetween('tahun_risalah', [

            $this->tahunAwal,

            $this->tahunAkhir

        ]);

    }

    return $query
        ->orderBy('tahun_risalah', 'asc')
        ->orderByRaw("
            CAST(
                SUBSTRING_INDEX(nomor_risalah,'/',1)
            AS UNSIGNED)
        ")
        ->get();
}
    public function headings(): array
{
    return [

        'No',

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

    ];
}
    public function map($minuta): array
{
    static $no = 1;

    return [

        $no++,

        $minuta->tahun_risalah,

        $minuta->lokasi_gudang,

        $minuta->lokasi_lemari,

        $minuta->nomor_risalah,

        $minuta->tanggal_risalah,

        $minuta->pemohon_lelang,

        $minuta->nama_debitur,

        $minuta->objek,

        $minuta->jenis_lelang,

        $minuta->pejabat_lelang,

    ];
}
}
