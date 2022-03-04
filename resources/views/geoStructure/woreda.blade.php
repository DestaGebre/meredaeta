@extends('layouts.app')

@section('htmlheader_title')
     ወረዳ 
@endsection

@section('contentheader_title')
    ወረዳ
@endsection

@section('header-extra')




@endsection
@section('main-content')


<div>
<div class="box box-primary">
    <div class="box-header with-border">
    <?php
       $show_zone = $hide_woreda = $hide_tabia = $hide_widabe = $hide_wahio = true;
    ?>
    @include('layouts.partials.filter_html', ['address' => 'woreda'])
    <div class="" style="height: 50px;">
     <button class="pull-right add-modal btn btn-success" data-info=""><span class="glyphicon glyphicon-plus"></span> ሓዱሽ መዝግብ</button>
    </div>

   
	<div class="">
		{{ csrf_field() }}
		<div class="table-responsive text-center">
			<table class="table table-borderless" id="table">
				<thead>
					<tr>
                        <th class="text-center">ወረዳ ኮድ</th>
						<th class="text-center">ዞባ</th>
						<th class="text-center">ወረዳ </th>
						<th class="text-center">ዓይነት ወረዳ </th>
						<th class="text-center">ተግባር</th>
					</tr>
				</thead>
				
                  <tbody	id="products-list" name="products-list"> 				
				@foreach($data as $item)
					
				<tr class="item{{$item->woredacode}}" >
				   
					<td>{{$item->woredacode}}</td>
                    <td>{{$item->zonat->zoneName}}</td>
					<td>{{$item->name}}</td>
					<td>{{$item->isUrban}}</td>
					
					<td><button class="edit-modal btn btn-info"
							data-info="{{$item->woredacode}},{{$item->zonat->zoneName}},{{$item->woredacode}},{{$item->name}},{{$item->isUrban}},{{$item->zoneCode}}">
							<span class="glyphicon glyphicon-edit"></span> ኣስተኻኽል
						</button>
						<button class="delete-modal btn btn-danger"
							data-info="{{$item->woredacode}},{{$item->zonat->zoneName}},{{$item->woredacode}},{{$item->name}},{{$item->isUrban}}">
							<span class="glyphicon glyphicon-trash"></span> ሰርዝ
						</button></td>
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
					<label class="control-label col-md-3 col-sm-3 col-xs-2"> ዓይነት ወረዳ*: </label>
						ገጠር:<input type="radio" class="flat" name="urban" id="geter1" value="ገጠር" checked="" required /> 
						ከተማ: <input type="radio" class="flat" name="urban" id="ketema1" value="ከተማ" />
				</div>	 

				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-2" for="zoneCodeselect">ዝርከበሉ ዞባ:<span class="text-danger">*</span></label>
					<div class="col-sm-3">

						 <select class="form-control"  id ="zoneCodeselect" >
						   
						   @foreach($zobadata as $item)
							  <option value="{{$item->zoneCode}}">{{$item->zoneName}}</option>
						  @endforeach
							
						 </select>
					</div>	
			    </div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="woredaName">ሽም ወረዳ:<span class="required"></span>
					</label>
					<div class="col-md-6 col-sm-5 col-xs-12">
					  <input type="text" id="woredaName" name="woredaName"  required="required" class="form-control col-md-7 col-xs-12">
					</div>
					<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
				</div>    
                 	<!-- <div class="form-group">
    					<label class="control-label col-sm-2" for="woredaCode">ወረዳ ኮድ<span class="required"></span>
    					</label>
    					<div class="col-md-6 col-sm-5 col-xs-12">
    					  <input type="text" id="woredaCode" name="woredaCode" required="required" readonly="" class="form-control col-md-7 col-xs-12">
    					</div>
				    </div> -->
						<p class="fname_error error text-center alert alert-danger hidden"></p>
								
											
					
					</form>
					<div class="deleteContent">
						ብትክክል ክጠፍአ ይድለ ድዩ <span class="dname"></span> ? <span
							class="hidden did"></span>
							<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
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
					<label class="control-label col-md-3 col-sm-3 col-xs-3"> ዓይነት ወረዳ*: </label>
						ከተማ: <input type="radio" class="flat" name="urban2" id="ketema" checked="" value="ከተማ" />
						ገጠር:<input type="radio" class="flat" name="urban2" id="geter" value="ገጠር"  required /> 						
				</div>
		
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-3" for="zoneCode2">ዝርከበሉ ዞባ:<span class="text-danger">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-6">

						 <select class="form-control col-md-6 col-sm-6 col-xs-6" name="zoneCode2" id ="zoneCode2" required="required">
						   <option selected disabled>~ምረፅ~</option>
						   @foreach($zobadata as $item)
							  <option value="{{$item->zoneCode}}">{{$item->zoneName}}</option>
						  @endforeach
							
						 </select>
					</div>	
			    </div>
			    <!-- <div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-3" for="woredaCode2">ወረዳ ኮድ:<span class="required"></span>
					</label>
					<div class="col-md-6 col-sm-5 col-xs-12">
					  <input type="text" id="woredaCode2" name="woredaCode2" required="required" class="form-control col-md-7 col-xs-12">
					</div>
				</div> -->
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-3" for="woredaName2">ሽም ወረዳ:<span class="required"></span>
					</label>
					<div class="col-md-6 col-sm-5 col-xs-12">
					  <input type="text" id="woredaName2" name="woredaName2"  required="required" class="form-control col-md-7 col-xs-12">
					</div>
				</div>    
                     				
						<p class="fname_error error text-center alert alert-danger hidden"></p>
								
											
					
					</form>
					
					<div class="modal-footer">
					<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
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
@endsection
	@section('scripts-extra')
	<script>
  $(document).ready(function() {
    $('#table').DataTable({
        @include('layouts.partials.lang'),
        "order": []
      });
} );
    var row, stuff;
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
        stuff = [$(row[0]).html(),$(row[1]).html(),$(row[2]).html(),$(row[3]).html()];
        fillmodalData(stuff);
        $('#myModal').modal('show');
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
		
        // $('.dname').html(stuff[3]);
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
    setIt('zoneCodeselect', details[1]);
    $('#woredaName').val(details[2]);
	(details[3]=='ከተማ') ? ($('#ketema1').prop('checked',true)) : ($('#geter1').prop('checked',true));
}

    $('.modal-footer').on('click', '.edit', function() {
        $.ajax({
            type: 'post',
            url: 'editWoreda',
            data: {
                '_token': $('input[name=_token]').val(),				
                'wcode': stuff[0],
                'zcode': $('#zoneCodeselect').val(),
                'wname': $('#woredaName').val(),
				'urban': $('input[name=urban]:checked').val()
              
            },
			
            success: function(data) {
                if(data[0] == true){
                    $(row[1]).html($('#zoneCodeselect option:selected').html());
                    $(row[2]).html($('#woredaName').val());
                    $(row[3]).html($('input[name=urban]:checked').val());
                    $('#zoneCodeselect').prop('selectedIndex',0);
                    $('#woredacode').modal('hide');
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
            url: 'addWoreda',
            data: {
                '_token': $('input[name=_token]').val(),				
                'zcode': $('#zoneCode2').val(),
                'wname': $('#woredaName2').val(),
				'wcode': $('#woredaCode2').val(),
				'urban': $('input[name=urban2]:checked').val()
              
            },
			
			
            success: function(data) {
                  if(data[0] == true){
                    var n_row = '<tr>'+
                    '<td>'+data[3]+'</td>'+
                    '<td>'+$('#zoneCode2 option:selected').html()+'</td>'+
                    '<td>'+$('#woredaName2').val()+'</td>'+
                    '<td>'+$('input[name=urban2]:checked').val()+'</td>'+
                    '<td>'+
                    '<button class="edit-modal btn btn-info"><span class="glyphicon glyphicon-edit"></span> ኣስተኻኽል</button>'+
                    ' <button class="delete-modal btn btn-danger"><span class="glyphicon glyphicon-trash"></span> ሰርዝ</button>'+
                    '</td>'+
                    '</tr>';
                    $($('tbody')[0]).append(n_row);
                    $('#zoneCode2').prop('selectedIndex', 0);
                    $('#woredaName2').val('');
                    $('#woredaCode2').val('');
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
            url: 'deleteWoreda',
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
</script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css"></style>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
@endsection


