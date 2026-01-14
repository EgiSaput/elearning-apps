<?php $__env->startSection('styles'); ?>
<style type="text/css">
	body{
		
		background: url('<?php echo e(URL::to('asset/images/foto_sekolah.jpg')); ?>') no-repeat center center fixed; 
 		 -webkit-background-size: cover;
 	 -moz-background-size: cover;
 	 -o-background-size: cover;
 	 background-size: cover;

	}
	.input-group{
		margin-bottom: 20px;
	}
	#TitleForm{
		margin-top: 1%;
		margin-bottom: 1%;
		margin-left: 12%;
		margin-right: 12%;
		opacity: 0.9;
		border-radius: 25px;
		opacity: 0.9;
	}
	#loginForm{
		margin-top: 5%;
		margin-bottom: 1%;
		opacity: 0.9;
		border-radius: 10px;
		opacity: 0.9;
	}
	
	#logo-pgri{
		margin-top: -80px;
	}
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('banner'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="col-md-9 well" id="TitleForm" >
	<center>  		
		<strong><h3>Selamat Datang di | SISTEM INFORMASI E-UJIAN SMK PRIMA GRAFIKA </h3></strong>
	</center>
</div>
<div class="col-md-4 col-md-offset-4 well" id="loginForm">
	<center>  
		<img src="<?php echo e(URL::to('img/logo_sklh.png')); ?>" height="180px" width="260px" id="logo-sekolah">
		<h3>Login</h3>
	</center>
		<?php if(count($errors) > 0): ?>
			<div class="alert alert-danger" style="text-align: center;">
				<ul>
					<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<li><?php echo e($error); ?></li>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</ul>
			</div>
		<?php endif; ?>	
	<form id="form-login" name="form-login"  action="<?php echo e(url('/login')); ?>" method="post" autocomplete="off">
		<?php echo e(csrf_field()); ?>

		<div class="input-group">
			<span class="input-group-addon" id="addon1"><i class="glyphicon glyphicon-user"></i></span>
			<input type="text" id="username" name="username" class="form-control input-lg" aria-describedby="addon1" placeholder="Username">
			
		</div>
		<div class="input-group">
			<span class="input-group-addon" id="addon1"><i class="glyphicon glyphicon-lock"></i></span>
			<input type="password" id="password" name="password" class="form-control input-lg" aria-describedby="addon1" placeholder="Password">
			 
		</div>
		<button type="submit" class="btn btn-danger btn-block btn-lg" value="Login"><font style="color:black"> Login </font></button>
	</form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('auth.layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\JOKI\fix\laravel-elearning-master\resources\views/auth/login.blade.php ENDPATH**/ ?>