<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dari nama model
    protected $table = 'barang';

    // Tentukan kolom yang dapat diisi
    protected $fillable = [
        'nama_barang', 'jumlah_barang', 'detail'
    ];

    protected $primaryKey = 'barang_id';

    // Relasi dengan Peminjaman (Many-to-Many)
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'barang_id');
    }
}