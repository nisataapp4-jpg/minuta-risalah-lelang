<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\Minuta;
use Illuminate\Http\Request;
use App\Exports\PengembalianExport;
use Maatwebsite\Excel\Facades\Excel;

class PengembalianController extends Controller
{

    public function index(Request $request)
    {
        $query = Pengembalian::with('minuta');


        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('nama_pengembali', 'like', "%{$search}%")
                  ->orWhere('divisi_pengembali', 'like', "%{$search}%")
                  ->orWhereHas('minuta', function ($m) use ($search) {

                        $m->where('tahun_risalah', 'like', "%{$search}%")
                          ->orWhere('nomor_risalah', 'like', "%{$search}%")
                          ->orWhere('tanggal_risalah', 'like', "%{$search}%")
                          ->orWhere('pemohon_lelang', 'like', "%{$search}%")
                          ->orWhere('nama_debitur', 'like', "%{$search}%")
                          ->orWhere('objek','like',"%{$search}%")
                          ->orWhere('lokasi_gudang','like',"%{$search}%")
                          ->orWhere('lokasi_lemari','like',"%{$search}%")
                          ->orWhere('jenis_lelang', 'like', "%{$search}%")
                          ->orWhere('pejabat_lelang', 'like', "%{$search}%");

                  });

            });

        }


        // FILTER TAHUN

        if ($request->filled('tahun_awal')) {

            $query->whereHas('minuta', function ($m) use ($request) {

                $m->where('tahun_risalah', '>=', $request->tahun_awal);

            });

        }

        if ($request->filled('tahun_akhir')) {

            $query->whereHas('minuta', function ($m) use ($request) {

                $m->where('tahun_risalah', '<=', $request->tahun_akhir);

            });

        }

        $pengembalian = $query
                            ->latest('tanggal_kembali')
                            ->paginate(10);

        $pengembalian->appends($request->query());

        return view('pengembalian.index', compact('pengembalian'));
    }


public function create()
{
    // Mengambil transaksi peminjaman aktif yang terhubung ke model Minuta
    $peminjaman = \App\Models\Peminjaman::with('minuta')->get();

    return view('pengembalian.create', compact('peminjaman'));
}

public function store(Request $request)
{
    $request->validate([
        'peminjaman_id' => 'required|exists:peminjaman,id',
    ], [
        'peminjaman_id.required' => 'Pilih transaksi peminjaman yang akan dikembalikan.',
    ]);

    $peminjaman = Peminjaman::with('minuta')->findOrFail($request->peminjaman_id);

    // 1. Simpan ke tabel riwayat pengembalian
    Pengembalian::create([
        'minuta_id'         => $peminjaman->minuta_id,
        'nama_pengembali'   => $peminjaman->nama_peminjam,
        'divisi_pengembali' => $peminjaman->divisi_peminjam ?? 'Seksi Lelang',
        'tanggal_kembali'   => now(),
    ]);

    // 2. Kembalikan status minuta menjadi 0 (Tersedia)
    if ($peminjaman->minuta) {
        $peminjaman->minuta->update([
            'status'   => 0,
            'dipinjam' => false
        ]);
    }

    // 3. Hapus data dari tabel peminjaman aktif
    $peminjaman->delete();

    return redirect()
        ->route('pengembalian.index')
        ->with('success', 'Minuta berhasil dikembalikan dan status telah diperbarui.');
}

public function export(Request $request)
{
    return Excel::download(

        new PengembalianExport(

            $request->search,

            $request->tahun_awal,

            $request->tahun_akhir

        ),

        'Data_Pengembalian_Minuta.xlsx'

    );
}
}