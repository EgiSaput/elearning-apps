<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWktColumnsToNilaiUjianPilganSiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nilai_ujian_pilgan_siswas', function (Blueprint $table) {
            // Cek apakah kolom sudah ada sebelum menambahkan
            if (!Schema::hasColumn('nilai_ujian_pilgan_siswas', 'wkt_mulai')) {
                $table->timestamp('wkt_mulai')->nullable()->after('nilai');
            }
            if (!Schema::hasColumn('nilai_ujian_pilgan_siswas', 'wkt_selesai')) {
                $table->timestamp('wkt_selesai')->nullable()->after('wkt_mulai');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nilai_ujian_pilgan_siswas', function (Blueprint $table) {
            if (Schema::hasColumn('nilai_ujian_pilgan_siswas', 'wkt_mulai')) {
                $table->dropColumn('wkt_mulai');
            }
            if (Schema::hasColumn('nilai_ujian_pilgan_siswas', 'wkt_selesai')) {
                $table->dropColumn('wkt_selesai');
            }
        });
    }
}
