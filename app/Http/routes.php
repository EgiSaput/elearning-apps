<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\{
    UjianController,
    PengumumanController,
    KelasController,
    SiswaController,
    GuruController,
    MataPelajaranController,
    SoalUjianController,
    NilaiController,
    NilaiUjianController,
    SiswaJawabUjianController
};

/*
|--------------------------------------------------------------------------
| AUTH & HOME
|--------------------------------------------------------------------------
*/
Route::middleware(['web'])->group(function () {

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [AdminController::class, 'index'])->name('admin');
});

/*
|--------------------------------------------------------------------------
| SISWA
|--------------------------------------------------------------------------
*/
Route::middleware(['web', 'auth'])->prefix('siswa')->group(function () {

    Route::get('pengumuman', [PengumumanController::class, 'index_siswa'])->name('siswa.pengumuman');

    Route::get('ujian', [UjianController::class, 'index_siswa'])->name('siswa.ujian.index');
    Route::get('ujian/{id}', [UjianController::class, 'show'])->name('siswa.ujian.show');
    Route::get('ujian/{id}/detail', [UjianController::class, 'detail'])->name('siswa.detail_ujian');

    Route::get('ujian/{id}/ambil', [UjianController::class, 'ambilUjian'])->name('siswa.ujian.ambil');
    Route::post('ujian/{id}/ambil', [UjianController::class, 'simpanAmbilUjian'])->name('siswa.ujian.simpan_ambil');

    Route::get('ujian/{id}/mulai', [UjianController::class, 'mulaiUjian'])->name('siswa.ujian.mulai');
    Route::post('ujian/{id}/mulai', [UjianController::class, 'simpanMulaiUjian'])->name('siswa.ujian.simpan_mulai');

    Route::get('ujians/{ujians}/soals/{soals}', [SoalUjianController::class, 'show'])->name('siswa.soal_ujian.show');
    Route::put('ujians/{ujians}/soals/{soals}', [SoalUjianController::class, 'update'])->name('siswa.soal_ujian.update');

    Route::get('nilai', [NilaiController::class, 'showSiswaKelasNilai'])->name('siswa.nilai');

    Route::get('siswa/{id}/detail', [SiswaController::class, 'detail_siswa'])->name('siswa.detailsiswa');
    Route::get('siswa/edit', [SiswaController::class, 'edit_asSiswa'])->name('siswa.editsiswa');
    Route::put('siswa/simpanedit', [SiswaController::class, 'simpanedit_asSiswa'])->name('siswa.siswa.simpanedit');

    Route::get('ubahpassword', [AdminController::class, 'showUbahPasswordUser'])->name('siswa.user.ubah_password');
    Route::post('ubahpassword', [AdminController::class, 'simpanubahpassworduser'])->name('siswa.user.simpanedit');
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['web', 'auth', 'level:11'])->prefix('admin')->group(function () {

    Route::get('pengumuman', [PengumumanController::class, 'index'])->name('admin.pengumuman');
    Route::post('pengumuman/tambah', [PengumumanController::class, 'tambah'])->name('admin.tambahpengumuman');
    Route::put('pengumuman/{id}/simpanedit', [PengumumanController::class, 'simpanedit'])->name('admin.pengumuman.simpanedit');
    Route::get('pengumuman/{id}/hapus', [PengumumanController::class, 'hapus'])->name('admin.hapuspengumuman');

    Route::resource('kelas', KelasController::class)->except(['show']);
    Route::resource('siswa', SiswaController::class);
    Route::resource('guru', GuruController::class);
    Route::resource('mapel', MataPelajaranController::class);

    Route::resource('ujian', UjianController::class);
    Route::resource('soal_ujian', SoalUjianController::class);

    Route::get('nilai_siswa', [NilaiController::class, 'showKelasNilai'])->name('admin.nilai_siswa');
    Route::post('nilai/toggle_visibility', [NilaiController::class, 'toggleNilaiVisibility'])->name('admin.nilai.toggle_visibility');

    Route::resource('nilai_ujian', NilaiUjianController::class);
});

/*
|--------------------------------------------------------------------------
| GURU
|--------------------------------------------------------------------------
*/
Route::middleware(['web', 'auth', 'level:12'])->prefix('guru')->group(function () {

    Route::get('kelas', [KelasController::class, 'index_guru'])->name('guru.kelas');

    Route::get('ujian', [UjianController::class, 'index'])->name('guru.ujian');
    Route::get('ujian/{id}', [UjianController::class, 'show'])->name('guru.ujian.show');

    Route::resource('soal_ujian', SoalUjianController::class);

    Route::get('nilai', [NilaiController::class, 'showKelasNilai'])->name('guru.nilai');
    Route::post('nilai/toggle_visibility', [NilaiController::class, 'toggleNilaiVisibility'])->name('guru.nilai.toggle_visibility');

    Route::get('guru/edit', [GuruController::class, 'edit_asGuru'])->name('guru.editguru');
    Route::put('guru/simpanedit', [GuruController::class, 'simpanedit_asGuru'])->name('guru.guru.simpanedit');
});
