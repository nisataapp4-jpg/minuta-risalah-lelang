@extends('layouts.app')

@section('title','Tambah Pengembalian Minuta')

@section('content')

<style>

.form-container{

    max-width:900px;

    margin:auto;

}

.page-title{

    color:#003b71;

    margin-bottom:30px;

}

.form-card{

    background:white;

    border:1px solid #dbe4ee;

    border-radius:12px;

    padding:30px;

    box-shadow:0 2px 10px rgba(0,0,0,.08);

}

.form-group{

    margin-bottom:22px;

}

.form-group label{

    display:block;

    font-weight:600;

    margin-bottom:8px;

    color:#374151;

}

.info-minuta{

    background:#f8fafc;

    border:1px dashed #b6c3d1;

    border-radius:8px;

    padding:18px;

    color:#6b7280;

    min-height:80px;

}

.button-area{

    margin-top:30px;

    display:flex;

    gap:12px;

}

/* ================= MODAL ================= */

.modal{

    display:none;

    position:fixed;

    z-index:9999;

    left:0;

    top:0;

    width:100%;

    height:100%;

    overflow:auto;

    background:rgba(0,0,0,.45);

}

.modal-content{

    background:white;

    width:98%;

    max-width:95vw;

    margin:20px auto;

    border-radius:12px;

    overflow:auto;

    max-height:95vh;

    animation:fadeIn .25s;

}

@keyframes fadeIn{

    from{

        opacity:0;

        transform:translateY(-20px);

    }

    to{

        opacity:1;

        transform:translateY(0);

    }

}

.modal-header{

    background:#005AA9;

    color:white;

    padding:18px 24px;

    display:flex;

    justify-content:space-between;

    align-items:center;

}

.modal-header h3{

    margin:0;

    font-size:22px;

}

.close-modal{

    font-size:32px;

    cursor:pointer;

    font-weight:bold;

}

.modal-body{

    padding:25px;

}

.modal-search{

    width:100%;

    margin-bottom:20px;

}

.modal-table{

    width:100%;

    border-collapse:collapse;

}

.modal-table thead{

    background:#005AA9;

    color:white;

}

.modal-table th{

    padding:10px;

    font-size:14px;

    text-align:center;

}

.modal-table td{

    padding:10px;

    text-align:center;

    border-bottom:1px solid #e5e7eb;

}

.modal-table tbody tr:hover{

    background:#f5f9ff;

}

</style>

<div class="form-container">

<h2 class="page-title">

Tambah Pengembalian Minuta

</h2>

<form action="{{ route('pengembalian.store') }}" method="POST">

@csrf

<div class="form-card">

<div class="form-group">

<label>Nama Pengembali</label>

<input
type="text"
name="nama_pengembali"
value="{{ old('nama_pengembali') }}"
required>

</div>

<div class="form-group">

<label>Seksi Pengembali</label>

<input
type="text"
name="divisi_pengembali"
value="{{ old('divisi_pengembali') }}"
required>

</div>

<div class="form-group">

<label>Minuta yang Dikembalikan</label>

<button
type="button"
class="btn btn-primary"
id="btnPilihMinuta">

Pilih Minuta

</button>

</div>

<input
type="hidden"
name="minuta_id"
id="minuta_id">

<div
class="info-minuta"
id="detailMinuta">

Belum ada minuta yang dipilih.

</div>

<div class="button-area">

<button
type="submit"
class="btn btn-success">

Simpan

</button>

<a
href="{{ route('pengembalian.index') }}"
class="btn btn-secondary">

Kembali

</a>

</div>

</div>

</form>

</div>

{{-- ================= MODAL PILIH MINUTA ================= --}}

<div id="modalMinuta" class="modal">

    <div class="modal-content">

        <div class="modal-header">

            <h3>Pilih Minuta Yang Dikembalikan</h3>

            <span class="close-modal">&times;</span>

        </div>

