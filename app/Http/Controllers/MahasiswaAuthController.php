<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MahasiswaAuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'NIM' => 'required|unique:mahasiswa,NIM',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:mahasiswa,email',
            'password' => 'required|min:8|confirmed', // Password minimal 8 karakter
        ]);

        // Membuat mahasiswa baru
        Mahasiswa::create([
            'NIM' => $validated['NIM'],
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Redirect setelah sukses
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cek kredensial Mahasiswa
        $mahasiswa = Mahasiswa::checkCredentials($request->email, $request->password);
        if ($mahasiswa) {
            session(['user' => $mahasiswa]);
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    public function showRegisterForm()
{
    return view('auth.register_mahasiswa');
}

public function showLoginForm()
{
    return view('auth.login_mahasiswa');
}

public function logout(Request $request)
{
    // Hapus session pengguna
    $request->session()->forget('user');

    // Redirect ke halaman login
    return redirect()->route('login')->with('status', 'Anda telah logout.');
}

}