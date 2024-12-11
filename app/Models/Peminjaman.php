<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dari nama model
    protected $table = 'peminjaman';

    // Tentukan kolom yang dapat diisi
    protected $fillable = [
        'user_id', 'barang_id', 'nama_peminjam', 'nama_acara', 'tanggal_pinjam', 'tanggal_kembali', 'jumlah_pinjam', 'status'
    ];

    // Relasi dengan Mahasiswa (Many-to-One)
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'user_id');
    }

    // Relasi dengan Barang (Many-to-One)
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}