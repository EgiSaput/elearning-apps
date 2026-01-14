<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasHaveMataPelajaransTableSeeder extends Seeder
{
    public function run()
    {
        // Ensure there are some mata_pelajarans to link to. We'll link null if none.
        $mapel = DB::table('mata_pelajarans')->first();
        $id_mapel = $mapel ? $mapel->id_mapel : null;

        $kelas = [
            ['nama_kelas' => 'X', 'id_mapel' => $id_mapel, 'created_at' => now(), 'updated_at' => now()],
            ['nama_kelas' => 'XI', 'id_mapel' => $id_mapel, 'created_at' => now(), 'updated_at' => now()],
            ['nama_kelas' => 'XII', 'id_mapel' => $id_mapel, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('kelas_have_mata_pelajarans')->insert($kelas);
    }
}
