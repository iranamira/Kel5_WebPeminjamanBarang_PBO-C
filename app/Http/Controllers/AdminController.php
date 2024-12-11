<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
{
    $peminjaman = Peminjaman::all();

    return view('admin.dashboard', compact( 'peminjaman'));
}

public function showBarang()
{
    $barang = Barang::all();

    return view('admin.barang', compact( 'barang'));
}
}