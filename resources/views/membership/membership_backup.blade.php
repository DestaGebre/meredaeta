
@extends('layouts.app')

@section('htmlheader_title')
ምሕደራ ሕፁይነት
@endsection

@section('contentheader_title')
ምሕደራ ሕፁይነት
@endsection

@section('header-extra')

<link rel="stylesheet" href="css/jquery.dataTables.min.css"></style>
@endsection
@section('main-content')
	<div class="box box-primary">
		<div class="box-header with-border">

			<div class="">
				{{ csrf_field() }}
				<div class="table-responsive text-center">
					<table class="table table-hover" id="table2">
						<thead>
							<tr>
								<th class="text-center">መ.ቑ</th>
								<th class="text-center">ሽም ህፁይ</th>
								<th class="text-center">ፆታ</th>
								<th class="text-center">ዝተመልመለሉ ዕለት</th>
								<th class="text-center">ዝመለመሎ ዋህዮ</th>
								<th class="text-center">ዝተዋፈርሉ ስራሕ</th>
								<th class="text-center">ኩነታት ሕፁይነት</th>
								<th class="text-center">ተግባር</th>
								
							</tr>					
						</thead>
						<tbody>
							@foreach ($data as $mydata)						  
							<tr>
								<td>{{ $mydata->hitsuyID }}</td>	
								<td>{{ $mydata->name }} {{ $mydata->fname }} {{ $mydata->gfname }}</td>                          
								<td>{{ $mydata->gender }}</td>
								<td>{{ $mydata->regDate }}</td>
								<td>{{ $mydata->proposerWahio }}</td>
								<td>{{ $mydata->occupation }}</td>
								<td>{{ $mydata->hitsuy_status }}</td>
								<td><button class="add-modal btn btn-success" data-info="{{ $mydata->hitsuyID }},{{ $mydata->name }} {{ $mydata->fname }} {{ $mydata->gfname }},{{ $mydata->tabiaID }}" title="ኣባልነት ይፅደቕ">
									<span class="fa fa-check-circle"></span>ኣባልነት ይፅደቕ</button>
									@if($mydata->hitsuy_status=='ሕፁይ')
									<button class="edit-modal btn btn-success" data-info="{{ $mydata->hitsuyID }},{{ $mydata->name }} {{ $mydata->fname }} {{ $mydata->gfname }},{{ $mydata->tabiaID }}" title="ይናዋሕ">
									<span class="fa fa-plus-circle"></span>ይናዋሕ</button>
									@endif
									<button class="delete-modal btn btn-warning" data-info="{{ $mydata->hitsuyID }},{{ $mydata->name }} {{ $mydata->fname }} {{ $mydata->gfname }},{{ $mydata->tabiaID }}" title="ይሰረዝ">
									<span class="fa fa-times-circle"></span>ይሰረዝ</button>
								</td>									
						   </tr>
							@endforeach
							</tbody>
					</table>
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
    						<!-- We don't need name but id, b/se we are using ajax post -->
    						<div class="form-group">
    							<div class="col-md-6 col-sm-6 col-xs-12">
    								<input type="hidden" class="form-control" id="hitsuyID">
    							</div>
    						</div>
    						<div class="form-group">
    							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="fullName">ሽም ሕፁይ
    							</label>
    							<div class="col-md-6 col-sm-6 col-xs-12">
    								<input type="text" id="fullName" required="required" class="form-control col-md-7 col-xs-12" readonly>
    							</div>
    						</div> 
    						<div class="form-group">
    							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="membershipDate">ኣባል ዝኾነሉ ዕለት<span class="text-danger">（*）</span>
    							</label>
    							<div class="col-md-6 col-sm-6 col-xs-12">
    								<input type="text" id="membershipDate" required="required" class="form-control col-md-7 col-xs-12">
    							</div>
    						</div> 		 
    						<div class="form-group">
    							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="membershipType">ዓይነት ኣባል:<span class="text-danger">(*)</span></label>
    							<div class="col-md-6 col-sm-6 col-xs-12">
    								<select class="form-control" id="membershipType" required="required">
    									<option selected disabled>~ዓይነት ኣባል ምረፅ~</option>
    									<option value="ተጋዳላይ">ተጋዳላይ</option>
    									<option value="ሲቪል">ሲቪል</option>
    								</select>
    							</div>
    						</div>
    						<div class="form-group">
    							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="grossSalary">ጠቕላላ ደሞዝ
    							</label>
    							<div class="col-md-6 col-sm-6 col-xs-12">
    								<input type="text" id="grossSalary" class="form-control col-md-7 col-xs-12">
    							</div>
    						</div> 
    						<div class="form-group">
    							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="netSalary">ዝተፃረየ ደሞዝ<span class="text-danger">（*）</span>
    							</label>
    							<div class="col-md-6 col-sm-6 col-xs-12">
    								<input type="text" id="netSalary" required="required" class="form-control col-md-7 col-xs-12">
    							</div>
    						</div> 
    						<div class="form-group">
    							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="assignedWudabe">ዝተወደበሉ መሰረታዊ ውዳበ<span class="text-danger">（*）</span>
    							</label>
    							<div class="col-md-6 col-sm-6 col-xs-12">								
    								<select class="form-control" id="assignedWudabe" name="assignedWudabe" required="required">
    										<option selected disabled>~ዝተወደበሉ መሰረታዊ ውዳበ ምረፅ~</option>
    								</select>
    							</div>
    						</div> 
    						<div class="form-group">
    							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="assignedWahio">ዝተወደበሉ ዋህዮ<span class="text-danger">（*）</span>
    							</label>
    							<div class="col-md-6 col-sm-6 col-xs-12">								
    								<select class="form-control" id="assignedWahio" name="assignedWahio" required="required">
    										<option selected disabled>~ዝተወደበሉ ዋህዮ ምረፅ~</option>
    								</select>
    							</div>
    						</div> 						
    						<div class="form-group">
    							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="assignedAssoc">ዝተወደበሉ ማሕበር:</label>
    							<div class="col-sm-6">
    								<select class="form-control" id="assignedAssoc" >
    									<option selected disabled>~ዝተወደበሉ ማሕበር ምረፅ~</option>
    									<option value="ደቂ ኣንስትዮ">ደቂ ኣንስትዮ</option>
    									<option value="መናእሰይ">መናእሰይ</option>
    								</select>
    							</div>
    						</div>
    						<div class="form-group">
    							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="fileNumber">ቁፅሪ ሰነድ
    							</label>
    							<div class="col-md-6 col-sm-6 col-xs-12">
    								<input type="text" id="fileNumber" class="form-control col-md-7 col-xs-12">
    							</div>
    						</div> 						  
    						<div class="form-group">&nbsp &nbsp &nbsp &nbsp &nbsp
    							<label>&nbsp &nbsp ቅድሚ ኣባልነት ምፅዳቕ እዞም ቅድመ ኩነታት የረጋግፁ</label>
    							<div class="checkbox">
    								<label>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
    									<input type="checkbox" id="isReported" value="1">ናይ መልማላይ ወይድማ ዋህዮ ኣቦ ወንበር ርእይቶ ዝሓዘ ፀብፃብ ምስ ናይቲ ውልቀሰብ ርኢቶ <br>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbspናብ መ/ውዲበ ኮሚቴ ቐሪቡ እዩ
    								</label>
    							</div>
    							<div class="checkbox">&nbsp &nbsp
    								<label>&nbsp &nbsp &nbsp &nbsp &nbsp
    									<input type="checkbox" id="hasRequested" value="1">ሕፁይ ናብ ኣባልነት ክሰጋገር ዝሓተተ ምዃኑ ዝገልፅ ዯብዲበ ቐሪቡ እዩ
    								</label>
    							</div>
    							<div class="checkbox">&nbsp &nbsp &nbsp &nbsp &nbsp
    								<label>&nbsp &nbsp
    									<input type="checkbox" id="isApproved" value="1">ናብ ኣባልነት ይሰጋገር ዝብል ናይ ዋህዮ ውሳነ ኣብ ናይ መሰረታዊ ውዲበ ኮሚቴ ፀዱቑ እዩ
    								</label>
    							</div>
    							<p class="fname_error error text-center alert alert-danger hidden"></p>
    						</div>
    						<div class="modal-footer">
    							<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
    							<button type="button" class="btn actionBtn" data-dismiss="modal">
    								<span id="footer_action_button2" class='glyphicon'> </span>
    							</button>
    							<button type="button" class="btn btn-warning" data-dismiss="modal">
    								<span class='glyphicon glyphicon-remove'></span> ዕፀው
    							</button>
    						</div>
    					</form>
    				</div>
    			</div>
    		</div>
    	</div> <!-- Modal Add -->

    	<div id="myModalEdit" class="modal fade" role="dialog">
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
    							<div class="col-md-6 col-sm-6 col-xs-12">
    								<input type="hidden" class="form-control" id="hitsuyID1">
    							</div>
    						</div>
    						<div class="form-group">
    							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="fullName">ሽም ሕፁይ
    							</label>
    							<div class="col-md-6 col-sm-6 col-xs-12">
    								<input type="text" id="fullName1" required="required" class="form-control col-md-7 col-xs-12" readonly>
    							</div>
    						</div> 
    						<div class="form-group">
    							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="postponedDate">ዝተናወሐሉ ዕለት<span class="text-danger">（*）</span>
    							</label>
    							<div class="col-md-6 col-sm-6 col-xs-12">
    								<input type="text" id="postponedDate" required="required" class="form-control col-md-7 col-xs-12">
    							</div>
    						</div>
    						<p class="fname_error error text-center alert alert-danger hidden"></p>
    					</form>
    					<div class="modal-footer">
    					<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
    						<button type="button" class="btn actionBtn" data-dismiss="modal">
    							<span id="footer_action_button" class='glyphicon'> </span>
    						</button>
    						<button type="button" class="btn btn-warning" data-dismiss="modal">
    							<span class='glyphicon glyphicon-remove'></span> ዕፀው
    						</button>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div><!-- Modal Edit -->
    	<div id="myModalDelete" class="modal fade" role="dialog">
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
    							<div class="col-md-6 col-sm-6 col-xs-12">
    								<input type="hidden" class="form-control" id="hitsuyID2">
    							</div>
    						</div>
    						<div class="form-group">
    							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="fullName">ሽም ሕፁይ
    							</label>
    							<div class="col-md-6 col-sm-6 col-xs-12">
    								<input type="text" id="fullName2" required="required" class="form-control col-md-7 col-xs-12" readonly>
    							</div>
    						</div> 
    						<div class="form-group">
    							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="rejectionReason">ዝተሰረዘሉ ምኽንያት<span class="text-danger">（*）</span>
    							</label>
    							<div class="col-md-6 col-sm-6 col-xs-12">
    								<input type="text" id="rejectionReason" required="required" class="form-control col-md-7 col-xs-12">
    							</div>
    						</div>
    						<div class="form-group">
    							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="rejectionDate">ዝተሰረዘሉ ዕለት<span class="text-danger">（*）</span>
    							</label>
    							<div class="col-md-6 col-sm-6 col-xs-12">
    								<input type="text" id="rejectionDate" required="required" class="form-control col-md-7 col-xs-12">
    							</div>
    						</div>
    						
    						<p class="fname_error error text-center alert alert-danger hidden"></p>
    					</form>
    					
    					<div class="modal-footer">
    					<input type="hidden" name="_token" value="{{{ csrf_token() }}}">
    						<button type="button" class="btn actionBtn1" data-dismiss="modal">
    							<span id="footer_action_button1" class='glyphicon'> </span>
    						</button>
    						<button type="button" class="btn btn-warning" data-dismiss="modal">
    							<span class='glyphicon glyphicon-remove'></span> ዕፀው
    						</button>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div><!-- Modal Delete -->
    </div>
