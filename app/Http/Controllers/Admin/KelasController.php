<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Response;
use DB;
use Auth;
use Validator;
use Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Kelas as Kelas;
use App\Guru as Guru;
use App\MataPelajaran as MataPelajaran;

class KelasController extends Controller
{
 
  public function showTambahKelas()
  {
  	$idMapel= MataPelajaran::select(DB::raw("id_mapel, nama_mapel"))
        ->orderBy(DB::raw("id_mapel"))        
        ->get();
    $gurus = Guru::select('nip_guru','nama_guru')->orderBy('nama_guru')->get();
    return view('admin.dashboard.kelas.tambah_kelas')
      	->with('Mapel', $idMapel)
      	->with('Gurus', $gurus);
  }

  public function index()
  {
    // Prefix match for kelas: X, XI, XII (match values starting with these prefixes)
    $dataKelas = DB::table('kelas_have_mata_pelajarans')
                 ->join('mata_pelajarans', 'kelas_have_mata_pelajarans.id_mapel', '=', 'mata_pelajarans.id_mapel')
                 ->leftJoin('guru_mapel', 'mata_pelajarans.id_mapel', '=', 'guru_mapel.id_mapel')
                 ->leftJoin('gurus', 'guru_mapel.nip_guru', '=', 'gurus.nip_guru')
                 ->select('kelas_have_mata_pelajarans.*', 'mata_pelajarans.nama_mapel', DB::raw('GROUP_CONCAT(gurus.nama_guru SEPARATOR ", ") as nama_guru'))
                 ->where(function($q) {
                     $q->where('kelas_have_mata_pelajarans.nama_kelas', 'like', 'X%')
                       ->orWhere('kelas_have_mata_pelajarans.nama_kelas', 'like', 'XI%')
                       ->orWhere('kelas_have_mata_pelajarans.nama_kelas', 'like', 'XII%');
                 })
                 ->groupBy('kelas_have_mata_pelajarans.id', 'mata_pelajarans.nama_mapel')
                 ->orderBy('kelas_have_mata_pelajarans.nama_kelas', 'asc')
                 ->get();
    $data = array('kelas' => $dataKelas);   
    return view('admin.dashboard.kelas.kelas',$data);
  }   

  public function index_guru()
  {
    $guru = Guru::where('id_user', Auth::user()->id_user)->first();
    $mapelIds = $guru ? $guru->mataPelajaran()->get()->pluck('id_mapel')->toArray() : [];
    $dataKelas = [];
    if (count($mapelIds)) {
      $dataKelas = DB::table('kelas_have_mata_pelajarans')
                   ->join('mata_pelajarans', 'kelas_have_mata_pelajarans.id_mapel', '=', 'mata_pelajarans.id_mapel')
                   ->leftJoin('guru_mapel', 'mata_pelajarans.id_mapel', '=', 'guru_mapel.id_mapel')
                   ->leftJoin('gurus', 'guru_mapel.nip_guru', '=', 'gurus.nip_guru')
                   ->select('kelas_have_mata_pelajarans.*', 'mata_pelajarans.nama_mapel', DB::raw('GROUP_CONCAT(gurus.nama_guru SEPARATOR ", ") as nama_guru'))
                   ->whereIn('kelas_have_mata_pelajarans.id_mapel', $mapelIds)
                   ->groupBy('kelas_have_mata_pelajarans.id', 'mata_pelajarans.nama_mapel')
                   ->orderBy('kelas_have_mata_pelajarans.nama_kelas', 'asc')->get();         
    }
    $data = array('kelas' => $dataKelas);   
    return view('admin.dashboard.kelas.kelas',$data);
  }     

