<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKelasHaveMataPelajaransTable extends Migration
{
    public function up()
    {
        Schema::create('kelas_have_mata_pelajarans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_kelas');
            $table->integer('id_mapel')->unsigned()->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kelas_have_mata_pelajarans');
    }
}