@endsection

@section('scripts-extra')
    <script type="text/javascript" src="js/jquery.calendars.js"></script> 
    <script type="text/javascript" src="js/jquery.calendars.plus.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/jquery.calendars.picker.css"> 
    <script type="text/javascript" src="js/jquery.plugin.min.js"></script> 
    <script type="text/javascript" src="js/jquery.calendars.picker.js"></script>
    <script type="text/javascript" src="js/jquery.calendars.ethiopian.min.js"></script>

    <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
	<script>
    var selectedRow;
 
 
	 $(document).ready(function() {
      $('#table2').DataTable({
        @include('layouts.partials.lang'),
        "order": []
      });
     });
    //
	$(document).on('click', '.add-modal', function() {
        $('#membershipDate').val("");
        $('#membershipType').val("");
        $('#grossSalary').val("");
        $('#netSalary').val("");
        $('#assignedWudabe').val("");
        $('#assignedWahio').val("");
        $('#assignedAssoc').val("");
        $('#fileNumber').val("");
        $('#isReported').prop("checked",false);
        $('#hasRequested').prop("checked",false);
        $('#isApproved').prop("checked",false);

        selectedRow = $($(this).parent().parent()[0]);
        $('#footer_action_button2').text(" ኣፅድቕ");
        $('#footer_action_button2').addClass('glyphicon-check');
        $('#footer_action_button2').removeClass('glyphicon-trash');
        $('.actionBtn').addClass('btn-success');
        $('.actionBtn').removeClass('btn-danger');
        $('.actionBtn').removeClass('delete');
        $('.actionBtn').addClass('add');
        $('.modal-title').text('ምፅዳቕ ኣባልነት');
        $('.deleteContent').hide();
        $('.form-horizontal').show();
        var stuff = $(this).data('info').split(',');
        fillmodalData(stuff)
        $('#myModaladd').modal('show');
    });

    function fillmodalData(details){
	     $('#hitsuyID').val(details[0]);
	    $('#fullName').val(details[1]);
	    $.ajax({
                    url: 'myform2/ajax/wahio/'+details[2],
                    type: "GET",
                    dataType: "json",
                    success:function(data) {

                        
                        $('select[name="assignedWudabe"]').empty();
						$('select[name="assignedWudabe"]').append('<option value="'+ " " +'" selected disabled >'+ "~መሰረታዊ ውዳበ ምረፅ~" +'</option>');
                        $.each(data, function(key, value) {
                            $('select[name="assignedWudabe"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });

                    }
                });
	    
	}
	$('select[name="assignedWudabe"]').on('change', function() {
            var stateID = $(this).val();
                        	
               if(stateID) {
                $.ajax({
                    url: 'myform2/ajax/wahio/meseretawi/'+stateID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {

                        
                        $('select[name="assignedWahio"]').empty();
						$('select[name="assignedWahio"]').append('<option value="'+ " " +'">'+ "~ዝተወደበሉ ዋህዮ ምረፅ~" +'</option>');
                        $.each(data, function(key, value) {
                            $('select[name="assignedWahio"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });

                    },
		            error: function(xhr,errorType,exception){                        
		              alert(exception);                      
		            }
                });
            }else{
                $('select[name="assignedWahio"]').empty();
            }
        });

	$('.modal-footer').on('click', '.add', function() {
        $.ajax({
            type: 'post',
            url: 'membership',
            data: {
                '_token': $('input[name=_token]').val(),				
                'hitsuyID': $('#hitsuyID').val(),
                'membershipDate': $('#membershipDate').val(),
                'membershipType': $('#membershipType').val(),
                'grossSalary': $('#grossSalary').val(),
                'netSalary': $('#netSalary').val(),
                'assignedWudabe': $('#assignedWudabe').val(),
                'assignedWahio': $('#assignedWahio').val(),
                'assignedAssoc': $('#assignedAssoc').val(),                
                'fileNumber': $('#fileNumber').val(),
                'isReported': $('#isReported').val(),
                'hasRequested': $('#hasRequested').val(),
                'isApproved': $('#isApproved').val()
              
            },
			
            success: function(data) {
			      document.getElementById("hitsuyID").value="";
			      document.getElementById("fullName").value="";
                  if(data[0]==true){
                      toastr.info(data[1]);
                      setTimeout(function() {selectedRow.fadeOut(1000, function() {selectedRow.remove();})}, 250);
                  }
            	},

            error: function(xhr,errorType,exception){
            		
            			alert(exception);
                        
            }
        });
    }); 
	$(document).on('click', '.edit-modal', function() {
        selectedRow = $($(this).parent().parent()[0]);
        $('#footer_action_button').text(" ሕፁይነት ይናዋሕ");
        $('#footer_action_button').addClass('glyphicon-check');
        $('#footer_action_button').removeClass('glyphicon-trash');
        $('.actionBtn').addClass('btn-success');
        $('.actionBtn').removeClass('btn-danger');
        $('.actionBtn').removeClass('delete');
        $('.actionBtn').addClass('edit');
        $('.modal-title').text('ሕፁይነት መናውሒ ቕጥዒ');
        $('.deleteContent').hide();
        $('.form-horizontal').show();
        var stuff = $(this).data('info').split(',');
        fillmodalEdit(stuff)
        $('#myModalEdit').modal('show');
    });

     function fillmodalEdit(details){
	     $('#hitsuyID1').val(details[0]);
	    $('#fullName1').val(details[1]);
	    
	}
	
   
    $('.modal-footer').on('click', '.edit', function() {
        $.ajax({
            type: 'post',
            url: 'hitsuypostpone',
            data: {
                '_token': $('input[name=_token]').val(),				
                'hitsuyID': $("#hitsuyID1").val(),
                'postponedDate': $('#postponedDate').val()
              
            },
			
             success: function(data) {
			      document.getElementById("hitsuyID1").value="";
			      document.getElementById("fullName1").value="";
                  if(data[0] == true){
                      toastr.info(data[1]);
                      $(selectedRow.children()[6]).html("ሕፁይነት ተናዊሑ");
                      $($(selectedRow.children()[7]).children()[1]).remove();
                  }
            	},

            error: function(xhr,errorType,exception){
            		
            			alert(exception);
                        
            }
        });
    });
	
    $(document).on('click', '.delete-modal', function() {
        selectedRow = $($(this).parent().parent()[0]);
        $('#footer_action_button1').text("ሕፁይነት ይሰረዝ");
        $('#footer_action_button1').addClass('glyphicon-check');
        $('#footer_action_button1').removeClass('glyphicon-trash');
        $('.actionBtn1').addClass('btn-success');
        $('.actionBtn1').removeClass('btn-danger');
        $('.actionBtn1').removeClass('edit');
        $('.actionBtn1').addClass('delete');
        $('.modal-title').text('ሕፁይነት መሰረዚ ቕጥዒ');
        $('.deleteContent').hide();
        $('.form-horizontal').show();
        var stuff = $(this).data('info').split(',');
        fillmodalDelete(stuff)
        $('#myModalDelete').modal('show');
    });

    function fillmodalDelete(details){
	     $('#hitsuyID2').val(details[0]);
	    $('#fullName2').val(details[1]);
	    
	}
     
    $('.modal-footer').on('click', '.delete', function() {
        $.ajax({
            type: 'post',
            url: 'hitsuyreject',
            data: {
                '_token': $('input[name=_token]').val(),				
                'hitsuyID': $("#hitsuyID2").val(),
                'rejectionReason': $("#rejectionReason").val(),
                'rejectionDate': $('#rejectionDate').val()
				
            },
			
            success: function(data) {
			      document.getElementById("hitsuyID2").value="";
			      document.getElementById("fullName2").value="";
                  if(data[0]==true){
                     toastr.info(data[1]);
                     setTimeout(function() {selectedRow.fadeOut(1000, function() {selectedRow.remove();})}, 250);
                  }
            	},

            error: function(xhr,errorType,exception){
            		
            			alert(exception);
                        
            }
        });
    });
    $('#membershipDate').calendarsPicker({calendar: $.calendars.instance('ethiopian')});
    $('#postponedDate').calendarsPicker({calendar: $.calendars.instance('ethiopian')});
    $('#rejectionDate').calendarsPicker({calendar: $.calendars.instance('ethiopian')});
</script>
@endsection

