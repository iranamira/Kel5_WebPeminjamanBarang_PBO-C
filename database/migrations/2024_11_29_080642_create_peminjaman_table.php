<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeminjamanTable extends Migration
{
    public function up()
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('barang_id');
            $table->foreign('user_id')->references('user_id')->on('mahasiswa')->onDelete('cascade');
            $table->foreign('barang_id')->references('barang_id')->on('barang')->onDelete('cascade');
            
            $table->string('nama_peminjam', 100);
            $table->string('NIM', 100);
            $table->string('nama_acara', 100);
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali');
            $table->integer('jumlah_pinjam');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('peminjaman');
    }
}