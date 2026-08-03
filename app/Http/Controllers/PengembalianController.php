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
    /**
     * Menampilkan daftar riwayat pengembalian
     */
    public function index(Request $request)
    {
        $query = Pengembalian::with('minuta');

        // ==========================
        // PENCARIAN
        // ==========================
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

        // ==========================
        // FILTER TAHUN
        // ==========================
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

    /**
 * Form tambah pengembalian
 */
public function create()
{
    $peminjaman = Peminjaman::with('minuta')
                    ->orderBy('tanggal_pinjam', 'asc')
                    ->get();

    foreach ($peminjaman as $item) {

    $item->umur_pinjam = \Carbon\Carbon::parse($item->tanggal_pinjam)
                        ->diffInDays(now());

}

    return view('pengembalian.create', compact('peminjaman'));
}

    /**
     * Simpan pengembalian
     */
    /**
 * Simpan pengembalian
 */
public function store(Request $request)
{
    // ==========================
    // Validasi
    // ==========================
    $request->validate([
        'minuta_id' => 'required|exists:minuta,id',
        'nama_pengembali' => 'required|string|max:255',
        'divisi_pengembali' => 'required|string|max:255',
    ]);

    // ==========================
    // Ambil data minuta
    // ==========================
    $minuta = Minuta::findOrFail($request->minuta_id);

    // ==========================
    // Simpan ke tabel pengembalian
    // ==========================
    Pengembalian::create([
        'minuta_id' => $minuta->id,
        'nama_pengembali' => $request->nama_pengembali,
        'divisi_pengembali' => $request->divisi_pengembali,
        'tanggal_kembali' => now(),
    ]);

    // ==========================
    // Kembalikan status minuta
    // ==========================
    $minuta->update([
        'dipinjam' => false,
    ]);

    // ==========================
    // Hapus dari tabel peminjaman
    // ==========================
    Peminjaman::where('minuta_id', $minuta->id)->delete();

    // ==========================
    // Redirect
    // ==========================
    return redirect()
            ->route('pengembalian.index')
            ->with('success', 'Minuta berhasil dikembalikan.');
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