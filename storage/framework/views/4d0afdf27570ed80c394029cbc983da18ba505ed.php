<?php $__env->startSection('htmlheader_title'); ?>
ስልጠና
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheader_title'); ?>
ምሕደራ ስልጠና
<?php $__env->stopSection(); ?>

<?php $__env->startSection('header-extra'); ?>
<!-- <script src="//code.jquery.com/jquery-1.12.3.js"></script>
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css"> -->
<style type="text/css">
  tr{
    cursor: pointer;
  }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('main-content'); ?>
<form method="get" action="<?php echo e(url('training')); ?>">
        <?php if(Auth::user()->usertype == 'admin'): ?>
            <div class="col-md-2 col-sm-4 col-xs-4">
                <select name="zone" id="zone_filter" class="form-control hide-print" >
                    <option value="" selected disabled>~ዞባ ምረፅ~</option>
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
        <?php if(array_search(Auth::user()->usertype, ['admin', 'zone','zoneadmin']) !== false): ?>
            <div class="col-md-2 col-sm-4 col-xs-4">
                <select name="woreda" id="woreda_filter" class="form-control hide-print" >
                    <option value="" selected disabled>~ወረዳ ምረፅ~</option>
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
        <div class="col-md-2 col-sm-4 col-xs-4">
            <select name="tabia" id="tabia_filter" class="form-control hide-print" >
                <option value="" selected disabled>~ጣብያ ምረፅ~</option>
                <?php $__currentLoopData = $filter['tabia_l']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                    <option value="<?php echo e($key); ?>" 
                    <?php if($filter['tabia'] && $filter['tabia']->tabiaCode == $key): ?>
                        <?php echo e('selected'); ?>

                    <?php endif; ?> 
                    ><?php echo e($value); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            </select>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-4">
            <select name="widabe" id="widabe_filter" class="form-control hide-print" >
                <option value="" selected disabled>~መሰረታዊ ውዳበ ምረፅ~</option>
                <?php $__currentLoopData = $filter['widabe_l']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                    <option value="<?php echo e($key); ?>" 
                    <?php if($filter['widabe'] && $filter['widabe']->widabeCode == $key): ?>
                        <?php echo e('selected'); ?>

                    <?php endif; ?> 
                    ><?php echo e($value); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            </select>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-4">
            <select name="wahio" id="wahio_filter" class="form-control hide-print" >
                <option value="" selected disabled>~ዋህዮ ምረፅ~</option>
                <?php $__currentLoopData = $filter['wahio_l']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                    <option value="<?php echo e($key); ?>" 
                    <?php if($filter['wahio'] && $filter['wahio']->id == $key): ?>
                        <?php echo e('selected'); ?>

                    <?php endif; ?> 
                    ><?php echo e($value); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            </select>
        </div>
        <div class="col-md-5 col-md-offset-3 col-xs-12">
            <select name="show" id="show" class="form-control hide-print" >
                <option value="" selected disabled>~ዓይነት ኣመራርሓ~</option>
                <?php $__currentLoopData = $leader_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                    <option value="<?php echo e($value); ?>" 
                    <?php if($show == $value): ?>
                        <?php echo e('selected'); ?>

                    <?php endif; ?> 
                    ><?php echo e($value); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            </select>
        </div>
        <button class="btn btn-success hide-print" type="submit">ኣርእይ</button>
    </form>
  <div class="row">
        <!-- <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="form-group col-md-12 col-sm-12 col-xs-12">                          
                    <div class="col-md-6 col-sm-6 col-xs-6">    
                        <select name="membertype" id="membertype" class="form-control" >
                            <option value="" selected disabled>~ዓይነት ኣባል ምረፅ~</option>
                            <option>ተራ ኣባል</option>
                            <option>ሰብ ሞያ</option>
                            <option>ጀማሪ ኣመራርሓ</option>
                            <option>ታሕተዋይ ኣመራርሓ</option>                      
                            <option>ማእኸላይ ኣመራርሓ</option>
                            <option>ላዕለዋይ ኣመራርሓ</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">                        
                    </div>
                </div>
            </div> -->  
    </div>
  <div class="box box-primary">
   <div class="box-header with-border">
     <?php echo e(csrf_field()); ?>

     <div class="table-responsive text-center">
      <div class="pull-right" style="margin-top: 5px;">
          <button class="add-modal btn btn-success"
        data-info="">
          <span class="glyphicon glyphicon-tick"></span>ስልጠና መዝግብ
        </button><br><br>
      </div>
      <table class="table table-borderless table-hover" id="table2">
                        <thead>
                            <tr>
                                <th><label><input type="checkbox" id="select_all" value="">ኩሎም ምረፅ</label></th>
                                <th class="text-center">መ.ቑ</th>
                                <th class="text-center">ሽም ኣባል</th>
                                <th class="text-center">መሰረታዊ ውዳበ</th>
                                <th class="text-center">ዋህዮ</th>
                                <th class="text-center">ዓይነት ኣባል</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mytraining): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                            <tr>
                                <td><input style="display: inline;" type="checkbox" class="checkbox" name="check[]" value="<?php echo e($mytraining->hitsuyID); ?>"></td>
                                <td><?php echo e($mytraining->hitsuyID); ?></td>   
                                <td><?php echo e($mytraining->hitsuy->name); ?> <?php echo e($mytraining->hitsuy->fname); ?></td>
                                <td><?php echo e($mwidabedata[$mytraining->assignedWudabe]); ?></td>                          
                                <td><?php echo e($wahiodata[$mytraining->assignedWahio]); ?></td>
                                <td><?php echo e($mytraining->memberType); ?></td>
                           </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                            </tbody>
                        </table>
             </div>
             <?php echo e($data->links()); ?>

          <div id="myModaladd" class="modal fade" role="dialog">
            <div class="modal-dialog">
             <!-- Modal content-->
             <div class="modal-content">
              <div class="modal-header">
               <button type="button" class="close myclose" data-dismiss="modal">&times;</button>
               <h4 class="modal-title"></h4>

             </div>
             <div class="modal-body">
               <form class="form-horizontal" role="form">
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="memeberID">መፍለይ ቑፅሪ ኣባላት  <span class="required">（*）</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="memeberID" required="required" class="form-control col-md-7 col-xs-12" readonly>
                  </div>
                </div> 
                <div id="myAdder">
                </div>  
                <div class="form-group">
                  <label for="trainingLevel" class="control-label col-md-3 col-sm-3 col-xs-">ዝወሰዶ ስልጠና <span class="required">（*）</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="trainingLevel" name="trainingLevel" class="form-control">
                      <option selected disabled>~ዝወሰዶ ስልጠና ምረፅ~</option>
                      <option>ጀማሪ ኣመራርሓ ስልጠና</option>
                      <!-- <option>ታሕተዋይ ኣመራርሓ ስልጠና</option>                       -->
                      <option>ማእኸላይ ኣመራርሓ ስልጠና</option>
                      <option>ላዕለዋይ ኣመራርሓ ስልጠና</option>
                    </select>
                  </div>
                </div>	
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="trainer">ስልጠና ዝሃበ ትካል<span class="required">（*）</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="trainer" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>   	
                 <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="startDate">ስልጠና ዝጀመረሉ ዕለት<span class="required">（*）</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="startDate" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div> 
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="endDate">ስልጠና ዝተወደአሉ ዕለት<span class="required">（*）</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="endDate" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div> 
                					  
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="numDays">ጠቅላላ ናይ ስልጠና መዓልትታት    <span class="required">（*）</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="numDays" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>   		
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="trainingPlace">ናይ ስልጠና ቦታ    <span class="required"></span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="trainingPlace" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>
                <div class="form-group">
                  <label for="trainingType" class="control-label col-md-3 col-sm-3 col-xs-12">ዝተውሃበ ስልጠና <span class="required">（*）</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="trainingType" class="form-control">
                      <option  selected disabled>~ምረፅ~</option>
                      <option>ናይ ውድብ  </option>
                      <option> ናይ መንግስቲ  </option>                            

                    </select>
                  </div>
                </div>	
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">መበገሲ ሓሳብ ዘቕረበ ኣካል     <span class="required"></span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>   		
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ርእይቶ ዝሃበ ኣካል    <span class="required"></span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>   		
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ዘፅደቐ ኣካል <span class="required"></span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>   	
                <label>ቕድሚ ምምዝጋቡ እዞም ዝስዕቡ ከም ዝተማለኡ አረጋግፅ</label>
                <p style="padding: 5px;">
                  <div class="checkbox1">
                  <label>
                  <input type="checkbox" id="zoneDecision" value="1" class="flat" /> ካብ ናይ ኣመራርሓ ስልጠና ወፃኢ ዘሎ መደብ ናይ ዞባ ውሳነ ቐሪቡ እዩ </label>
                  <br /></div>
                  <div class="checkbox1">
                  <label>
                  <input type="checkbox" id="woredaApproved" value="1" class="flat" />  ናይ ጀማሪ ኣመራርሓ ስልጠና ኣብ ወረዳ ኮሚቴ ቀሪቡ ፀዲቑ 
                  እዩ </label></div>
                  <br />
                  <div class="checkbox1">
                  <label>
                  <input type="checkbox" id="zoneApproved" value="1" class="flat" /> ናይ ማእኸላይ ኣመራርሓ  ስልጠና ኣብ ዞባ ኮሚቴ ቀሪቡ ፀዲቑ 
                  እዩ </label></div>
                  <br />
                  <div class="checkbox1">
                  <label>
                  <input type="checkbox" id="officeApproved" value="1" class="flat" /> ናይ ላ/ኣመራርሓ ስልጠና ብቤት ፅሕፈት ህወሓት  ፀዲቑ እዩ 	</label>
                  <br/></div>
                  <div class="checkbox1">
                  <label>
                  <input type="checkbox" id="isDocumented" value="1" class="flat" /> እቲ ውልቀሰብ ነቲ ተገሊፁ ዘሎ ስልጠና ምውሳዱ ዘርእይ ኣድላይ መረዳእታ ቀሪቡ እዩ  </label></div> 							

                  <p class="fname_error error text-center alert alert-danger hidden"></p>



                </form>

                <div class="modal-footer">
                 <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
                 <button type="button" class="btn actionBtn">
                   <span id="footer_action_button2" class='glyphicon'> </span>
                 </button>
                 <button type="button" class="btn btn-warning myclose" data-dismiss="modal">
                   <span class='glyphicon glyphicon-remove'></span> ዕፀው
                 </button>
               </div>
			   
             </div>
			 
           </div>
		   
         </div>
		 
       </div>
	        
	 
   </div>
 </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts-extra'); ?>
