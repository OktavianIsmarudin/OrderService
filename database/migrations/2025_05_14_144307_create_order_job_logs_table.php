<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('order_job_logs', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('siswa_id');
    $table->unsignedBigInteger('produk_id');
    $table->integer('jumlah');
    $table->string('status'); // sukses / gagal
    $table->text('message')->nullable(); // pesan error atau info
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_job_logs');
    }
};
