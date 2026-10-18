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

.status-hijau, .status-merah {
    display: inline-block;
    width: 12px;
    height: 12px;
    border-radius: 50%;
}
.status-hijau { background-color: #28a745; }
.status-merah { background-color: #dc3545; }
</style>

<div class="form-container">

    <h2 class="page-title">Tambah Pengembalian Minuta</h2>

    <form action="{{ route('pengembalian.store') }}" method="POST">
        @csrf

<div class="form-card">

    <div class="form-group">
        <label>Nama Pengembali</label>
        <input
            type="text"
            name="nama_pengembali"
            class="form-control search-input"
            value="{{ old('nama_pengembali') }}"
            required>
    </div>

    <div class="form-group">
        <label>Seksi Pengembali</label>
        <input
            type="text"
            name="divisi_pengembali"
            class="form-control search-input"
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
    

            <input type="hidden" name="peminjaman_id" id="peminjaman_id" required>
            <input type="hidden" name="minuta_id" id="minuta_id">

            <div class="info-minuta" id="detailMinuta">
                Belum ada minuta yang dipilih.
            </div>

            <div class="button-area">
                <button type="submit" class="btn btn-success">
                    Simpan
                </button>
                <a href="{{ route('pengembalian.index') }}" class="btn btn-secondary">
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
                        @foreach($peminjaman as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_peminjam }}</td>
                                <td>{{ $item->divisi_peminjam ?? $item->seksi_peminjam ?? 'Seksi Lelang' }}</td>
                                <td>{{ optional($item->minuta)->tahun_risalah }}</td>
                                <td>{{ optional($item->minuta)->lokasi }}</td>
                                <td>{{ optional($item->minuta)->nomor_risalah }}</td>
                                <td>{{ optional($item->minuta)->tanggal_risalah ? \Carbon\Carbon::parse($item->minuta->tanggal_risalah)->format('d-m-Y') : '-' }}</td>
                                <td>{{ optional($item->minuta)->pemohon_lelang }}</td>
                                <td>{{ optional($item->minuta)->nama_debitur }}</td>
                                <td>{{ optional($item->minuta)->objek }}</td>
                                <td>{{ optional($item->minuta)->jenis_lelang }}</td>
                                <td>{{ optional($item->minuta)->pejabat_lelang }}</td>
                                <td>{{ $item->tanggal_pinjam ? \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d-m-Y') : '-' }}</td>
                                <td>
                                    @if(($item->umur_pinjam ?? 0) >= 7)
                                        <span class="status-merah"></span>
                                    @else
                                        <span class="status-hijau"></span>
                                    @endif
                                </td>
                                <td>
                                    <button
                                        type="button"
                                        class="btn btn-primary pilih-minuta-item"
                                        data-peminjamid="{{ $item->id }}"
                                        data-minutaid="{{ optional($item->minuta)->id }}"
                                        data-peminjam="{{ $item->nama_peminjam }}"
                                        data-seksi="{{ $item->divisi_peminjam ?? $item->seksi_peminjam ?? 'Seksi Lelang' }}"
                                        data-tahun="{{ optional($item->minuta)->tahun_risalah }}"
                                        data-lokasi="{{ optional($item->minuta)->lokasi }}"
                                        data-risalah="{{ optional($item->minuta)->nomor_risalah }}"
                                        data-tanggal="{{ optional($item->minuta)->tanggal_risalah ? \Carbon\Carbon::parse($item->minuta->tanggal_risalah)->format('d-m-Y') : '-' }}"
                                        data-pemohon="{{ optional($item->minuta)->pemohon_lelang }}"
                                        data-debitur="{{ optional($item->minuta)->nama_debitur }}"
                                        data-objek="{{ optional($item->minuta)->objek }}"
                                        data-jenis="{{ optional($item->minuta)->jenis_lelang }}"
                                        data-pejabat="{{ optional($item->minuta)->pejabat_lelang }}">
                                        Pilih
                                    </button>
                                </td>
                            </tr>
                        @endforeach

                        @if($peminjaman->isEmpty())
                            <tr>
                                <td colspan="15">Tidak ada minuta yang sedang dipinjam saat ini.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
              
        </div>
    </div>
</div>

<script>
const modal = document.getElementById('modalMinuta');
const btnPilih = document.getElementById('btnPilihMinuta');
const closeModal = document.querySelector('.close-modal');
const inputPeminjaman = document.getElementById('peminjaman_id');
const inputMinuta = document.getElementById('minuta_id');
const detailMinuta = document.getElementById('detailMinuta');

btnPilih.addEventListener('click', function(){
    modal.style.display = 'block';
});

closeModal.addEventListener('click', function(){
    modal.style.display = 'none';
});

window.addEventListener('click', function(e){
    if(e.target == modal){
        modal.style.display = 'none';
    }
});

document.querySelectorAll('.pilih-minuta-item').forEach(function(button) {
    button.addEventListener('click', function() {
        if(inputPeminjaman) inputPeminjaman.value = this.dataset.peminjamid;
        if(inputMinuta) inputMinuta.value = this.dataset.minutaid;

        detailMinuta.innerHTML = `
            <table style="width:100%; border-collapse:collapse;">
                <tr>
                    <td style="width:180px;"><b>Nama Peminjam</b></td>
                    <td>${this.dataset.peminjam}</td>
                </tr>
                <tr>
                    <td><b>Seksi Peminjam</b></td>
                    <td><b style="color:#005AA9;">${this.dataset.seksi}</b></td>
                </tr>
                <tr>
                    <td><b>Nomor Risalah</b></td>
                    <td>${this.dataset.risalah} (Tahun ${this.dataset.tahun})</td>
                </tr>
                <tr>
                    <td><b>Tanggal Risalah</b></td>
                    <td>${this.dataset.tanggal}</td>
                </tr>
                <tr>
                    <td><b>Pemohon / Debitur</b></td>
                    <td>${this.dataset.pemohon} / ${this.dataset.debitur}</td>
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

const searchInput = document.getElementById('searchMinuta');
if(searchInput){
    searchInput.addEventListener('keyup', function(){
        const keyword = this.value.toLowerCase();
        document.querySelectorAll('.modal-table tbody tr').forEach(function(row){
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(keyword) ? '' : 'none';
        });
    });
}
</script>

@endsection