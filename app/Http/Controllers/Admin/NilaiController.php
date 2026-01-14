<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Auth;
use DB;
use Session;
use App\Siswa;
use App\Guru;
use App\Kelas;
use App\MataPelajaran;
use App\Ujian;
use App\NilaiUjianPilihanGandaSiswa;

class NilaiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show nilai by kelas for admin/guru
     */
    public function showKelasNilai(Request $request)
    {
        $user = Auth::user();
        $listKelas = Kelas::all();
        
        // Get assigned subjects for guru
        $assignedSubjects = [];
        if ($user->level == 12) {
            $guru = Guru::where('id_user', $user->id_user)->first();
            if ($guru) {
                $assignedSubjects = DB::table('guru_mapel')
                    ->join('mata_pelajarans', 'guru_mapel.id_mapel', '=', 'mata_pelajarans.id_mapel')
                    ->where('guru_mapel.nip_guru', $guru->nip_guru)
                    ->pluck('mata_pelajarans.nama_mapel')
                    ->toArray();
            }
        }

        $kelas_terpilih = $request->input('kelas_terpilih');

        $nilaiUjian = collect();

        if ($kelas_terpilih) {
            // Build query for nilai ujian
            $query = DB::table('nilai_ujian_pilgan_siswas')
                ->join('siswas', 'nilai_ujian_pilgan_siswas.nisn_siswa', '=', 'siswas.nisn_siswa')
                ->join('ujians', 'nilai_ujian_pilgan_siswas.id_ujian', '=', 'ujians.id_ujian')
                ->join('mata_pelajarans', 'ujians.id_mapel', '=', 'mata_pelajarans.id_mapel')
                ->select(
                    'nilai_ujian_pilgan_siswas.*',
                    'siswas.nisn_siswa',
                    'siswas.nama_siswa',
                    'siswas.kelas_siswa',
                    'ujians.judul_ujian',
                    'ujians.jenis_ujian',
                    'ujians.id_ujian',
                    'ujians.nilai_visible',
                    'mata_pelajarans.nama_mapel'
                )
                ->where('siswas.kelas_siswa', $kelas_terpilih);

            // Filter by assigned subjects if guru
            if ($user->level == 12 && count($assignedSubjects) > 0) {
                $query->whereIn('mata_pelajarans.nama_mapel', $assignedSubjects);
            }

            $nilaiUjian = $query->orderBy('siswas.nama_siswa')->get();
        }

        return view('admin.dashboard.nilai.nilai')
            ->with('listKelas', $listKelas)
            ->with('kelas_terpilih', $kelas_terpilih)
            ->with('nilaiUjian', $nilaiUjian);
    }

    /**
     * Show nilai for siswa
     */
    public function showSiswaKelasNilai()
    {
        $user = Auth::user();
        $siswa = Siswa::where('id_user', $user->id_user)->first();
        
        if (!$siswa) {
            return redirect()->back()->withErrors(['error' => 'Data siswa tidak ditemukan']);
        }

        // Get nilai ujian for this siswa (semua ujian yang sudah dikerjakan)
        $nilaiUjian = DB::table('nilai_ujian_pilgan_siswas')
            ->join('ujians', 'nilai_ujian_pilgan_siswas.id_ujian', '=', 'ujians.id_ujian')
            ->join('mata_pelajarans', 'ujians.id_mapel', '=', 'mata_pelajarans.id_mapel')
            ->select(
                'nilai_ujian_pilgan_siswas.*',
                'ujians.judul_ujian',
                'ujians.jenis_ujian',
                'ujians.nilai_visible',
                'mata_pelajarans.nama_mapel'
            )
            ->where('nilai_ujian_pilgan_siswas.nisn_siswa', $siswa->nisn_siswa)
            ->orderBy('ujians.judul_ujian')
            ->get();

        return view('siswa.dashboard.nilai.nilai_siswa')
            ->with('nilaiUjian', $nilaiUjian)
            ->with('siswa', $siswa);
    }

    /**
     * Toggle nilai visibility for an ujian
     */
    public function toggleNilaiVisibility(Request $request)
    {
        $jenisUjian = $request->input('jenis_ujian');
        $kelas = $request->input('kelas');
        $visible = $request->input('visible') == '1' ? false : true; // Toggle

        // Update all ujian of this jenis for this kelas
        $ujianIds = DB::table('ujians')
            ->where('jenis_ujian', $jenisUjian)
            ->where('kelas_ujian', $kelas)
            ->pluck('id_ujian');

        Ujian::whereIn('id_ujian', $ujianIds)->update(['nilai_visible' => $visible]);
        
        Session::flash('flash_message', 'Visibilitas nilai berhasil diubah');

        return redirect()->back();
    }

    /**
     * Show detail jawaban siswa per ujian
     */
    public function showDetailJawaban($id_nilai)
    {
        $nilaiUjian = NilaiUjianPilihanGandaSiswa::find($id_nilai);
        
        if (!$nilaiUjian) {
            return redirect()->back()->with('flash_message', 'Data nilai tidak ditemukan');
        }

        // Get siswa info
        $siswa = Siswa::where('nisn_siswa', $nilaiUjian->nisn_siswa)->first();
        
        // Get ujian info
        $ujian = Ujian::find($nilaiUjian->id_ujian);
        $mapel = MataPelajaran::find($ujian->id_mapel);

        // Get all jawaban siswa untuk ujian ini
        $jawabanSiswa = DB::table('siswa_jawab_ujian_pilgans')
            ->join('soals', 'siswa_jawab_ujian_pilgans.id_soal', '=', 'soals.id_soal')
            ->leftJoin('jawaban_soal_ujians as jawaban_dipilih', 'siswa_jawab_ujian_pilgans.id_jawaban_soal_ujian', '=', 'jawaban_dipilih.id_jawaban_soal_ujian')
            ->select(
                'siswa_jawab_ujian_pilgans.*',
                'soals.pertanyaan',
                'soals.gambar as gambar_soal',
                'jawaban_dipilih.jawaban as jawaban_dipilih_text',
                'jawaban_dipilih.is_benar as jawaban_dipilih_benar'
            )
            ->where('siswa_jawab_ujian_pilgans.id_nilai_ujian_pilgan', $id_nilai)
            ->orderBy('siswa_jawab_ujian_pilgans.id_siswa_jawab_ujian_pilgan')
            ->get();

        // Get all jawaban options for each soal
        foreach ($jawabanSiswa as $js) {
            $js->opsi_jawaban = DB::table('jawaban_soal_ujians')
                ->where('id_soal', $js->id_soal)
                ->orderBy('id_jawaban_soal_ujian')
                ->get();
            
            // Get jawaban benar
            $js->jawaban_benar = DB::table('jawaban_soal_ujians')
                ->where('id_soal', $js->id_soal)
                ->where('is_benar', 1)
                ->first();
        }

        return view('admin.dashboard.nilai.detail_jawaban')
            ->with('nilaiUjian', $nilaiUjian)
            ->with('siswa', $siswa)
            ->with('ujian', $ujian)
            ->with('mapel', $mapel)
            ->with('jawabanSiswa', $jawabanSiswa);
    }
}
