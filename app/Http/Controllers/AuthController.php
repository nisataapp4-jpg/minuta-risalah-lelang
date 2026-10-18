<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // Menampilkan halaman form login
    public function showLoginForm()
    {
        if (Session::has('pegawai_id')) {
            return redirect()->route('dashboard');
        }
        return view('login');
    }

    // Memproses data login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'Username atau NIP wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        // Cari pegawai berdasarkan username atau NIP
        $pegawai = DB::table('pegawai')
            ->where('username', $request->username)
            ->orWhere('nip', $request->username)
            ->first();

        if ($pegawai && Hash::check($request->password, $pegawai->password)) {
            // Simpan data pegawai ke dalam session
            Session::put([
                'pegawai_id'   => $pegawai->id,
                'nip'          => $pegawai->nip,
                'nama_pegawai' => $pegawai->nama_pegawai,
                'seksi'        => $pegawai->seksi,
                'username'     => $pegawai->username,
                'role'         => $pegawai->role,
                'is_logged_in' => true,
            ]);

            return redirect()->route('dashboard')->with('success', 'Selamat datang, ' . $pegawai->nama_pegawai);
        }

        return back()->withErrors(['login_error' => 'Username/NIP atau Password salah.'])->withInput();
    }

    // Memproses logout
    public function logout()
    {
        Session::flush();
        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar dari sistem.');
    }

    // Menampilkan halaman form registrasi
    public function showRegisterForm()
    {
        return view('register');
    }

    // Memproses data pendaftaran pegawai baru
    public function register(Request $request)
    {
        $request->validate([
            'nip'          => 'required|unique:pegawai,nip',
            'nama_pegawai' => 'required',
            'seksi'        => 'required',
            'username'     => 'required|unique:pegawai,username',
            'password'     => 'required|min:6',
        ], [
            'nip.required'          => 'NIP wajib diisi.',
            'nip.unique'            => 'NIP sudah terdaftar di sistem.',
            'nama_pegawai.required' => 'Nama lengkap wajib diisi.',
            'seksi.required'        => 'Seksi wajib diisi.',
            'username.required'     => 'Username wajib diisi.',
            'username.unique'       => 'Username sudah digunakan.',
            'password.required'     => 'Kata sandi wajib diisi.',
            'password.min'          => 'Kata sandi minimal harus 6 karakter.',
        ]);

        DB::table('pegawai')->insert([
            'nip'          => $request->nip,
            'nama_pegawai' => $request->nama_pegawai,
            'seksi'        => $request->seksi,
            'username'     => $request->username,
            'password'     => Hash::make($request->password),
            'role'         => 'Pegawai', // Default role untuk pendaftaran mandiri adalah Pegawai
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan masuk menggunakan akun yang telah dibuat.');
    }
}