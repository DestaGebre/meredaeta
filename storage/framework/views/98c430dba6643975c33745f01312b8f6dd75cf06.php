<?php $__env->startSection('htmlheader_title'); ?>
    Log in
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="<?php echo e(url('/')); ?>">ሶፍትዌር ምሕደራ ኣባላት ህዝባዊ ወያነ ሓርነት ትግራይ</a>
        </div><!-- /.login-logo -->

    <?php if(count($errors) > 0): ?>
        <div class="alert alert-danger">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="login-box-body">
    <!-- <p class="login-box-msg">Sign in to start your session</p> -->
    <form action="<?php echo e(url('/login')); ?>" method="post">

        <?php echo csrf_field(); ?>


        <div class="form-group has-feedback">
            <input type="email" class="form-control" placeholder="ኢሜይል" name="email"/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="ፓስዎርድ" name="password"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <!-- <div class="col-xs-8">
                <div class="checkbox icheck">
                    <label>
                        <input type="checkbox" name="remember"> Remember Me
                    </label>
                </div>
            </div> -->
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">እቶ</button>
            </div><!-- /.col -->
        </div>
    </form>

    
    <!-- <a href="<?php echo e(url('/register')); ?>" class="text-center"><span class="glyphicon glyphicon-user"></span> Register New Member</a><br> -->
    <!-- <a href="<?php echo e(url('/password/reset')); ?>"><span class="glyphicon glyphicon-info-sign"></span> I forgot my password</a><br> -->
    

</div><!-- /.login-box-body -->

</div><!-- /.login-box -->

    <?php echo $__env->make('layouts.partials.scripts_auth', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
</body>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>