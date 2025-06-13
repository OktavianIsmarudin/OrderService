<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id');
            $table->unsignedBigInteger('produk_id');
            $table->integer('jumlah');
            $table->decimal('total_harga', 15, 2);
            $table->timestamps();

            // Jika kamu ingin menambahkan foreign key, pastikan tabel terkait ada
            // $table->foreign('produk_id')->references('id')->on('produks');
            // $table->foreign('siswa_id')->references('id')->on('siswas');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
