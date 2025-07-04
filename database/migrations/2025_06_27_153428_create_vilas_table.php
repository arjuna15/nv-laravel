<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vilas', function (Blueprint $table) {
            $table->id('vila_id'); // ID auto increment
            $table->string('nama_vila');
            $table->string('lokasi_vila');
            $table->integer('kapasitas_vila');
            $table->json('detail')->nullable(); // Diganti jadi array
            $table->string('kedalaman_luas_kolam')->nullable();
            $table->text('fasilitas_tambahan_vila')->nullable();
            $table->json('fasilitas_vila')->nullable();
            $table->string('harga_villa');
            $table->longText('gambar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vilas');
    }
};