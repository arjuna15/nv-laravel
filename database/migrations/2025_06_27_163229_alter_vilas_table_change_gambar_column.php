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
        Schema::table('vilas', function (Blueprint $table) {
            $table->longText('gambar')->change();
        });
    }

    public function down()
    {
        Schema::table('vilas', function (Blueprint $table) {
            $table->string('gambar', 255)->change();
        });
    }
};
