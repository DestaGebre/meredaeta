<!-- jQuery 2.1.4 -->
<script src="<?php echo e(asset('/plugins/jQuery/jQuery-2.1.4.min.js')); ?>"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="<?php echo e(asset('/js/bootstrap.min.js')); ?>" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="<?php echo e(asset('/js/adminlte.min.js')); ?>" type="text/javascript"></script>
<!-- Toastr -->
<script src="<?php echo e(asset('/js/toastr.min.js')); ?>" type="text/javascript"></script>
<?php echo Toastr::render(); ?>

<!-- SweetAlert2 -->
<script src="<?php echo e(asset('/js/sweetalert2.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('/plugins/iCheck/icheck.min.js')); ?>" type="text/javascript"></script>
<script type="text/javascript">
    toastr.options.positionClass='toast-bottom-right';
    toastr.options.escapeHtml = true;
    toastr.options.closeButton = true;
    toastr.options.showMethod = 'slideDown';
    toastr.options.hideMethod = 'slideUp';
    toastr.options.hideMethod = 'slideUp';
    toastr.options.progressBar = true;
</script>
<?php echo $__env->yieldContent('scripts-extra'); ?>