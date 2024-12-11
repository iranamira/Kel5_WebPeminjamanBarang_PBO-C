<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use App\Events\PeminjamanCreated;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    // Menyimpan peminjaman
    public function store(Request $request)
    {
        try {
            // Validasi data yang dikirim dari form
            $request->validate([
                'barang_id' => 'required',
                'nama_acara' => 'required|string',
                'tanggal_pinjam' => 'required|date',
                'tanggal_kembali' => 'required|date',
                'jumlah_pinjam' => 'required|integer|min:1',
            ]);

            // Ambil data pengguna yang sedang login
            $user = session('user');

            if (!$user) {
                throw new \Exception('Pengguna tidak terdeteksi, silakan login terlebih dahulu.');
            }

            // Cek apakah jumlah barang yang dipinjam melebihi jumlah barang yang tersedia
            $barang = Barang::find($request->barang_id);
            if (!$barang) {
                throw new \Exception('Barang tidak ditemukan, silakan pilih barang yang tersedia.');
            }

            if ($barang->jumlah_barang < $request->jumlah_pinjam) {
                throw new \Exception('Jumlah barang yang dipinjam melebihi jumlah yang tersedia.');
            }

            // Buat entri baru peminjaman
            $peminjaman = new Peminjaman();
            $peminjaman->barang_id = $request->barang_id;
            $peminjaman->user_id = $user->getId();
            $peminjaman->nama_peminjam = $user->getName();
            $peminjaman->NIM = $user->getNIM();
            $peminjaman->nama_acara = $request->nama_acara;
            $peminjaman->tanggal_pinjam = $request->tanggal_pinjam;
            $peminjaman->tanggal_kembali = $request->tanggal_kembali;
            $peminjaman->jumlah_pinjam = $request->jumlah_pinjam;
            $peminjaman->status = 'pending'; // Status default

            $peminjaman->save();

            // Kurangi jumlah barang yang tersedia
            $barang->jumlah_barang -= $request->jumlah_pinjam;
            $barang->save();

            return response()->json([
                'success' => true,
                'message' => 'Peminjaman berhasil diajukan!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateStatus(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:peminjaman,id',
                'status' => 'required|in:pending,approved,rejected',
            ]);
    
            $peminjaman = Peminjaman::find($request->id);
            if (!$peminjaman) {
                throw new \Exception('Peminjaman tidak ditemukan.');
            }
    
            $barang = $peminjaman->barang;
            if (!$barang) {
                throw new \Exception('Barang tidak ditemukan untuk peminjaman ini.');
            }
    
            // Logika perubahan status
            if (($peminjaman->status === 'pending' && $request->status === 'rejected') || 
                ($peminjaman->status === 'approved' && $request->status === 'rejected')) {
                // Barang dikembalikan ke stok
                $barang->jumlah_barang += $peminjaman->jumlah_pinjam;
            } elseif (($peminjaman->status === 'rejected' && $request->status === 'approved') ||
                    ($peminjaman->status === 'rejected' && $request->status === 'pending')) {
                // Barang dikurangi kembali dari stok
                $barang->jumlah_barang -= $peminjaman->jumlah_pinjam;
            }
    
            // Perbarui status peminjaman
            $peminjaman->status = $request->status;
            $peminjaman->save();
            $barang->save();
    
            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diperbarui.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

}