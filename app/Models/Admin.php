<?php

namespace App\Models;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dari nama model
    protected $table = 'admin';

    // Tentukan kolom yang dapat diisi
    protected $fillable = [
        'username', 'email', 'password'
    ];

    // Tipe autentikasi untuk admin
    protected $guarded = [];
    public static function checkCredentials($email, $password)
    {
        $admin = self::where('email', $email)->first();

        if ($admin && Hash::check($password, $admin->password)) {
            return $admin;
        }

        return null;
    }
}