
<?php $__env->startSection('breadcrump'); ?>
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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
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
                <td><strong><?php echo e($siswa->nama_siswa); ?></strong></td>
              </tr>
              <tr>
                <th>NISN</th>
                <td><?php echo e($siswa->nisn_siswa); ?></td>
              </tr>
              <tr>
                <th>Kelas</th>
                <td><?php echo e($siswa->kelas_siswa); ?></td>
              </tr>
            </table>
          </div>
          <div class="col-md-6">
            <table class="table table-bordered">
              <tr>
                <th style="width: 150px;">Judul Ujian</th>
                <td><strong><?php echo e($ujian->judul_ujian); ?></strong></td>
              </tr>
              <tr>
                <th>Mata Pelajaran</th>
                <td><?php echo e($mapel->nama_mapel); ?></td>
              </tr>
              <tr>
                <th>Nilai</th>
                <td>
                  <?php if($nilaiUjian->nilai >= 80): ?>
                    <span class="badge bg-green" style="font-size: 16px;"><?php echo e($nilaiUjian->nilai); ?></span>
                  <?php elseif($nilaiUjian->nilai >= 70): ?>
                    <span class="badge bg-yellow" style="font-size: 16px;"><?php echo e($nilaiUjian->nilai); ?></span>
                  <?php else: ?>
                    <span class="badge bg-red" style="font-size: 16px;"><?php echo e($nilaiUjian->nilai); ?></span>
                  <?php endif; ?>
                  <?php if($nilaiUjian->nilai >= 70): ?>
                    <span class="label label-success">Lulus</span>
                  <?php else: ?>
                    <span class="label label-danger">Tidak Lulus</span>
                  <?php endif; ?>
                </td>
              </tr>
            </table>
          </div>
        </div>

        <!-- Summary -->
        <?php
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
        ?>
        <div class="row" style="margin-top: 20px;">
          <div class="col-md-3 col-sm-6">
            <div class="info-box bg-aqua">
              <span class="info-box-icon"><i class="fa fa-list"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Total Soal</span>
                <span class="info-box-number"><?php echo e($total); ?></span>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-sm-6">
            <div class="info-box bg-green">
              <span class="info-box-icon"><i class="fa fa-check"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Benar</span>
                <span class="info-box-number"><?php echo e($benar); ?></span>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-sm-6">
            <div class="info-box bg-red">
              <span class="info-box-icon"><i class="fa fa-times"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Salah</span>
                <span class="info-box-number"><?php echo e($salah); ?></span>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-sm-6">
            <div class="info-box bg-yellow">
              <span class="info-box-icon"><i class="fa fa-minus"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Tidak Dijawab</span>
                <span class="info-box-number"><?php echo e($kosong); ?></span>
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
        <?php $nomor = 1; ?>
        <?php $__currentLoopData = $jawabanSiswa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $js): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php
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
          ?>
          <div class="panel panel-<?php echo e($statusClass); ?>" style="margin-bottom: 15px;">
            <div class="panel-heading">
              <h4 class="panel-title">
                <strong>Soal #<?php echo e($nomor); ?></strong>
                <span class="pull-right label label-<?php echo e($statusClass); ?>">
                  <i class="fa <?php echo e($statusIcon); ?>"></i> <?php echo e($statusText); ?>

                </span>
              </h4>
            </div>
            <div class="panel-body">
              <!-- Pertanyaan -->
              <div class="well" style="background-color: #f9f9f9;">
                <strong>Pertanyaan:</strong><br>
                <?php echo $js->pertanyaan; ?>

                <?php if($js->gambar_soal && $js->gambar_soal != ''): ?>
                  <br><br>
                  <img src="<?php echo e(asset('upload_gambar/' . $js->gambar_soal)); ?>" alt="Gambar Soal" style="max-width: 300px; max-height: 200px;">
                <?php endif; ?>
              </div>

              <!-- Opsi Jawaban -->
              <div style="margin-top: 15px;">
                <strong>Pilihan Jawaban:</strong>
                <ul class="list-group" style="margin-top: 10px;">
                  <?php $huruf = ['A', 'B', 'C', 'D', 'E']; $idx = 0; ?>
                  <?php $__currentLoopData = $js->opsi_jawaban; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opsi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
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
                    ?>
                    <li class="list-group-item" style="background-color: <?php echo e($bgColor); ?>;">
                      <strong><?php echo e($huruf[$idx] ?? ($idx+1)); ?>.</strong> 
                      <?php echo e($opsi->jawaban); ?>

                      <?php if($isSelected): ?>
                        <span class="badge bg-blue pull-right" style="margin-left: 5px;">Jawaban Siswa</span>
                      <?php endif; ?>
                      <?php if($isCorrect): ?>
                        <span class="badge bg-green pull-right">Kunci Jawaban</span>
                      <?php endif; ?>
                      <?php echo $icon; ?>

                    </li>
                    <?php $idx++; ?>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
              </div>

              <!-- Jawaban Siswa Info -->
              <div class="row" style="margin-top: 15px;">
                <div class="col-md-6">
                  <div class="alert alert-info" style="margin-bottom: 0;">
                    <strong>Jawaban Siswa:</strong> 
                    <?php if($js->jawaban_dipilih_text): ?>
                      <?php echo e($js->jawaban_dipilih_text); ?>

                    <?php else: ?>
                      <em>Tidak menjawab</em>
                    <?php endif; ?>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="alert alert-success" style="margin-bottom: 0;">
                    <strong>Kunci Jawaban:</strong> 
                    <?php if($js->jawaban_benar): ?>
                      <?php echo e($js->jawaban_benar->jawaban); ?>

                    <?php else: ?>
                      <em>-</em>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php $nomor++; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
@media  print {
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\JOKI\fix\laravel-elearning-master\resources\views/admin/dashboard/nilai/detail_jawaban.blade.php ENDPATH**/ ?>