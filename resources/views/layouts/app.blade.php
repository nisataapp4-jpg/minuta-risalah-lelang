<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Sistem Informasi Minuta Risalah Lelang')</title>

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:'Poppins',sans-serif;
            background:#f4f7fb;
            color:#2c3e50;
        }

        /* ================= HEADER ================= */

        header{
            background:#005AA9;
            min-height:80px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:0 32px;
        }

        header h2{
            margin:0;
            color:#fff;
            font-family:'Poppins',sans-serif;
            font-size:24px;
            font-weight:600;
            letter-spacing:.4px;
            line-height:1;
        }

        .user-profile-header {
            display:flex;
            align-items:center;
            gap:15px;
            color:white;
        }

        .user-badge {
            background: rgba(255, 255, 255, 0.15);
            padding: 8px 14px;
            border-radius: 20px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 8px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .role-tag {
            background: #FFC107;
            color: #222;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .btn-logout {
            background: #DC3545;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
            transition: .25s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-logout:hover {
            background: #bb2d3b;
        }

        /* ================= NAVBAR ================= */

        nav{
            background:white;
            display:flex;
            gap:12px;
            padding:12px 30px;
            box-shadow:0 2px 8px rgba(0,0,0,.08);
        }

        nav a{
            text-decoration:none;
            color:#4b5563;
            font-weight:600;
            padding:10px 18px;
            border-radius:8px;
            transition:.25s;
        }

        nav a:hover{
            background:#eaf3ff;
            color:#005AA9;
        }

        nav a.active{
            background:#005AA9;
            color:white;
        }

        /* ================= CONTAINER ================= */

        .container{
            width:95%;
            margin:35px auto;
            background:white;
            border-radius:12px;
            padding:35px;
            min-height:525px;
            box-shadow:0 4px 18px rgba(0,0,0,.08);
        }

        h2{
            margin-bottom:20px;
            color:#003b71;
        }

        /* ================= BUTTON ================= */

        .btn{
            display:inline-block;
            text-decoration:none;
            border:none;
            border-radius:8px;
            padding:10px 18px;
            cursor:pointer;
            font-size:14px;
            font-weight:600;
            transition:.25s;
        }

        .btn-primary{
            background:#005AA9;
            color:white;
        }

        .btn-primary:hover{
            background:#00498c;
        }

        .btn-success{
            background:#0B63CE;
            color:white;
        }

        .btn-success:hover{
            background:#0957b4;
        }

        .btn-warning{
            background:#FFC107;
            color:#222;
        }

        .btn-warning:hover{
            background:#e0aa00;
        }

        .btn-danger{
            background:#DC3545;
            color:white;
        }

        .btn-danger:hover{
            background:#bb2d3b;
        }

        .btn-secondary{
            background:#6C757D;
            color:white;
        }

        .btn-secondary:hover{
            background:#565e64;
        }

        /* ================= FORM ================= */

        input,
        select,
        textarea{
            width:100%;
            padding:10px 12px;
            border:1px solid #d8dee6;
            border-radius:8px;
            outline:none;
            font-size:14px;
        }

        input:focus,
        select:focus,
        textarea:focus{
            border-color:#005AA9;
            box-shadow:0 0 0 3px rgba(0,90,169,.15);
        }

        /* ================= TABLE ================= */

        table{
            width:100%;
            border-collapse:collapse;
        }

        table th{
            background:#005AA9;
            color:white;
            padding:12px;
            text-align:center;
        }

        table td{
            padding:10px;
            border-bottom:1px solid #e9edf2;
            text-align:center;
            vertical-align:middle;
        }

        table tbody tr:hover{
            background:#f5f9ff;
        }

        /* ================= CARD ================= */

        .card{
            background:white;
            border-radius:12px;
            padding:20px;
            box-shadow:0 2px 10px rgba(0,0,0,.08);
        }

        /* ================= PAGINATION ================= */

        .pagination{
            display:flex;
            justify-content:flex-end;
            align-items:center;
            margin-top:25px;
            gap:6px;
        }

        .pagination .page-item{
            list-style:none;
        }

        .pagination .page-link{
            color:#005AA9;
            border:1px solid #d7dde5;
            border-radius:8px;
            padding:9px 15px;
            font-weight:600;
            transition:.2s;
        }

        .pagination .page-link:hover{
            background:#eaf3ff;
            color:#005AA9;
        }

        .pagination .active .page-link{
            background:#005AA9;
            border-color:#005AA9;
            color:white;
        }

        .pagination .disabled .page-link{
            color:#9ca3af;
            background:#f3f4f6;
        }

        /* ================= RESPONSIVE ================= */

        @media(max-width:768px){
            header {
                flex-direction: column;
                gap: 12px;
                padding: 15px 20px;
                text-align: center;
            }

            nav{
                flex-wrap:wrap;
            }

            .container{
                width:98%;
            }

            table{
                display:block;
                overflow-x:auto;
            }
        }

        .filled{
            background:#eaf3ff !important;
            transition:.2s;
        }

        /* ================= STATUS PEMINJAMAN ================= */

        .badge-status {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-tersedia {
            background: #d1e7dd;
            color: #0f5132;
        }

        .badge-dipinjam {
            background: #f8d7da;
            color: #842029;
        }

    </style>

</head>

<body>

<header>

    <h2>Arsip Minuta Risalah Lelang KPKNL Malang</h2>

    {{-- Profil Pengguna & Tombol Logout --}}
    @if(Session::has('pegawai_id'))
    <div class="user-profile-header">
        <div class="user-badge">
            <i class="bi bi-person-circle fs-6"></i>
            <span>{{ Session::get('nama_pegawai') }}</span>
            <span class="role-tag">{{ Session::get('role') }}</span>
        </div>
        
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="bi bi-box-arrow-right"></i> Keluar
            </button>
        </form>
    </div>
    @endif

</header>

<nav>

    <a href="{{ route('dashboard') }}"
        class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">

        Dashboard

    </a>

    <a href="{{ route('minuta.index') }}"
        class="{{ request()->routeIs('minuta.*') ? 'active' : '' }}">

        Minuta Risalah Lelang

    </a>

    <a href="{{ route('peminjaman.index') }}"
        class="{{ request()->routeIs('peminjaman.*') ? 'active' : '' }}">

        Peminjaman Minuta Risalah Lelang

    </a>

    <a href="{{ route('pengembalian.index') }}"
        class="{{ request()->routeIs('pengembalian.*') ? 'active' : '' }}">

        Riwayat Pengembalian Minuta Risalah Lelang

    </a>

</nav>

<div class="container">

    @yield('content')

</div>

{{-- ================= SweetAlert Notifikasi ================= --}}

@if(session('success'))

<script>

document.addEventListener("DOMContentLoaded", function () {

    Swal.fire({

        toast: true,
        position: 'top-end',
        icon: 'success',
        title: "{{ session('success') }}",
        showConfirmButton: false,
        timer: 2500,
        timerProgressBar: true

    });

});

</script>

@endif

@if ($errors->any())

<script>

Swal.fire({

    icon: 'error',

    title: 'Terjadi Kesalahan',
    text: 'Mohon periksa kembali inputan Anda.',

    confirmButtonColor: '#005AA9'

});

</script>

@endif


{{-- ================= SweetAlert Konfirmasi Hapus ================= --}}

<script>

document.addEventListener("DOMContentLoaded", function () {

    const deleteForms = document.querySelectorAll('.delete-form');

    deleteForms.forEach(function(form){

        form.addEventListener('submit', function(e){

            e.preventDefault();

            Swal.fire({

                title: 'Konfirmasi Hapus',
                text: 'Apakah Anda yakin ingin menghapus data ini?',
                icon: 'warning',

                showCancelButton: true,

                confirmButtonColor: '#005AA9',
                cancelButtonColor: '#6c757d',

                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',

                reverseButtons: true

            }).then((result)=>{

                if(result.isConfirmed){

                    form.submit();

                }

            });

        });

    });

});

</script>

<script>

document.addEventListener('DOMContentLoaded', function(){

    document.querySelectorAll('input, select, textarea').forEach(function(el){

        if(el.classList.contains('search-input')){
            return;
        }
        
        function cekIsi(){

            if(el.value.trim() !== ''){

                el.classList.add('filled');

            }else{

                el.classList.remove('filled');

            }

        }

        cekIsi();

        el.addEventListener('input', cekIsi);

        el.addEventListener('change', cekIsi);

    });

});

</script>

</body>
</html>