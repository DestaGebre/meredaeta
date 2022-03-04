@extends('layouts.app')

@section('htmlheader_title')
     ምሕደራ ዓይነታት ስልጠና
@endsection

@section('contentheader_title')
 ምሕደራ ዓይነታት ስልጠና
@endsection

@section('header-extra')


@endsection
@section('main-content')

<div class="box box-primary">
    <div class="box-header with-border">
<div class="" style="height: 50px;">
    <button class="pull-right add-modal btn btn-success" data-info=""><span class="glyphicon glyphicon-plus"></span> ሓዱሽ መዝግብ</button>
</div>
	<div class="">
		{{ csrf_field() }}
		<div class="table-responsive text-center">
			<table class="table table-borderless" id="table2">
				<thead>
					<tr>
						
						<th class="text-center">ዓይነት ስልጠና</th>
						<th class="text-center">ስልጠና ዝወስድ ዓይነት ኣባል</th>
						<th class="text-center">ስልጠና ዝውድኦ ግዘ</th>
						<th class="text-center">ዝውድኣሉ ዕለት</th>
					</tr>
				</thead>
				<tbody>
		          @foreach ($data as $mytraining)
		          <tr>
		            <td>{{ $mytraining->trainingname }}</td>  
		            <td>{{ $mytraining->trainee }}</td>                          
		            <td>{{ $mytraining->traininglength }}</td>		            
		            <td>{{ $mytraining->deadline }}</td>            		            
		          </tr>
		          @endforeach            
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
							<label class="control-label col-sm-2" for="trainingname1">ዓይነት ስልጠና</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="trainingname1" >
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="trainee1">ዓይነት ኣባል</label>
							<div class="col-sm-10">
								<input type="name" class="form-control" id="trainee1">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="traininglength1">ስልጠና ዝውድኦ ግዘ</label>
							<div class="col-sm-10">
								<input type="name" class="form-control" id="traininglength1">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="deadline1">ዝውድኣሉ ዕለት</label>
							<div class="col-sm-10">
								<input type="name" class="form-control" id="deadline1">
							</div>
						</div>
						<p class="fname_error error text-center alert alert-danger hidden"></p>
						
						<div class="col-md-6 col-sm-6 col-xs-12">
                         
                        </div>
						
						
						
					</form>
					<div class="deleteContent">
						ብትክክል ክጠፍአ ይድለ ድዩ <span class="dname"></span> ? <span
							class="hidden yid"></span>
							<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
					</div>
					<div class="modal-footer">
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
							<label class="control-label col-sm-2" for="trainingname">ዓይነት ስልጠና</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="trainingname" >
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="trainee">ዓይነት ኣባል</label>
							<div class="col-sm-10">
								<input type="name" class="form-control" id="trainee">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="traininglength">ስልጠና ዝውድኦ ግዘ</label>
							<div class="col-sm-10">
								<input type="name" class="form-control" id="traininglength">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="deadline">ዝውድኣሉ ዕለት</label>
							<div class="col-sm-10">
								<input type="name" class="form-control" id="deadline">
							</div>
						</div>
						<p class="fname_error error text-center alert alert-danger hidden"></p>
								
											
					
					</form>
					
					<div class="modal-footer">
					<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
						<button type="button" class="btn actionBtn" data-dismiss="modal">
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
@endsection

	@section('scripts-extra')
	<script>
 
 
	 $(document).ready(function() {
      $('#table2').DataTable({
        @include('layouts.partials.lang'),
        "order": []
      });
        } );
    $(document).on('click', '.edit-modal', function() {
        $('#footer_action_button').text(" ኣስተኻኽል");
        $('#footer_action_button').addClass('glyphicon-check');
        $('#footer_action_button').removeClass('glyphicon-trash');
        $('.actionBtn').addClass('btn-success');
        $('.actionBtn').removeClass('btn-danger');
        $('.actionBtn').removeClass('delete');
        $('.actionBtn').addClass('edit');
        $('.modal-title').text('ኣስተኻኽል');
        $('.deleteContent').hide();
        $('.form-horizontal').show();
        var stuff = $(this).data('info').split(',');
        fillmodalData(stuff)
        $('#myModal').modal('show');
    });
	$(document).on('click', '.add-modal', function() {
        $('#footer_action_button2').text("ኣቀምጥ");
        $('#footer_action_button2').addClass('glyphicon-check');
        $('#footer_action_button2').removeClass('glyphicon-trash');
        $('.actionBtn').addClass('btn-success');
        $('.actionBtn').removeClass('btn-danger');
        $('.actionBtn').removeClass('delete');
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
        $('.actionBtn').addClass('delete');
        $('.modal-title').text('ሰርዝ');
        $('.deleteContent').show();
        $('.form-horizontal').hide();
        var stuff = $(this).data('info').split(',');
		
	     
        $('.yid').text(stuff[0]);
		
	
        $('.dname').html(stuff[1]);
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
	$('.modal-footer').on('click', '.add', function() {
        $.ajax({
            type: 'post',
            url: 'trainingsetting',
            data: {
                '_token': $('input[name=_token]').val(),				
                'trainingname': $('#trainingname').val(),
                'trainee': $('#trainee').val(),
                'traininglength': $('#traininglength').val(),
                'deadline': $('#deadline').val()
              
            },
			
            success: function(data) {      
		       // alert('yes');

		    },
		    error:function(xhr,err,exception){
		        alert(exception);
		    }
        });
    });
    $('.modal-footer').on('click', '.delete', function() {
        $.ajax({
            type: 'post',
            url: 'zonedelete',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('.yid').text()
				
            },
			
            success: function(data) {
              
				 $('.item' + $('.yid').text()).remove();
				 
				  
            }
        });
    });
</script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css"></style>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
@endsection

