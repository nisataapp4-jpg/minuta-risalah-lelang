<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Sistem Informasi Minuta Risalah Lelang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f4f8;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .register-card {
            max-width: 1050px;
            border: none;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0, 102, 204, 0.12);
            overflow: hidden;
        }
        .bg-left {
            background: linear-gradient(135deg, #005bb5 0%, #0073e6 100%);
            color: #ffffff;
            padding: 4rem 3.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .form-right {
            padding: 3rem 3.5rem;
            background-color: #ffffff;
        }
        .btn-primary-custom {
            background-color: #0073e6;
            border: none;
            padding: 0.75rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        .btn-primary-custom:hover {
            background-color: #005bb5;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 p-4">

<div class="card register-card w-100">
    <div class="row g-0">
        <!-- Panel Kiri -->
        <div class="col-md-5 bg-left">
            <h6 class="text-uppercase tracking-wider mb-3 opacity-75 fw-bold">KPKNL Malang</h6>
            <h2 class="fw-bold mb-3">Pendaftaran Akun Pegawai KPKNL Malang</h2>
            <p class="opacity-90 fs-6 mb-4">Daftarkan diri Anda untuk mengakses sistem pengelolaan dan peminjaman Minuta Risalah Lelang.</p>
            <div class="mt-auto small opacity-75">
            </div>
        </div>

        <!-- Panel Kanan: Form Register -->
        <div class="col-md-7 form-right">
            <h3 class="fw-bold text-dark mb-2">Form Registrasi</h3>
            <p class="text-muted small mb-3">Lengkapi data diri untuk membuat akun baru.</p>

            <form action="{{ route('register.post') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-secondary small fw-semibold">NIP</label>
                        <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip') }}" placeholder="Nomor Induk Pegawai" required>
                        @error('nip') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-secondary small fw-semibold">Nama Lengkap</label>
                        <input type="text" name="nama_pegawai" class="form-control @error('nama_pegawai') is-invalid @enderror" value="{{ old('nama_pegawai') }}" placeholder="Nama Lengkap Pegawai" required>
                        @error('nama_pegawai') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-secondary small fw-semibold">Seksi</label>
                        <input type="text" name="seksi" class="form-control @error('seksi') is-invalid @enderror" value="{{ old('seksi') }}" placeholder="Contoh: Seksi Lelang" required>
                        @error('seksi') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-secondary small fw-semibold">Username</label>
                        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" placeholder="Username Login" required>
                        @error('username') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label text-secondary small fw-semibold">Kata Sandi</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 6 karakter" required>
                    @error('password') <div class="invalid-feedback small">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-primary-custom w-100 text-white rounded-3 shadow-sm mb-3">
                    Daftar Akun Sekarang &rarr;
                </button>

                <div class="text-center small text-muted">
                    Sudah punya akun? <a href="{{ route('login') }}" class="text-decoration-none fw-semibold" style="color: #0073e6;">Masuk di sini</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>