<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('vilas', function (Blueprint $table) {
            $table->id('vila_id'); // ID auto increment
            $table->string('nama_vila');
            $table->string('lokasi_vila');
            $table->integer('kapasitas_vila');
            $table->integer('jumlah_kamar_tidur');
            $table->integer('jumlah_tempat_tidur');
            $table->integer('jumlah_kamar_mandi');
            $table->integer('jumlah_area_parkir_mobil');
            $table->enum('jumlah_area_parkir_bus', ['Ya', 'Tidak']);
            $table->string('kedalaman_luas_kolam')->nullable();
            $table->text('fasilitas_tambahan_vila')->nullable();
            $table->json('fasilitas_vila')->nullable();
            $table->integer('harga_minggu_kamis');
            $table->integer('harga_jumat');
            $table->integer('harga_sabtu');
            $table->longText('gambar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vilas');
    }
};
