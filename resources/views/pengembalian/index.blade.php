@extends('layouts.app')

@section('title','Riwayat Pengembalian Minuta')

@section('content')

<style>

.page-title{
    margin-bottom:25px;
    color:#003b71;
}

/* ================= FILTER ================= */

.filter-box{
    background:#f8fbff;
    border:1px solid #d9e3ef;
    border-radius:10px;
    padding:20px;
    margin-bottom:25px;
}

.filter-container{
    display:flex;
    justify-content:space-between;
    align-items:flex-end;
    gap:20px;
    flex-wrap:wrap;
}

.filter-left{
    display:flex;
    flex-wrap:wrap;
    gap:20px;
    align-items:flex-end;
}

.form-group label{
    display:block;
    margin-bottom:6px;
    font-weight:600;
    color:#444;
}

.form-group input{
    min-width:220px;
}

.tahun-group{
    display:flex;
    align-items:center;
    gap:10px;
}

.tahun-group input{
    width:90px;
}

.button-group{
    display:flex;
    gap:10px;
}

.table-container{
    overflow-x:auto;
}

.action{
    display:flex;
    justify-content:center;
    gap:8px;
}

.action .btn{
    padding:6px 12px;
    font-size:13px;
}

.btn-export{

    display:inline-flex;

    justify-content:center;

    align-items:center;

    width:150px;

    height:46px;

    background:linear-gradient(135deg,#198754,#2eb85c);

    color:#fff;

    border:none;

    border-radius:8px;

    text-decoration:none;

    font-size:14px;

    font-weight:600;

    transition:.25s;

}

.btn-export:hover{

    background:linear-gradient(135deg,#157347,#23914a);

    color:#fff;

}

.action-button .btn-primary{

    width:220px;

    height:46px;

    display:inline-flex;

    justify-content:center;

    align-items:center;

    font-weight:600;

}

</style>

<h2 class="page-title">
    Riwayat Pengembalian Minuta
</h2>

@if(session('error'))

<script>

document.addEventListener('DOMContentLoaded',function(){

    Swal.fire({

        icon:'error',

        title:'Gagal',

        text:"{{ session('error') }}"

    });

});

</script>

@endif

<div class="filter-box">

<form action="{{ route('pengembalian.index') }}" method="GET">

<div class="filter-container">

<div class="filter-left">

<div class="form-group">

<label>Pencarian</label>

<input
type="text"
name="search"
class="search-input"
placeholder="Cari data..."
value="{{ request('search') }}">

</div>

<div class="form-group">

<label>Filter Tahun</label>

<div class="tahun-group">

<input
type="number"
name="tahun_awal"
class="search-input"
value="{{ request('tahun_awal') }}"
min="1000"
max="3000">

<span>s/d</span>

<input
type="number"
name="tahun_akhir"
class="search-input"
value="{{ request('tahun_akhir') }}"
min="1000"
max="3000">

</div>

</div>

<div class="button-group">

<button
type="submit"
class="btn btn-primary">

Cari

</button>

<a
href="{{ route('pengembalian.index') }}"
class="btn btn-secondary">

Reset

</a>

</div>

</div> {{-- tutup filter-left --}}

<div style="display:flex; justify-content:flex-end; gap:8px;">

    <a href="{{ route('pengembalian.export', request()->query()) }}"
       class="btn btn-export">
        Export Excel
    </a>

    <a href="{{ route('pengembalian.create') }}"
   class="btn btn-primary">
    Tambah Pengembalian
</a>

</div>

</div> {{-- tutup filter-container --}}

</form>

</div>

<div class="table-container">

<table>

<thead>

<tr>

<th>No</th>

<th>Nama Pengembali</th>

<th>Seksi</th>

<th>Tahun</th>

<th>Lokasi</th>

<th>Nomor Risalah</th>

<th>Tanggal</th>

<th>Pemohon</th>

<th>Debitur</th>

<th>Objek</th>

<th>Jenis</th>

<th>Pejabat</th>

<th>Tanggal Kembali</th>

</tr>

</thead>

<tbody>

@forelse($pengembalian as $item)

<tr>

<td>

{{ ($pengembalian->currentPage()-1) * $pengembalian->perPage() + $loop->iteration }}

</td>

<td>{{ $item->nama_pengembali }}</td>

<td>{{ $item->divisi_pengembali }}</td>

<td>{{ optional($item->minuta)->tahun_risalah }}</td>

<td>{{ optional($item->minuta)->lokasi }}</td>

<td>{{ optional($item->minuta)->nomor_risalah }}</td>

<td>

{{ \Carbon\Carbon::parse(optional($item->minuta)->tanggal_risalah)->format('d-m-Y') }}

</td>

<td>{{ optional($item->minuta)->pemohon_lelang }}</td>

<td>

    {{ \Illuminate\Support\Str::limit($item->minuta->nama_debitur,50,'...') }}

</td>

<td>

{{ \Illuminate\Support\Str::limit($item->minuta->objek,50,'...') }}

</td>

<td>{{ optional($item->minuta)->jenis_lelang }}</td>

<td>{{ optional($item->minuta)->pejabat_lelang }}</td>

<td>

{{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d-m-Y') }}


</td>

</tr>

@empty

<tr>

<td colspan="14" style="text-align:center;">

Belum ada data pengembalian.  

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

<div style="margin-top:20px; display:flex; justify-content:flex-end;">

    {{ $pengembalian->links() }}

</div>
@endsection