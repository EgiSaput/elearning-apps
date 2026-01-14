<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
	protected $table = 'mata_pelajarans';
    protected $primaryKey = 'id_mapel';  
    public function gurus()
    {
        return $this->belongsToMany('\App\Guru', 'guru_mapel', 'id_mapel', 'nip_guru');
    }
    // protected $fillable = array('nama_mapel', 'nip_guru'); 
}
