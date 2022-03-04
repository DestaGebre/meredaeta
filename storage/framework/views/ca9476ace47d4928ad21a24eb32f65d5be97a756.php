<?php $__env->startSection('htmlheader_title'); ?>
  ናይ ክልል ሪፖርት
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheader_title'); ?>
   ናይ ክልል ሪፖርት  
<?php $__env->stopSection(); ?>

<?php $__env->startSection('header-extra'); ?>
<style type="text/css">
    th, td {
        border: 1px solid black;
    }
    @media  print{
        #excelbtn{
            display: none;
        }
        .hide-print{
            display: none;
        }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>
    
           

<div class="container">
    <form method="get" action="<?php echo e(url('regionalreportexcel')); ?>">
        <input type="hidden" value="<?php echo e($zoneCode); ?>" id="zoneCode" name="zoneCode">
        <button class="btn btn-success hide-print" type="submit"><span class="fa fa-download"></span>ኤክሴል ኣውርድ</button>
    </form>
    <form method="get" action="<?php echo e(url('regionalreport')); ?>">
        <?php if(Auth::user()->usertype == 'admin'): ?>
            <div class="col-md-6 col-sm-6 col-xs-6">    
                <select name="zone" id="zone" class="form-control hide-print">
                    <option value="" selected disabled>~ዞባ ምረፅ~</option>
                    <option value="all" 
                    <?php if($zoneCode == 'all'): ?>
                        <?php echo e('selected'); ?>

                    <?php endif; ?> 
                    >ኩሎም</option>
                    <?php $__currentLoopData = $zobadatas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                        <option value="<?php echo e($key); ?>" 
                        <?php if($zoneCode == $key): ?>
                            <?php echo e('selected'); ?>

                        <?php endif; ?> 
                        ><?php echo e($value); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                </select>
            </div>
            
            <button class="btn btn-success hide-print" type="submit">ኣርእይ</button>
            <br><br>
        <?php endif; ?>
    </form>
    <div class="row">
        <div class="col-sm-12">
            <h4 style="text-align: center;">ናይ ዞባታት ገጠርን ከተማን ኣባል ውድብ /ዞባ  <?php echo e($zoneName); ?></h4>
            <div class="table-responsive table-condensed">
                <table style="width: 75%;" class="text-center">
                    <thead>
                        <tr>
                            <th rowspan="2">ወረዳ</th>
                            <th colspan="3">ገጠር</th>
                            <th colspan="3">ከተማ</th>
                            <th colspan="3">ጠ/ድምር</th>
                        </tr>
                        <tr>
                            <th>ተባ</th>
                            <th>ኣን</th>
                            <th>ድምር</th>
                            <th>ተባ</th>
                            <th>ኣን</th>
                            <th>ድምር</th>
                            <th>ድምር ተባ</th>
                            <th>ድምር ኣን</th>
                            <th>ጠ/ድምር</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $ketemageter; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                        <tr>
                            <td><?php echo e($k[0]); ?></td>
                            <td><?php echo e($k[1]); ?></td>
                            <td><?php echo e($k[2]); ?></td>
                            <td><?php echo e($k[3]); ?></td>
                            <td><?php echo e($k[4]); ?></td>
                            <td><?php echo e($k[5]); ?></td>
                            <td><?php echo e($k[6]); ?></td>
                            <td><?php echo e($k[7]); ?></td>
                            <td><?php echo e($k[8]); ?></td>
                            <td><?php echo e($k[9]); ?></td>
                        </tr>            
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                    </tbody>
                </table>
            </div>  
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <h4 style="text-align: center;">ገጠርን ከተማ ውዳበ ዞባ <?php echo e($zoneName); ?></h4>
            <div class="table-responsive table-condensed">
                <table style="width: 75%;" class="text-center">
                    <thead>
                        <tr>
                            <th rowspan="2">ወረዳ</th>
                            <th colspan="3">ገባር</th>
                            <th colspan="3">ደኣንት</th>
                            <th colspan="3">ሲ/ሰርቫንት</th>
                            <th colspan="3">መምህራን</th>
                            <th colspan="3">ተምሃሮ</th>
                            <th colspan="3">ሸቃሎ</th>
                            <th colspan="3">ጠ/ድምር</th>
                        </tr>
                        <tr>
                            <th>ተባ</th>
                            <th>ኣን</th>
                            <th>ድምር</th>
                            <th>ተባ</th>
                            <th>ኣን</th>
                            <th>ድምር</th>
                            <th>ተባ</th>
                            <th>ኣን</th>
                            <th>ድምር</th>
                            <th>ተባ</th>
                            <th>ኣን</th>
                            <th>ድምር</th>
                            <th>ተባ</th>
                            <th>ኣን</th>
                            <th>ድምር</th>
                            <th>ተባ</th>
                            <th>ኣን</th>
                            <th>ድምር</th>
                            <th>ድምር ተባ</th>
                            <th>ድምር ኣን</th>
                            <th>ጠ/ድምር</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $ketemageterwidabe; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                        <tr>
                            <td><?php echo e($k[0]); ?></td>
                            <td><?php echo e($k[1]); ?></td>
                            <td><?php echo e($k[2]); ?></td>
                            <td><?php echo e($k[3]); ?></td>
                            <td><?php echo e($k[4]); ?></td>
                            <td><?php echo e($k[5]); ?></td>
                            <td><?php echo e($k[6]); ?></td>
                            <td><?php echo e($k[7]); ?></td>
                            <td><?php echo e($k[8]); ?></td>
                            <td><?php echo e($k[9]); ?></td>
                            <td><?php echo e($k[10]); ?></td>
                            <td><?php echo e($k[11]); ?></td>
                            <td><?php echo e($k[12]); ?></td>
                            <td><?php echo e($k[13]); ?></td>
                            <td><?php echo e($k[14]); ?></td>
                            <td><?php echo e($k[15]); ?></td>
                            <td><?php echo e($k[16]); ?></td>
                            <td><?php echo e($k[17]); ?></td>
                            <td><?php echo e($k[18]); ?></td>
                            <td><?php echo e($k[19]); ?></td>
                            <td><?php echo e($k[20]); ?></td>
                            <td><?php echo e($k[21]); ?></td>
                        </tr>            
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <h4 style="text-align: center;">ገጠር ውዳበ ዞባ <?php echo e($zoneName); ?></h4>
            <div class="table-responsive table-condensed">
                <table style="width: 75%;" class="text-center">
                    <thead>
                        <tr>
                            <th rowspan="2">ወረዳ</th>
                            <th colspan="3">ገባር</th>
                            <th colspan="3">ሲ/ሰርቫንት</th>
                            <th colspan="3">መምህራን</th>
                            <th colspan="3">ተምሃሮ</th>
                            <th colspan="3">ጠ/ድምር</th>
                        </tr>
                        <tr>
                            <th>ተባ</th>
                            <th>ኣን</th>
                            <th>ድምር</th>
                            <th>ተባ</th>
                            <th>ኣን</th>
                            <th>ድምር</th>
                            <th>ተባ</th>
                            <th>ኣን</th>
                            <th>ድምር</th>
                            <th>ተባ</th>
                            <th>ኣን</th>
                            <th>ድምር</th>
                            <th>ድምር ተባ</th>
                            <th>ድምር ኣን</th>
                            <th>ጠ/ድምር</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $geterwidabe; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                        <tr>
                            <td><?php echo e($k[0]); ?></td>
                            <td><?php echo e($k[1]); ?></td>
                            <td><?php echo e($k[2]); ?></td>
                            <td><?php echo e($k[3]); ?></td>
                            <td><?php echo e($k[4]); ?></td>
                            <td><?php echo e($k[5]); ?></td>
                            <td><?php echo e($k[6]); ?></td>
                            <td><?php echo e($k[7]); ?></td>
                            <td><?php echo e($k[8]); ?></td>
                            <td><?php echo e($k[9]); ?></td>
                            <td><?php echo e($k[10]); ?></td>
                            <td><?php echo e($k[11]); ?></td>
                            <td><?php echo e($k[12]); ?></td>
                            <td><?php echo e($k[13]); ?></td>
                            <td><?php echo e($k[14]); ?></td>
                            <td><?php echo e($k[15]); ?></td>
                        </tr>            
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <h4 style="text-align: center;">ከተማ ውዳበ ዞባ <?php echo e($zoneName); ?></h4>
            <div class="table-responsive table-condensed">
                <table style="width: 75%;" class="text-center">
                    <thead>
                        <tr>
                            <th rowspan="2">ወረዳ</th>
                            <th colspan="3">ደኣንት</th>
                            <th colspan="3">ሸቃሎ</th>
                            <th colspan="3">ሰብ ሞያ</th>
                            <th colspan="3">መምህራን</th>
                            <th colspan="3">ተምሃሮ</th>
                            <th colspan="3">ጠ/ድምር</th>
                        </tr>
                        <tr>
                            <th>ተባ</th>
                            <th>ኣን</th>
                            <th>ድምር</th>
                            <th>ተባ</th>
                            <th>ኣን</th>
                            <th>ድምር</th>
                            <th>ተባ</th>
                            <th>ኣን</th>
                            <th>ድምር</th>
                            <th>ተባ</th>
                            <th>ኣን</th>
                            <th>ድምር</th>
                            <th>ተባ</th>
                            <th>ኣን</th>
                            <th>ድምር</th>
                            <th>ድምር ተባ</th>
                            <th>ድምር ኣን</th>
                            <th>ጠ/ድምር</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $ketemawidabe; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                        <tr>
                            <td><?php echo e($k[0]); ?></td>
                            <td><?php echo e($k[1]); ?></td>
                            <td><?php echo e($k[2]); ?></td>
                            <td><?php echo e($k[3]); ?></td>
                            <td><?php echo e($k[4]); ?></td>
                            <td><?php echo e($k[5]); ?></td>
                            <td><?php echo e($k[6]); ?></td>
                            <td><?php echo e($k[7]); ?></td>
                            <td><?php echo e($k[8]); ?></td>
                            <td><?php echo e($k[9]); ?></td>
                            <td><?php echo e($k[10]); ?></td>
                            <td><?php echo e($k[11]); ?></td>
                            <td><?php echo e($k[12]); ?></td>
                            <td><?php echo e($k[13]); ?></td>
                            <td><?php echo e($k[14]); ?></td>
                            <td><?php echo e($k[15]); ?></td>
                            <td><?php echo e($k[16]); ?></td>
                            <td><?php echo e($k[17]); ?></td>
                            <td><?php echo e($k[18]); ?></td>
                        </tr>            
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
        <h4 style="text-align: center;">ደኣንት ዞባ <?php echo e($zoneName); ?> ብማሕበራዊ ቦታ</h4>
        <div class="table-responsive table-condensed">
            <table style="width: 75%;" class="text-center">
                <thead>
                    <tr>
                        <th rowspan="2">ወረዳ</th>
                        <th colspan="3">መፍረይቲ</th>
                        <th colspan="3">ከ/ሕርሻ</th>
                        <th colspan="3">ኮንስትራክሽን</th>
                        <th colspan="3">ንግዲ</th>
                        <th colspan="3">ግልጋሎት</th>
                        <th colspan="3">ጠ/ድምር</th>
                    </tr>
                    <tr>
                        <th>ተባ</th>
                        <th>ኣን</th>
                        <th>ድምር</th>
                        <th>ተባ</th>
                        <th>ኣን</th>
                        <th>ድምር</th>
                        <th>ተባ</th>
                        <th>ኣን</th>
                        <th>ድምር</th>
                        <th>ተባ</th>
                        <th>ኣን</th>
                        <th>ድምር</th>
                        <th>ተባ</th>
                        <th>ኣን</th>
                        <th>ድምር</th>
                        <th>ድምር ተባ</th>
                        <th>ድምር ኣን</th>
                        <th>ጠ/ድምር</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $deant; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                    <tr>
                        <td><?php echo e($k[0]); ?></td>
                        <td><?php echo e($k[1]); ?></td>
                        <td><?php echo e($k[2]); ?></td>
                        <td><?php echo e($k[3]); ?></td>
                        <td><?php echo e($k[4]); ?></td>
                        <td><?php echo e($k[5]); ?></td>
                        <td><?php echo e($k[6]); ?></td>
                        <td><?php echo e($k[7]); ?></td>
                        <td><?php echo e($k[8]); ?></td>
                        <td><?php echo e($k[9]); ?></td>
                        <td><?php echo e($k[10]); ?></td>
                        <td><?php echo e($k[11]); ?></td>
                        <td><?php echo e($k[12]); ?></td>
                        <td><?php echo e($k[13]); ?></td>
                        <td><?php echo e($k[14]); ?></td>
                        <td><?php echo e($k[15]); ?></td>
                        <td><?php echo e($k[16]); ?></td>
                        <td><?php echo e($k[17]); ?></td>
                        <td><?php echo e($k[18]); ?></td>
                    </tr>            
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                </tbody>
            </table>
        </div>  
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts-extra'); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>