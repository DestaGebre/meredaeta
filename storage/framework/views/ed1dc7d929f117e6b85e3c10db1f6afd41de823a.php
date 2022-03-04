<?php $__env->startSection('htmlheader_title'); ?>
  ናይ ከተማ ሪፖርት
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheader_title'); ?>
   ናይ ከተማ ሪፖርት  
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
    <form method="get" action="<?php echo e(url('ketemareportexcelnew')); ?>">
        <input type="hidden" value="<?php echo e($zoneCode); ?>" id="zone" name="zone">
        <input type="hidden" value="<?php echo e($year); ?>" id="year" name="year">
        <input type="hidden" value="<?php echo e($this_quarter); ?>" id="quarter" name="quarter">
        <button class="btn btn-success" type="submit" id="excelbtn"><span class="fa fa-download"></span>ኤክሴል ኣውርድ</button>
    </form>
    <form method="get" action="<?php echo e(url('ketemareport')); ?>">
        <?php if(Auth::user()->usertype == 'admin'): ?>
            <div class="col-md-3 col-sm-4 col-xs-4">    
                <select name="zone" id="zone" class="form-control hide-print" >
                    <option value="" selected disabled>~ዞባ ምረፅ~</option>
                    <option value="0" 
                        <?php if($zoneCode == '0'): ?>
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
        <?php endif; ?>
        <div class="col-md-2 col-sm-4 col-xs-4">    
            <select name="year" id="year" class="form-control hide-print" >
                <option value="" selected disabled>~ዓመት~</option>
                <?php $this_year = explode("/", App\DateConvert::toEthiopian(date('d/m/Y')))[2]; ?>
                <?php $__currentLoopData = range(2010, $this_year); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                    <option  
                    <?php if($value == $year): ?>
                        <?php echo e(''); ?>

                    <?php endif; ?> 
                    ><?php echo e($value); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            </select>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-4">    
            <select name="quarter" id="quarter" class="form-control hide-print" >
                <option value="" selected disabled>~ወቕቲ~</option>
                <?php $__currentLoopData = $quarter_names; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                    <option  
                    <?php if($value == $this_quarter): ?>
                        <?php echo e(''); ?>

                    <?php endif; ?> 
                    ><?php echo e($value); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            </select>
        </div>
        <button class="btn btn-success hide-print" type="submit">ኣርእይ</button>
        <br><br>
    </form>
    <div class="row">
        <div class="col-sm-12">
            <h4 style="text-align: center;">ወሰኽን ጉድለትን ኣሃዛዊ መረዳእታ  <?php echo e($zoneName); ?></h4>
            <div class="table-responsive table-condensed">
                <table style="width: 75%;" class="text-center">
                    <thead>
                        <tr>
                            <th rowspan="3">ወረዳ</th>
                            <th rowspan="3">መበገሲ ኣባል</th>
                            <th colspan="4">ምኽንያት ወሰኽ</th>
                            <th colspan="9">ምኽንያት ጉድለት</th>
                            <th rowspan="3">ሚዛን</th>
                            <th rowspan="3">ሕዚ ዘሎ በዝሒ ኣባል</th>
                        </tr>
                        <tr>
                            <th rowspan="2">ብምልመላ</th>
                            <th rowspan="2">ካብ ካሊእ ዞባ ብዝውውር ዝመፁ</th>
                            <th rowspan="2">ተኣጊዱ ዝነበረ</th>
                            <th rowspan="2">ድምር ወሰኽ</th>
                            <th rowspan="2">ብሞት</th>
                            <th rowspan="2">ብምብራር</th>
                            <th rowspan="2">ብምእጋድ</th>
                            <th colspan="4">ብዝውውር ናብ</th>
                            <th rowspan="2">ብስንብት</th>
                            <th rowspan="2">ድምር ጉድለት</th>
                        </tr>
                        <tr>
                            <th>ዩኒቨርሲቲ</th>
                            <th>ኣብ ዞባ ውሽጢ</th>
                            <th>ናብ ካሊእ ዞባ</th>
                            <th>ካብ ክልል ወፃኢ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $weseking_gudletin; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
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
                        </tr>            
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                    </tbody>
                </table>
            </div>  
        </div>
        <div class="col-sm-12">
            <h4 style="text-align: center;">ናይ 3ተ ወርሒ ከተማ ኣባል  <?php echo e($zoneName); ?></h4>
            <div class="table-responsive table-condensed">
                <table style="width: 75%;" class="text-center">
                    <thead>
                        <tr>
                            <th rowspan="2">ወረዳ</th>
                            <th colspan="3">ደረጃ ኣባልነት</th>
                            <th colspan="3">ደረጃ ዕድመ</th>
                            <th colspan="9">ደረጃ ትምህርቲ</th>
                        </tr>
                        <tr>
                            <th>ሙሉእ</th>
                            <th>ሕፁይ</th>
                            <th>ድምር</th>
                            <th>18-35</th>
                            <th>36-60</th>
                            <th>ካብ 61 ንላዕሊ</th>
                            <th>ዘይተምሃረ</th>
                            <th>1-8</th>
                            <th>9-12</th>
                            <th>ሰርቲፍኬት</th>
                            <th>ዲፕሎማ</th>
                            <th>ዲግሪ</th>
                            <th>MS</th>
                            <th>ዶክተር</th>
                            <th>ድምር</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $abalat_age_education; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
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
        <div class="col-sm-12">
            <h4 style="text-align: center;">ናይ 3ተ ወርሒ ከተማ ኣባል  <?php echo e($zoneName); ?></h4>
            <div class="table-responsive table-condensed">
                <table style="width: 75%;" class="text-center">
                    <thead>
                        <tr>
                            <th rowspan="2">ወረዳ</th>
                            <th colspan="5">ማሕበራዊ ቦታ</th>
                            <th colspan="4">ዕድመ ኣባልነት</th>
                            <th colspan="3">ኣብ ማሕበራት ዘሎ ኣባል</th>
                            <th colspan="3">ብዘለዎ ስራሕ</th>
                            <th colspan="2">ብፆታ</th>
                        </tr>
                        <tr>
                            <th>ደኣንት</th>
                            <th>ሸቃሎ</th>
                            <th>ካልኦት ሰብ ሞያ</th>
                            <th>መምህራን</th>
                            <th>ተምሃሮ</th>
                            <th>67-83</th>
                            <th>84-93</th>
                            <th>94-2000</th>
                            <th>ድሕሪ 2001</th>
                            <th>ደ/ኣንስትዮ</th>
                            <th>መናእሰይ</th>
                            <th>መምህራን</th>
                            <th>መ/ሰራሕተኛ</th>
                            <th>ዘይመንግስታዊ</th>
                            <th>ብውልቀ</th>
                            <th>ደ/ኣንስትዮ</th>
                            <th>ድምር</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $abalat_mahberawi_bota; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
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
                        </tr>            
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                    </tbody>
                </table>
            </div>  
        </div>
        <div class="col-sm-12">
            <h4 style="text-align: center;">ኣብ ደኣንት ዘሎ ኣባል  <?php echo e($zoneName); ?></h4>
            <div class="table-responsive table-condensed">
                <table style="width: 75%;" class="text-center">
                    <thead>
                        <tr>
                            <th rowspan="2">ወረዳ</th>
                            <th colspan="5">ኣብ ማሕበራዊ ቦታ ደኣንት</th>
                            <th colspan="4">ዕድመ ኣባልነት</th>
                            <th colspan="3">ኣብ ማሕበራት ዘሎ ኣባል</th>
                            <th colspan="3">ብዘለዎ ስራሕ</th>
                            <th colspan="2">ብፆታ</th>
                        </tr>
                        <tr>
                            <th>መፍረይቲ</th>
                            <th>ከ/ሕርሻ</th>
                            <th>ኮንስትራክሽን</th>
                            <th>ንግዲ</th>
                            <th>ግልጋሎት</th>
                            <th>67-83</th>
                            <th>84-93</th>
                            <th>94-2000</th>
                            <th>ድሕሪ 2001</th>
                            <th>ደ/ኣንስትዮ</th>
                            <th>ደኣንት</th>
                            <th>መናእሰይ</th>
                            <th>መ/ሰራሕተኛ</th>
                            <th>ዘይመንግስታዊ</th>
                            <th>ብውልቀ</th>
                            <th>ደ/ኣንስትዮ</th>
                            <th>ድምር</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $abalat_deant; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
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
                        </tr>            
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                    </tbody>
                </table>
            </div>  
        </div>
        <div class="col-sm-12">
            <h4 style="text-align: center;">በዝሒ ዋህዮታት ከተማ ካብ ደኣንት ወፃኢ  <?php echo e($zoneName); ?></h4>
            <div class="table-responsive table-condensed">
                <table style="width: 75%;" class="text-center">
                    <thead>
                        <tr>
                            <th rowspan="1">ወረዳ</th>
                            <th>ተምሃሮ</th>
                            <th>መምህራን</th>
                            <th>ካልኦት ሰብ ሞያ</th>
                            <th>ሸቃሎ</th>
                            <th>ድምር</th>
                            <th>ጠቕላላ ድምር<br> ዋህዮ ኣብ ከተማ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $wahio_count; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                        <tr>
                            <td><?php echo e($k[0]); ?></td>
                            <td><?php echo e($k[1]); ?></td>
                            <td><?php echo e($k[2]); ?></td>
                            <td><?php echo e($k[3]); ?></td>
                            <td><?php echo e($k[4]); ?></td>
                            <td><?php echo e($k[5]); ?></td>
                            <td><?php echo e($k[6]); ?></td>
                        </tr>            
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                    </tbody>
                </table>
            </div>  
        </div>
        <div class="col-sm-12">
            <h4 style="text-align: center;">ዞባ <?php echo e($zoneName); ?>: በዝሒ ወረዳ፣ ቀበሌታትን ውዳበ ከተማ</h4>
            <div class="table-responsive table-condensed">
                <table style="width: 75%;" class="text-center">
                    <thead>
                        <tr>
                            <th rowspan="2">ወረዳ</th>
                            <th rowspan="2">በዝሒ ቀበሌታት</th>
                            <th colspan="3">ቀበሌታት ብበዝሒ ኣባላተን</th>
                            <th colspan="6">በዝሒ መ/ውዳበታት</th>
                            <th colspan="5">በዝሒ መ/ውዳበታት ካብ ከተማ ወፃኢ</th>
                            <th rowspan="2">ጠ/ድምር መ/ውዳበታት</th>
                        </tr>
                        <tr>
                            <th>ልዕሊ 500</th>
                            <th>500ን ትሕቲኡ</th>
                            <th>ድምር</th>
                            <th>መፍረይቲ</th>
                            <th>ከተማ ሕርሻ</th>
                            <th>ኮንስትራክሽን</th>
                            <th>ንግዲ</th>
                            <th>ግልጋሎት</th>
                            <th>ድምር</th>
                            <th>ሸቃሎ</th>
                            <th>ተምሃሮ</th>
                            <th>መምህራን</th>
                            <th>ካልኦት ሰብ ሞያ</th>
                            <th>ድምር</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $tabia_count; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
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
                        </tr>            
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                    </tbody>
                </table>
            </div>  
        </div>
        <div class="col-sm-12">
            <h4 style="text-align: center;">ዞባ <?php echo e($zoneName); ?>: ደኣንት ትልሚ</h4>
            <div class="table-responsive table-condensed">
                <table style="width: 75%;" class="text-center">
                    <thead>
                        <tr>
                            <th rowspan="3">ወረዳ</th>
                            <th colspan="10">ትልሚ ምድላው መ/ውዳበ ደኣንት</th>
                            <th colspan="3" rowspan="2">ድምር መ/ውዳበታት</th>
                        </tr>
                        <tr>
                            <th colspan="2">መፍረይቲ</th>
                            <th colspan="2">ከተማ ሕርሻ</th>
                            <th colspan="2">ኮንስትራክሽን</th>
                            <th colspan="2">ንግዲ</th>
                            <th colspan="2">ግልጋሎት</th>
                        </tr>
                        <tr>
                            <th>መበገሲ</th>
                            <th>ዘውፅአ</th>
                            <th>መበገሲ</th>
                            <th>ዘውፅአ</th>
                            <th>መበገሲ</th>
                            <th>ዘውፅአ</th>
                            <th>መበገሲ</th>
                            <th>ዘውፅአ</th>
                            <th>መበገሲ</th>
                            <th>ዘውፅአ</th>
                            <th>መበገሲ</th>
                            <th>ዘውፅአ</th>
                            <th>%</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $plan_deant; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
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
                        </tr>            
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                    </tbody>
                </table>
            </div>  
        </div>
        <div class="col-sm-12">
            <h4 style="text-align: center;">ዞባ <?php echo e($zoneName); ?>: ካብ ደኣንት ወፃኢ ትልሚ</h4>
            <div class="table-responsive table-condensed">
                <table style="width: 75%;" class="text-center">
                    <thead>
                        <tr>
                            <th rowspan="3">ወረዳ</th>
                            <th colspan="8">ትልሚ ምድላው መ/ውዳበ ካብ ደኣንት ወፃኢ</th>
                            <th colspan="3" rowspan="2">ድምር መ/ውዳበታት</th>
                        </tr>
                        <tr>
                            <th colspan="2">ሸቃሎ</th>
                            <th colspan="2">ተምሃሮ</th>
                            <th colspan="2">መምህራን</th>
                            <th colspan="2">ካልኦት ሰብ ሞያ</th>
                        </tr>
                        <tr>
                            <th>መበገሲ</th>
                            <th>ዘውፅአ</th>
                            <th>መበገሲ</th>
                            <th>ዘውፅአ</th>
                            <th>መበገሲ</th>
                            <th>ዘውፅአ</th>
                            <th>መበገሲ</th>
                            <th>ዘውፅአ</th>
                            <th>መበገሲ</th>
                            <th>ዘውፅአ</th>
                            <th>%</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $plan_non_deant; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
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
                        </tr>            
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                    </tbody>
                </table>
            </div>  
        </div>
        <div class="col-sm-12">
            <h4 style="text-align: center;">ዞባ <?php echo e($zoneName); ?>: በቢደረጅኡ ትልሚ ምድላው ዝምልከት</h4>
            <div class="table-responsive table-condensed">
                <table style="width: 75%;" class="text-center">
                    <thead>
                        <tr>
                            <th rowspan="2">ወረዳ</th>
                            <th colspan="3">ውልቀ ኣባል</th>
                            <th colspan="3">መ/ውዳበ</th>
                            <th colspan="3">ዋህዮታት</th>
                            <th rowspan="2">መብርሂ</th>
                        </tr>
                        <tr>
                            <th>መበገሲ</th>
                            <th>ዘውፅአ</th>
                            <th>%</th>
                            <th>መበገሲ</th>
                            <th>ዘውፅአ</th>
                            <th>%</th>
                            <th>መበገሲ</th>
                            <th>ዘውፅአ</th>
                            <th>%</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $plan_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
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
                        </tr>            
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                    </tbody>
                </table>
            </div>  
        </div>
        <div class="col-sm-12">
            <h4 style="text-align: center;">ዞባ <?php echo e($zoneName); ?>: ሞዴል ኣመራርሓ መ/ውዳበን ዋህዮታትን</h4>
            <div class="table-responsive table-condensed">
                <table style="width: 75%;" class="text-center">
                    <thead>
                        <tr>
                            <th rowspan="2">ወረዳ</th>
                            <th colspan="4">መ/ውዳበ ኣመራርሓ</th>
                            <th colspan="4">ዋህዮታት ኣመራርሓ</th>
                            <!-- <th colspan="4">ዋህዮታት ደ/ኣንስትዮ ኣመራርሓ</th> -->
                            <th rowspan="2">መብርሂ</th>
                        </tr>
                        <tr>
                            <th>መበገሲ</th>
                            <th>ሞዴል</th>
                            <th>ዘይኮኑ</th>
                            <th>%</th>
                            <th>መበገሲ</th>
                            <th>ሞዴል</th>
                            <th>ዘይኮኑ</th>
                            <th>%</th>
                            <!-- <th>መበገሲ</th>
                            <th>ሞዴል</th>
                            <th>ዘይኮኑ</th>
                            <th>%</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $model_members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
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
                                <!-- <td><?php echo e($k[9]); ?></td>
                                <td><?php echo e($k[10]); ?></td>
                                <td><?php echo e($k[11]); ?></td>
                                <td><?php echo e($k[12]); ?></td> -->
                                <td><?php echo e($k[13]); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                    </tbody>
                </table>
            </div>  
        </div>
        <div class="col-sm-12">
            <h4 style="text-align: center;">ዞባ <?php echo e($zoneName); ?>: ኣፈፃፅማ ምልመላ ሓደሽቲ ኣባላት ውድብ ካብ ደኣንት ወፃኢ</h4>
            <div class="table-responsive table-condensed">
                <table style="width: 75%;" class="text-center">
                    <thead>
                        <tr>
                            <th rowspan="2">ወረዳ</th>
                            <th colspan="2">ካልኦት ሰብ ሞያ</th>
                            <th colspan="2">ሸቃሎ</th>
                            <th colspan="2">ተምሃሮ</th>
                            <th colspan="2">መምህራን</th>
                            <th rowspan="2">ድምር ፍፃመ ምልመላ</th>
                        </tr>
                        <tr>
                            <th>ትልሚ</th>
                            <th>ፍፃመ</th>
                            <th>ትልሚ</th>
                            <th>ፍፃመ</th>
                            <th>ትልሚ</th>
                            <th>ፍፃመ</th>
                            <th>ትልሚ</th>
                            <th>ፍፃመ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $new_members_non_deant; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
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
        <div class="col-sm-12">
            <h4 style="text-align: center;">ዞባ <?php echo e($zoneName); ?>: ኣፈፃፅማ ምልመላ ሓደሽቲ ኣባላት ውድብ ደኣንት</h4>
            <div class="table-responsive table-condensed">
                <table style="width: 75%;" class="text-center">
                    <thead>
                        <tr>
                            <th rowspan="2">ወረዳ</th>
                            <th colspan="2">መፍረይቲ</th>
                            <th colspan="2">ከተማ ሕርሻ</th>
                            <th colspan="2">ኮንስትራክሽን</th>
                            <th colspan="2">ንግዲ</th>
                            <th colspan="2">ግልጋሎት</th>
                            <th rowspan="2">ድምር ፍፃመ ምልመላ</th>
                        </tr>
                        <tr>
                            <th>ትልሚ</th>
                            <th>ፍፃመ</th>
                            <th>ትልሚ</th>
                            <th>ፍፃመ</th>
                            <th>ትልሚ</th>
                            <th>ፍፃመ</th>
                            <th>ትልሚ</th>
                            <th>ፍፃመ</th>
                            <th>ትልሚ</th>
                            <th>ፍፃመ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $new_members_deant; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
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
                        </tr>            
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                    </tbody>
                </table>
            </div>  
        </div>
        <div class="col-sm-12">
            <h4 style="text-align: center;">ዞባ <?php echo e($zoneName); ?>: ካብ ብርኪ ሕፁይነት ናብ ሙሉእ ዝሰገሩ ፀብፃብ</h4>
            <div class="table-responsive table-condensed">
                <table style="width: 75%;" class="text-center">
                    <thead>
                        <tr>
                            <th rowspan="2">ወረዳ</th>
                            <th colspan="3">ክስግሩ ዝግበኦም ወይ ሽቶ</th>
                            <th colspan="4">ፍፃመ</th>
                            <th colspan="3">ምኽንያት ዘይምስጋር</th>
                            <th rowspan="2">ግዚኦም ዘይኣኸለ</th>
                        </tr>
                        <tr>
                            <th>ተባ</th>
                            <th>ኣን</th>
                            <th>ድምር</th>
                            <th>ተባ</th>
                            <th>ኣን</th>
                            <th>ድምር</th>
                            <th>%</th>
                            <th>ብቕፅዓት</th>
                            <th>ተሰናቢቱ</th>
                            <th>ብድኽመት</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $approved_new_members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
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
                        </tr>            
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                    </tbody>
                </table>
            </div>  
        </div>
        <div class="col-sm-12">
            <h4 style="text-align: center;">ዞባ <?php echo e($zoneName); ?>: ስርርዕ ኣባልን ኣመራርሓን ከተማ</h4>
            <div class="table-responsive table-condensed">
                <table style="width: 75%;" class="text-center">
                    <thead>
                        <tr>
                            <th rowspan="2">ወረዳ</th>
                            <th colspan="5">ደኣንት</th>
                            <th colspan="5">ሸቃሎ</th>
                            <th colspan="5">ካልኦት ሰብ ሞያ</th>
                            <th colspan="5">መምህራን</th>
                            <th colspan="5">ተምሃሮ</th>
                        </tr>
                        <tr>
                            <th>በዝሒ</th>
                            <th>A</th>
                            <th>B</th>
                            <th>C</th>
                            <th>ዘይተሰርዑ</th>
                            <th>በዝሒ</th>
                            <th>A</th>
                            <th>B</th>
                            <th>C</th>
                            <th>ዘይተሰርዑ</th>
                            <th>በዝሒ</th>
                            <th>A</th>
                            <th>B</th>
                            <th>C</th>
                            <th>ዘይተሰርዑ</th>
                            <th>በዝሒ</th>
                            <th>A</th>
                            <th>B</th>
                            <th>C</th>
                            <th>ዘይተሰርዑ</th>
                            <th>በዝሒ</th>
                            <th>ቶፕ 20</th>
                            <th>ማእኸላይ</th>
                            <th>ትሑት</th>
                            <th>ዘይተሰርዑ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
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
                            <td><?php echo e($k[22]); ?></td>
                            <td><?php echo e($k[23]); ?></td>
                            <td><?php echo e($k[24]); ?></td>
                            <td><?php echo e($k[25]); ?></td>
                        </tr>            
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                    </tbody>
                </table>
            </div>  
        </div>
        <div class="col-sm-12">
            <h4 style="text-align: center;">ዞባ <?php echo e($zoneName); ?>: ቅፅዓት ዝምልከት</h4>
            <div class="table-responsive table-condensed">
                <table style="width: 75%;" class="text-center">
                    <thead>
                        <tr>
                            <th rowspan="2">ወረዳ</th>
                            <th colspan="9">ዓይነት ቅፅዓት</th>
                            <th colspan="5">ምኽንያት ቅፅዓት</th>
                            <th colspan="3">ዝተቐፅዑ ብፃታ</th>
                        </tr>
                        <tr>
                            <th>መጠንቐቕታ</th>
                            <th>ሕፀ ዝተናውሐ</th>
                            <th>ካብ ሕፀ ዝተባረሩ</th>
                            <th>ናብ ሕፀ ዝወረዱ</th>
                            <th>ካብ ሓላፍነት ዝተኣገዱ</th>
                            <th>ካብ ሓላፍነት ዝወረዱ</th>
                            <th>ካብ ኣባልነት ዝተኣገዱ</th>
                            <th>ካብ ኣባልነት ዝተባረሩ</th>
                            <th>ድምር</th>
                            <th>ናይ ኣረኣእያ ፀገም</th>
                            <th>ስነ-ምግበር</th>
                            <th>ግቡእ ዘይምፍፃም</th>
                            <th>ዓቕሚ ምንኣስ</th>
                            <th>ፀረ ዲሞክራሲ</th>
                            <th>ኣነ</th>
                            <th>ተባ</th>
                            <th>ድምር</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $punishment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
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
                        </tr>            
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                    </tbody>
                </table>
            </div>  
        </div>
    </div>
</div>

    
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts-extra'); ?>
    <script type="text/javascript">
        $('#excelbtn').on('click', function(e) {
            $('#zoneCode').val($('#zone').val());
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>