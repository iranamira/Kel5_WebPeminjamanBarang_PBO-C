<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:admin',
            'password' => 'required|min:6',
        ]);

        // Membuat mahasiswa baru
        Admin::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Redirect setelah sukses
        return redirect()->route('admin.login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cek kredensial Admin
        $admin = Admin::checkCredentials($request->email, $request->password);
        if ($admin) {
            session(['admin' => $admin]);
            return redirect()->route('dashboard.admin');
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    public function showRegisterForm()
    {
        return view('auth.register_admin');
    }
    
    public function showLoginForm()
    {
        return view('auth.login_admin');
    }
    public function logout(Request $request)
{
    // Hapus session pengguna
    $request->session()->forget('admin');

    // Redirect ke halaman login
    return redirect()->route('admin.login')->with('status', 'Anda telah logout.');
}
}