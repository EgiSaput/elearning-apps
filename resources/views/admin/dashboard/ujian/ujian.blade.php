@extends('admin.layout.master')
@section('breadcrump')
          <?php if ( Auth::user()->level  == 11 or  Auth::user()->level  == 12): ?>
            <h1> Data Ujian
          <?php endif ?>
          <?php if ( Auth::user()->level  == 13): ?>
            <h1>Ujian Online kelas "{{ $siswa->kelas_siswa }}"
          <?php endif ?>
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>            
          <?php if ( Auth::user()->level  == 11): ?>
            <li class="active">Admin</li> 
            <li class="active">Data Ujian</li>        
          <?php endif ?>

          <?php if (Auth::user()->level  == 12): ?>
            <li class="active">Guru</li> 
            <li class="active">Data Ujian</li> 
          <?php endif ?>  

          <?php if (Auth::user()->level  == 13): ?>
            <li class="active">Siswa</li> 
            <li class="active">Ujian Online kelas "{{ $siswa->kelas_siswa }}"</li> 
          <?php endif ?>           
          </ol>
@stop

@section('content')
@if(Session::has('flash_message'))
<div class="alert alert-success alert-dismissible">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <h4><i class="icon fa fa-check"></i> Berhasil!</h4>
  {{ Session::get('flash_message') }}
