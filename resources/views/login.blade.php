<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Informasi Minuta Risalah Lelang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons untuk ikon mata -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f0f4f8;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-card {
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
            padding: 4rem 3.5rem;
            background-color: #ffffff;
        }
        .btn-primary-custom {
            background-color: #0073e6;
            border: none;
            padding: 0.85rem;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.2s ease;
        }
        .btn-primary-custom:hover {
            background-color: #005bb5;
        }
        .form-control:focus {
            border-color: #0073e6;
            box-shadow: 0 0 0 0.25rem rgba(0, 115, 230, 0.25);
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 p-4">

<div class="card login-card w-100">
    <div class="row g-0">
        <!-- Panel Kiri -->
        <div class="col-md-5 bg-left">
            <h6 class="text-uppercase tracking-wider mb-3 opacity-75 fw-bold" style="letter-spacing: 1px;">KPKNL Malang</h6>
            <h2 class="fw-bold mb-3" style="line-height: 1.3;">Sistem Informasi Pengelolaan Minuta Risalah Lelang</h2>
            <p class="opacity-90 fs-6 mb-4" style="line-height: 1.6;">Portal tata kelola, pengarsipan digital, dan peminjaman dokumen resmi Minuta Risalah Lelang KPKNL Malang.</p>
            <div class="mt-auto small opacity-75">
            </div>
        </div>

        <!-- Panel Kanan: Form Login -->
        <div class="col-md-7 form-right">
            <h3 class="fw-bold text-dark mb-2">Masuk ke Akun Pegawai</h3>
            <p class="text-muted small mb-4 fs-6">Masukkan NIP atau Username terdaftar untuk memulai sesi kerja.</p>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show small" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->has('login_error'))
                <div class="alert alert-danger alert-dismissible fade show small" role="alert">
                    {{ $errors->first('login_error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="username" class="form-label text-secondary small fw-semibold">Username / NIP</label>
                    <input type="text" name="username" id="username" class="form-control form-control-lg fs-6 @error('username') is-invalid @enderror" value="{{ old('username') }}" placeholder="Masukkan Username atau NIP" required autofocus>
                    @error('username')
                        <div class="invalid-feedback small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label text-secondary small fw-semibold">Kata Sandi</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control form-control-lg fs-6 @error('password') is-invalid @enderror" placeholder="Masukkan kata sandi akun" required>
                        <button class="btn btn-outline-secondary px-3" type="button" id="togglePassword">
                            <i class="bi bi-eye-slash" id="eyeIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback small d-block">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary-custom w-100 text-white rounded-3 shadow-sm mb-3">
                    Masuk ke Sistem &rarr;
                </button>

                <div class="text-center small text-muted">
                    Belum punya akun? <a href="{{ route('register') }}" class="text-decoration-none fw-semibold" style="color: #0073e6;">Daftar di sini</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Skrip interaktif untuk toggle lihat/sembunyikan password
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    const eyeIcon = document.querySelector('#eyeIcon');

    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        
        // Ganti ikon mata
        eyeIcon.classList.toggle('bi-eye');
        eyeIcon.classList.toggle('bi-eye-slash');
    });
</script>
</body>
</html>