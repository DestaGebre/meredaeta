<?php $__env->startSection('htmlheader_title'); ?>
    ገፅ ኣይተረኽበን
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheader_title'); ?>
    404 Error Page
<?php $__env->stopSection(); ?>

<?php $__env->startSection('$contentheader_description'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="error-page">
    <h2 class="headline text-yellow"> 404</h2>
    <div class="error-content">
        <h3><i class="fa fa-warning text-yellow"></i>ይቕረታ! እቲ ገፅ ኣይተረኸበን።</h3>
        <p>
            እቲ ዝሓተትዎ ገፅ ክንረኽቦ ኣይከኣልናን። ናብ ዳሽ ቦርድ ንምኻድ <a href='<?php echo e(url('/')); ?>'>ነዙይ ይንክኡ</a>
        </p>
    </div><!-- /.error-content -->
</div><!-- /.error-page -->
<style type="text/css">
    a:hover{
        background-color: #a4d1ec;
        color: #fff;
    }
    </style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.auth', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>