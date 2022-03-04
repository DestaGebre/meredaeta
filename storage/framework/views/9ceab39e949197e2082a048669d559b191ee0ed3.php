<?php $__env->startSection('htmlheader_title'); ?>
     ጣብያ 
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheader_title'); ?>
    ጣብያ
<?php $__env->stopSection(); ?>

<?php $__env->startSection('header-extra'); ?>




<?php $__env->stopSection(); ?>
<?php $__env->startSection('main-content'); ?>
<div>
<div class="box box-primary">
    <div class="box-header with-border">
        <?php
       $show_zone = $show_woreda = $hide_tabia = $hide_widabe = $hide_wahio = true;
    ?>
    <?php echo $__env->make('layouts.partials.filter_html', ['address' => 'tabia'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <div class="" style="height: 50px;">
        <button class="pull-right add-modal btn btn-success" data-info=""><span class="glyphicon glyphicon-plus"></span> ሓዱሽ መዝግብ</button>
    </div>

	<div class="">
		<?php echo e(csrf_field()); ?>

		<div class="table-responsive text-center">
			<table class="table table-borderless" id="table">
				<thead>
					<tr>	
                      <th class="text-center">ጣብያ ኮድ</th>
                      <th class="text-center">ዝርከበሉ ዞባ</th>
                      <th class="text-center">ዝርከበሉ ወረዳ</th>
                      <th class="text-center">ሽም ጣብያ</th>
                      <th class="text-center">ዓይነት ጣብያ</th>             
                      <th class="text-center">ተግባር</th>
                  </tr>
                </thead>
				<tbody	id="products-list" name="products-list"> 				
				<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tabia): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>					
				<tr class="item<?php echo e($tabia->tabiaCode); ?>" >
                    <td><?php echo e($tabia->tabiaCode); ?></td>
                    <td><?php echo e($tabia->tabiatat->zonat->zoneName); ?></td>
				    <td><?php echo e($tabia->tabiatat->name); ?></td>
					<td><?php echo e($tabia->tabiaName); ?></td>
					<td><?php echo e($tabia->isUrban); ?></td>					
					<td><button class="edit-modal btn btn-info" data-info="<?php echo e($tabia->tabiatat->woredacode); ?>,<?php echo e($tabia->tabiaName); ?>,<?php echo e($tabia->tabiaCode); ?>,<?php echo e($tabia->isUrban); ?>,<?php echo e($tabia->tabiatat->zonat->zoneCode); ?>">
							<span class="glyphicon glyphicon-edit"></span> ኣስተኻኽል
						</button>
						<button class="delete-modal btn btn-danger" data-info="<?php echo e($tabia->tabiaCode); ?>,<?php echo e($tabia->tabiaName); ?>,<?php echo e($tabia->tabiaCode); ?>,<?php echo e($tabia->isUrban); ?>">
							<span class="glyphicon glyphicon-trash"></span> ሰርዝ
						</button></td>
				</tr>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
				</tbody>
	
				
			</table>
		</div>
	</div>
    </div>
    </div>
	
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>

                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3"> ዓይነት ጣብያ*: </label>
                            ከተማ: <input type="radio" class="flat" name="urban" id="ketema1" checked="" value="ከተማ" />
                            ገጠር:<input type="radio" class="flat" name="urban" id="geter1" value="ገጠር"  required />                      
                    </div>  
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="state1"> ሽም ዞባ <span class="required"></span>
                    </label>
                 <div class="col-md-6 col-sm-6 col-xs-6">   
                <select name="state" id="state1" class="form-control" >
                    
                    <?php $__currentLoopData = $zobadatas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                        <option value="<?php echo e($key); ?>"><?php echo e($value); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                </select>
                </div>
            </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-2" for="city1">ዝርከበሉ ወረዳ:<span class="text-danger">*</span></label>
                    <div class="col-sm-3">

                         <select class="form-control" name="city"  id ="city1" >
                         </select>
                    </div>  
                </div>
                
                <!-- <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3" for="tabiaCode"> ጣብያ ኮድ <span class="required"></span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                      <input type="text" id="tabiaCode" name="tabiaCode" required="required" class="form-control col-md-6 col-xs-6">
                    </div>
                </div>  -->
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3" for="tabiaName"> ሽም ጣብያ <span class="required"></span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                      <input type="text" id="tabiaName" name="tabiaName" required="required" class="form-control col-md-6 col-xs-6">
                    </div>
                </div>                  
                        <p class="fname_error error text-center alert alert-danger hidden"></p>
                                
                                            
                    
                    </form>
                    <div class="deleteContent">
                        ብትክክል ክጠፍአ ይድለ ድዩ <span class="dname"></span> ? <span
                            class="hidden did"></span>
                            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn actionBtn" >
                            <span id="footer_action_button" class='glyphicon'> </span>
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> ዕፀው
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<div id="myModaladd" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"></h4>

				</div>
				<div class="modal-body">
				  <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3"> ዓይነት ጣብያ*: </label>
                            ከተማ: <input type="radio" class="flat" name="urban22" id="ketema" checked="" value="ከተማ" />
                            ገጠር:<input type="radio" class="flat" name="urban22" id="geter" value="ገጠር"  required />                      
                    </div>						 	
				
     
      <div class="panel-body">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="state"> ሽም ዞባ <span class="required"></span>
					</label>
                 <div class="col-md-6 col-sm-6 col-xs-6">   
                <select name="state" id="state" class="form-control" >
                    <option value="" selected Disabled>~ዞባ ምረፅ~</option>
                    <?php $__currentLoopData = $zobadatas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                        <option value="<?php echo e($key); ?>"><?php echo e($value); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                </select>
                </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-3" for="city"> ሽም ወረዳ <span class="required"></span>
					</label>
                <div class="col-md-6 col-sm-6 col-xs-6">    
                <select name="city" id="city" class="form-control" >                    
                    <option value="" selected Disabled>~ወረዳ ምረፅ~</option>
                </select>
                </div>
            </div>
      </div>
                <!-- <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3" for="tabiaCodeadd"> ጣብያ ኮድ <span class="required"></span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                      <input type="text" id="tabiaCodeadd" name="tabiaCodeadd" required="required" class="form-control col-md-6 col-xs-6">
                    </div>
                </div>  -->
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3" for="tabiaNameadd"> ሽም ጣብያ <span class="required"></span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                      <input type="text" id="tabiaNameadd" name="tabiaNameadd" required="required" class="form-control col-md-6 col-xs-6">
                    </div>
                </div>   
                                 
                
                        <p class="fname_error error text-center alert alert-danger hidden"></p>
                                
                                            
                    
                    </form>
			    </div>
				
                 	
					
					<div class="modal-footer">
					<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
						<button type="button" class="btn actionBtn" >
							<span id="footer_action_button2" class='glyphicon'> </span>
						</button>
						<button type="button" class="btn btn-warning" data-dismiss="modal">
							<span class='glyphicon glyphicon-remove'></span> ዕፀው
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>
	<?php $__env->startSection('scripts-extra'); ?>
    <?php echo $__env->make('layouts.partials.filter_js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<script>
	$(document).ready(function() {
        $('#table').DataTable({
            <?php echo $__env->make("layouts.partials.lang", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>,
            "order": []
        });
    });
    var row,stuff,update=false;
    $(document).on('click', '.edit-modal', function() {
        $('#footer_action_button').text("ኣስተኻኽል");
        $('#footer_action_button').addClass('glyphicon-check');
        $('#footer_action_button').removeClass('glyphicon-trash');
        $('.actionBtn').addClass('btn-success');
        $('.actionBtn').removeClass('btn-danger');
        $('.actionBtn').removeClass('delete');
        $('.actionBtn').removeClass('add');
        $('.actionBtn').addClass('edit');
        $('.modal-title').text('ኣስተኻኽል');
        $('.deleteContent').hide();
        $('.form-horizontal').show();
        row = $($($(this).parent()).parent()).children();
        stuff = [$(row[0]).html(),$(row[1]).html(),$(row[2]).html(),$(row[3]).html(),$(row[4]).html()];
        update=true;
        fillmodalData(stuff);
    });
	$(document).on('click', '.add-modal', function() {
        $('#footer_action_button2').text("ኣቀምጥ");
        $('#footer_action_button2').addClass('glyphicon-check');
        $('#footer_action_button2').removeClass('glyphicon-trash');
        $('.actionBtn').addClass('btn-success');
        $('.actionBtn').removeClass('btn-danger');
        $('.actionBtn').removeClass('delete');
        $('.actionBtn').removeClass('edit');
        $('.actionBtn').addClass('add');
        $('.modal-title').text('ኣቀምጥ');
        $('.deleteContent').hide();
        $('.form-horizontal').show();
        $('#myModaladd').modal('show');
		
    });
    $(document).on('click', '.delete-modal', function() {
        $('#footer_action_button').text("ሰርዝ");
        $('#footer_action_button').removeClass('glyphicon-check');
        $('#footer_action_button').addClass('glyphicon-trash');
        $('.actionBtn').removeClass('btn-success');
        $('.actionBtn').addClass('btn-danger');
        $('.actionBtn').removeClass('edit');
        $('.actionBtn').removeClass('add');
        $('.actionBtn').addClass('delete');
        $('.modal-title').text('ሰርዝ');
        $('.deleteContent').show();
        $('.form-horizontal').hide();
        row = $($($(this).parent()).parent()).children();
        
         
        $('.did').text($(row[0]).html());
		
        // $('.dname').html(stuff[1]);
        $('#myModal').modal('show');
    });
function setIt(id,value){
    $('#'+id+' option').each(function(){
     if($(this).html() == value){
        $(this).prop('selected',true);
     }
    });
}
function fillmodalData(details){
    setIt('state1',details[1]);
    $('#state1').change();
    $('#tabiaName').val(details[3]);
    // $('#tabiaCode').val(details[2]);
    (details[4]=='ከተማ') ? ($('#ketema1').prop('checked',true)) : ($('#geter1').prop('checked',true));
    
}

    $('.modal-footer').on('click', '.edit', function() {
        $.ajax({
            type: 'post',
            url: 'editTabia',
            data: {
                '_token': $('input[name=_token]').val(),
                'wcode': $("#city1").val(),
                'tname': $('#tabiaName').val(),
                'tcode': stuff[0],
                'urban': $('input[name=urban]:checked').val()
               
              
            },
			
            success: function(data) {
                if(data[0] == true){
                    $(row[1]).html($('#state1 option:selected').html());
                    $(row[2]).html($('#city1 option:selected').html());
                    $(row[3]).html($('#tabiaName').val());
                    $(row[4]).html($('input[name=urban]:checked').val());
                    $('#state1').prop('selectedIndex',0);
                    $('#city1').prop('selectedIndex',0);
                    $('#tabiaName').val('');
                    $('#myModal').modal('hide');
                }
                else{
                      if(Array.isArray(data[2]))
                          data[2] = data[2].join('<br>');
                }
                toastr.clear();
                toastr[data[1]](data[2]);
            }
        });
    });
	$('.modal-footer').on('click', '.add', function() {
        $.ajax({
            type: 'post',
            url: 'addTabia',
			
            data: {
                '_token': $('input[name=_token]').val(),				
                'wcode': $('#city').val(),
                'tname': $('#tabiaNameadd').val(),
				'tcode': $('#tabiaCodeadd').val(),
				'urban': $('input[name=urban22]:checked').val()		
              
            },
			
			
            success: function(data) {
			     if(data[0] == true){
                    var n_row = '<tr>'+
                    '<td>'+data[3]+'</td>'+
                    '<td>'+$('#state option:selected').html()+'</td>'+
                    '<td>'+$('#city option:selected').html()+'</td>'+
                    '<td>'+$('#tabiaNameadd').val()+'</td>'+
                    '<td>'+$('input[name=urban22]:checked').val()       +'</td>'+
                    '<td>'+
                    '<button class="edit-modal btn btn-info"><span class="glyphicon glyphicon-edit"></span> ኣስተኻኽል</button>'+
                    ' <button class="delete-modal btn btn-danger"><span class="glyphicon glyphicon-trash"></span> ሰርዝ</button>'+
                    '</td>'+
                    '</tr>';
                    $($('tbody')[0]).append(n_row);
                    $('#state').prop('selectedIndex', 0);
                    $('#city').prop('selectedIndex', 0);
                    $('#tabiaNameadd').val('');
                    $('#myModaladd').modal('hide');
                 }
                 else{
                    if(Array.isArray(data[2]))
                        data[2] = data[2].join('<br>');
                  }
                  toastr.clear();
                  toastr[data[1]](data[2]);
            }
        });
    });

    $('.modal-footer').on('click', '.delete', function() {
        $.ajax({
            type: 'post',
            url: 'deleteTabia',
            data: {
                '_token': $('input[name=_token]').val(),
                'code': $('.did').text()
            },
			
            success: function(data) {
                if(data[0] == true){
                    $('#myModal').modal('hide');
                    toastr.clear();
                    toastr['warning'](data[1]);
                    setTimeout(function() {row.remove();}, 1000);
                } 
            }
        });
    });

     $('select[name="state"]').on('change', function() {
            var stateID = $(this).val();             
        

               if(stateID) {
                $.ajax({
                    url: 'myform/ajax/'+stateID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {

                        $('select[name="city"]').empty();
                        $('select[name="city"]').append('<option value="'+ " " +'" selected disabled>'+ "~ወረዳ ምረፅ~" +'</option>');
                        $.each(data, function(key, value) {
                            $('select[name="city"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                        if(update){
                            setIt('city1',stuff[2]);
                            $('#city1').change();
                            $('#myModal').modal('show');
                            update = false;
                        }

                    }
                });
            }else{
                $('select[name="city"]').empty();
            }
        });
</script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css"></style>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>