<script type="text/javascript" src="js/jquery.calendars.js"></script> 
<script type="text/javascript" src="js/jquery.calendars.plus.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.calendars.picker.css"> 
<script type="text/javascript" src="js/jquery.plugin.min.js"></script> 
<script type="text/javascript" src="js/jquery.calendars.picker.js"></script>
<script type="text/javascript" src="js/jquery.calendars.ethiopian.min.js"></script>
<script>

$(document).ready(function(){

    //select all checkboxes
    $('#select_all').change(function(){
      var status=this.checked;
      $('.checkbox').each(function(){
        this.checked=status;
      });
    });
    //
    $('.checkbox').change(function(){
      if(this.checked==false){
        $('#select_all')[0].checked=false;
      }

      if($('.checkbox:checked').length==$('.checkbox').length){
        $('#select_all')[0].checked=true;
      }
      });

    });   
  $('select[name="membertype"]').on('change', function() {
            var stateID = $(this).val();            
            $('.traineelist').removeClass('hidden');                
               if(stateID) {
                $.ajax({
                    url: 'myform2/ajax/searchtraining/'+stateID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {

                        
                        $('select[name="trainingLevel"]').empty();
                        $('select[name="trainingLevel"]').append('<option value="'+ " " +'" selected disabled>'+ "~ዝወሰዶ ስልጠና ምረፅ~" +'</option>');
                        $.each(data, function(key, value) {
                            $('select[name="trainingLevel"]').append('<option value="'+ value +'">'+ value +'</option>');
                        });

                    },
                  error:function(xhr,err,exception){
                      alert(exception);
                  }
                });
            }else{
                $('select[name="woreda"]').empty();
            }
            $('#table2').DataTable().column(4).search('^'+stateID,true,false).draw();
        });

