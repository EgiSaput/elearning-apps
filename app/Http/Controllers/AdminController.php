<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
//use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Validator;
use Response;
use DB;
use Session;
use Hash;
use App\User as User;
use App\Siswa as Siswa;
use App\Guru as Guru;
use App\Kelas as Kelas;
use App\MataPelajaran as MataPelajaran;
use App\Pengumuman as Pengumuman;
use App\Ujian as Ujian;
use App\Soal as Soal;

class AdminController extends Controller
{

    public function __construct(Request $request)
    {
      $this->middleware('auth');      
    }    

    public function showTambahUser()
    {
      $idUser= User::select(DB::raw("id_user, username"))
          ->orderBy(DB::raw("id_user"))        
          ->get();
      return view('admin.dashboard.user.tambah_user');
          // ->with('listIduser', $idUser);
    }

    public function index_user()
    {
      $dataUser = User::all();        
      $data = array('user' => $dataUser);   
      return view('admin.dashboard.user.user',$data);
    }
        /**
     * Method Membuat akun baru
     *
     * @return Response
     */
    public function createAkunNew(Request $request)
    {
      // $level = $request['level'];      
      $input =$request->all();
      $pesan = array(
            'name.required'       => 'Nama Pengguna dibutuhkan.',
            'username.required'       => 'Username dibutuhkan.',
            'email.required'       => 'Email dibutuhkan.',
            'password.required'       => 'Password dibutuhkan.',
            'level.required'       => 'Jenis Hak Akses dibutuhkan.',
        );

        $aturan = array(
            'name'        => 'required',
            'username'        => 'required',
            'email'        => 'required',
            'password'        => 'required',
            'level'        => 'required',
        );
        
        $validator = Validator::make($input,$aturan, $pesan);

        if($validator->fails()) {
          # Kembali kehalaman yang sama dengan pesan error
          return Redirect::back()->withErrors($validator)->withInput();
        }
        # Bila validasi sukses
        // buat akun baru
        $akunNew = new User;
        $akunNew->name        = $request['name'];
        $akunNew->username    = $request['username'];
        $akunNew->email       = $request['email'];
        $akunNew->password    = bcrypt($request['password']);
        $akunNew->level       = $request['level'];

        if (! $akunNew->save() )
          App::abort(500);

        Session::flash('flash_message', 'Data User Baru "'.$request['username'].'" - " '.$request['email'].'" Berhasil disimpan.');

        // If level is 12 (guru) or 13 (siswa), redirect to create guru/siswa form
        if ($request['level'] == '12') {
            Session::flash('flash_message', 'User guru berhasil dibuat. Silahkan lengkapi data guru.');
            return Redirect::action('Admin\GuruController@showTambahGuru');
        } elseif ($request['level'] == '13') {
            Session::flash('flash_message', 'User siswa berhasil dibuat. Silahkan lengkapi data siswa.');
            return Redirect::action('Admin\SiswaController@showTambahSiswa');
        }

        return Redirect::action('AdminController@index_user');
     
    }

    public function hapus($id_user)
    {
    
      $id_user = User::where('id_user', '=', $id_user)->first();

      if ($id_user == null)
        app::abort(404);
      
      Session::flash('flash_message', 'Data User "'.$id_user->id_user.'" - "'.$id_user->name.'" Berhasil dihapus.');

      $id_user->delete();
      
      return Redirect::action('AdminController@index_user');

    }

     public function edituser($id_user)
    {

        $data = User::find($id_user);
        // dd($data->password);

        return view('admin.dashboard.user.edit_user',$data);                
    }