  public function hapus($id)
  {
  
    $kelas = Kelas::where('id', '=', $id)->first();

    if ($kelas == null)
      app::abort(404);
    
    Session::flash('flash_message', 'Data Kelas "'.$kelas->nama_kelas.'" - "'.$kelas->id_mapel.'" Berhasil dihapus.');

    $kelas->delete();
    
    return Redirect::action('Admin\KelasController@index');

  }  
 
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data | Request $request | Opsional | dipakai keduanya bisa juga
     * @return User
     */
  protected function tambah(Request $request)
  {
        $input =$request->all();
        $pesan = array(
            'nama_kelas.required' => 'Judul dibutuhkan.',
            'id_mapel.required' => 'Deskripsi dibutuhkan.',                    
        );

        $aturan = array(
            'nama_kelas'=> 'required',
            'id_mapel'  => 'required',           
        );        
        $validator = Validator::make($input,$aturan, $pesan);        
        if($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        // revisi
        $dataKelas = Kelas::all();
        foreach ($dataKelas as $data) {
          if ($data->nama_kelas == $request['nama_kelas'] && $data->id_mapel == $request['id_mapel']) {
            Session::flash('flash_message', 'Data Kelas dan mata pelajaran sudah ada. Periksa Kembali !!!');
            return Redirect::back()->withInput();
          }
        }

        $kelas = new Kelas;
        $kelas->nama_kelas     	= $request['nama_kelas'];
        $kelas->id_mapel 		= $request['id_mapel'];      

        // if admin selected guru(s) for this mapel, sync pivot guru_mapel with nama_kelas
        if (isset($request['nip_gurus']) && is_array($request['nip_gurus'])) {
            $mapel = MataPelajaran::find($request['id_mapel']);
            if ($mapel) {
                $syncData = [];
                foreach ($request['nip_gurus'] as $nip_guru) {
                    $syncData[$nip_guru] = ['nama_kelas' => $request['nama_kelas']];
                }
                $mapel->gurus()->sync($syncData);
            }
        }

        if (! $kelas->save() )
          App::abort(500);

        Session::flash('flash_message', 'Data Kelas "'.$request['nama_kelas'].'" - " '.$request['id_mapel'].'" Berhasil disimpan.');

        return Redirect::action('Admin\KelasController@index');
  }  

 public function editkelas($id)
    {
        $data = Kelas::find($id);        
        $idMapel= MataPelajaran::select(DB::raw("id_mapel, nama_mapel"))
        ->orderBy(DB::raw("id_mapel"))        
        ->get();
          $gurus = Guru::select('nip_guru','nama_guru')->orderBy('nama_guru')->get();
          // determine current guru assignments for selected mapel if available
          $current_nips = [];
          if (isset($data->id_mapel)) {
            $mapel = MataPelajaran::find($data->id_mapel);
            if ($mapel) $current_nips = $mapel->gurus()->get()->pluck('nip_guru')->toArray();
          }
        return view('admin.dashboard.kelas.edit_kelas',$data)
                ->with('Mapel', $idMapel)
                ->with('Gurus', $gurus)
                ->with('current_nips', $current_nips);
    }

 public function simpanedit(Request $request, $id)
  {
    $input = $request->all();
        $messages = [
            'nama_kelas.required' => 'Judul dibutuhkan.',
            'id_mapel.required' => 'Deskripsi dibutuhkan.',           
        ];        

        $validator = Validator::make($input, [
            'nama_kelas'  => 'required',
            'id_mapel'  => 'required',
        ], $messages);
                     

        if($validator->fails()) {        
            return Redirect::back()->withErrors($validator)->withInput();          
        }
         
        $editKelas = Kelas::find($id);
        $editKelas->nama_kelas     = $input['nama_kelas'];
        $editKelas->id_mapel = $input['id_mapel'];     

        if (isset($input['nip_gurus']) && is_array($input['nip_gurus'])) {
          $mapel = MataPelajaran::find($input['id_mapel']);
          if ($mapel) {
            $mapel->gurus()->sync($input['nip_gurus']);
          }
        }

        if (! $editKelas->save())
          App::abort(500);

        Session::flash('flash_message', 'Data Kelas "'.$input['nama_kelas'].'" id mapel " '.$input['id_mapel'].'" Berhasil diubah.');

        return Redirect::action('Admin\KelasController@index'); 
    }
}
