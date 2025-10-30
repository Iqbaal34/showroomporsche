<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class LoginController extends Controller
{
    /**
     * 🔹 Tampilkan halaman login
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * 🔹 Proses autentikasi login
     */
    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cek user berdasarkan email & username
        $user = DB::table('tb_user')
            ->where('email', $request->email)
            ->where('nama', $request->username)
            ->first();

        if (!$user) {
            return back()->with('error', 'User tidak ditemukan.');
        }

        // Cek password
        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Password salah.');
        }

        // Simpan data user ke session
        Session::put([
            'user_id' => $user->user_id,
            'nama' => $user->nama,
            'role' => $user->role,
            'logged_in' => true
        ]);

        // 🔹 Jika sebelumnya diarahkan dari ORDER page
        if (Session::has('redirect_after_login')) {
            $redirect = Session::get('redirect_after_login');
            Session::forget('redirect_after_login');
            return redirect($redirect)->with('success', 'Selamat datang kembali, ' . $user->nama . '!');
        }

        // 🔹 Kalau tidak ada redirect, arahkan ke home
        return redirect('/')->with('success', 'Selamat datang kembali, ' . $user->nama . '!');
    }

    /**
     * 🔹 Logout dan hapus session
     */
    public function logout()
    {
        Session::flush();
        return redirect('/login')->with('success', 'Kamu telah logout.');
    }

    /**
     * 🔹 Tampilkan halaman register
     */
    public function registerPage()
    {
        return view('auth.register');
    }

    /**
     * 🔹 Proses register user baru
     */
    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:tb_user,email',
            'password' => 'required|min:6',
            'no_hp' => 'required|max:20',
            'alamat' => 'required|string',
        ]);

        DB::table('tb_user')->insert([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'role' => 'pembeli',
            'tanggal_daftar' => Carbon::now(),
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}
