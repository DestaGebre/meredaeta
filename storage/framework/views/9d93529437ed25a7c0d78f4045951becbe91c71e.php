<form method="get" action="<?php echo e(url($address)); ?>">
    <div class="row">
    <?php if(!isset($hide_zone) && (Auth::user()->usertype == 'admin' || isset($show_zone))): ?>
        <div class="col-md-2 col-sm-4 col-xs-4">
            <select name="zone" id="zone_filter" class="form-control hide-print" >
                <option value="" selected >~ዞባ ምረፅ~</option>
                <!-- <option value="0" 
                    <?php if($zoneCode == '0'): ?>
                        <?php echo e('selected'); ?>

                    <?php endif; ?> 
                    >ኩሎም</option> -->
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
    <?php if(!isset($hide_woreda) && (array_search(Auth::user()->usertype, ['admin', 'zone','zoneadmin']) !== false || isset($show_woreda))): ?>
        <div class="col-md-2 col-sm-4 col-xs-4">
            <select name="woreda" id="woreda_filter" class="form-control hide-print">
                <option value="" selected >~ወረዳ ምረፅ~</option>
                <?php $__currentLoopData = $filter['woreda_l']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                    <option value="<?php echo e($key); ?>" 
                    <?php if($filter['woreda'] && $filter['woreda']->woredacode == $key): ?>
                        <?php echo e('selected'); ?>

                    <?php endif; ?> 
                    ><?php echo e($value); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            </select>
        </div>
    <?php endif; ?>
    <?php if(!isset($hide_tabia)): ?>
    <div class="col-md-2 col-sm-4 col-xs-4">
        <select name="tabia" id="tabia_filter" class="form-control hide-print" >
            <option value="" selected >~ጣብያ ምረፅ~</option>
            <?php $__currentLoopData = $filter['tabia_l']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                <option value="<?php echo e($key); ?>" 
                <?php if($filter['tabia'] && $filter['tabia']->tabiaCode == $key): ?>
                    <?php echo e('selected'); ?>

                <?php endif; ?> 
                ><?php echo e($value); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
        </select>
    </div>
    <?php endif; ?>
    <?php if(!isset($hide_widabe)): ?>
    <div class="col-md-2 col-sm-4 col-xs-4">
        <select name="widabe" id="widabe_filter" class="form-control hide-print" >
            <option value="" selected >~መሰረታዊ ውዳበ ምረፅ~</option>
            <?php $__currentLoopData = $filter['widabe_l']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                <option value="<?php echo e($key); ?>" 
                <?php if($filter['widabe'] && $filter['widabe']->widabeCode == $key): ?>
                    <?php echo e('selected'); ?>

                <?php endif; ?> 
                ><?php echo e($value); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
        </select>
    </div>
    <?php endif; ?>
    <?php if(!isset($hide_wahio)): ?>
        <div class="col-md-2 col-sm-4 col-xs-4">
            <select name="wahio" id="wahio_filter" class="form-control hide-print" >
                <option value="" selected >~ዋህዮ ምረፅ~</option>
                <?php $__currentLoopData = $filter['wahio_l']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                    <option value="<?php echo e($key); ?>" 
                    <?php if($filter['wahio'] && $filter['wahio']->id == $key): ?>
                        <?php echo e('selected'); ?>

                    <?php endif; ?> 
                    ><?php echo e($value); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            </select>
        </div>
    <?php endif; ?>
    <?php if(isset($show_actions)): ?>
        <div class="col-md-2 col-sm-4 col-xs-4">
            <select name="general" id="general" class="form-control hide-print">
                <option value="" selected>~ሓፈሻዊ ተግባር~</option>
                <option value="<?php echo e(App\Constant::CREATE); ?>" 
                <?php if($filter['general'] && $filter['general'] == App\Constant::CREATE): ?>
                    <?php echo e('selected'); ?>

                <?php endif; ?> 
                >ምዝገባ</option>
                <option value="<?php echo e(App\Constant::UPDATE); ?>"
                <?php if($filter['general'] && $filter['general'] == App\Constant::UPDATE): ?>
                    <?php echo e('selected'); ?>

                <?php endif; ?> 
                >ምምሕያሽ</option>
                <option value="<?php echo e(App\Constant::DELETE); ?>"
                <?php if($filter['general'] && $filter['general'] == App\Constant::DELETE): ?>
                    <?php echo e('selected'); ?>

                <?php endif; ?> 
                >ምስራዝ</option>
            </select>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-4">
            <select name="specific" id="specific" class="form-control hide-print">
                <option value="" selected>~ፉሉይ ተግባር~</option>
                <?php $__currentLoopData = App\Constant::ACTION_MAP; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                <option value="<?php echo e($key); ?>" 
                <?php if($filter['specific'] && $filter['specific'] == $key): ?>
                    <?php echo e('selected'); ?>

                <?php endif; ?> 
                ><?php echo e($value); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            </select>
        </div>
    <?php endif; ?>
    <?php if(!isset($show_month) && !isset($show_year)): ?>
        <button class="btn btn-success hide-print" type="submit">ኣርእይ</button>
    <?php endif; ?>
    </div>
    <?php if(isset($show_month) || isset($show_year)): ?>
    <div class="row" style="margin-top: 15px;">
    <?php if(isset($show_month)): ?>
     <div class="col-md-2 col-sm-4 col-xs-4">
        <select name="month" id="month" class="form-control hide-print">
            <option value="" selected >~ወርሒ~</option>
            <option value="1">መስከረም</option>
            <option value="2">ጥቅምቲ</option>
            <option value="3">ሕዳር</option>
            <option value="4">ታሕሳስ</option>
            <option value="5">ጥሪ</option>
            <option value="6">ለካቲት</option>
            <option value="7">መጋቢት</option>
            <option value="8">ሚያዝያ</option>
            <option value="9">ግንቦት</option>
            <option value="10">ሰነ</option>
            <option value="11">ሓምለ</option>
            <option value="12">ነሓሰ</option>
        </select>
      </div>
    <?php endif; ?>
    <?php if(isset($show_year)): ?>
    <div class="col-md-2 col-sm-4 col-xs-4">
        <input name="year" id="year" class="form-control" placeholder="ዓመተምህረት"
        <?php if(isset($year)): ?>
            value="<?php echo e($year); ?>"
        <?php endif; ?> 
        >
    </div>
    <?php endif; ?>
    <?php if(isset($paid_or_not)): ?>
        <div class="col-md-2 col-sm-4 col-xs-4">
            <select name="paid" id="paid" class="form-control hide-print">
                <option value="" selected >~ዝኸፈሉ/ዘይኸፈሉ~</option>
                <option value="0">ዘይኸፈሉ</option>
                <option value="1">ዝኸፈሉ</option>
            </select>
        </div>
    <?php endif; ?>
    <?php if(isset($show_rank)): ?>
        <div class="col-md-2 col-sm-4 col-xs-4">
            <select name="rank" id="rank" class="form-control hide-print">
                <option value="" selected>~ደረጃ ስርርዕ~</option>
                <option>ቅድሚት</option>
                <option>ማእኸላይ</option>
                <option>ድሕሪት</option>
            </select>
        </div>
    <?php endif; ?>
    <button class="btn btn-success hide-print" type="submit">ኣርእይ</button>
    </div>
    <?php endif; ?>
</form>