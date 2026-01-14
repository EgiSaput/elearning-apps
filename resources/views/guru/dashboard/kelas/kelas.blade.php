@extends('guru.layout.master')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Daftar Kelas Saya</h3>
                <div class="box-tools pull-right">
                    <a href="{{ route('guru.kelas.manage') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-cog"></i> Kelola Penugasan
                    </a>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kelas</th>
                            <th>Mata Pelajaran</th>
                            <th>Status Penugasan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kelas as $index => $k)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $k->nama_kelas }}</td>
                            <td>{{ $k->nama_mapel }}</td>
                            <td>
                                @if($k->assigned_kelas)
                                    <span class="label label-success">Ditugaskan</span>
                                @else
                                    <span class="label label-warning">Belum Ditugaskan</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data kelas</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