 public function simpanedit($id_user)
    {
        $input =Input::all();
        // dd($input);
        $pesan = array(
            'name.required'       => 'Nama Pengguna dibutuhkan.',
            'username.required'       => 'Username dibutuhkan.',
            'email.required'       => 'Email dibutuhkan.',
            'password.required'       => 'Password dibutuhkan.',
            'level.required'       => 'Jenis Hak Akses dibutuhkan.',
        );

        $aturan = array(
            'name'        => 'required',
            'username'        => 'required',
            'email'        => 'sometimes',
            'password'        => 'sometimes',
            'level'        => 'required',
        );

        $validator = Validator::make($input,$aturan, $pesan);
        // tipe validasi 1 
        if($validator->fails()) {
            # Kembali kehalaman yang sama dengan pesan error
            return Redirect::back()->withErrors($validator)->withInput();          
        }
        # Bila validasi sukses
        $akunEdit = User::find($id_user);
        $akunEdit->name        = $input['name'];
        $akunEdit->username    = $input['username'];
        $akunEdit->email       = $input['email'];
        // $akunEdit->password    = $input['password'];
        $akunEdit->level       = $input['level'];               

        if (! $akunEdit->save())
          App::abort(500);

        Session::flash('flash_message', 'Data User "'.$input['username'].'" - " '.$input['email'].'" Berhasil diubah.');

        return Redirect::action('AdminController@index_user');                
    }

    
    public function test_view()
    {
      return view('test_view');
    }

    public function showUbahPasswordUserAdmin($id_user)
    {      
      $user = User::find($id_user);
      return view('users.ubah_password_user')
              ->with('user', $user);
    }

    public function showUbahPasswordUser()
    {    
      $user = Auth::user();
      return view('users.ubah_password_user')
              ->with('user', $user);
    }

    public function simpanubahpassworduser()
    {                
        if (Auth::user()->level == 11) {
          $request = Input::all();      
          $user = User::find($request['id_user']);   

          $messages = array(            
            'newpassword.required' => 'Anda belum mengisi password baru',            
            'newpassword.min' => 'Password baru kurang dari 6 karakter',            
        );

        $rules = [                        
            'newpassword' => 'required|min:6',            
          ];
        }
        else{
          $request = Input::all();
          $user = Auth::user(); 

          Validator::extend('passcheck', function($attribute, $value, $parameters) {            
            return Hash::check($value, Auth::user()->password);
          });          

          $messages = array(
            'passcheck' => 'Password lama tidak sesuai dengan database',
            'oldpassword.required' => 'Anda belum mengisi password lama',
            'newpassword.required' => 'Anda belum mengisi password baru',
            'newpassword_confirmation.required' => 'Anda belum mengisi konfirmasi password baru',
            'newpassword.min' => 'Password baru kurang dari 6 karakter',
            'newpassword.confirmed' => 'Password baru tidak sesuai konfirmasi',
        );

        $rules = [
            'oldpassword' => 'passcheck',
            'oldpassword' => 'required',            
            'newpassword' => 'required|min:6|confirmed',
            'newpassword_confirmation' => 'required',
          ];
        }
        

        $validator = Validator::make($request,$rules,$messages);
        // tipe validasi 2
        if($validator->passes()){
            $user->password = bcrypt($request['newpassword']);
            $user->save();

            if (Auth::user()->level == 11) {
              Session::flash('flash_message', 'Password user berhasil diubah');
              return Redirect::action('AdminController@index_user');
            } else {
              Session::flash('flash_message', 'Anda telah berhasil melakukan perubahan password, silahkan login kembali untuk mengaktifkanya');
              return Redirect::action('AdminController@index');
            }
        }else{
          return Redirect::back()->withErrors($validator)->withInput();
        }
    }

    public function index(Request $request){
      $level = Auth::user()->level;

      switch ($level) {
        case "11":
            return $this->dashboardLevel11(); //Admin
            break;
        case "12":
            return $this->dashboardLevel12(); //Guru
            break;
        case "13":
            return $this->dashboardLevel13(); //Siswa
            break;        
        default:
            return "Dashboard SI E-Learning!";
      }
    }    

