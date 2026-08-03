<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Minuta;
use Carbon\Carbon;
use App\Exports\PeminjamanExport;
use Maatwebsite\Excel\Facades\Excel;

class PeminjamanController extends Controller
{
    /**
     * Menampilkan daftar peminjaman
     */
    public function index(Request $request)
    {
        $query = Peminjaman::with('minuta');

        // Pencarian
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

    // Data peminjaman
    $q->where('nama_peminjam', 'like', "%{$search}%")
      ->orWhere('divisi_peminjam', 'like', "%{$search}%")

      // Data minuta
      ->orWhereHas('minuta', function ($m) use ($search) {

            $m->where('tahun_risalah', 'like', "%{$search}%")
              ->orWhere('nomor_risalah', 'like', "%{$search}%")
              ->orWhere('tanggal_risalah', 'like', "%{$search}%")
              ->orWhere('pemohon_lelang', 'like', "%{$search}%")
              ->orWhere('nama_debitur', 'like', "%{$search}%")
              ->orWhere('objek', 'like', "%$search%")
              ->orWhere('lokasi_gudang', 'like', "%{$search}%")
              ->orWhere('lokasi_lemari', 'like', "%{$search}%")
              ->orWhere('jenis_lelang', 'like', "%{$search}%")
              ->orWhere('pejabat_lelang', 'like', "%{$search}%");

      });

});

        }

        // Filter Tahun
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

       $peminjaman = $query
    ->orderBy('tanggal_pinjam', 'asc')
    ->paginate(10);

$peminjaman->appends($request->query());

foreach ($peminjaman as $item) {

    $item->umur_pinjam = Carbon::parse($item->tanggal_pinjam)
                                ->diffInDays(now());

}

return view('peminjaman.index', compact('peminjaman'));
    }

    /**
     * Form tambah peminjaman
     */
    public function create()
{
    $minuta = Minuta::whereNotIn(
        'id',
        Peminjaman::pluck('minuta_id')
    )
    ->orderBy('tahun_risalah', 'asc')
    ->orderByRaw("
        CAST(
            SUBSTRING_INDEX(nomor_risalah, '/', 1)
        AS UNSIGNED)
    ")
    ->get();

    return view('peminjaman.create', [
        'minuta' => $minuta
    ]);
}

    /**
 * Menyimpan data peminjaman
 */
/**
 * Simpan peminjaman
 */
public function store(Request $request)
{
    $request->validate([
        'nama_peminjam'   => 'required|string|max:255',
        'divisi_peminjam' => 'required|string|max:255',
        'minuta_id'       => 'required|exists:minuta,id',
    ]);

    // Ambil data minuta
    $minuta = Minuta::findOrFail($request->minuta_id);

    // Cek apakah minuta masih tersedia
    if ($minuta->dipinjam) {

        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Minuta tersebut sedang dipinjam.');

    }

    // Simpan data peminjaman
    Peminjaman::create([

        'minuta_id'       => $minuta->id,
        'nama_peminjam'   => $request->nama_peminjam,
        'divisi_peminjam' => $request->divisi_peminjam,
        'tanggal_pinjam'  => now(),

    ]);

    // Ubah status minuta menjadi dipinjam
    $minuta->update([
        'dipinjam' => true
    ]);

    return redirect()
        ->route('peminjaman.index')
        ->with('success', 'Peminjaman minuta berhasil disimpan.');
}

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    public function export(Request $request)
{
    return Excel::download(

        new PeminjamanExport(

            $request->search,

            $request->tahun_awal,

            $request->tahun_akhir

        ),

        'Data Peminjaman Minuta.xlsx'

    );
}
}