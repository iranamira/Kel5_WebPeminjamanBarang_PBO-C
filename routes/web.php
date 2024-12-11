<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BarangController;
use App\Http\Middleware\MahasiswaMiddleware;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MahasiswaAuthController;
use App\Http\Controllers\PeminjamanController;



// Route untuk Mahasiswa
Route::middleware('guest')->group(function () {
    Route::get('register', [MahasiswaAuthController::class, 'showRegisterForm'])->name('mahasiswa.register');
    Route::post('register', [MahasiswaAuthController::class, 'register'])->name('register.mahasiswa');
    Route::get('login', [MahasiswaAuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [MahasiswaAuthController::class, 'login']);
});

Route::middleware([MahasiswaMiddleware::class])->group(function () {
    Route::get('/',[MahasiswaController::class, 'dashboard'])->name('dashboard');
    Route::get('form-peminjaman',[MahasiswaController::class, 'showForm'])->name('form');
    Route::get('list',[MahasiswaController::class, 'listPeminjaman'])->name('list');
    Route::post('logout', [MahasiswaAuthController::class, 'logout'])->name('logout');

    Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
});


// Route untuk Admin
Route::middleware('guest')->group(function () {
    Route::get('register-admin', [AdminAuthController::class, 'showRegisterForm'])->name('admin.register');
    Route::post('register-admin', [AdminAuthController::class, 'register'])->name('admin.register.post');
    Route::get('login-admin', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login-admin', [AdminAuthController::class, 'login'])->name('admin.login.post');
});

Route::middleware([AdminMiddleware::class])->group(function () {
    Route::get('dashboard-admin',[AdminController::class, 'dashboard'])->name('dashboard.admin');
    Route::get('barang-admin',[AdminController::class, 'showBarang'])->name('barang.admin');
    Route::post('logout-admin', [AdminAuthController::class, 'logout'])->name('logout.admin');
    Route::post('/barang', [BarangController::class, 'store']);
    Route::get('/barang/{id}/edit', [BarangController::class, 'edit']);
    Route::put('/barang/{id}', [BarangController::class, 'update']);
    Route::delete('/barang/{id}', [BarangController::class, 'destroy']);

    Route::post('/peminjaman/update-status', [PeminjamanController::class, 'updateStatus'])->name('peminjaman.updateStatus');

});