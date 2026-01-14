<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo e(config('app.name', 'E-learning')); ?></title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="<?php echo e(URL::asset('admin/bootstrap/css/bootstrap.min.css')); ?>"  rel="stylesheet"  type="text/css">
    <link href="<?php echo e(URL::asset('admin/bootstrap/css/font-awesome.min.css')); ?>"  rel="stylesheet"  type="text/css" >
    <link href="<?php echo e(URL::asset('admin/plugins/jvectormap/jquery-jvectormap-1.2.2.css')); ?>" rel="stylesheet"  type="text/css" >
    <link href="<?php echo e(URL::asset('admin/dist/css/AdminLTE.min.css')); ?>" rel="stylesheet"  type="text/css" >
    <link href="<?php echo e(URL::asset('admin/dist/css/skins/_all-skins.min.css')); ?>"  rel="stylesheet" >
    <link href="<?php echo e(URL::asset('admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')); ?>" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/png" href="<?php echo e(asset('auth/images/logo_sklh.png?v=').time()); ?>">
<link rel="shortcut icon" type="image/png" href="<?php echo e(asset('auth/images/logo_sklh.png?v=').time()); ?>">
    <link href="<?php echo e(URL::asset('admin/plugins/datatables/dataTables.bootstrap.css')); ?>" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo e(URL::asset('admin/plugins/select2/select2.css')); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo e(URL::asset('admin/plugins/datepicker/datepicker3.css')); ?>" type="text/css">
    <!-- bikin script base_url untuk dipanggil dari javascript -->
    <meta name="base_url" content="<?php echo e(URL::to('/')); ?>">
  </head>

    <!-- jika siswa maka pake layout-top-nav -->
    <?php if(Auth::user()->level==11): ?> 
    <body class="layout-fixed sidebar-mini skin-red"> 
    <?php elseif(Auth::user()->level==12): ?>
    <body class="layout-fixed sidebar-mini skin-red"> 
    <?php elseif(Auth::user()->level==13): ?>
    <!-- <body class="layout-top-nav skin-red-light">  -->
    <body class="layout-fixed sidebar-mini skin-red"> 
    <?php endif; ?>
     
    <div class="wrapper">      
      <?php echo $__env->make('admin.include.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

      <?php if(Auth::user()->level==11): ?>        
        <?php echo $__env->make('admin.include.sidebar_admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php elseif(Auth::user()->level==12): ?>
        <?php echo $__env->make('admin.include.sidebar_guru', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php elseif(Auth::user()->level==13): ?>
        <?php echo $__env->make('admin.include.sidebar_siswa', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>
      
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <?php echo $__env->yieldContent('breadcrump'); ?>
        </section>

          
        <!-- Main content -->
        <section class="content">
          <?php echo $__env->make('_partial.flash_message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          <?php echo $__env->yieldContent('content'); ?>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
     
    <?php echo $__env->make('admin.include.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <script src="<?php echo e(URL::asset('admin/plugins/jQuery/jQuery-2.1.4.min.js')); ?>"></script>    
    <script src="<?php echo e(URL::asset('admin/plugins/jQueryUI/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('admin/bootstrap/js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/vendor/tinymce/tinymce.min.js ')); ?>"></script>
    <?php echo $__env->yieldContent('script'); ?>
    
    <script src="<?php echo e(URL::asset('admin/plugins/raphael/raphael-min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('admin/plugins/morris/morris.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('admin/plugins/sparkline/jquery.sparkline.min.js')); ?>"></script>   
    <script src="<?php echo e(URL::asset('admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('admin/plugins/knob/jquery.knob.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('admin/plugins/moment/moment.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('admin/plugins/daterangepicker/daterangepicker.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('admin/plugins/datepicker/bootstrap-datepicker.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')); ?>"></script>

    <script src="<?php echo e(URL::asset('admin/plugins/fastclick/fastclick.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('admin/dist/js/app.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('admin/dist/js/pages/dashboard.js')); ?>"></script> 
    <script src="<?php echo e(URL::asset('admin/plugins/highcharts/highcharts.js')); ?>"></script>
    <script src="<?php echo e(asset('/vendor/tinymce/jquery.tinymce.min.js')); ?>"></script>  
    
 
  </body>
</html>
<?php /**PATH D:\JOKI\fix\laravel-elearning-master\resources\views/admin/layout/master.blade.php ENDPATH**/ ?>