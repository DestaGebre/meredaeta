@extends('layouts.app')

@section('htmlheader_title')
     ወረዳ 
@endsection

@section('contentheader_title')
    ወረዳ
@endsection

@section('header-extra')


<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<script src="//code.jquery.com/jquery-1.12.3.js"></script>
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script
	src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet"
	href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet"
	href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
<script
	src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>


@endsection
@section('main-content')

<body>
<div>
<div class="pull-right">

 <button class="add-modal btn btn-success"
							data-info="">
							<span class="glyphicon glyphicon-add"></span> ሓዱሽ መዝግብ
						</button>
						</div>
	<div class="container ">
		{{ csrf_field() }}
		<div class="table-responsive text-center">
			<table class="table table-borderless" id="table">
				<thead>
					<tr>
						<th class="text-center">ዞባ</th>
						<th class="text-center">ወረዳ ኮድ</th>
						<th class="text-center">ወረዳ </th>
						<th class="text-center">ዓይነት ወረዳ </th>
						<th class="text-center">ተግባር</th>
					</tr>
				</thead>
				
                  <tbody	id="products-list" name="products-list"> 				
				@foreach($data as $woreda)
					
				<tr class="item{{$woreda->id}}" >
				   
					<td> {{$woreda->zonat->zoneName}}</td>
					<td> {{$woreda->woredacode}}</td>
					<td> {{$woreda->name}}</td>
					<td> {{$woreda->isUrban}}</td>
					
					<td><button class="edit-modal btn btn-info"
							data-info="{{$woreda->id}},{{$woreda->zonat->zoneName}},{{$woreda->woredacode}},{{$woreda->name}},{{$woreda->isUrban}},{{$woreda->zoneCode}}">
							<span class="glyphicon glyphicon-edit"></span> ኣስተኻኽል
						</button>
						<button class="delete-modal btn btn-danger"
							data-info="{{$woreda->id}},{{$woreda->zonat->zoneName}},{{$woreda->woredacode}},{{$woreda->name}},{{$woreda->isUrban}}">
							<span class="glyphicon glyphicon-trash"></span> ሰርዝ
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
					
						 <label> 
				 &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbspዓይነት ወረዳ *:</label>
				ገጠር:
				<div class="form-group">
				<input type="radio" class="flat" id ="geter" name="urban"  value="ገጠር"  /> ከተማ:
				<input type="radio" class="flat" id ="ketema" name="urban"  value="ከተማ" /> 
				
				
				</div>
	            <br>
		
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-2" for="postion">ዝርከበሉ ዞባ:<span class="text-danger">*</span></label>
					<div class="col-sm-3">

						 <select class="form-control"  id ="zoneCodeselect" >
						   
						   @foreach($zobadata as $item)
							  <option value="{{$item->zoneCode}}">{{$item->zoneName}}</option>
						  @endforeach
							
						 </select>
					</div>	
			    </div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="woredaName">ስም ወረዳ<span class="required"></span>
					</label>
					<div class="col-md-6 col-sm-5 col-xs-12">
					  <input type="text" id="woredaName" name="woredaName"  required="required" class="form-control col-md-7 col-xs-12">
					</div>
					<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
				</div>    
                 	<div class="form-group">
					<label class="control-label col-sm-2" for="woredaCode">ወረዳ ኮድ<span class="required"></span>
					</label>
					<div class="col-md-6 col-sm-5 col-xs-12">
					  <input type="text" id="woredaCode" name="woredaCode" required="required" readonly="" class="form-control col-md-7 col-xs-12">
					</div>
				</div>    				
						<p class="fname_error error text-center alert alert-danger hidden"></p>
								
											
					
					</form>
					<div class="deleteContent">
						ብትክክል ክጠፍአ ይድለ ድዩ <span class="dname"></span> ? <span
							class="hidden did"></span>
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
				
						 <label> 
				 &nbsp &nbsp &nbsp  &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbspዓይነት ወረዳ *:</label>
				 ገጠር:
				<div class="form-group">
				<input type="radio" class="flat" id ="geter" name="urban2"  value="ገጠር" checked="checked" required />ከተማ:
				<input type="radio" class="flat" id ="ketema" name="urban2"  value="ከተማ" /> 
				
				
				</div>
	            <br>
		
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-2" for="postion">ዝርከበሉ ዞባ:<span class="text-danger">*</span></label>
					<div class="col-sm-3">

						 <select class="form-control" name="zoneCode2" id ="zoneCode2" required="required">
						   <option selected disabled>~ምረፅ~</option>
						   @foreach($zobadata as $item)
							  <option value="{{$item->zoneCode}}">{{$item->zoneName}}</option>
						  @endforeach
							
						 </select>
					</div>	
			    </div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="woredaName">ስም ወረዳ<span class="required"></span>
					</label>
					<div class="col-md-6 col-sm-5 col-xs-12">
					  <input type="text" id="woredaName2" name="woredaName2"  required="required" class="form-control col-md-7 col-xs-12">
					</div>
				</div>    
                 	<div class="form-group">
					<label class="control-label col-sm-2" for="woredaCode">ወረዳ ኮድ<span class="required"></span>
					</label>
					<div class="col-md-6 col-sm-5 col-xs-12">
					  <input type="text" id="woredaCode2" name="woredaCode2" required="required" class="form-control col-md-7 col-xs-12">
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
	@section('scripts-extra')
	<script>
  $(document).ready(function() {
    $('#table').DataTable();
} );
  </script>
  

	<script>
	
    $(document).on('click', '.edit-modal', function() {
        $('#footer_action_button').text("ኣስተኻኽል");
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
		
	     
        $('.did').text(stuff[0]);
		
        $('.dname').html(stuff[3]);
        $('#myModal').modal('show');
    });

function fillmodalData(details){
    $('#zoneCode').val(details[1]);
    $('#woredaCode').val(details[2]);
    $('#woredaName').val(details[3]);
	var selobj =(details[5]);
	
	
    $('#zoneCodeselect').val(selobj);
	
	
	
	if(details[4]=='ከተማ')
	{
	$('#geter').attr('checked', 'checked');
	}
	else
	{
	
	$('#ketema').attr('checked', 'checked');
	}


	
    
}

    $('.modal-footer').on('click', '.edit', function() {
        $.ajax({
            type: 'post',
            url: '/editWoreda',
            data: {
                '_token': $('input[name=_token]').val(),				
                'wcode': $("#woredaCode").val(),
                'zonecode': $('#zoneCode').val(),
                'woredaname': $('#woredaName').val(),
				'urban': $('#urban').val()
              
            },
			
            success: function(data) {
            	}
        });
    });
	$('.modal-footer').on('click', '.add', function() {
        $.ajax({
            type: 'post',
            url: '/addWoreda',
            data: {
                '_token': $('input[name=_token]').val(),				
                'zcode': $('#zoneCode2').val(),
                'wname': $('#woredaName2').val(),
				'wcode': $('#woredaCode2').val(),
				'urban': $('input[name=urban2]:checked').val()		
              
            },
			
			
            success: function(data) {
			    

            	}
        });
    });
    $('.modal-footer').on('click', '.delete', function() {
        $.ajax({
            type: 'post',
            url: '/deleteWoreda',
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
 <script src="//code.jquery.com/jquery-1.12.3.js"></script>
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script
	src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet"
	href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet"
	href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
<script
	src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
@endsection
</body>
@endsection