$(document).ready(function() {
  $('#table2').DataTable({
    <?php echo $__env->make('layouts.partials.lang', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>,
    "order": []
  });
} );

$(document).on('click', '.add-modal', function() {
   if($('.checkbox:checked').length==0){
        toastr.warning("ዝተመረፀ ነገር የለን!! በይዘኦም ይምረፁ");
        setTimeout(function() {toastr.clear()}, 2000);
  }else{
        $('#footer_action_button2').text(" ኣቐምጥ");
        $('#footer_action_button2').addClass('glyphicon-check');
        $('#footer_action_button2').removeClass('glyphicon-trash');
        $('.actionBtn').addClass('btn-success');
        $('.actionBtn').removeClass('btn-danger');
        $('.actionBtn').removeClass('delete');
        $('.actionBtn').addClass('add');
        $('.modal-title').text('ስልጠና መመዝገቢ ቕጥዒ');
        $('.deleteContent').hide();
        $('.form-horizontal').show();

        var idVals=[];

        $('.checkbox').each(function(){
            if(this.checked){
              var myVal=$(this).val();
              idVals.push(myVal);            
            }
        });

        $('#memeberID').val(JSON.stringify(idVals));
        $('#membertype').val('');
        $('#trainingLevel').val('');
        $('#trainer').val('');
        $('#startDate').val('');
        $('#endDate').val('');
        $('#numDays').val('');
        $('#trainingPlace').val('');
        $('#trainingType').val('');
        $('#zoneDecision').prop("checked", false);
        $('#woredaApproved').prop("checked", false);
        $('#zoneApproved').prop("checked", false);
        $('#officeApproved').prop("checked", false);
        $('#isDocumented').prop("checked", false);       
        $('#myModaladd').modal('show');
  }  
});

$('.modal-footer').on('click', '.add', function() {
  $.ajax({
    type: 'post',
    url: 'training',
    data: {
      '_token': $('input[name=_token]').val(),        
      'memeberID': $('#memeberID').val(),
      'membertype': $('#membertype').val(),      
      'trainingLevel': $('#trainingLevel').val(),
      'trainer': $('#trainer').val(),
      'startDate': $('#startDate').val(),
      'endDate': $('#endDate').val(),
      'numDays': $('#numDays').val(),
      'trainingPlace': $('#trainingPlace').val(),
      'trainingType': $('#trainingType').val(),
      'zoneDecision': ($('#zoneDecision').prop("checked")?1:0),
      'woredaApproved': ($('#woredaApproved').prop("checked")?1:0),
      'zoneApproved': ($('#zoneApproved').prop("checked")?1:0),
      'officeApproved': ($('#officeApproved').prop("checked")?1:0),
      'isDocumented': ($('#isDocumented').prop("checked")?1:0)
    },

    success: function(data) {      
     if(data[0] == true){
          $('#myModaladd').modal('hide');
      }
      else{
          if(Array.isArray(data[2]))
              data[2] = data[2].join('<br>');
      }
      toastr.clear();
      toastr[data[1]](data[2]);

    },
    error:function(xhr,err,exception){
        alert(exception);
    }
  });
});

$(document).on('click', '.delete-modal', function() {
  $('#footer_action_button').text("Delete");
  $('#footer_action_button').removeClass('glyphicon-check');
  $('#footer_action_button').addClass('glyphicon-trash');
  $('.actionBtn').removeClass('btn-success');
  $('.actionBtn').addClass('btn-danger');
  $('.actionBtn').removeClass('edit');
  $('.actionBtn').addClass('delete');
  $('.modal-title').text('Delete');
  $('.deleteContent').show();
  $('.form-horizontal').hide();
  var stuff = $(this).data('info').split(',');


  $('.did').text(stuff[0]);


  $('.dname').html(stuff[1]);
  $('#myModal').modal('show');
});

$(document).on('click', '.edit-modal', function() {
  $('#footer_action_button').text(" Update");
  $('#footer_action_button').addClass('glyphicon-check');
  $('#footer_action_button').removeClass('glyphicon-trash');
  $('.actionBtn').addClass('btn-success');
  $('.actionBtn').removeClass('btn-danger');
  $('.actionBtn').removeClass('delete');
  $('.actionBtn').addClass('edit');
  $('.modal-title').text('Edit');
  $('.deleteContent').hide();
  $('.form-horizontal').show();
  var stuff = $(this).data('info').split(',');
  fillmodalData(stuff)
  $('#myModal').modal('show');
});

function fillmodalData(details){
 $('#fid').val(details[0]);
 $('#fname').val(details[1]);

}

$('.modal-footer').on('click', '.edit', function() {
  $.ajax({
    type: 'post',
    url: 'zoneedit',
    data: {
      '_token': $('input[name=_token]').val(),				
      'id': $("#iid").val(),
      'fname': $('#fid').val(),
      'lname': $('#fname').val()

    },

    success: function(data) {
     if (data.errors){
       $('#myModal').modal('show');
       if(data.errors.fname) {
         $('.fname_error').removeClass('hidden');
         $('.fname_error').text("Code can't be empty !");
       }
       if(data.errors.lname) {
         $('.lname_error').removeClass('hidden');
         $('.lname_error').text("Name can't  be empty !");
       }


     }
     else {

       $('.error').addClass('hidden');
       $('.item' + data.zoneCode).replaceWith("<tr class='item" + data.zoneCode + "'> <td>" + data.zoneCode +
        "</td><td>" + data.zoneName + "</td><td><button class='edit-modal btn btn-info' data-info='" + data.zoneCode+","+data.zoneName+"'><span class='glyphicon glyphicon-edit'></span> Edit</button> <button class='delete-modal btn btn-danger' data-info='" + data.zoneCode+","+data.zoneName+"' ><span class='glyphicon glyphicon-trash'></span> Delete</button></td></tr>");

     }}
   });
});

$('.modal-footer').on('click', '.delete', function() {
  $.ajax({
    type: 'post',
    url: 'zonedelete',
    data: {
      '_token': $('input[name=_token]').val(),
      'id': $('.did').text()

    },

    success: function(data) {

     $('.item' + $('.did').text()).remove();


   }
 });
});
$(document).on('click', 'tbody tr', function() {
  var checkBox = $($(this).find('input')[0])
  checkBox.click();
});
$('tr').on('click', 'input[type="checkbox"]', function(e){
  e.stopPropagation();
});
$('#startDate').calendarsPicker({calendar: $.calendars.instance('ethiopian')});
$('#endDate').calendarsPicker({calendar: $.calendars.instance('ethiopian')});
</script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css"></style>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>