  public function dashBoardLevel11(){    
      $countSiswa   = Siswa::count();
      $countGuru   = Guru::count();
      $countMapel   = MataPelajaran::count();
      $countPengumuman   = Pengumuman::count();
      $countSoal   = Soal::count();
      $countUjian   = Ujian::count();
      return view('admin.dashboard.index.main_admin')
             ->with('countSiswa', $countSiswa)
             ->with('countGuru', $countGuru)
             ->with('countMapel', $countMapel)
             ->with('countPengumuman', $countPengumuman)
             ->with('countSoal', $countSoal)
             ->with('countUjian', $countUjian);
    }

  public function dashBoardLevel12(){
      $guru = Guru::where('id_user', Auth::user()->id_user)->first();
      if (!$guru) {
          Auth::logout();
          return redirect('login')->withErrors(['error' => 'Data guru tidak ditemukan. Silahkan hubungi admin untuk melengkapi data guru.']);
      }
      if (!$guru->nip_guru) {
          Auth::logout();
          return redirect('login')->withErrors(['error' => 'NIP guru tidak ditemukan. Silahkan hubungi admin untuk melengkapi data NIP guru.']);
      }
      // Check if teacher has any assignments in guru_mapel table
      $guruAssignments = DB::table('guru_mapel')->where('nip_guru', $guru->nip_guru)->count();
      if ($guruAssignments == 0) {
          Auth::logout();
          return redirect('login')->withErrors(['error' => 'Guru belum di-assign ke mata pelajaran manapun. Silahkan hubungi admin untuk assign mata pelajaran.']);
      }

      // Get all subjects assigned to this teacher
      $assignedSubjects = DB::table('guru_mapel')
          ->join('mata_pelajarans', 'guru_mapel.id_mapel', '=', 'mata_pelajarans.id_mapel')
          ->where('guru_mapel.nip_guru', $guru->nip_guru)
          ->pluck('mata_pelajarans.nama_mapel')
          ->toArray();

      $dataSoalUjian = DB::table('soals')
               ->join('ujians', 'soals.id_ujian', '=', 'ujians.id_ujian')
               ->leftjoin('mata_pelajarans','ujians.id_mapel','=','mata_pelajarans.id_mapel')
               ->leftjoin('gurus','mata_pelajarans.nip_guru','=','gurus.nip_guru')
               ->select('soals.*', 'ujians.*', 'mata_pelajarans.nama_mapel', 'gurus.nama_guru')
               ->whereIn('mata_pelajarans.nama_mapel', $assignedSubjects)
               ->get();
      $countSoal   = count($dataSoalUjian);
      $dataUjian = DB::table('ujians')
                 ->join('mata_pelajarans', 'ujians.id_mapel', '=', 'mata_pelajarans.id_mapel')
                 ->select('ujians.*', 'mata_pelajarans.nama_mapel')
                 ->whereIn('mata_pelajarans.nama_mapel', $assignedSubjects)
                 ->get();
      $countUjian   = count($dataUjian);
      return view('admin.dashboard.index.main_guru')
             ->with('countSoal', $countSoal)
             ->with('countUjian', $countUjian);
    }

  public function dashBoardLevel13(){
      $siswa = Siswa::where('id_user', Auth::user()->id_user)->first();
      if (!$siswa) {
          Auth::logout();
          return redirect('login')->withErrors(['error' => 'Data siswa tidak ditemukan. Silahkan hubungi admin untuk melengkapi data siswa.']);
      }
      $kelas_siswa = Kelas::where('nama_kelas', $siswa->kelas_siswa)->get();

      $dataUjian = DB::table('ujians')                  
                 ->join('mata_pelajarans', 'ujians.id_mapel', '=', 'mata_pelajarans.id_mapel')
                 ->select('ujians.*', 'mata_pelajarans.nama_mapel')
                 ->where('kelas_ujian', $siswa->kelas_siswa)
                 ->where('status_ujian', 'Aktif')
                 ->get();
      $countUjian   = count($dataUjian);
      $countPengumuman   = Pengumuman::count();      
      return view('admin.dashboard.index.main_siswa')
            ->with('countUjian', $countUjian)            
            ->with('countPengumuman', $countPengumuman);     
    }   

}