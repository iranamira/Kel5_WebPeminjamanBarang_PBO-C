<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
public function dashboard()
{
    $barang = Barang::all();
    $peminjaman = Peminjaman::where('user_id', session('user')->getId())->with('barang')->get();

    return view('mahasiswa.dashboard', compact('barang', 'peminjaman'));
}

public function listPeminjaman()
{
    $peminjaman = Peminjaman::where('user_id', session('user')->getId())->with('barang')->get();

    return view('mahasiswa.list', compact('peminjaman'));
}

public function showForm()
{
    $barang = Barang::all();
    return view('mahasiswa.form', compact('barang'));
}
}