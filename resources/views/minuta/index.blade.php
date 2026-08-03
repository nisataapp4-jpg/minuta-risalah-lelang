@extends('layouts.app')

@section('title','Data Minuta Risalah Lelang')

@section('content')

<style>

.pagination-wrapper{

    display:flex;

    justify-content:flex-end;

    margin-top:25px;

}

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

/* ================= BUTTON ================= */

.btn{
    border:none;
    border-radius:8px;
    padding:10px 16px;
    cursor:pointer;
    font-weight:600;
    text-decoration:none;
    display:inline-block;
    transition:.2s;
}

.btn-primary{
    background:#005AA9;
    color:white;
}

.btn-primary:hover{
    background:#004b8d;
}

.btn-success{
    background:#0B63CE;
    color:white;
}

.btn-success:hover{
    background:#004b8d;
}

.btn-warning{
    background:#FFC107;
    color:#222;
}

.btn-danger{
    background:#DC3545;
    color:white;
}

.btn-secondary{
    background:#6C757D;
    color:white;
}

.btn-export{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    min-width:145px;

    height:46px;

    padding:0 18px;

    background:linear-gradient(135deg,#198754,#2eb85c);

    color:#fff;

    border:none;

    border-radius:8px;

    text-decoration:none;

    font-size:14px;

    font-weight:600;

    transition:.25s;

    box-sizing:border-box;

}

.btn-export:hover{

    background:linear-gradient(135deg,#157347,#23914a);

    color:#fff;

    transform:translateY(-2px);

    box-shadow:0 6px 12px rgba(25,135,84,.25);

}
/* ================= TABLE ================= */

.table-container{
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse:collapse;
}

thead{
    background:#005AA9;
    color:white;
}

th{
    padding:12px;
    font-size:14px;
}

td{
    padding:10px;
    border-bottom:1px solid #e5e7eb;
    text-align:center;
}

tbody tr:hover{
    background:#f5f9ff;
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

/* ================= PAGINATION ================= */

.pagination{
    justify-content:flex-end;
    margin-top:20px;
}

</style>

<h2 class="page-title">Data Minuta Risalah Lelang</h2>

<div class="filter-box">

<form action="{{ route('minuta.index') }}" method="GET">

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

<button type="submit" class="btn btn-primary">
Cari
</button>

<a href="{{ route('minuta.index') }}" class="btn btn-secondary">
Reset
</a>

</div>

</div>

<div style="display:flex; justify-content:flex-end; gap:8px;">

    <a href="{{ route('minuta.export', request()->query()) }}" class="btn btn-export">
    Export Excel
</a>

    <a href="{{ route('minuta.create') }}" class="btn btn-primary">
        Tambah Minuta
    </a>

</div>

</div>

</form>

</div>

<div class="table-container">

<table>

<thead>

<tr>

<th>No</th>
<th>Tahun</th>
<th>Lokasi</th>
<th>Nomor Risalah</th>
<th>Tanggal</th>
<th>Pemohon</th>
<th>Debitur</th>
<th>Objek</th>
<th>Jenis</th>
<th>Pejabat</th>
<th width="130">Aksi</th>

</tr>

</thead>

<tbody>

@forelse($minuta as $item)

<tr>

<td>{{ ($minuta->currentPage()-1)*$minuta->perPage()+$loop->iteration }}</td>

<td>{{ $item->tahun_risalah }}</td>

<td>{{ $item->lokasi }}</td>

<td>{{ $item->nomor_risalah }}</td>

<td>{{ \Carbon\Carbon::parse($item->tanggal_risalah)->format('d-m-Y') }}</td>

<td>{{ $item->pemohon_lelang }}</td>

<td>
    {{ \Illuminate\Support\Str::limit($item->nama_debitur, 50, '...') }}
</td>

<td>
    {{ \Illuminate\Support\Str::limit($item->objek, 50, '...') }}
</td>

<td>{{ $item->jenis_lelang }}</td>

<td>{{ $item->pejabat_lelang }}</td>

<td>

<div class="action">

<a href="{{ route('minuta.edit',$item->id) }}" class="btn btn-warning">
Edit
</a>

<form action="{{ route('minuta.destroy',$item->id) }}"
      method="POST"
      class="delete-form"
      style="display:inline;">

@csrf
@method('DELETE')

<button type="submit" class="btn btn-danger">
Hapus
</button>

</form>

</div>

</td>

</tr>

@empty

<tr>

<td colspan="13">

Belum ada data minuta.

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

<div class="pagination-wrapper">

    {{ $minuta->links() }}

</div>

@endsection