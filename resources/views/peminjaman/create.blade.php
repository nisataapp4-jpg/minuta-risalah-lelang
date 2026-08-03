@extends('layouts.app')

@section('title','Tambah Peminjaman Minuta')

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

    max-width:1700px;

    margin:20px auto;

    border-radius:12px;

    overflow-x:auto;

    overflow-y:auto;

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

    table-layout:fixed;

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

    vertical-align:middle;

    word-break:break-word;

}

.modal-table tbody tr:hover{

    background:#f5f9ff;

}

</style>

<div class="form-container">

<h2 class="page-title">

Tambah Peminjaman Minuta

</h2>

<form action="{{ route('peminjaman.store') }}" method="POST">

@csrf

<div class="form-card">

<div class="form-group">

<label>Nama Peminjam</label>

<input
type="text"
name="nama_peminjam"
value="{{ old('nama_peminjam') }}"
required>

</div>

<div class="form-group">

<label>Seksi Peminjam</label>

<input
type="text"
name="divisi_peminjam"
value="{{ old('divisi_peminjam') }}"
required>

</div>

<div class="form-group">

<label>Minuta yang Dipinjam</label>

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
href="{{ route('peminjaman.index') }}"
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

            <h3>Pilih Minuta Risalah Lelang</h3>

            <span class="close-modal">&times;</span>

        </div>

        <div class="modal-body">

            <input
                type="text"
                id="searchMinuta"
                placeholder="Cari nomor risalah, debitur, pemohon..."
                class="modal-search search-input"

            <div style="overflow-x:auto;">

    <table class="modal-table">

        <thead>
<tr>

    <th style="width:50px;">No</th>

    <th style="width:70px;">Tahun</th>

    <th style="width:170px;">Lokasi</th>

    <th style="width:150px;">Nomor Risalah</th>

    <th style="width:110px;">Tanggal</th>

    <th style="width:230px;">Pemohon</th>

    <th style="width:180px;">Debitur</th>

    <th style="width:200px;">Objek</th>

    <th style="width:140px;">Jenis</th>

    <th style="width:160px;">Pejabat</th>

    <th style="width:100px;">Aksi</th>

</tr>
</thead>
        <tbody>

        @foreach($minuta as $item)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $item->tahun_risalah }}</td>

                        <td>{{ $item->lokasi }}</td>

                        <td>{{ $item->nomor_risalah }}</td>

                        <td>{{ \Carbon\Carbon::parse($item->tanggal_risalah)->format('d-m-Y') }}</td>

                        <td>{{ $item->pemohon_lelang }}</td>

                        <td>

                            {{ \Illuminate\Support\Str::limit($item->nama_debitur,50,'...') }}

                        </td>

                        <td>

                            {{ \Illuminate\Support\Str::limit($item->objek,50,'...') }}

                        </td>

                        <td>{{ $item->jenis_lelang }}</td>

                        <td>{{ $item->pejabat_lelang }}</td>

                        <td style="width:100px;">

                            <button
                                type="button"
                                class="btn btn-primary pilih-minuta"
                                data-id="{{ $item->id }}"
                                data-tahun="{{ $item->tahun_risalah }}"
                                data-lokasi="{{ $item->lokasi }}"
                                data-risalah="{{ $item->nomor_risalah }}"
                                data-tanggal="{{ \Carbon\Carbon::parse($item->tanggal_risalah)->format('d-m-Y') }}"
                                data-pemohon="{{ $item->pemohon_lelang }}"
                                data-debitur="{{ $item->nama_debitur }}"
                                data-objek="{{ $item->objek }}"
                                data-jenis="{{ $item->jenis_lelang }}"
                                data-pejabat="{{ $item->pejabat_lelang }}">

                                Pilih

                            </button>

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

<script>

// ============================
// Ambil Elemen
// ============================

const modal = document.getElementById('modalMinuta');

const btnOpen = document.getElementById('btnPilihMinuta');

const btnClose = document.querySelector('.close-modal');

const inputMinuta = document.getElementById('minuta_id');

const detailMinuta = document.getElementById('detailMinuta');


// ============================
// Buka Modal
// ============================

btnOpen.addEventListener('click', function(){

    modal.style.display = 'block';

});


// ============================
// Tutup Modal
// ============================

btnClose.addEventListener('click', function(){

    modal.style.display = 'none';

});


// ============================
// Klik luar modal
// ============================

window.addEventListener('click', function(e){

    if(e.target == modal){

        modal.style.display = 'none';

    }

});


// ============================
// Tombol Pilih
// ============================

document.querySelectorAll('.pilih-minuta').forEach(function(button){

    button.addEventListener('click', function(){

        inputMinuta.value = this.dataset.id;

        detailMinuta.innerHTML = `

        <table style="width:100%;border-collapse:collapse;">

            <tr>

                <td><b>Tahun</b></td>
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

                <td><b>Tanggal</b></td>
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

    <td><b>Objek</b></td>

    <td style="
        white-space: normal;
        word-break: break-word;
        overflow-wrap: anywhere;
        max-width:700px;
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

// ============================
// Pencarian Modal
// ============================

const searchInput = document.getElementById('searchMinuta');

searchInput.addEventListener('keyup', function(){

    let keyword = this.value.toLowerCase();

    let rows = document.querySelectorAll('.modal-table tbody tr');

    rows.forEach(function(row){

        let text = row.textContent.toLowerCase();

        // Ambil objek lengkap dari tombol Pilih
        let button = row.querySelector('.pilih-minuta');

        let objek = '';

        if(button){

            objek = (button.dataset.objek || '').toLowerCase();

        }

        // Gabungkan teks tabel + objek lengkap
        let gabungan = text + ' ' + objek;

        if(gabungan.includes(keyword)){

            row.style.display = '';

        }else{

            row.style.display = 'none';

        }

    });

});


</script>

@endsection