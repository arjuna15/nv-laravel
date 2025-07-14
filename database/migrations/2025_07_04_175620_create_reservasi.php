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
        Schema::create('reservasi', function (Blueprint $table) {
            $table->id(); // PRIMARY KEY, AUTO_INCREMENT
            $table->unsignedBigInteger('vila_id');
            $table->string('no');
            $table->string('nama_tamu');
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->string('total');
            $table->string('uang_masuk');
            $table->string('sisa');
            $table->string('pelunasan');
            $table->text('catatan')->nullable();
            $table->string('no_hp');
            $table->string('status');
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservasi');
    }
};
