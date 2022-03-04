<?php $__env->startSection('htmlheader_title'); ?>
    ሓዱሽ ፋይል
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheader_title'); ?>
    ሓዱሽ ፋይል
<?php $__env->stopSection(); ?>

<?php $__env->startSection('header-extra'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>
<div class="col-xs-12 col-md-8">
    <div class="box box-primary">
        <div class="box-body">
            <form action="<?php echo e(url('newdocumentupload')); ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PATCH">
                <?php echo e(csrf_field()); ?>

                <?php $cnt = (count($errors) > 0); ?>
                <?php if(count($errors) > 0): ?>
                    <div class="alert alert-danger">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                            <p><?php echo e($error); ?></p>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                    </div>
                <?php endif; ?>

                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="ሽም ፋይል" name="title" value=""/>
                </div>

                <div class="form-group has-feedback">
                    <textarea class="form-control" placeholder="መብርሂ" name="description"></textarea>
                </div>
                <div class="form-group has-feedback">
                    <input type="file" class="form-control" name="file" />
                </div>

                <button type="submit" class="btn btn-primary btn-block btn-flat">ፋይል ኣእትው</button>
            </form>
        </div>
    </div>
</div>       
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts-extra'); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>