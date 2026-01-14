<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuruMapelTable extends Migration
{
    public function up()
    {
        Schema::create('guru_mapel', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nip_guru');
            $table->integer('id_mapel')->unsigned();
            $table->timestamps();

            $table->foreign('nip_guru')->references('nip_guru')->on('gurus')->onDelete('cascade');
            $table->foreign('id_mapel')->references('id_mapel')->on('mata_pelajarans')->onDelete('cascade');
            $table->unique(['nip_guru','id_mapel']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('guru_mapel');
    }
}
