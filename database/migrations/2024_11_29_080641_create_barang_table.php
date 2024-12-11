<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangTable extends Migration
{
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id('barang_id');
            $table->string('nama_barang', 100);
            $table->integer('jumlah_barang');
            $table->text('detail')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('barang');
    }
}