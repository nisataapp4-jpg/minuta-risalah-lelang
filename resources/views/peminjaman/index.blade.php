@extends('layouts.app')

@section('title','Data Peminjaman Minuta')

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

.action-button{
    display:flex;
    justify-content:flex-end;
    align-items:center;
    gap:8px;
    margin-left:auto;
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
    border-radius:6px;
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

/* ================= INDIKATOR STATUS PEMINJAMAN ================= */

.status-hijau,
.status-merah{
    display:inline-block;
    width:14px;
    height:14px;
    border-radius:50%;
    vertical-align:middle;
    margin-right:6px;
}

.status-hijau{
    background:#28a745;
    box-shadow:0 0 6px rgba(40, 167, 69, 0.4);
}

.status-merah{
    background:#dc3545;
    box-shadow:0 0 6px rgba(220, 53, 69, 0.4);
}

</style>

<h2 class="page-title">
    Data Peminjaman Minuta
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

    <form action="{{ route('peminjaman.index') }}" method="GET">

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
                        href="{{ route('peminjaman.index') }}"
                        class="btn btn-secondary">

                        Reset

                    </a>

                </div>

            </div>

            <div class="action-button">

                <a
                    href="{{ route('peminjaman.export', request()->query()) }}"
                    class="btn-export">

                    Export Excel

                </a>

                <a
                    href="{{ route('peminjaman.create') }}"
                    class="btn btn-primary">

                    Tambah Peminjaman

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
                <th>Nama Peminjam</th>
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
                <th>Tanggal Pinjam</th>
                <th>Status (Umur Pinjam)</th>

            </tr>

        </thead>

        <tbody>

        @forelse($peminjaman as $item)

            <tr>

                <td>
                    {{ ($peminjaman->currentPage()-1) * $peminjaman->perPage() + $loop->iteration }}
                </td>

                <td>{{ $item->nama_peminjam }}</td>
                <td>{{ $item->divisi_peminjam }}</td>
                <td>{{ optional($item->minuta)->tahun_risalah }}</td>
                <td>{{ optional($item->minuta)->lokasi }}</td>
                <td>{{ optional($item->minuta)->nomor_risalah }}</td>
                <td>
                    {{ \Carbon\Carbon::parse(optional($item->minuta)->tanggal_risalah)->format('d-m-Y') }}
                </td>
                <td>{{ optional($item->minuta)->pemohon_lelang }}</td>
                <td>
                    {{ \Illuminate\Support\Str::limit(optional($item->minuta)->nama_debitur, 50, '...') }}
                </td>
                <td>
                    {{ \Illuminate\Support\Str::limit(optional($item->minuta)->objek, 50, '...') }}
                </td>
                <td>{{ optional($item->minuta)->jenis_lelang }}</td>
                <td>{{ optional($item->minuta)->pejabat_lelang }}</td>
                <td>
                    {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d-m-Y') }}
                </td>

                <!-- Indikator Status & Umur Pinjam -->
                <td style="text-align: center; white-space: nowrap;">
                    @if($item->umur_pinjam >= 7)
                        <span class="status-merah" title="Mendekati / Memasuki Batas Pengembalian"></span>
                        <span style="color: #dc3545; font-weight: 600;">{{ $item->umur_pinjam }} Hari</span>
                    @else
                        <span class="status-hijau" title="Masa Pinjam Aman"></span>
                        <span style="color: #28a745; font-weight: 600;">{{ $item->umur_pinjam }} Hari</span>
                    @endif
                </td>

            </tr>

        @empty

            <tr>

                <td colspan="14" style="text-align:center;">
                    Belum ada data peminjaman.
                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

</div>

<div style="margin-top:20px; display:flex; justify-content:flex-end;">
    {{ $peminjaman->links() }}
</div>

@endsection