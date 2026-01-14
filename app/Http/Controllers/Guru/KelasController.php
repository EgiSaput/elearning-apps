<?php

namespace App\Http\Controllers\Guru;

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
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $guru = Guru::where('id_user', Auth::user()->id_user)->first();
        $mapelIds = $guru ? $guru->mataPelajaran()->get()->pluck('id_mapel')->toArray() : [];
        $dataKelas = [];
        if (count($mapelIds)) {
            $dataKelas = DB::table('kelas_have_mata_pelajarans')
                         ->join('mata_pelajarans', 'kelas_have_mata_pelajarans.id_mapel', '=', 'mata_pelajarans.id_mapel')
                         ->leftJoin('guru_mapel', function($join) use ($guru) {
                             $join->on('mata_pelajarans.id_mapel', '=', 'guru_mapel.id_mapel')
                                  ->where('guru_mapel.nip_guru', '=', $guru->nip_guru);
                         })
                         ->select('kelas_have_mata_pelajarans.*', 'mata_pelajarans.nama_mapel', 'guru_mapel.nama_kelas as assigned_kelas')
                         ->whereIn('kelas_have_mata_pelajarans.id_mapel', $mapelIds)
                         ->orderBy('kelas_have_mata_pelajarans.nama_kelas', 'asc')
                         ->get();
        }
        $data = array('kelas' => $dataKelas);
        return view('guru.dashboard.kelas.kelas', $data);
    }

    public function manage()
    {
        $guru = Guru::where('id_user', Auth::user()->id_user)->first();
        $mapelIds = $guru ? $guru->mataPelajaran()->get()->pluck('id_mapel')->toArray() : [];
        $dataKelas = [];
        if (count($mapelIds)) {
            $dataKelas = DB::table('kelas_have_mata_pelajarans')
                         ->join('mata_pelajarans', 'kelas_have_mata_pelajarans.id_mapel', '=', 'mata_pelajarans.id_mapel')
                         ->leftJoin('guru_mapel', function($join) use ($guru) {
                             $join->on('mata_pelajarans.id_mapel', '=', 'guru_mapel.id_mapel')
                                  ->where('guru_mapel.nip_guru', '=', $guru->nip_guru);
                         })
                         ->select('kelas_have_mata_pelajarans.*', 'mata_pelajarans.nama_mapel', 'guru_mapel.nama_kelas as assigned_kelas')
                         ->whereIn('kelas_have_mata_pelajarans.id_mapel', $mapelIds)
                         ->orderBy('kelas_have_mata_pelajarans.nama_kelas', 'asc')
                         ->get();
        }
        $data = array('kelas' => $dataKelas);
        return view('guru.dashboard.kelas.manage_kelas', $data);
    }

    public function updateAssignments(Request $request)
    {
        $guru = Guru::where('id_user', Auth::user()->id_user)->first();
        if (!$guru) {
            return Redirect::back()->withErrors(['error' => 'Guru tidak ditemukan.']);
        }

        $assignments = $request->input('assignments', []);

        // Clear existing assignments for this guru
        DB::table('guru_mapel')->where('nip_guru', $guru->nip_guru)->delete();

        // Insert new assignments
        foreach ($assignments as $assignment) {
            DB::table('guru_mapel')->insert([
                'nip_guru' => $guru->nip_guru,
                'id_mapel' => $assignment['id_mapel'],
                'nama_kelas' => $assignment['nama_kelas'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Session::flash('flash_message', 'Penugasan kelas berhasil diperbarui.');
        return Redirect::action('Guru\KelasController@index');
    }
}
