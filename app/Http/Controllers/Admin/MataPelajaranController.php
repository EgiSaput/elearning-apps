<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Response;
use DB;

use Validator;
use App\Http\Controllers\Controller;
use App\MataPelajaran as MataPelajaran;
use App\Guru as Guru;
use Session;

class MataPelajaranController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function showTambahMataPelajaran()
  {
    return view('admin.dashboard.mata_pelajaran.tambah_mata_pelajaran');
  }

  public function index()
  {

    $dataMapel = MataPelajaran::all();

    $data = array('mata_pelajaran' => $dataMapel);
    return view('admin.dashboard.mata_pelajaran.mata_pelajaran',$data);
  }

  public function hapus($id_mapel)
  {
  
    $id_mapel = MataPelajaran::where('id_mapel', '=', $id_mapel)->first();

    if ($id_mapel == null)
      app::abort(404);
    
    Session::flash('flash_message', 'Data Mata Pelajaran  "'.$id_mapel->id_mapel.'" - "'.$id_mapel->nama_mapel.'" Berhasil dihapus.');

    $id_mapel->delete();
    
    return Redirect::action('Admin\MataPelajaranController@index');

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
            'nama_mapel.required'     => 'Nama Mata Pelajaran dibutuhkan.',
        );

        $aturan = array(
            'nama_mapel' => 'required',
        );


        $validator = Validator::make($input,$aturan, $pesan);

        if($validator->fails()) {
            # Kembali kehalaman yang sama dengan pesan error
            return Redirect::back()->withErrors($validator)->withInput();
        }
        # Bila validasi sukses

        $mapel = new MataPelajaran;
        $mapel->nama_mapel     = $request['nama_mapel'];

        //melakukan save, jika gagal (return value false) lakukan harakiri
        //error kode 500 - internel server error
        if (! $mapel->save() )
          App::abort(500);

        Session::flash('flash_message', 'Data Mata Pelajaran "'.$request['nama_mapel'].'" Berhasil disimpan.');

        return Redirect::action('Admin\MataPelajaranController@index');
  }

 public function editmapel($id_mapel)
    {
        $data = MataPelajaran::find($id_mapel);
        $mata_pelajaran = MataPelajaran::orderBy('id_mapel')->get();

        return view('admin.dashboard.mata_pelajaran.edit_mata_pelajaran',$data)
                ->with('list_mata_pelajaran', $mata_pelajaran);
    }

  public function simpanedit($id_mapel)
    {
        $input =Input::all();
        $messages = [
            'nama_mapel.required'     => 'Nama Mata Pelajaran dibutuhkan.',
        ];

        $validator = Validator::make($input, [
            'nama_mapel' => 'required',
        ], $messages);


        if($validator->fails()) {
            # Kembali kehalaman yang sama dengan pesan error
            return Redirect::back()->withErrors($validator)->withInput();
        }
        # Bila validasi sukses
        $editMapel = MataPelajaran::find($id_mapel);
        $editMapel->nama_mapel        = $input['nama_mapel'];

        if (! $editMapel->save())
          App::abort(500);

        Session::flash('flash_message', 'Data Nama Mata Pelajaran " '.$input['nama_mapel'].'" Berhasil diubah.');

        return Redirect::action('Admin\MataPelajaranController@index');
    }
}


