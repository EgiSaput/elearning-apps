@extends('admin.layout.master')
@section('breadcrump')
          <h1>
            Detail Jawaban Siswa
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
            <li class="active">Detail Jawaban</li>
          </ol>
@stop
@section('content')
<div class="row">
  <div class="col-xs-12">
    <!-- Info Box -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-user"></i> Informasi Siswa & Ujian</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-6">
            <table class="table table-bordered">
              <tr>
                <th style="width: 150px;">Nama Siswa</th>
                <td><strong>{{ $siswa->nama_siswa }}</strong></td>
              </tr>
              <tr>
                <th>NISN</th>
                <td>{{ $siswa->nisn_siswa }}</td>
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
                <th style="width: 150px;">Judul Ujian</th>
                <td><strong>{{ $ujian->judul_ujian }}</strong></td>
              </tr>
              <tr>
                <th>Mata Pelajaran</th>
                <td>{{ $mapel->nama_mapel }}</td>
              </tr>
              <tr>
                <th>Nilai</th>
                <td>
                  @if($nilaiUjian->nilai >= 80)
                    <span class="badge bg-green" style="font-size: 16px;">{{ $nilaiUjian->nilai }}</span>
                  @elseif($nilaiUjian->nilai >= 70)
                    <span class="badge bg-yellow" style="font-size: 16px;">{{ $nilaiUjian->nilai }}</span>
                  @else
                    <span class="badge bg-red" style="font-size: 16px;">{{ $nilaiUjian->nilai }}</span>
                  @endif
                  @if($nilaiUjian->nilai >= 70)
                    <span class="label label-success">Lulus</span>
                  @else
                    <span class="label label-danger">Tidak Lulus</span>
                  @endif
                </td>
              </tr>
            </table>
          </div>
        </div>

        <!-- Summary -->
        @php
          $benar = 0;
          $salah = 0;
          $kosong = 0;
          foreach ($jawabanSiswa as $js) {
            if ($js->id_jawaban_soal_ujian === null) {
              $kosong++;
            } elseif ($js->jawaban_dipilih_benar) {
              $benar++;
            } else {
              $salah++;
            }
          }
          $total = count($jawabanSiswa);
        @endphp
        <div class="row" style="margin-top: 20px;">
          <div class="col-md-3 col-sm-6">
            <div class="info-box bg-aqua">
              <span class="info-box-icon"><i class="fa fa-list"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Total Soal</span>
                <span class="info-box-number">{{ $total }}</span>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-sm-6">
            <div class="info-box bg-green">
              <span class="info-box-icon"><i class="fa fa-check"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Benar</span>
                <span class="info-box-number">{{ $benar }}</span>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-sm-6">
            <div class="info-box bg-red">
              <span class="info-box-icon"><i class="fa fa-times"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Salah</span>
                <span class="info-box-number">{{ $salah }}</span>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-sm-6">
            <div class="info-box bg-yellow">
              <span class="info-box-icon"><i class="fa fa-minus"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Tidak Dijawab</span>
                <span class="info-box-number">{{ $kosong }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Detail Jawaban -->
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-list-ol"></i> Detail Jawaban Per Soal</h3>
      </div>
      <div class="box-body">
        @php $nomor = 1; @endphp
        @foreach ($jawabanSiswa as $js)
          @php
            $statusSoal = 'kosong';
            $statusClass = 'warning';
            $statusIcon = 'fa-minus';
            $statusText = 'Tidak Dijawab';
            
            if ($js->id_jawaban_soal_ujian !== null) {
              if ($js->jawaban_dipilih_benar) {
                $statusSoal = 'benar';
                $statusClass = 'success';
                $statusIcon = 'fa-check';
                $statusText = 'Benar';
              } else {
                $statusSoal = 'salah';
                $statusClass = 'danger';
                $statusIcon = 'fa-times';
                $statusText = 'Salah';
              }
            }
          @endphp
          <div class="panel panel-{{ $statusClass }}" style="margin-bottom: 15px;">
            <div class="panel-heading">
              <h4 class="panel-title">
                <strong>Soal #{{ $nomor }}</strong>
                <span class="pull-right label label-{{ $statusClass }}">
                  <i class="fa {{ $statusIcon }}"></i> {{ $statusText }}
                </span>
              </h4>
            </div>
            <div class="panel-body">
              <!-- Pertanyaan -->
              <div class="well" style="background-color: #f9f9f9;">
                <strong>Pertanyaan:</strong><br>
                {!! $js->pertanyaan !!}
                @if($js->gambar_soal && $js->gambar_soal != '')
                  <br><br>
                  <img src="{{ asset('upload_gambar/' . $js->gambar_soal) }}" alt="Gambar Soal" style="max-width: 300px; max-height: 200px;">
                @endif
              </div>

              <!-- Opsi Jawaban -->
              <div style="margin-top: 15px;">
                <strong>Pilihan Jawaban:</strong>
                <ul class="list-group" style="margin-top: 10px;">
                  @php $huruf = ['A', 'B', 'C', 'D', 'E']; $idx = 0; @endphp
                  @foreach ($js->opsi_jawaban as $opsi)
                    @php
                      $isSelected = ($js->id_jawaban_soal_ujian == $opsi->id_jawaban_soal_ujian);
                      $isCorrect = $opsi->is_benar;
                      
                      $bgColor = '';
                      $icon = '';
                      if ($isCorrect) {
                        $bgColor = '#dff0d8'; // green
                        $icon = '<i class="fa fa-check-circle text-success"></i>';
                      }
                      if ($isSelected && !$isCorrect) {
                        $bgColor = '#f2dede'; // red
                        $icon = '<i class="fa fa-times-circle text-danger"></i>';
                      }
                      if ($isSelected && $isCorrect) {
                        $bgColor = '#dff0d8';
                        $icon = '<i class="fa fa-check-circle text-success"></i>';
                      }
                    @endphp
                    <li class="list-group-item" style="background-color: {{ $bgColor }};">
                      <strong>{{ $huruf[$idx] ?? ($idx+1) }}.</strong> 
                      {{ $opsi->jawaban }}
                      @if($isSelected)
                        <span class="badge bg-blue pull-right" style="margin-left: 5px;">Jawaban Siswa</span>
                      @endif
                      @if($isCorrect)
                        <span class="badge bg-green pull-right">Kunci Jawaban</span>
                      @endif
                      {!! $icon !!}
                    </li>
                    @php $idx++; @endphp
                  @endforeach
                </ul>
              </div>

              <!-- Jawaban Siswa Info -->
              <div class="row" style="margin-top: 15px;">
                <div class="col-md-6">
                  <div class="alert alert-info" style="margin-bottom: 0;">
                    <strong>Jawaban Siswa:</strong> 
                    @if($js->jawaban_dipilih_text)
                      {{ $js->jawaban_dipilih_text }}
                    @else
                      <em>Tidak menjawab</em>
                    @endif
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="alert alert-success" style="margin-bottom: 0;">
                    <strong>Kunci Jawaban:</strong> 
                    @if($js->jawaban_benar)
                      {{ $js->jawaban_benar->jawaban }}
                    @else
                      <em>-</em>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
          @php $nomor++; @endphp
        @endforeach
      </div>
      <div class="box-footer">
        <a href="javascript:history.back()" class="btn btn-default">
          <i class="fa fa-arrow-left"></i> Kembali
        </a>
        <button onclick="window.print()" class="btn btn-primary pull-right">
          <i class="fa fa-print"></i> Cetak
        </button>
      </div>
    </div>
  </div>
</div>

<style>
@media print {
  .main-sidebar, .main-header, .main-footer, .box-footer, .breadcrumb, .btn {
    display: none !important;
  }
  .content-wrapper {
    margin-left: 0 !important;
  }
  .box {
    border: none !important;
  }
}
</style>
@endsection
