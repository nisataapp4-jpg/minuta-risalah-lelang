<?php

namespace App\Http\Controllers;

use App\Models\Minuta;
use Illuminate\Http\Request;
use App\Exports\MinutaExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\Rule;

class MinutaController extends Controller
{
    /**
     * Menampilkan seluruh data minuta
     */
public function index(Request $request)
{
     $query = Minuta::where('dipinjam', false);

    if($request->filled('search'))
    {
        $search = $request->search;

        $query->where(function($q) use ($search){

            $q->where('tahun_risalah','like',"%$search%")
            ->orWhere('nomor_risalah','like',"%$search%")
            ->orWhere('tanggal_risalah','like',"%$search%")
            ->orWhere('pemohon_lelang','like',"%$search%")
            ->orWhere('nama_debitur','like',"%$search%")
            ->orWhere('objek', 'like', "%$search%")
            ->orWhere('lokasi_gudang','like',"%$search%")
            ->orWhere('lokasi_lemari','like',"%$search%")
            ->orWhere('jenis_lelang','like',"%$search%")
            ->orWhere('pejabat_lelang','like',"%$search%");
        });
    }

    if($request->filled('tahun_awal') && $request->filled('tahun_akhir'))
    {
        $query->whereBetween('tahun_risalah',[
            $request->tahun_awal,
            $request->tahun_akhir
        ]);
    }

    $minuta = $query
    ->orderBy('tahun_risalah', 'asc')
    ->orderByRaw("
        CAST(
            SUBSTRING_INDEX(nomor_risalah, '/', 1)
        AS UNSIGNED)
    ")
    ->paginate(10);
    return view('minuta.index', compact('minuta'));
}

    /**
     * Menampilkan form tambah minuta
     */
    public function create()
    {
        return view('minuta.create');
    }

    /**
     * Menyimpan data minuta
     */
    public function store(Request $request)
{
    $request->validate([
        'tahun_risalah' => 'required',
        'nomor_risalah' => 'required|unique:minuta,nomor_risalah',
        'tanggal_risalah' => 'required',
        'pemohon_lelang' => 'required',
        'nama_debitur' => 'required',
        'objek' => 'nullable',
        'jenis_lelang' => 'nullable',
        'pejabat_lelang' => 'required',
        'lokasi_gudang' => 'nullable',
        'lokasi_lemari' => 'nullable',
    ],
    ['nomor_risalah.unique'=>'Nomor risalah sudah pernah terdaftar.',
    ]);

    Minuta::create($request->all());

    return redirect()->route('minuta.index')
            ->with('success','Data minuta berhasil ditambahkan.');
}

    /**
     * Detail minuta
     */
    public function show(Minuta $minutum)
    {
        return view('minuta.show', [
            'minuta' => $minutum
        ]);
    }

    /**
     * Form edit
     */
    public function edit(Minuta $minutum)
    {
        return view('minuta.edit', [
            'minuta' => $minutum
        ]);
    }

    /**
     * Update data
     */
    public function update(Request $request, Minuta $minutum)
    {
        $request->validate([
            'tahun_risalah'   => 'required',
            'nomor_risalah' => [
    'required',
    Rule::unique('minuta', 'nomor_risalah')->ignore($minutum->id),
],
            'tanggal_risalah' => 'required',
            'pemohon_lelang'  => 'required',
            'nama_debitur'    => 'required',
            'objek' => 'nullable',
            'jenis_lelang'    => 'nullable',
            'pejabat_lelang'  => 'required',
            'lokasi_gudang' => 'nullable',
            'lokasi_lemari' => 'nullable',
        ],
    ['nomor_risalah.unique'=>'Nomor risalah sudah pernah terdaftar.',
    ]);

        $minutum->update($request->all());

        return redirect()
                ->route('minuta.index')
                ->with('success', 'Data minuta berhasil diubah.');
    }

    /**
     * Hapus data
     */
    public function destroy(Minuta $minutum)
    {
        $minutum->delete();

        return redirect()
                ->route('minuta.index')
                ->with('success', 'Data minuta berhasil dihapus.');
    }

    public function export(Request $request)
{
    return Excel::download(

        new MinutaExport(

            $request->search,

            $request->tahun_awal,

            $request->tahun_akhir

        ),

        'Data Minuta.xlsx'

    );
}
}