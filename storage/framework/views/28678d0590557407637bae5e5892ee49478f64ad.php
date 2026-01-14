<!-- Terpaksa Ngoding di View -->
<?php 
  $i = Auth::user()->level;
  $idUser = Auth::user()->id_user;                         
  $siswa = \App\Siswa::where('id_user', $idUser)->first(); // detail field siswa yang sedang login.
  $guru = \App\Guru::where('id_user', $idUser)->first(); // detail field siswa yang sedang login.
?>       
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="<?php echo e(URL::to('upload_gambar/'.$guru->foto_guru)); ?>" class="img-circle" alt="User Image" style="height:45px; width:45px;">
            </div>
            <div class="pull-left info">
              <p>Guru</p>
              <a ><i class="fa fa-circle text-success"></i> <?php echo e(Auth::user()->username); ?></a>
            </div>
          </div>

          <!-- Sidebar Menu Header-->
        <ul class="sidebar-menu">
            <li class="header" style=" text-align: center;"> <font color = "white";"><b>MAIN NAVIGATION GURU </b> </font> </li>
            <!-- Optionally, you can add icons to the links -->
            <li class="<?php if(url('/') == request()->url()): ?> active <?php else: ?> '' <?php endif; ?>"><a href="<?php echo e(url('/')); ?>">
              <i class='fa fa-dashcube'></i> <span>Dashboard</span></a>
            </li>

            <!-- Menu Admin-->
            <!-- Pilihan, untuk menampilkan menu yang dapat digunakan oleh 3 jenis pengguna, yaitu admin, guru, dan siswa -->

            <li class="treeview active ">
              <a href="<?php echo e(URL::to('guru/mapel')); ?>">
                <i class="fa fa-list-alt"></i>
                <span>Kelola Mata Pelajaran</span>
                <span class="label label-primary pull-right">5</span>
              </a>
              <ul class="treeview-menu">
                <li class="<?php if(url('guru/kelas') == request()->url() ): ?> active <?php else: ?> '' <?php endif; ?>">
                  <a href="<?php echo e(URL::to('guru/kelas')); ?>"><i class="fa fa-plus-square">                    
                  </i> Kelas Anda </a>
                </li>

                <!-- Materi Ajar and Tugas links removed for guru -->

                <li class="<?php if(url('guru/soal_ujian') == request()->url() or url('guru/tambah_soal_ujian')  == request()->url() ): ?> active <?php else: ?> '' <?php endif; ?>">
                  <a href="<?php echo e(URL::to('guru/soal_ujian')); ?>"><i class="fa fa-plus-square">                    
                  </i> Soal Ujian Siswa</a>
                </li>

                <li class="<?php if(url('guru/ujian') == request()->url() ): ?> active <?php else: ?> '' <?php endif; ?>">
                  <a href="<?php echo e(URL::to('guru/ujian')); ?>"><i class="fa fa-plus-square">                    
                  </i> Ujian Siswa</a>
                </li>

                <?php
                  // Jika URL saat ini adalah /guru/ujian/{id}/detail atau sejenis, ambil id ujian
                  $detailUjianId = null;
                  if (request()->segment(1) == 'guru' && request()->segment(2) == 'ujian' && is_numeric(request()->segment(3))) {
                    $detailUjianId = request()->segment(3);
                  }
                ?>
                <li class="<?php if(request()->is('guru/ujian/*/detail')): ?> active <?php else: ?> '' <?php endif; ?>">
                  <?php if($detailUjianId): ?>
                    <a href="<?php echo e(url('guru/ujian/'.$detailUjianId.'/detail')); ?>"><i class="fa fa-info-circle"></i> Detail Ujian</a>
                  <?php else: ?>
                    <a href="#" title="Buka detail ujian dari halaman Ujian" onclick="return false;"><i class="fa fa-info-circle"></i> Detail Ujian</a>
                  <?php endif; ?>
                </li>

                <li class="<?php if(url('guru/nilai') == request()->url() ): ?> active <?php else: ?> '' <?php endif; ?>">
                  <a href="<?php echo e(URL::to('guru/nilai')); ?>"><i class="fa fa-plus-square">                    
                  </i> Nilai Siswa</a>
                </li>                
              </ul>
            </li>            

        </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>
<?php /**PATH D:\JOKI\fix\laravel-elearning-master\resources\views/admin/include/sidebar_guru.blade.php ENDPATH**/ ?>