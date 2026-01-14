<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{    
	protected $table = 'gurus';
    protected $primaryKey = 'nip_guru';
    public $incrementing = false;

    public function mataPelajaran()
    {
        return $this->belongsToMany('\App\MataPelajaran', 'guru_mapel', 'nip_guru', 'id_mapel');
    }

    // protected $fillable = {
    // 	'nip_guru', 'nama_guru', 'ttl_guru','jns_kelamin_guru','agama_guru','no_telp_guru','email_guru','alamat_guru','jabatan_guru','foto_guru','status_guru'
    // }
    
}
