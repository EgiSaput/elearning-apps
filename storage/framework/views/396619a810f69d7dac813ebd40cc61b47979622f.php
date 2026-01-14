<!-- Terpaksa Ngoding di View -->
<?php 
  $i = Auth::user()->level;
  $idUser = Auth::user()->id_user;                         
  $siswa = \App\Siswa::where('id_user', $idUser)->first(); // detail field siswa yang sedang login.
  $guru = \App\Guru::where('id_user', $idUser)->first(); // detail field siswa yang sedang login.
  $foto = 'foto .jpg';
?>
      <header class="main-header">

        <!-- Logo -->
       <a href="<?php echo e(URL::to('/')); ?>" class="logo" style="display: flex; align-items: center; justify-content: center;">
  
  <span class="logo-mini">
    <img src="<?php echo e(asset('img/logo_sklh.png')); ?>" alt="Logo" 
         style="width: 40px; height: auto; margin: auto; display: block;">
  </span>

  <span class="logo-lg" style="display: flex; align-items: center; justify-content: center;">
    <img src="<?php echo e(asset('img/logo_sklh.png')); ?>" alt="Logo" 
         style="width: 45px; height: auto; margin-right: 10px; margin-top: -2px;">
    <b style="font-size: 18px;">E-Learning</b>
  </span>

</a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu Selamat Datang di Sistem Informasi E-Learning pada SMP PGRI 1 Bandar Lampung -->          
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav" >
              <li>
                <a href="#">
                  <!-- <b> Waktu Sekarang : </b><?php echo e(date("d m Y H:i:s ")); ?><br>   -->
                  <!-- <div id="clock">00</div>   -->
                </a>                
              </li>
              
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">                  
                    <?php if($i === 11): ?>                     
                      <img src="<?php echo e(asset('/img/avatar04.png')); ?>" class="user-image" alt="User Image">                
                    <?php elseif($i === 12): ?>
                      <img src="<?php echo e(URL::to('upload_gambar/'.$guru->foto_guru)); ?>" class="user-image" alt="User Image">
                    <?php elseif($i === 13): ?>
                      <img src="<?php echo e(URL::to('upload_gambar/'.$siswa->foto_siswa)); ?>" class="user-image" alt="User Image">                    
                    <?php endif; ?>  
                    <span class="hidden-xs"><b>
                        <?php echo e(Auth::user()->name); ?>

                    </b></span>                
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->                  
                  <li class="user-header">                                                         
                      <?php if($i === 11): ?> 
                      <img src="<?php echo e(asset('/img/avatar04.png')); ?>" class="img-circle" alt="User Image">
                      <?php elseif($i === 12): ?>
                      <img src="<?php echo e(URL::to('upload_gambar/'.$guru->foto_guru)); ?>" class="img-circle" alt="User Image">
                      <?php elseif($i === 13): ?>
                      <img src="<?php echo e(URL::to('upload_gambar/'.$siswa->foto_siswa)); ?>" class="img-circle" alt="User Image">
                      <?php endif; ?>
                      <p>
                      <b>Username : </b><?php echo e(Auth::user()->username); ?><br>
                      <b>Otoritas user : </b>Level <?php echo e(Auth::user()->level); ?> 
                      <small></small>
                    </p>
                  </li>                 
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <?php if($i === 11): ?> 
                        <a href="<?php echo e(URL::to('admin/user/'.Auth::user()->id_user.'/ubahpassword')); ?>" class="btn btn-default btn-flat">Ubah Password</a>
                      <?php elseif($i === 12): ?>                                              
                        <a href="<?php echo e(URL::to('guru/guru/'.$guru->nip_guru.'/detail')); ?>" class="btn btn-default btn-flat">Profile</a>
                      <?php elseif($i === 13): ?>
                        <a href="<?php echo e(URL::to('siswa/siswa/'.$siswa->nisn_siswa.'/detail')); ?>" class="btn btn-default btn-flat">Profile</a>
                      <?php endif; ?>
                    </div>
                    <div class="pull-right">
                      <a href="<?php echo e(URL::to('/logout')); ?>" class="btn btn-default btn-flat">Sign Out</a>
                    </div>                                      
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->              
            </ul>
          </div>

        </nav>
      </header><?php /**PATH D:\JOKI\fix\laravel-elearning-master\resources\views/admin/include/header.blade.php ENDPATH**/ ?>