@extends('guru.layout.master')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Kelola Penugasan Kelas</h3>
                <div class="box-tools pull-right">
                    <a href="{{ route('guru.kelas') }}" class="btn btn-default btn-sm">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="box-body">
                <form action="{{ route('guru.kelas.update_assignments') }}" method="POST">
                    @csrf
                    <p class="text-info">
                        <i class="fa fa-info-circle"></i> Pilih kelas yang ingin Anda ajar untuk setiap mata pelajaran.
                    </p>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Mata Pelajaran</th>
                                <th>Nama Kelas</th>
                                <th>Ajar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kelas as $k)
                            <tr>
                                <td>{{ $k->nama_mapel }}</td>
                                <td>{{ $k->nama_kelas }}</td>
                                <td>
                                    <input type="checkbox"
                                           name="assignments[{{ $loop->index }}][id_mapel]"
                                           value="{{ $k->id_mapel }}"
                                           {{ $k->assigned_kelas ? 'checked' : '' }}>
                                    <input type="hidden"
                                           name="assignments[{{ $loop->index }}][nama_kelas]"
                                           value="{{ $k->nama_kelas }}">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Simpan Penugasan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
