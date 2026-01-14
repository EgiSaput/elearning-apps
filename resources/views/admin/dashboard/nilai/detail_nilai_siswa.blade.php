@extends('admin.layout.master')
@section('breadcrump')
          <h1>
            Nilai Siswa - {{$siswa->nama_siswa}}
            <small>Kelas {{$siswa->kelas_siswa}}</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
            <li class="active">Nilai Siswa</li>
          </ol>
@stop
@section('content')
<div class="row">
  <div class="col-xs-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Nilai Akademik Siswa</h3>
      </div>

      <div class="box-body">
        <!-- Filter Mata Pelajaran -->
        <form id="formKelasMapel" class="form-inline" role="form" method="GET" action="{{ route('siswa.nilai')}}" style="margin-bottom: 20px;">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="form-group">
            <label style="margin-right:10px; font-weight:600;">Pilih Mata Pelajaran:</label>
            <select class="form-control" name="mapel_terpilih" style="min-width:200px;">
              <option value="">Semua Mata Pelajaran</option>
             @foreach ($listMapel as $dataMapel)
              <option value="{{$dataMapel->nama_mapel}}"  @if($mapel_terpilih == $dataMapel->nama_mapel) selected="selected" @endif > {{$dataMapel->nama_mapel}}</option>
             @endforeach
            </select>
            <button type="submit" class="btn btn-primary" style="margin-left:10px;">
              <i class="fa fa-search"></i> Tampilkan
            </button>
          </div>
        </form>

        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
          <li class="active"><a href="#nilai_tugas" data-toggle="tab">Nilai Tugas</a></li>
          <li><a href="#nilai_ujian" data-toggle="tab">Nilai Ujian</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
          <!-- Nilai Tugas Tab -->
          <div class="tab-pane fade in active" id="nilai_tugas">
            <br/>
            @if (count($nilaiTugas) > 0)
              <!-- Responsive Table for Tugas -->
              <div class="table-responsive">
                <table id="dataTabelNilaiTugas" class="table table-striped table-hover">
                  <thead>
                    <tr class="bg-primary">
                      <th class="text-center">No</th>
                      <th>Mata Pelajaran</th>
                      <th>Judul Tugas</th>
                      <th class="text-center">Nilai</th>
                      <th class="text-center">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                   <?php $i=1; foreach ($nilaiTugas as $dataNilaiTugas):  ?>
                    <tr>
                      <td class="text-center">{{ $i }}</td>
                      <td>{{ $dataNilaiTugas->nama_mapel }}</td>
                      <td>{{ $dataNilaiTugas->judul_tugas }}</td>
                      <td class="text-center">
                        @if($dataNilaiTugas->nilai >= 80)
                          <span class="badge bg-green">{{ $dataNilaiTugas->nilai }}</span>
                        @elseif($dataNilaiTugas->nilai >= 70)
                          <span class="badge bg-yellow">{{ $dataNilaiTugas->nilai }}</span>
                        @else
                          <span class="badge bg-red">{{ $dataNilaiTugas->nilai }}</span>
                        @endif
                      </td>
                      <td class="text-center">
                        @if($dataNilaiTugas->nilai >= 70)
                          <span class="label label-success">Lulus</span>
                        @else
                          <span class="label label-danger">Tidak Lulus</span>
                        @endif
                      </td>
                    </tr>
                    <?php $i++; endforeach  ?>
                  </tbody>
                </table>
              </div>
            @else
              <div class="alert alert-info text-center">
                <i class="fa fa-info-circle"></i> Tidak ada data nilai tugas untuk mata pelajaran yang dipilih.
              </div>
            @endif
          </div>

          <!-- Nilai Ujian Tab -->
          <div class="tab-pane fade" id="nilai_ujian">
            <br/>
            @if (count($nilaiUjian) > 0)
              <!-- Responsive Table for Ujian -->
              <div class="table-responsive">
                <table id="dataTabelNilaiUjian" class="table table-striped table-hover">
                  <thead>
                    <tr class="bg-primary">
                      <th class="text-center">No</th>
                      <th>Mata Pelajaran</th>
                      <th>Judul Ujian</th>
                      <th>Jenis Ujian</th>
                      <th class="text-center">Nilai</th>
                      <th class="text-center">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                   <?php $i=1; foreach ($nilaiUjian as $dataNilaiUjian):  ?>
                    <tr>
                      <td class="text-center">{{ $i }}</td>
                      <td>{{ $dataNilaiUjian->nama_mapel }}</td>
                      <td>{{ $dataNilaiUjian->judul_ujian }}</td>
                      <td>{{ $dataNilaiUjian->jenis_ujian }}</td>
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
                          <span class="text-muted">-</span>
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
                          <span class="label label-warning">Tersembunyi</span>
                        @endif
                      </td>
                    </tr>
                    <?php $i++; endforeach  ?>
                  </tbody>
                </table>
              </div>
            @else
              <div class="alert alert-info text-center">
                <i class="fa fa-info-circle"></i> Tidak ada data nilai ujian untuk mata pelajaran yang dipilih.
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')

<script src="{{ URL::asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('admin/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script>
      $(function () {
        $('#dataTabelNilaiTugas').DataTable({"pageLength": 10}); //, "scrollX": true
        $('#dataTabelNilaiUjian').DataTable({"pageLength": 10}); //, "scrollX": true

      });

    </script>

@endsection

