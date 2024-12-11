<?php

namespace App\Models;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mahasiswa extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dari nama model
    protected $table = 'mahasiswa';

    // Tentukan kolom yang dapat diisi
    protected $fillable = [
        'NIM', 'nama', 'email', 'password'
    ];

    protected $guarded = ['user_id'];

    protected $primaryKey = 'user_id';
    
    public function getId()
    {
        return $this->attributes['user_id'];
    }

    public function getName()
    {
        return $this->attributes['nama'];
    }

    public function getNIM()
    {
        return $this->attributes['NIM'];
    }

    // Relasi dengan Peminjaman (Many-to-Many)
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'user_id');
    }

    public static function checkCredentials($email, $password)
    {
        $mahasiswa = self::where('email', $email)->first();

        if ($mahasiswa && Hash::check($password, $mahasiswa->password)) {
            return $mahasiswa;
        }

        return null;
    }
}