<div class="modal-body">

    <input
        type="text"
        id="searchMinuta"
        class="modal-search search-input"
        placeholder="Cari nama peminjam, nomor risalah, debitur, pemohon...">

    <div style="overflow-x:auto;">

        <table class="modal-table">

            <thead>

                <tr>

                    <th>No</th>
                    <th>Nama Peminjam</th>
                    <th>Seksi</th>
                    <th>Tahun</th>
                    <th>Lokasi</th>
                    <th>No. Risalah</th>
                    <th>Tanggal</th>
                    <th>Pemohon</th>
                    <th>Debitur</th>
                    <th>Objek</th>
                    <th>Jenis</th>
                    <th>Pejabat</th>
                    <th>Tanggal Pinjam</th>
                    <th>Status</th>
                    <th>Aksi</th>

                </tr>

            </thead>

            <tbody>

            @forelse($peminjaman as $item)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $item->nama_peminjam }}</td>

                        <td>{{ $item->seksi_peminjam }}</td>

                        <td>{{ $item->minuta->tahun_risalah }}</td>

                        <td>{{ $item->minuta->lokasi }}</td>

                        <td>{{ $item->minuta->nomor_risalah }}</td>

                        <td>{{ \Carbon\Carbon::parse($item->minuta->tanggal_risalah)->format('d-m-Y') }}</td>

                        <td>{{ $item->minuta->pemohon_lelang }}</td>

                        <td>

                            {{ \Illuminate\Support\Str::limit($item->minuta->nama_debitur,50,'...') }}

                        </td>

                        <td>

                            {{ \Illuminate\Support\Str::limit($item->minuta->objek,50,'...') }}

                        </td>

                        <td>{{ $item->minuta->jenis_lelang }}</td>

                        <td>{{ $item->minuta->pejabat_lelang }}</td>

                        <td>

                            {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d-m-Y') }}

                        </td>

<td style="text-align:center; vertical-align:middle;">

    @if($item->umur_pinjam >= 7)

        <span class="status-merah"></span>

    @else

        <span class="status-hijau"></span>

    @endif

</td>

                        <td>

                            <button
                                type="button"
                                class="btn btn-primary pilih-minuta"

                                data-id="{{ $item->minuta->id }}"

                                data-tahun="{{ $item->minuta->tahun_risalah }}"

                                data-lokasi="{{ $item->minuta->lokasi }}"

                                data-risalah="{{ $item->minuta->nomor_risalah }}"

                                data-tanggal="{{ \Carbon\Carbon::parse($item->minuta->tanggal_risalah)->format('d-m-Y') }}"

                                data-pemohon="{{ $item->minuta->pemohon_lelang }}"

                                data-debitur="{{ $item->minuta->nama_debitur }}"

                                data-objek="{{ $item->minuta->objek }}"

                                data-jenis="{{ $item->minuta->jenis_lelang }}"

                                data-pejabat="{{ $item->minuta->pejabat_lelang }}">

                                Pilih

                            </button>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="15">

                            Tidak ada minuta yang sedang dipinjam.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

<script>

const modal = document.getElementById('modalMinuta');

const btnPilih = document.getElementById('btnPilihMinuta');

const closeModal = document.querySelector('.close-modal');

const inputMinuta = document.getElementById('minuta_id');

const detailMinuta = document.getElementById('detailMinuta');


// ===============================
// BUKA MODAL
// ===============================

btnPilih.addEventListener('click', function(){

    modal.style.display = 'block';

});


// ===============================
// TUTUP MODAL
// ===============================

closeModal.addEventListener('click', function(){

    modal.style.display = 'none';

});

window.addEventListener('click', function(e){

    if(e.target == modal){

        modal.style.display = 'none';

    }

});


// ===============================
// PILIH MINUTA
// ===============================

document.querySelectorAll('.pilih-minuta').forEach(function(button){

    button.addEventListener('click', function(){

        inputMinuta.value = this.dataset.id;

detailMinuta.innerHTML = `

<table style="width:100%;border-collapse:collapse;">

    <tr>
        <td style="width:180px;"><b>Tahun Risalah</b></td>
        <td>${this.dataset.tahun}</td>
    </tr>

    <tr>
        <td><b>Lokasi</b></td>
        <td>${this.dataset.lokasi}</td>
    </tr>

    <tr>
        <td><b>Nomor Risalah</b></td>
        <td>${this.dataset.risalah}</td>
    </tr>

    <tr>
        <td><b>Tanggal Risalah</b></td>
        <td>${this.dataset.tanggal}</td>
    </tr>

    <tr>
        <td><b>Pemohon</b></td>
        <td>${this.dataset.pemohon}</td>
    </tr>

    <tr>
        <td><b>Debitur</b></td>
        <td>${this.dataset.debitur}</td>
    </tr>

    <tr>
        <td style="vertical-align:top;"><b>Objek</b></td>

        <td style="
            white-space:normal;
            word-break:break-word;
            overflow-wrap:anywhere;
            max-width:650px;
        ">

            ${this.dataset.objek}

        </td>
    </tr>

    <tr>
        <td><b>Jenis Lelang</b></td>
        <td>${this.dataset.jenis}</td>
    </tr>

    <tr>
        <td><b>Pejabat Lelang</b></td>
        <td>${this.dataset.pejabat}</td>
    </tr>

</table>

`;

        modal.style.display = 'none';

    });

});


// ===============================
// SEARCH MODAL
// ===============================

const searchInput = document.getElementById('searchMinuta');

searchInput.addEventListener('keyup', function(){

    const keyword = this.value.toLowerCase();

    document.querySelectorAll('.modal-table tbody tr').forEach(function(row){

        const text = row.innerText.toLowerCase();

        row.style.display = text.includes(keyword) ? '' : 'none';

    });

});

</script>

@endsection