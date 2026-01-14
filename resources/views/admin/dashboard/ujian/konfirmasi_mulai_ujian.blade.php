@extends('admin.layout.master')

@section('content')
<div class="container">
    <h3>Konfirmasi Mulai Ujian</h3>
    <div class="alert alert-info">
        <strong>Ujian:</strong> {{ $ujian->judul_ujian }}<br>
        <strong>Mata Pelajaran:</strong> {{ $nama_mapel }}<br>
        <strong>Tanggal Ujian:</strong> {{ $ujian->tgl_ujian }}<br>
        <strong>Kelas:</strong> {{ $ujian->kelas_ujian }}
    </div>
    <form method="POST" action="{{ route('siswa.ujian.simpan_mulai', $ujian->id_ujian) }}">
        @csrf
        <div class="form-group">
            <label>Apakah Anda yakin ingin memulai ujian ini?</label>
        </div>
        <button type="submit" class="btn btn-primary">Ya, Mulai Ujian</button>
        <a href="{{ route('siswa.ujian.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
