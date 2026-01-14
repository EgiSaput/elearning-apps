<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo e(config('app.name')); ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo e(URL::to('asset/css/bootstrap.min.css')); ?>">
	<?php echo $__env->yieldContent('styles'); ?>
</head>
<body>
<div class="container-fluid">
	<div class="row">
		<?php echo $__env->yieldContent('banner'); ?>
	</div>
	<div class="row">
		<?php echo $__env->yieldContent('content'); ?>
	</div>
	<div class="row">
		<?php echo $__env->yieldContent('footer'); ?>
	</div>
</div>
</body>
<?php echo $__env->yieldContent('scripts'); ?>
<script type="text/javascript" src="<?php echo e(URL::to('asset/jquery.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(URL::to('asset/js/bootstrap.min.js')); ?>"></script>
</html><?php /**PATH D:\JOKI\fix\laravel-elearning-master\resources\views/auth/layouts/default.blade.php ENDPATH**/ ?>