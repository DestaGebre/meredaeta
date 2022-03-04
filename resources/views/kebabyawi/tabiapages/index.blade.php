@extends('layouts.app')

@section('htmlheader_title')
     ጣብያ 
@endsection

@section('contentheader_title')
    ጣብያ
@endsection

@section('header-extra')




@endsection
@section('main-content')

<body>
<div>
<div class="pull-right">

 <button class="add-modal btn btn-success"
							data-info="">
							<span class="glyphicon glyphicon-plus"></span> ሓዱሽ መዝግብ
						</button>
						</div>
	<div class="container ">
		{{ csrf_field() }}
		<div class="table-responsive text-center">
			<table class="table table-borderless" id="table">
				<thead>
					<tr>
						
						         <th>ዝርከበሉ ወረዳ</th>								 
								 <th>ሽም ጣብያ</th>
								  <th>ጣብያ ኮድ</th>
								<th>ዓይነት ጣብያ</th>             
								<th>ተግባር</th>
					</tr>
				</thead>
				<tbody	id="products-list" name="products-list"> 				
				@foreach($data as $tabia)
					
				<tr class="item{{$tabia->id}}" >
				   
					
					<td> {{$tabia->tabiaName}}</td>
					<td> {{$tabia->tabiaCode}}</td>					
					<td> {{$tabia->isUrban}}</td>
					
					<td><button class="edit-modal btn btn-info"
							data-info="{{$tabia->id}},{{$tabia->tabiaName}},{{$tabia->tabiaCode}},{{$tabia->isUrban}}">
							<span class="glyphicon glyphicon-edit"></span> ኣስተኻኽል
						</button>
						<button class="delete-modal btn btn-danger"
							data-info="{{$tabia->id}},{{$tabia->tabiaName}},{{$tabia->tabiaCode}},{{$tabia->isUrban}}">
							<span class="glyphicon glyphicon-trash"></span> ሰርዝ
						</button></td>
				</tr>
				@endforeach
				</tbody>
	
				
			</table>
		</div>
	</div>
	<div id="woredaform">
			
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
				 &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbspዓይነት ጣብያ *:</label>
				ከተማ:
				<div class="form-group">
				<input type="radio" class="flat" id ="geter" name="urban22"  value="ገጠር" checked="" required /> ገጠር:
				<input type="radio" class="flat" id ="ketema" name="urban22"  value="ከተማ" /> 				
				
				</div>
	            <br>
		
				
     
      <div class="panel-body">
            <div class="form-group">
                <label class="control-label col-sm-2" for="woredaCode"> ሽም ዞባ <span class="required"></span>
					</label>

                <select name="state" id="state" class="form-control" style="width:350px">
                    <option value="">~ዞባ ምረፅ~</option>
                    @foreach ($zobadatas as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="woredaCode"> ሽም ወረዳ <span class="required"></span>
					</label>

                <select name="city" id="city" class="form-control" style="width:350px">
                </select>
            </div>
      </div>
   
			    </div>
				
                 	<div class="form-group">
					<label class="control-label col-sm-2" for="woredaCode"> ሽም ጣብያ <span class="required"></span>
					</label>
					<div class="col-md-6 col-sm-5 col-xs-8">
					  <input type="text" id="tabiaNameadd" name="tabiaNameadd" required="required" class="form-control col-md-7 col-xs-12">
					</div>
				</div>   
					<div class="form-group">
					<label class="control-label col-sm-2" for="woredaCode"> ጣብያ ኮድ <span class="required"></span>
					</label>
					<div class="col-md-6 col-sm-5 col-xs-12">
					  <input type="text" id="tabiaCodeadd" name="tabiaCodeadd" required="required" class="form-control col-md-7 col-xs-12">
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
	
  <script >
 
        $('select[name="state"]').on('change', function() {
            var stateID = $(this).val();
				
        

               if(stateID) {
                $.ajax({
                    url: '/myform/ajax/'+stateID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {

                        
                        $('select[name="city"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="city"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });

                    }
                });
            }else{
                $('select[name="city"]').empty();
            }
        });
    
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
            url: '/editWoreda',
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
            url: '/addTabia',
			
            data: {
                '_token': $('input[name=_token]').val(),				
                'wcode': $('#city').val(),
                'tname': $('#tabiaNameadd').val(),
				'tcode': $('#tabiaCodeadd').val(),
				'urban': $('input[name=urban22]:checked').val()		
              
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

