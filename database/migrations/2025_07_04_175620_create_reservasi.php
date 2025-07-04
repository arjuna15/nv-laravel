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
            $table->unsignedBigInteger('villa_id');
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservasi');
    }
};
