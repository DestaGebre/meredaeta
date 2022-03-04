<?php $__env->startSection('htmlheader_title'); ?>
     መሰረታዊ ውዳበን ዋህዮ ካብ ኤክሴል ኣእትው
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheader_title'); ?>
    መሰረታዊ ውዳበን ዋህዮ ካብ ኤክሴል ኣእትው
<?php $__env->stopSection(); ?>

<?php $__env->startSection('header-extra'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('main-content'); ?>
<body>
    <div class="box box-primary">
        <div class="box-header with-border">
            <?php $cnt = (count($errors) > 0); ?>
            <?php if(count($errors) > 0): ?>
                 <div class = "alert alert-danger">
                    <h3>እዞም ዝስዕቡ ፀገማት ስለዝተረኸቡ ኤክሴል ፋይል ናብ ዳታ ቤዝ ኣይተወን</h3>
                    <ul>
                       <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                          <li><?php echo $error; ?></li>
                       <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                    </ul>
                 </div>
              <?php endif; ?>
            <form action="<?php echo e(url('importwidabeexcel')); ?>" method="post" enctype="multipart/form-data">
                <!-- <label class="col-md-2" for="excelfile">ኤክሴል ፋይል ምረፅ</label>
                <div class="form-group has-feedback col-md-4">
                    <input type="file" class="form-control" name="excelfile" id="excelfile" />
                    <span class="fa fa-picture-o form-control-feedback"></span>
                </div> -->
                <?php echo e(csrf_field()); ?>

                <div class="form-group">
                    <label class="col-md-2 control-label" for="excelfile">ኤክሴል ፋይል ምረፅ</label>
                    <div class="form-group has-feedback col-md-5">
                        <input id="excelfile" name="excelfile" type="file" placeholder="" class="form-control" required="" value="">
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-2">
                    <button type="submit" class="btn btn-block btn-success">ኣእትው</button>
                </div>
            </form>
        </div>
    </div>
</body>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>