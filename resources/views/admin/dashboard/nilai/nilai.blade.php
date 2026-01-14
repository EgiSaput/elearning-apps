@extends('admin.layout.master')
@section('breadcrump')
          <h1>
            Nilai Siswa
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          <?php if ( Auth::user()->level  == 11): ?>
            <li class="active">Admin</li>
          <?php endif ?>
          <?php if (Auth::user()->level  == 12): ?>
            <li class="active">Guru</li>
          <?php endif ?>
            <li class="active">Nilai Siswa</li>
          </ol>
@stop
@section('content')
<div class="row">
  <div class="col-xs-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Nilai Siswa</h3>
      </div>

      <div class="box-body">
        <!-- Filter Kelas -->
        <form id="formKelasMapel" class="form-inline" role="form" method="POST" action="{{ route(Auth::user()->level == 11 ? 'admin.nilai_siswa.kelas.mapel' : 'guru.nilai_siswa.kelas.mapel')}}" style="margin-bottom: 20px;">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="form-group">
            <label style="margin-right:10px; font-weight:600;">Pilih Kelas:</label>
            <select class="form-control" name="kelas_terpilih" style="min-width:150px;">
              @foreach ($listKelas as $dataKelas)
                @php
                  $kelasNama = is_object($dataKelas) ? $dataKelas->nama_kelas : $dataKelas;
                  $showKelas = preg_match('/^(X|XI|XII)(\s|$)/', $kelasNama);
                @endphp
                @if($showKelas)
                <option value="{{ $kelasNama }}" @if($kelas_terpilih == $kelasNama) selected="selected" @endif>
                  {{ $kelasNama }}
                </option>
                @endif
              @endforeach
            </select>
            <button type="submit" class="btn btn-primary" style="margin-left:10px;">
              <i class="fa fa-search"></i> Tampilkan
            </button>
          </div>
        </form>

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
              <!-- Summary Cards -->
              <div class="row" style="margin-bottom: 20px;">
                @php
                  $totalSiswaHarian = $filteredNilaiUjianHarian->count();
                  $rataRataHarian = $filteredNilaiUjianHarian->avg('nilai');
                  $lulusHarian = $filteredNilaiUjianHarian->where('nilai', '>=', 70)->count();
                  $tidakLulusHarian = $totalSiswaHarian - $lulusHarian;
                @endphp
                <div class="col-md-3 col-sm-6">
                  <div class="small-box bg-aqua">
                    <div class="inner">
                      <h3>{{ $totalSiswaHarian }}</h3>
                      <p>Total Siswa</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-users"></i>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 col-sm-6">
                  <div class="small-box bg-green">
                    <div class="inner">
                      <h3>{{ number_format($rataRataHarian, 1) }}</h3>
                      <p>Rata-rata Nilai</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-chart-line"></i>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 col-sm-6">
                  <div class="small-box bg-yellow">
                    <div class="inner">
                      <h3>{{ $lulusHarian }}</h3>
                      <p>Lulus (≥70)</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-check-circle"></i>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 col-sm-6">
                  <div class="small-box bg-red">
                    <div class="inner">
                      <h3>{{ $tidakLulusHarian }}</h3>
                      <p>Tidak Lulus (<70)</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-times-circle"></i>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Toggle Visibility Button -->
              @php
                $isVisibleHarian = $filteredNilaiUjianHarian->first() ? $filteredNilaiUjianHarian->first()->nilai_visible : true;
              @endphp
              <div class="row" style="margin-bottom: 15px;">
                <div class="col-md-12">
                  <button type="button" class="btn {{ $isVisibleHarian ? 'btn-warning' : 'btn-success' }} btn-toggle-visibility" 
                          data-jenis="Ujian Harian" 
                          data-kelas="{{ $kelas_terpilih }}"
                          data-visible="{{ $isVisibleHarian ? '1' : '0' }}">
                    <i class="fa {{ $isVisibleHarian ? 'fa-eye-slash' : 'fa-eye' }}"></i> 
                    {{ $isVisibleHarian ? 'Sembunyikan Nilai untuk Siswa' : 'Tampilkan Nilai untuk Siswa' }}
                  </button>
                  <span class="label {{ $isVisibleHarian ? 'label-success' : 'label-warning' }}" style="margin-left: 10px; font-size: 12px;">
                    Status: {{ $isVisibleHarian ? 'Nilai Terlihat oleh Siswa' : 'Nilai Tersembunyi dari Siswa' }}
                  </span>
                </div>
              </div>

              <!-- Responsive Table -->
              <div class="table-responsive">
                <table id="dataTabelNilaiUjianHarian" class="table table-striped table-hover">
                  <thead>
                    <tr class="bg-primary">
                      <th class="text-center">No</th>
                      <th>Nama Siswa</th>
                      <th>Mata Pelajaran</th>
                      <th>Judul Ujian</th>
                      <th class="text-center">Nilai</th>
                      <th class="text-center">Status</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                   <?php $i=1; foreach ($filteredNilaiUjianHarian as $dataNilaiUjian):  ?>
                    <tr>
                      <td class="text-center">{{ $i }}</td>
                      <td>
                        <strong>{{ $dataNilaiUjian->nama_siswa }}</strong><br>
                        <small class="text-muted">NISN: {{ $dataNilaiUjian->nisn_siswa }}</small>
                      </td>
                      <td>{{ $dataNilaiUjian->nama_mapel }}</td>
                      <td>{{ $dataNilaiUjian->judul_ujian }}</td>
                      <td class="text-center">
                        @if($dataNilaiUjian->nilai >= 80)
                          <span class="badge bg-green">{{ $dataNilaiUjian->nilai }}</span>
                        @elseif($dataNilaiUjian->nilai >= 70)
                          <span class="badge bg-yellow">{{ $dataNilaiUjian->nilai }}</span>
                        @else
                          <span class="badge bg-red">{{ $dataNilaiUjian->nilai }}</span>
                        @endif
                      </td>
                      <td class="text-center">
                        @if($dataNilaiUjian->nilai >= 70)
                          <span class="label label-success">Lulus</span>
                        @else
                          <span class="label label-danger">Tidak Lulus</span>
                        @endif
                      </td>
                      <td class="text-center">
                        <a href="{{ route(Auth::user()->level == 11 ? 'admin.nilai_siswa.detail' : 'guru.nilai_siswa.detail', $dataNilaiUjian->id_nilai_ujian_pilgan) }}" 
                           class="btn btn-info btn-xs" title="Lihat Detail Jawaban">
                          <i class="fa fa-eye"></i> Detail
                        </a>
                      </td>
                    </tr>
                    <?php $i++; endforeach  ?>
                  </tbody>
                </table>
              </div>
            @else
              <div class="alert alert-info text-center">
                <i class="fa fa-info-circle"></i> Tidak ada data nilai ujian harian untuk kelas yang dipilih.
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
              <!-- Summary Cards -->
              <div class="row" style="margin-bottom: 20px;">
                @php
                  $totalSiswaTengah = $filteredNilaiUjianTengah->count();
                  $rataRataTengah = $filteredNilaiUjianTengah->avg('nilai');
                  $lulusTengah = $filteredNilaiUjianTengah->where('nilai', '>=', 70)->count();
                  $tidakLulusTengah = $totalSiswaTengah - $lulusTengah;
                @endphp
                <div class="col-md-3 col-sm-6">
                  <div class="small-box bg-aqua">
                    <div class="inner">
                      <h3>{{ $totalSiswaTengah }}</h3>
                      <p>Total Siswa</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-users"></i>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 col-sm-6">
                  <div class="small-box bg-green">
                    <div class="inner">
                      <h3>{{ number_format($rataRataTengah, 1) }}</h3>
                      <p>Rata-rata Nilai</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-chart-line"></i>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 col-sm-6">
                  <div class="small-box bg-yellow">
                    <div class="inner">
                      <h3>{{ $lulusTengah }}</h3>
                      <p>Lulus (≥70)</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-check-circle"></i>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 col-sm-6">
                  <div class="small-box bg-red">
                    <div class="inner">
                      <h3>{{ $tidakLulusTengah }}</h3>
                      <p>Tidak Lulus (<70)</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-times-circle"></i>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Toggle Visibility Button -->
              @php
                $isVisibleTengah = $filteredNilaiUjianTengah->first() ? $filteredNilaiUjianTengah->first()->nilai_visible : true;
              @endphp
              <div class="row" style="margin-bottom: 15px;">
                <div class="col-md-12">
                  <button type="button" class="btn {{ $isVisibleTengah ? 'btn-warning' : 'btn-success' }} btn-toggle-visibility" 
                          data-jenis="Ujian Tengah Semester" 
                          data-kelas="{{ $kelas_terpilih }}"
                          data-visible="{{ $isVisibleTengah ? '1' : '0' }}">
                    <i class="fa {{ $isVisibleTengah ? 'fa-eye-slash' : 'fa-eye' }}"></i> 
                    {{ $isVisibleTengah ? 'Sembunyikan Nilai untuk Siswa' : 'Tampilkan Nilai untuk Siswa' }}
                  </button>
                  <span class="label {{ $isVisibleTengah ? 'label-success' : 'label-warning' }}" style="margin-left: 10px; font-size: 12px;">
                    Status: {{ $isVisibleTengah ? 'Nilai Terlihat oleh Siswa' : 'Nilai Tersembunyi dari Siswa' }}
                  </span>
                </div>
              </div>

              <!-- Responsive Table -->
              <div class="table-responsive">
                <table id="dataTabelNilaiUjianTengah" class="table table-striped table-hover">
                  <thead>
                    <tr class="bg-primary">
                      <th class="text-center">No</th>
                      <th>Nama Siswa</th>
                      <th>Mata Pelajaran</th>
                      <th>Judul Ujian</th>
                      <th class="text-center">Nilai</th>
                      <th class="text-center">Status</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                   <?php $i=1; foreach ($filteredNilaiUjianTengah as $dataNilaiUjian):  ?>
                    <tr>
                      <td class="text-center">{{ $i }}</td>
                      <td>
                        <strong>{{ $dataNilaiUjian->nama_siswa }}</strong><br>
                        <small class="text-muted">NISN: {{ $dataNilaiUjian->nisn_siswa }}</small>
                      </td>
                      <td>{{ $dataNilaiUjian->nama_mapel }}</td>
                      <td>{{ $dataNilaiUjian->judul_ujian }}</td>
                      <td class="text-center">
                        @if($dataNilaiUjian->nilai >= 80)
                          <span class="badge bg-green">{{ $dataNilaiUjian->nilai }}</span>
                        @elseif($dataNilaiUjian->nilai >= 70)
                          <span class="badge bg-yellow">{{ $dataNilaiUjian->nilai }}</span>
                        @else
                          <span class="badge bg-red">{{ $dataNilaiUjian->nilai }}</span>
                        @endif
                      </td>
                      <td class="text-center">
                        @if($dataNilaiUjian->nilai >= 70)
                          <span class="label label-success">Lulus</span>
                        @else
                          <span class="label label-danger">Tidak Lulus</span>
                        @endif
                      </td>
                      <td class="text-center">
                        <a href="{{ route(Auth::user()->level == 11 ? 'admin.nilai_siswa.detail' : 'guru.nilai_siswa.detail', $dataNilaiUjian->id_nilai_ujian_pilgan) }}" 
                           class="btn btn-info btn-xs" title="Lihat Detail Jawaban">
                          <i class="fa fa-eye"></i> Detail
                        </a>
                      </td>
                    </tr>
                    <?php $i++; endforeach  ?>
                  </tbody>
                </table>
              </div>
            @else
              <div class="alert alert-info text-center">
                <i class="fa fa-info-circle"></i> Tidak ada data nilai ujian tengah semester untuk kelas yang dipilih.
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
              <!-- Summary Cards -->
              <div class="row" style="margin-bottom: 20px;">
                @php
                  $totalSiswaAkhir = $filteredNilaiUjianAkhir->count();
                  $rataRataAkhir = $filteredNilaiUjianAkhir->avg('nilai');
                  $lulusAkhir = $filteredNilaiUjianAkhir->where('nilai', '>=', 70)->count();
                  $tidakLulusAkhir = $totalSiswaAkhir - $lulusAkhir;
                @endphp
                <div class="col-md-3 col-sm-6">
                  <div class="small-box bg-aqua">
                    <div class="inner">
                      <h3>{{ $totalSiswaAkhir }}</h3>
                      <p>Total Siswa</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-users"></i>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 col-sm-6">
                  <div class="small-box bg-green">
                    <div class="inner">
                      <h3>{{ number_format($rataRataAkhir, 1) }}</h3>
                      <p>Rata-rata Nilai</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-chart-line"></i>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 col-sm-6">
                  <div class="small-box bg-yellow">
                    <div class="inner">
                      <h3>{{ $lulusAkhir }}</h3>
                      <p>Lulus (≥70)</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-check-circle"></i>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 col-sm-6">
                  <div class="small-box bg-red">
                    <div class="inner">
                      <h3>{{ $tidakLulusAkhir }}</h3>
                      <p>Tidak Lulus (<70)</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-times-circle"></i>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Toggle Visibility Button -->
              @php
                $isVisibleAkhir = $filteredNilaiUjianAkhir->first() ? $filteredNilaiUjianAkhir->first()->nilai_visible : true;
              @endphp
              <div class="row" style="margin-bottom: 15px;">
                <div class="col-md-12">
                  <button type="button" class="btn {{ $isVisibleAkhir ? 'btn-warning' : 'btn-success' }} btn-toggle-visibility" 
                          data-jenis="Ujian Akhir Semester" 
                          data-kelas="{{ $kelas_terpilih }}"
                          data-visible="{{ $isVisibleAkhir ? '1' : '0' }}">
                    <i class="fa {{ $isVisibleAkhir ? 'fa-eye-slash' : 'fa-eye' }}"></i> 
                    {{ $isVisibleAkhir ? 'Sembunyikan Nilai untuk Siswa' : 'Tampilkan Nilai untuk Siswa' }}
                  </button>
                  <span class="label {{ $isVisibleAkhir ? 'label-success' : 'label-warning' }}" style="margin-left: 10px; font-size: 12px;">
                    Status: {{ $isVisibleAkhir ? 'Nilai Terlihat oleh Siswa' : 'Nilai Tersembunyi dari Siswa' }}
                  </span>
                </div>
              </div>

              <!-- Responsive Table -->
              <div class="table-responsive">
                <table id="dataTabelNilaiUjianAkhir" class="table table-striped table-hover">
                  <thead>
                    <tr class="bg-primary">
                      <th class="text-center">No</th>
                      <th>Nama Siswa</th>
                      <th>Mata Pelajaran</th>
                      <th>Judul Ujian</th>
                      <th class="text-center">Nilai</th>
                      <th class="text-center">Status</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                   <?php $i=1; foreach ($filteredNilaiUjianAkhir as $dataNilaiUjian):  ?>
                    <tr>
                      <td class="text-center">{{ $i }}</td>
                      <td>
                        <strong>{{ $dataNilaiUjian->nama_siswa }}</strong><br>
                        <small class="text-muted">NISN: {{ $dataNilaiUjian->nisn_siswa }}</small>
                      </td>
                      <td>{{ $dataNilaiUjian->nama_mapel }}</td>
                      <td>{{ $dataNilaiUjian->judul_ujian }}</td>
                      <td class="text-center">
                        @if($dataNilaiUjian->nilai >= 80)
                          <span class="badge bg-green">{{ $dataNilaiUjian->nilai }}</span>
                        @elseif($dataNilaiUjian->nilai >= 70)
                          <span class="badge bg-yellow">{{ $dataNilaiUjian->nilai }}</span>
                        @else
                          <span class="badge bg-red">{{ $dataNilaiUjian->nilai }}</span>
                        @endif
                      </td>
                      <td class="text-center">
                        @if($dataNilaiUjian->nilai >= 70)
                          <span class="label label-success">Lulus</span>
                        @else
                          <span class="label label-danger">Tidak Lulus</span>
                        @endif
                      </td>
                      <td class="text-center">
                        <a href="{{ route(Auth::user()->level == 11 ? 'admin.nilai_siswa.detail' : 'guru.nilai_siswa.detail', $dataNilaiUjian->id_nilai_ujian_pilgan) }}" 
                           class="btn btn-info btn-xs" title="Lihat Detail Jawaban">
                          <i class="fa fa-eye"></i> Detail
                        </a>
                      </td>
                    </tr>
                    <?php $i++; endforeach  ?>
                  </tbody>
                </table>
              </div>
            @else
              <div class="alert alert-info text-center">
                <i class="fa fa-info-circle"></i> Tidak ada data nilai ujian akhir semester untuk kelas yang dipilih.
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
  $('#dataTabelNilaiUjianHarian').DataTable({"pageLength": 25});
  $('#dataTabelNilaiUjianTengah').DataTable({"pageLength": 25});
  $('#dataTabelNilaiUjianAkhir').DataTable({"pageLength": 25});

  // Toggle Visibility Button Handler
  $('.btn-toggle-visibility').on('click', function() {
    var btn = $(this);
    var jenisUjian = btn.data('jenis');
    var kelas = btn.data('kelas');
    var currentVisible = btn.data('visible');
    // Jika saat ini visible (1), maka set ke hidden (0), dan sebaliknya
    var setVisible = currentVisible == '1' ? 0 : 1;
    
    if (!kelas) {
      alert('Silakan pilih kelas terlebih dahulu');
      return;
    }
    
    var confirmMsg = currentVisible == '1' 
      ? 'Apakah Anda yakin ingin menyembunyikan SEMUA nilai ' + jenisUjian + ' untuk siswa kelas ' + kelas + '?\n\nSiswa tidak akan bisa melihat nilai dan status Lulus/Tidak Lulus.' 
      : 'Apakah Anda yakin ingin menampilkan SEMUA nilai ' + jenisUjian + ' untuk siswa kelas ' + kelas + '?\n\nSiswa akan bisa melihat nilai dan status Lulus/Tidak Lulus.';
    
    if (!confirm(confirmMsg)) {
      return;
    }
    
    btn.prop('disabled', true);
    btn.html('<i class="fa fa-spinner fa-spin"></i> Memproses...');
    
    $.ajax({
      url: '{{ Auth::user()->level == 11 ? route("admin.nilai.toggle_visibility") : route("guru.nilai.toggle_visibility") }}',
      type: 'POST',
      data: {
        _token: '{{ csrf_token() }}',
        jenis_ujian: jenisUjian,
        kelas: kelas,
        set_visible: setVisible
      },
      success: function(response) {
        if (response.success) {
          // Reload page to reflect changes
          location.reload();
        } else {
          alert('Gagal mengubah status visibility');
          btn.prop('disabled', false);
          // Restore button text
          var isVisible = btn.data('visible') == '1';
          btn.html('<i class="fa ' + (isVisible ? 'fa-eye-slash' : 'fa-eye') + '"></i> ' + 
                   (isVisible ? 'Sembunyikan Nilai untuk Siswa' : 'Tampilkan Nilai untuk Siswa'));
        }
      },
      error: function(xhr) {
        alert('Terjadi kesalahan saat mengubah status visibility');
        btn.prop('disabled', false);
        // Restore button text
        var isVisible = btn.data('visible') == '1';
        btn.html('<i class="fa ' + (isVisible ? 'fa-eye-slash' : 'fa-eye') + '"></i> ' + 
                 (isVisible ? 'Sembunyikan Nilai untuk Siswa' : 'Tampilkan Nilai untuk Siswa'));
      }
    });
  });
});
</script>

@endsection
