<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNilaiUjianSiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai_ujian_siswas', function (Blueprint $table) {
            $table->increments('id_nilai_ujian_siswa');
            $table->string('nilai_ujian');
            $table->timestamps();

            // foreign key  
            $table->string('nisn_siswa');
            $table->foreign('nisn_siswa')->references('nisn_siswa')->on('siswas')->onDelete('cascade');
            $table->integer('id_nilai_ujian_pilgan')->unsigned();
            $table->foreign('id_nilai_ujian_pilgan')->references('id_nilai_ujian_pilgan')->on('nilai_ujian_pilgan_siswas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('nilai_ujian_siswas');
    }
}
