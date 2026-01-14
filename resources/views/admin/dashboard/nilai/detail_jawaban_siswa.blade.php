@extends('admin.layout.master')
@section('breadcrump')
          <h1>
            Detail Jawaban Siswa - {{ $siswa->nama_siswa }}
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
            <li class="active">Nilai Siswa</li>
            <li class="active">Detail Jawaban {{ $siswa->nama_siswa }}</li>
          </ol>
@stop
@section('content')
          <div class="row">
            <div class="col-xs-12">
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Detail Jawaban Siswa</h3>
                  <div class="box-tools pull-right">
                    <a href="{{ url()->previous() }}" class="btn btn-default btn-sm">
                      <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                  </div>
                </div>

                <div class="box-body">
                  <div class="row">
                    <div class="col-md-6">
                      <table class="table table-bordered">
                        <tr>
                          <th>NISN</th>
                          <td>{{ $siswa->nisn_siswa }}</td>
                        </tr>
                        <tr>
                          <th>Nama Siswa</th>
                          <td>{{ $siswa->nama_siswa }}</td>
                        </tr>
                        <tr>
                          <th>Kelas</th>
                          <td>{{ $siswa->kelas_siswa }}</td>
                        </tr>
                      </table>
                    </div>
                    <div class="col-md-6">
                      <table class="table table-bordered">
                        <tr>
                          <th>Judul Ujian</th>
                          <td>{{ $ujian->judul_ujian }}</td>
                        </tr>
                        <tr>
                          <th>Mata Pelajaran</th>
                          <td>{{ $ujian->nama_mapel ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                          <th>Nilai Akhir</th>
                          <td><strong>{{ $nilaiUjian->nilai }}</strong></td>
                        </tr>
                      </table>
                    </div>
                  </div>

                  <hr>

                  <h4>Detail Jawaban per Soal</h4>
                  <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Pertanyaan</th>
                          <th>Jawaban Siswa</th>
                          <th>Jawaban Benar</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($detailJawaban as $index => $detail)
                        <tr class="{{ $detail['is_benar'] ? 'success' : 'danger' }}">
                          <td>{{ $index + 1 }}</td>
                          <td>
                            <strong>{{ $detail['soal']->pertanyaan }}</strong>
                            @if($detail['soal']->gambar)
                            <br><img src="{{ asset('upload_gambar/' . $detail['soal']->gambar) }}" alt="Gambar Soal" class="img-responsive" style="max-width: 200px;">
                            @endif
                          </td>
                          <td>
                            @if($detail['jawaban_dipilih'])
                              {{ $detail['jawaban_dipilih']->jawaban }}
                            @else
                              <em>Tidak dijawab</em>
                            @endif
                          </td>
                          <td>
                            @if($detail['jawaban_benar'])
                              {{ $detail['jawaban_benar']->jawaban }}
                            @else
                              <em>Tidak ada jawaban benar</em>
                            @endif
                          </td>
                          <td>
                            @if($detail['is_benar'])
                              <span class="label label-success">Benar</span>
                            @else
                              <span class="label label-danger">Salah</span>
                            @endif
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
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
    $('.table').DataTable({"pageLength": 25});
  });
</script>
@endsection
