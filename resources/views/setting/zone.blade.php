@extends('layouts.app')

@section('htmlheader_title')
     ከባብያዊ ኣቀማምጣ 
@endsection

@section('contentheader_title')
    ምሕደራ ከባብያዊ ኣቀማምጣ
@endsection

@section('header-extra')
 

@endsection

@section('main-content')
 <!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<script src="//code.jquery.com/jquery-1.12.3.js"></script>
<script src="../js/jquery.dataTables.min.js"></script>
<script
	src="../js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet"
	href="../css/bootstrap.min.css">
<link rel="stylesheet"
	href="../css/dataTables.bootstrap.min.css">
<script
	src="../js/bootstrap.min.js"></script>
</head>
<style>
</style>
<body>
<div>
<div class="pull-right">

 <button class="add-modal btn btn-success" data-info="">
							<span class="glyphicon glyphicon-add"></span> New
						</button>
						</div>
	<div class="container ">
		{{ csrf_field() }}
		<div class="table-responsive text-center">
			<table class="table table-borderless" id="table">
				<thead>
					<tr>
						
						<th class="text-center">ኮድ</th>
						<th class="text-center">ዞባ</th>
						<th class="text-center">Actions</th>
					</tr>
				</thead>
				@foreach($zones as $item)
				<tr class="item{{$item->id}}">
					<td>{{$item->code}}</td>
					<td>{{$item->name}}</td>
					
					<td><button class="edit-modal btn btn-info"
							data-info="{{$item->id}},{{$item->code}},{{$item->name}}">
							<span class="glyphicon glyphicon-edit"></span> Edit
						</button>
						<button class="delete-modal btn btn-danger"
							data-info="{{$item->id}},{{$item->code}},{{$item->name}}">
							<span class="glyphicon glyphicon-trash"></span> Delete
						</button></td>
				</tr>
				@endforeach
			</table>
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
							
							<div class="col-sm-10">
								<input type="hidden" class="form-control" id="iid">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="fid">ኮድ</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="fid">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="fname">ዞባ</label>
							<div class="col-sm-10">
								<input type="name" class="form-control" id="fname">
							</div>
						</div>
						<p class="fname_error error text-center alert alert-danger hidden"></p>
						
						<div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control" name="zone_id">
						  @foreach($zones as $item)
                            <option value="{{$item->code}}">{{$item->name}}</option>
                          
                               @endforeach                  
                            
                          </select>
                        </div>
						
						
						
					</form>
					<div class="deleteContent">
						Are you Sure you want to delete <span class="dname"></span> ? <span
							class="hidden did"></span>
							<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
					</div>
					<div class="modal-footer">
						<button type="button" class="btn actionBtn" data-dismiss="modal">
							<span id="footer_action_button" class='glyphicon'> </span>
						</button>
						<button type="button" class="btn btn-warning" data-dismiss="modal">
							<span class='glyphicon glyphicon-remove'></span> Close
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
							<label class="control-label col-sm-2" for="id">ኮድ</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="fid2" >
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="fname">ዞባ</label>
							<div class="col-sm-10">
								<input type="name" class="form-control" id="fname2">
								
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
							<span class='glyphicon glyphicon-remove'></span> Close
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
  $(document).ready(function() {
    $('#table').DataTable();
} );
  </script>

	<script>
	
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
	$(document).on('click', '.add-modal', function() {
        $('#footer_action_button2').text(" Save");
        $('#footer_action_button2').addClass('glyphicon-check');
        $('#footer_action_button2').removeClass('glyphicon-trash');
        $('.actionBtn').addClass('btn-success');
        $('.actionBtn').removeClass('btn-danger');
        $('.actionBtn').removeClass('delete');
        $('.actionBtn').addClass('add');
        $('.modal-title').text('Add');
        $('.deleteContent').hide();
        $('.form-horizontal').show();
        $('#myModaladd').modal('show');
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
		var idhold= $('.did').text();
		alert(idhold);
        $('.dname').html(stuff[1]);
        $('#myModal').modal('show');
    });

function fillmodalData(details){
    $('#iid').val(details[0]);
    $('#fid').val(details[1]);
    $('#fname').val(details[2]);
    
}

    $('.modal-footer').on('click', '.edit', function() {
        $.ajax({
            type: 'post',
            url: 'editItem',
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
                $('.item' + data.id).replaceWith("<tr class='item" + data.id + "'> <td>" + data.code +
                        "</td><td>" + data.name + "</td><td><button class='edit-modal btn btn-info' data-info='" + data.id+","+data.code+","+data.name+"'><span class='glyphicon glyphicon-edit'></span> Edit</button> <button class='delete-modal btn btn-danger' data-info='" + data.id+","+data.code+"' ><span class='glyphicon glyphicon-trash'></span> Delete</button></td></tr>");

            	 }}
        });
    });
	$('.modal-footer').on('click', '.add', function() {
        $.ajax({
            type: 'post',
            url: 'addItem',
            data: {
                '_token': $('input[name=_token]').val(),				
                'fname': $('#fid2').val(),
                'lname': $('#fname2').val()
              
            },
			
            success: function(data) {
            	}
        });
    });
    $('.modal-footer').on('click', '.delete', function() {
        $.ajax({
            type: 'post',
            url: 'deleteItem',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('.did').text()
            },
			
            success: function(data) {
                $('.item' + $('.did').text()).remove();
            }
        });
    });
</script>

</body>
</html>
@endsection