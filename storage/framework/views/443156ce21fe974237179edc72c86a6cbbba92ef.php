<?php if(Session::has('flash_message')): ?>
    <div class="alert alert-success <?php echo e(Session::has('penting') ? 'alert-important' : ''); ?>" style="text-align: center;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo e(Session::get('flash_message')); ?>

    </div>
<?php endif; ?><?php /**PATH D:\JOKI\fix\laravel-elearning-master\resources\views/_partial/flash_message.blade.php ENDPATH**/ ?>