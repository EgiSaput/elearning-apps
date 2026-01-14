@extends('admin.layout.master')
@section('breadcrump')
          <h1>
            Nilai Saya
            <small>Daftar nilai ujian</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
            <li class="active">Siswa</li>
            <li class="active">Nilai Saya</li>
          </ol>
@stop
@section('content')
<div class="row">
  <div class="col-xs-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Nilai Ujian - {{ $siswa->nama_siswa ?? '' }}</h3>
      </div>

      <div class="box-body">
        <!-- Info Siswa -->
        <div class="alert alert-info">
          <strong><i class="fa fa-user"></i> {{ $siswa->nama_siswa ?? '' }}</strong><br>
          <small>NISN: {{ $siswa->nisn_siswa ?? '' }} | Kelas: {{ $siswa->kelas_siswa ?? '' }}</small>
        </div>

        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
          <li class="active"><a href="#ujian_harian" data-toggle="tab">Ujian Harian</a></li>
          <li><a href="#ujian_tengah_semester" data-toggle="tab">Ujian Tengah Semester</a></li>
          <li><a href="#ujian_akhir_semester" data-toggle="tab">Ujian Akhir Semester</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
          <!-- Ujian Harian Tab -->
          <div class="tab-pane fade in active" id="ujian_harian">
            <br/>
            @php
              $filteredNilaiUjianHarian = collect($nilaiUjian ?? [])->filter(function($n) {
                return $n->jenis_ujian == 'Ujian Harian';
              });
            @endphp
            @if (count($filteredNilaiUjianHarian) > 0)
              <div class="table-responsive">
                <table class="table table-striped table-hover">
                  <thead>
                    <tr class="bg-primary">
                      <th class="text-center">No</th>
                      <th>Mata Pelajaran</th>
                      <th>Judul Ujian</th>
                      <th class="text-center">Nilai</th>
                      <th class="text-center">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                   @php $i=1; @endphp
                   @foreach ($filteredNilaiUjianHarian as $dataNilaiUjian)
                    <tr>
                      <td class="text-center">{{ $i }}</td>
                      <td>{{ $dataNilaiUjian->nama_mapel }}</td>
                      <td>{{ $dataNilaiUjian->judul_ujian }}</td>
                      <td class="text-center">
                        @if($dataNilaiUjian->nilai_visible)
                          @if($dataNilaiUjian->nilai >= 80)
                            <span class="badge bg-green">{{ $dataNilaiUjian->nilai }}</span>
                          @elseif($dataNilaiUjian->nilai >= 70)
                            <span class="badge bg-yellow">{{ $dataNilaiUjian->nilai }}</span>
                          @else
                            <span class="badge bg-red">{{ $dataNilaiUjian->nilai }}</span>
                          @endif
                        @else
                          <span class="badge bg-gray">Tersembunyi</span>
                        @endif
                      </td>
                      <td class="text-center">
                        @if($dataNilaiUjian->nilai_visible)
                          @if($dataNilaiUjian->nilai >= 70)
                            <span class="label label-success">Lulus</span>
                          @else
                            <span class="label label-danger">Tidak Lulus</span>
                          @endif
                        @else
                          <span class="label label-default">Tersembunyi</span>
                        @endif
                      </td>
                    </tr>
                    @php $i++; @endphp
                    @endforeach
                  </tbody>
                </table>
              </div>
            @else
              <div class="alert alert-info text-center">
                <i class="fa fa-info-circle"></i> Belum ada nilai ujian harian.
              </div>
            @endif
          </div>

          <!-- Ujian Tengah Semester Tab -->
          <div class="tab-pane fade" id="ujian_tengah_semester">
            <br/>
            @php
              $filteredNilaiUjianTengah = collect($nilaiUjian ?? [])->filter(function($n) {
                return $n->jenis_ujian == 'Ujian Tengah Semester';
              });
            @endphp
            @if (count($filteredNilaiUjianTengah) > 0)
              <div class="table-responsive">
                <table class="table table-striped table-hover">
                  <thead>
                    <tr class="bg-primary">
                      <th class="text-center">No</th>
                      <th>Mata Pelajaran</th>
                      <th>Judul Ujian</th>
                      <th class="text-center">Nilai</th>
                      <th class="text-center">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                   @php $i=1; @endphp
                   @foreach ($filteredNilaiUjianTengah as $dataNilaiUjian)
                    <tr>
                      <td class="text-center">{{ $i }}</td>
                      <td>{{ $dataNilaiUjian->nama_mapel }}</td>
                      <td>{{ $dataNilaiUjian->judul_ujian }}</td>
                      <td class="text-center">
                        @if($dataNilaiUjian->nilai_visible)
                          @if($dataNilaiUjian->nilai >= 80)
                            <span class="badge bg-green">{{ $dataNilaiUjian->nilai }}</span>
                          @elseif($dataNilaiUjian->nilai >= 70)
                            <span class="badge bg-yellow">{{ $dataNilaiUjian->nilai }}</span>
                          @else
                            <span class="badge bg-red">{{ $dataNilaiUjian->nilai }}</span>
                          @endif
                        @else
                          <span class="badge bg-gray">Tersembunyi</span>
                        @endif
                      </td>
                      <td class="text-center">
                        @if($dataNilaiUjian->nilai_visible)
                          @if($dataNilaiUjian->nilai >= 70)
                            <span class="label label-success">Lulus</span>
                          @else
                            <span class="label label-danger">Tidak Lulus</span>
                          @endif
                        @else
                          <span class="label label-default">Tersembunyi</span>
                        @endif
                      </td>
                    </tr>
                    @php $i++; @endphp
                    @endforeach
                  </tbody>
                </table>
              </div>
            @else
              <div class="alert alert-info text-center">
                <i class="fa fa-info-circle"></i> Belum ada nilai ujian tengah semester.
              </div>
            @endif
          </div>

          <!-- Ujian Akhir Semester Tab -->
          <div class="tab-pane fade" id="ujian_akhir_semester">
            <br/>
            @php
              $filteredNilaiUjianAkhir = collect($nilaiUjian ?? [])->filter(function($n) {
                return $n->jenis_ujian == 'Ujian Akhir Semester';
              });
            @endphp
            @if (count($filteredNilaiUjianAkhir) > 0)
              <div class="table-responsive">
                <table class="table table-striped table-hover">
                  <thead>
                    <tr class="bg-primary">
                      <th class="text-center">No</th>
                      <th>Mata Pelajaran</th>
                      <th>Judul Ujian</th>
                      <th class="text-center">Nilai</th>
                      <th class="text-center">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                   @php $i=1; @endphp
                   @foreach ($filteredNilaiUjianAkhir as $dataNilaiUjian)
                    <tr>
                      <td class="text-center">{{ $i }}</td>
                      <td>{{ $dataNilaiUjian->nama_mapel }}</td>
                      <td>{{ $dataNilaiUjian->judul_ujian }}</td>
                      <td class="text-center">
                        @if($dataNilaiUjian->nilai_visible)
                          @if($dataNilaiUjian->nilai >= 80)
                            <span class="badge bg-green">{{ $dataNilaiUjian->nilai }}</span>
                          @elseif($dataNilaiUjian->nilai >= 70)
                            <span class="badge bg-yellow">{{ $dataNilaiUjian->nilai }}</span>
                          @else
                            <span class="badge bg-red">{{ $dataNilaiUjian->nilai }}</span>
                          @endif
                        @else
                          <span class="badge bg-gray">Tersembunyi</span>
                        @endif
                      </td>
                      <td class="text-center">
                        @if($dataNilaiUjian->nilai_visible)
                          @if($dataNilaiUjian->nilai >= 70)
                            <span class="label label-success">Lulus</span>
                          @else
                            <span class="label label-danger">Tidak Lulus</span>
                          @endif
                        @else
                          <span class="label label-default">Tersembunyi</span>
                        @endif
                      </td>
                    </tr>
                    @php $i++; @endphp
                    @endforeach
                  </tbody>
                </table>
              </div>
            @else
              <div class="alert alert-info text-center">
                <i class="fa fa-info-circle"></i> Belum ada nilai ujian akhir semester.
              </div>
            @endif
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@stop
