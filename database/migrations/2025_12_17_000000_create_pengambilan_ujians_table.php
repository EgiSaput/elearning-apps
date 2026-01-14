<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengambilanUjiansTable extends Migration
{
    public function up()
    {
        Schema::create('pengambilan_ujians', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('id_ujian');
            $table->string('nisn_siswa');
            $table->timestamp('diambil_pada')->nullable();
            $table->timestamps();

            $table->foreign('id_ujian')->references('id_ujian')->on('ujians')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengambilan_ujians');
    }
}
