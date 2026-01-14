@extends('admin.layout.master')
@section('breadcrump')
          <h1>
            Data Siswa
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
            <li class="active">Admin</li>
            <li class="active">Data Siswa</li>
           
          </ol>
@stop
@section('content')
          <div class="row">
            <div class="col-xs-12">
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Siswa <a href="{{{ URL::to('admin/tambahsiswa') }}}" class="btn btn-success btn-flat btn-sm" id="tambahSiswa" title="Tambah"><i class="fa fa-plus"></i></a></h3>
                </div><!-- /.box-header -->
                
                <div class="box-body">
                  <div class="table-responsive">
                  <table id="dataTabelSiswa" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>Foto</th>
                        <th>No</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                     <?php $i=1; foreach ($siswa as $dataSiswa):  ?>
                      <tr>
                        <td style="width:90px"><img src="{{URL::to('upload_gambar/'.$dataSiswa->foto_siswa) }}" alt="" style="width:60px; height:60px; border-radius:50%; border:3px solid #00bcd4"></td>
                        <td>{{$i}}</td>
                        <td>{{$dataSiswa->nisn_siswa}}</td>
                        <td>{{$dataSiswa->nama_siswa}}</td>
                        <td>{{$dataSiswa->kelas_siswa}}</td>
                        <td>{{ (strpos($dataSiswa->kelas_siswa, ' ') !== false) ? substr($dataSiswa->kelas_siswa, strpos($dataSiswa->kelas_siswa, ' ')+1) : '' }}</td>
                        <td>
                          <a href="{{{ URL::to('admin/siswa/'.$dataSiswa->nisn_siswa.'/edit') }}}" class="btn btn-warning btn-sm" style="border-radius:12px; margin-right:6px">Ubah</a>
                          <a href="{{{ action('Admin\SiswaController@hapus',[$dataSiswa->nisn_siswa]) }}}" class="btn btn-danger btn-sm" style="border-radius:12px" onclick="return confirm('Apakah anda yakin akan menghapus Data Siswa {{{($dataSiswa->nisn_siswa).' - '.($dataSiswa->nama_siswa) }}}?')">Hapus</a>
                        </td>
                      </tr>
                      <?php $i++; endforeach  ?> 
                    </tbody>
                  </table>
                  </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col -->
          </div><!-- /.row -->
       

@endsection
@section('script')

<script src="{{ URL::asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('admin/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script>
      $(function () {

        $('#dataTabelSiswa').DataTable({"pageLength": 10, "scrollX": true});

      });

    </script>

@endsection

