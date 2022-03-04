@extends('layouts.app')

@section('htmlheader_title')
    ውህብቶ
@endsection

@section('contentheader_title')
    ምሕደራ መረዳእታ ውህብቶ 
@endsection

@section('header-extra')
@endsection

@section('main-content')
<script src="//code.jquery.com/jquery-1.12.3.js"></script>
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script
    src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet"
    href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet"
    href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
<body>
<div class="box box-primary">
	<div class="box-header with-border">
		<div class="pull-right">
			<button class="add-modal btn btn-success"
				data-info="">
				<span class="glyphicon glyphicon-add"></span> New
			</button>
		</div>
		<div class="container ">
			{{ csrf_field() }}
			<div class="table-responsive text-center">
				<table class="table table-borderless" id="table2">
				<thead>
					<tr>
						<th>ተቁ</th>
						<th>ዓይነት ውህብቶ</th>
						<th>ዕላማ ውህብቶ</th>
						<th>ውህብቶ</th>
						<th>ግምት ውህብቶ</th>
						<th>ኩነታት ውህብቶ </th>
						<th>ዝተውሃበሉ/ዝወሃበሉ ዕለት</th>
						<th>ወሃቢ</th>
						<th>ኣድራሻ ወሃቢ</th>
						<th class="text-center">Actions</th>
					</tr>
				</thead>
			<tbody	id="products-list" name="products-list">

				@foreach($donation as $item)
				<tr class="item{{$item->id}}" >
					<td>{{$item->id}}</td>
					<td>{{$item->giftType}}</td>
					<td>{{$item->purpose}}</td>
					<td>{{$item->giftName}}</td>
					<td>{{$item->valuation}}</td>
					<td>{{$item->donationDate}}</td>
					<td>{{$item->donor}}</td>
					<td>{{$item->donorAddress}}</td>
					
					<td><button class="edit-modal btn btn-info"
							data-info="{{$item->id}},{{$item->giftType}},{{$item->purpose}},{{$item->giftName}},
							{{$item->valuation}},{{$item->donationDate}},{{$item->donor}},{{$item->donorAddress}}">
							<span class="glyphicon glyphicon-edit"></span> Edit
						</button>
						<button class="delete-modal btn btn-danger"
							ata-info="{{$item->id}},{{$item->giftType}},{{$item->purpose}},{{$item->giftName}},
							{{$item->valuation}},{{$item->donationDate}},{{$item->donor}},{{$item->donorAddress}}">
							<span class="glyphicon glyphicon-trash"></span> Delete
						</button></td>
					</tr>
					@endforeach

					</tbody>
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-">ዓይነት ውህብቶ</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control">
                            <option>ምረፅ</option>
                            <option> ተሽከርከርቲ   </option>
                            <option> ህንፃ    </option>
                            <option> ቀዋሚ ንብረት </option>
							 <option> ሃላቂ ኣቕሓ </option>
                            <option> ጥረ ገንዘብ </option>                         
                          </select>
                        </div>
                      </div>
					  <div class="form-group">
                       
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ዕላማ ውህብቶ<span class="required"></span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div> 
						 <div class="form-group">
                       
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ሽም ውህብቶ<span class="required"></span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>  
					   <div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ግምት ውህብቶ<span class="required"></span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>  
					   <div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ኩነታት ውህብቶ<span class="required"></span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div> 
					  <div class="form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ዝተውሃበሉ/ዝወሃበሉ ዕለት<span class="required"></span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>  
					  <div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ወሃቢ<span class="required"></span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div> 
						<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ኣድራሻ ወሃቢ<span class="required"></span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
						<p class="fname_error error text-center alert alert-danger hidden"></p>
						
						<div class="col-md-6 col-sm-6 col-xs-12">
                         
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-">ዓይነት ውህብቶ</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control">
                            <option>ምረፅ</option>
                            <option> ተሽከርከርቲ   </option>
                            <option> ህንፃ    </option>
                            <option> ቀዋሚ ንብረት </option>
							 <option> ሃላቂ ኣቕሓ </option>
                            <option> ጥረ ገንዘብ </option>                         
                          </select>
                        </div>
                      </div>
					  <div class="form-group">
                       
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ዕላማ ውህብቶ<span class="required"></span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div> 
						 <div class="form-group">
                       
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ሽም ውህብቶ<span class="required"></span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>  
					   <div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ግምት ውህብቶ<span class="required"></span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>  
					   <div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ኩነታት ውህብቶ<span class="required"></span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div> 
					  <div class="form-group"> 
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ዝተውሃበሉ/ዝወሃበሉ ዕለት<span class="required"></span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>  
					  <div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ወሃቢ<span class="required"></span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div> 
						<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ኣድራሻ ወሃቢ<span class="required"></span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
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
	</body>
@endsection

	@section('scripts-extra')
	<script>
 
 
	 $(document).ready(function() {
      $('#table2').DataTable();
        } );
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
            url: 'zoneadd',
            data: {
                '_token': $('input[name=_token]').val(),				
                'fname': $('#fid2').val(),
                'lname': $('#fname2').val()
              
            },
			
            success: function(data) {
			     $('#products-list').append("<tr class='item" + data.zoneCode + "'> <td>" + data.zoneCode +
                        "</td><td>" + data.zoneName + "</td><td><button class='edit-modal btn btn-info' data-info='" + data.zoneCode+","+data.zoneName+"'><span class='glyphicon glyphicon-edit'></span> Edit</button> <button class='delete-modal btn btn-danger' data-info='" + data.zoneCode+","+data.zoneName+"' ><span class='glyphicon glyphicon-trash'></span> Delete</button></td></tr>");
               
			
            	}
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
</script>
<link href="css/bootstrap.min.css" rel="stylesheet">   
<script src="js/jquery.min.js"></script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css"></style>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
@endsection
