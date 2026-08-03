<?php

namespace App\Http\Controllers;

use App\Models\Minuta;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
{

    $tahun = $request->tahun;

    $queryMinuta = Minuta::query();

    $queryDipinjam = Peminjaman::with('minuta');

    if($tahun && $tahun != 'semua')
    {

        $queryMinuta->where('tahun_risalah',$tahun);

        $queryDipinjam->whereHas('minuta',function($q) use($tahun){

            $q->where('tahun_risalah',$tahun);

        });

    }

    $minutaDiPetugas = (clone $queryMinuta)
                        ->where('dipinjam',false)
                        ->count();

    $minutaDipinjam = (clone $queryDipinjam)
                        ->count();

    $minutaKPKNL = $minutaDiPetugas + $minutaDipinjam;

    $tahunList = Minuta::select('tahun_risalah')
                    ->distinct()
                    ->orderBy('tahun_risalah','desc')
                    ->pluck('tahun_risalah');

    return view('dashboard.index',compact(

        'minutaKPKNL',

        'minutaDiPetugas',

        'minutaDipinjam',

        'tahun',

        'tahunList'

    ));

}
}