</div>
@endif

          <div class="row">
            <div class="col-xs-12">
              <?php if ( Auth::user()->level  == 11 or  Auth::user()->level  == 12): ?>
              <div class="box box-danger">                
                  <div class="box-header with-border">
                    
                    <?php if ( Auth::user()->level  == 11): ?>
                      <h3 class="box-title">Tambah Ujian <a href="{{{ URL::to('admin/tambahujian') }}}" class="btn btn-success btn-flat btn-sm" id="tambahUjian" title="Tambah"><i class="fa fa-plus"></i></a></h3>
                    <?php endif ?>
                    <?php if (Auth::user()->level  == 12): ?>
                      <h3 class="box-title">Tambah Ujian <a href="{{{ URL::to('guru/tambahujian') }}}" class="btn btn-success btn-flat btn-sm" id="tambahUjian" title="Tambah"><i class="fa fa-plus"></i></a></h3>
                    <?php endif ?>
                  </div><!-- /.box-header -->                  

                <div class="box-body">
                  <div class="table-responsive">
                  <table id="dataTabelUjian" class="table table-bordered table-hover">
                    <thead>
                      <tr>      
                        <th>No</th>  
                        <th>Jenis </th>                          
                        <th>Nama</th>  
                        <th>Keterangan</th>
                        <th>Mata Pelajaran</th>          
                        <th>Kelas</th>
                        <th>Jam Ujian</th>
                        <th>Jumlah Soal</th>
                        <th>Acak Soal</th>                       
                        <th>Tanggal</th>                    
                        <th>Status Ujian</th>   
                        <th>Pembuat</th> 
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                     <?php $i=1; foreach ($ujian as $dataUjian):  ?>
                      <tr>
                        <td>{{$i}}</td>
                        <td>{{$dataUjian->jenis_ujian}}</td>
                        <td>{{$dataUjian->judul_ujian}}</td>
                        <td>{{$dataUjian->info_ujian}}</td>
                        <td>{{$dataUjian->nama_mapel}}</td> 
                        <td>{{$dataUjian->kelas_ujian}}</td>
                        <td>{{ $dataUjian->jam_mulai ? substr($dataUjian->jam_mulai, 0, 5) : '-' }} - {{ $dataUjian->jam_selesai ? substr($dataUjian->jam_selesai, 0, 5) : '-' }}</td>
                        <td>{{$dataUjian->jumlah_soal}}</td> 
                        <td>{{$dataUjian->is_random ? 'Ya' : 'Tidak'}}</td>
                        <td>{{$dataUjian->tgl_ujian}}</td>
                        <td>{{$dataUjian->status_ujian}}</td>
                        <td>{{$dataUjian->pembuat_ujian}}</td>
                        <td>                            
                          <?php if (Auth::user()->level  == 11): ?>                            
                            <a href="{{{ URL::to('admin/ujian/'.$dataUjian->id_ujian.'/detail') }}}" class="btn btn-primary btn-xs">
                              <span class="glyphicon glyphicon-eye-open"></span> Lihat
                            </a>
                          <?php endif ?>
                          <?php if (Auth::user()->level  == 12): ?>
                            <a href="{{{ URL::to('guru/ujian/'.$dataUjian->id_ujian.'/detail') }}}" class="btn btn-primary btn-xs">
                              <span class="glyphicon glyphicon-eye-open"></span> Lihat
                            </a>
                          <?php endif ?>                            
                            <a href="{{{ URL::to('admin/ujian/'.$dataUjian->id_ujian.'/edit') }}}" class="btn btn-warning btn-xs">
                              <span class="glyphicon glyphicon-edit" ></span> Edit 
                            </a>
                            <a href="{{{ action('Admin\UjianController@hapus',[$dataUjian->id_ujian]) }}}" title="hapus"   onclick="return confirm('Apakah anda yakin akan menghapus Data Ujian {{{($i).' - '.($dataUjian->judul_ujian) }}}?')" class="btn btn-danger btn-xs">
                              <span class="glyphicon glyphicon-trash"></span> Delete
                            </a> 
                                                        
                        </td>                              
                      </tr>
                      <?php $i++; endforeach  ?> 
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>No</th>  
                        <th>Jenis </th>                          
                        <th>Nama</th>  
                        <th>Keterangan</th>
                        <th>Mata Pelajaran</th>          
                        <th>Kelas</th>
                        <th>Waktu</th>
                        <th>Jumlah Soal</th>
                        <th>Acak Soal</th>                       
                        <th>Tanggal</th>                    
                        <th>Status Ujian</th>   
                        <th>Pembuat</th> 
                        <th>Aksi</th>                        
                      </tr>
                    </tfoot>
                  </table>
                  </div>        
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            <?php endif ?>

            <?php if (Auth::user()->level  == 13): ?> 
            <div class="box box-danger">
              <div class="box-header with-border">
                <h3 class="box-title"><strong> Daftar ujian</strong></h3>
                <div class="box-tools pull-right">
                  <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                  <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="box-body" style="display: block;">

                <table id="dataTabelUjianSiswa" class="table table-striped table-responsive">
                  <thead>
                    <th>No</th>
                    <th>Mata Pelajaran</th> 
                    <th>Judul</th>
                    <th>Kelas</th>
                    <th>Tanggal Ujian</th>
                    <th>Jam Ujian</th>
                    <th>Status Waktu</th>
                    <th>Ambil</th>
                  </thead>
                  <tbody>
                  <?php $i=1; foreach ($ujianSiswa as $dataUjian):  ?>
                  @php
                    $now = now();
                    $tglUjian = $dataUjian->tgl_ujian;
                    $jamMulai = $dataUjian->jam_mulai ?? '00:00:00';
                    $jamSelesai = $dataUjian->jam_selesai ?? '23:59:59';
                    $waktuMulai = \Carbon\Carbon::parse($tglUjian . ' ' . $jamMulai);
                    $waktuSelesai = \Carbon\Carbon::parse($tglUjian . ' ' . $jamSelesai);
                    
                    // Jika jam_selesai <= jam_mulai, berarti jam selesai di hari berikutnya (misal 23:00 - 00:30)
                    if ($waktuSelesai <= $waktuMulai) {
                      $waktuSelesai->addDay();
                    }
                    
                    if ($now < $waktuMulai) {
                      $statusWaktu = 'belum';
                      $statusLabel = 'Belum Dimulai';
                      $statusClass = 'label-warning';
                    } elseif ($now >= $waktuMulai && $now <= $waktuSelesai) {
                      $statusWaktu = 'berlangsung';
                      $statusLabel = 'Sedang Berlangsung';
                      $statusClass = 'label-success';
                    } else {
                      $statusWaktu = 'selesai';
                      $statusLabel = 'Sudah Berakhir';
                      $statusClass = 'label-danger';
                    }
                  @endphp
                  <tr>
                    <td>{{$i}}</td> 
                    <td>{{$dataUjian->nama_mapel}}</td> 
                    <td>{{$dataUjian->judul_ujian}}</td>
                    <td>{{$dataUjian->kelas_ujian}}</td>
                    <td>{{date("d F Y",strtotime($dataUjian->tgl_ujian))}}</td>
                    <td>{{ $dataUjian->jam_mulai ? substr($dataUjian->jam_mulai, 0, 5) : '-' }} - {{ $dataUjian->jam_selesai ? substr($dataUjian->jam_selesai, 0, 5) : '-' }}</td>
                    <td><span class="label {{ $statusClass }}">{{ $statusLabel }}</span></td>
                    <td>
                      @if ($statusWaktu == 'berlangsung')
                        <a href="{{ route('siswa.ujian.ambil', $dataUjian->id_ujian) }}"
                           class="btn btn-info btn-xs">
                            <span class="glyphicon glyphicon-play"></span> Ambil
                        </a>
                      @elseif ($statusWaktu == 'belum')
                        <button class="btn btn-default btn-xs" disabled>
                            <span class="glyphicon glyphicon-time"></span> Tunggu
                        </button>
                      @else
                        <button class="btn btn-default btn-xs" disabled>
                            <span class="glyphicon glyphicon-ban-circle"></span> Berakhir
                        </button>
                      @endif
                    </td>
                  </tr>
                  <?php $i++; endforeach  ?> 
                  </tbody>
                </table> 

              </div><!-- /.box-body -->                                      
            </div>

            <div class="box box-danger">
              <div class="box-header with-border">
                <h3 class="box-title"><strong> Daftar Pengambilan Ujian</strong></h3>
                <div class="box-tools pull-right">
                  <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                  <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
            <div class="box-body" style="display: block;">
            @if ($userAmbilUjians->isEmpty())
            <div class="alert alert-warning" align="center"><font color="black"><strong>Anda</strong> Belum Mengikuti Ujian </font></div>
            @endif
            
            @if (!$userAmbilUjians->isEmpty())
            <table id="dataTabelPengambilanUjianSiswa" class="table table-striped table-responsive">
              <thead>
              <th>No</th>
              <th>Mata Pelajaran</th>
              <th>Jenis Ujian</th>
              <th>Judul</th>
              <th>Waktu Pengambilan</th>
              <th style="width: 15%;">Aksi</th>
              </thead>
              <tbody>
              <?php $i=1; foreach ($userAmbilUjians as $ambil):  ?> 
              <tr>
                <td>{{$i}}</td>
                <td>{{$ambil->nama_mapel}}</td>
                <td>{{$ambil->jenis_ujian}}</td>
                <td>{{$ambil->judul_ujian}}</td>
                <td>{{ $ambil->diambil_pada ? date("d F Y H:i:s", strtotime($ambil->diambil_pada)) : '-' }}</td>
                <td>
                  @php
                    $soalBelum = null;
                    $nilaiUjian = null;
                    if ($ambil->id_nilai_ujian_pilgan) {
                      $nilaiUjian = \DB::table('nilai_ujian_pilgan_siswas')
                        ->where('id_nilai_ujian_pilgan', $ambil->id_nilai_ujian_pilgan)
                        ->first();
                      $soalBelum = \DB::table('siswa_jawab_ujian_pilgans')
                        ->where('id_nilai_ujian_pilgan', $ambil->id_nilai_ujian_pilgan)
                        ->whereNull('id_jawaban_soal_ujian')
                        ->orderBy('id_soal')
                        ->first();
                    }
                    $firstSoal = \DB::table('soals')->where('id_ujian', $ambil->id_ujian)->orderBy('id_soal')->first();
                  @endphp
                  @if ($nilaiUjian && $nilaiUjian->wkt_selesai !== null)
                    {{-- Ujian sudah selesai --}}
                    <span class="label label-success">
                      <span class="glyphicon glyphicon-ok"></span> Selesai
                    </span>
                  @elseif ($ambil->id_nilai_ujian_pilgan && ($soalBelum || $firstSoal))
                    <a href="{{ route('siswa.ujian.mulai', $ambil->id_ujian) }}" class="btn btn-warning btn-xs">
                      <span class="glyphicon glyphicon-play"></span> Mulai
                    </a>
                  @else
                    <a href="{{ route('siswa.ujian.ambil', $ambil->id_ujian) }}" class="btn btn-warning btn-xs">
                      <span class="glyphicon glyphicon-play"></span> Ambil Ujian
                    </a>
                  @endif
                </td>
              </tr>
              <?php $i++; endforeach  ?>                 
              </tbody>
            </table>
            @endif

              </div><!-- /.box-body -->            
            </div>
          <?php endif ?>          
        </div><!-- /.col -->
      </div><!-- /.row -->
       

@endsection
@section('script')

<script src="{{ URL::asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('admin/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script>
      $(function () {

        $('#dataTabelUjian').DataTable({"pageLength": 10, "scrollX": true});
        $('#dataTabelUjianSiswa').DataTable({"pageLength": 10, "scrollX": true});
        $('#dataTabelPengambilanUjianSiswa').DataTable({"pageLength": 10, "scrollX": true});
      });

    </script>

@endsection