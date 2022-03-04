@extends('layouts.app')

@section('htmlheader_title')
     መዋጮ
@endsection

@section('contentheader_title')
 ምሕደራ መዋጮ
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
						<th class="text-center">ተ.ቑ</th>						
						<th class="text-center">ሽም መዋጮ</th>
						<th class="text-center">ዕላማ</th>
						<th class="text-center">ዓይነት ኣባል</th>
						<th class="text-center">መጠን</th>
						<th class="text-center">ዝኽፈለሉ ዕለት</th>
						<th class="text-center"></th>
					</tr>
				</thead>
				<tbody	id="products-list" name="products-list">
					@foreach($data as $item)
					<tr class="item{{$item->id}}" >
						<td>{{$item->id}}</td>
						<td>{{$item->name}}</td>
						<td>{{$item->purpose}}</td>
						<td>{{$item->mtype}}</td>						
						<td>{{$item->amount}}</td>
						<td>{{App\DateConvert::toEthiopian(date('d/m/Y',strtotime($item->deadline)))}}</td>	
						
						<td><button class="edit-modal btn btn-info"
								data-info="{{$item->id}},{{$item->name}},{{$item->purpose}},{{$item->mtype}},{{$item->amount}},{{$item->deadline}}">
								<span class="glyphicon glyphicon-edit"></span> ኣስተኻኽል
							</button>
							<button class="delete-modal btn btn-danger"
								data-info="{{$item->id}},{{$item->name}},{{$item->purpose}},{{$item->mtype}},{{$item->amount}},{{$item->deadline}}">
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
                            
                            <div class="col-sm-10">
                                <input type="hidden" class="form-control" id="iid">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="fid">ሽም መዋጮ</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="fid"  >
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="fname">ዕላማ</label>
                            <div class="col-sm-10">
                                <input type="name" class="form-control" id="fname">
                            </div>
                        </div>
                        <div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-">ዓይነት ኣባል</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control col-md-6 col-sm-6 col-xs-12" id="mtype1">
                            <option selected disabled>~ምረፅ~</option>
                            <option>ሓረስታይ</option>
                            <option>ሸቃላይ</option>
                            <option>ምሁር</option>
                            <option>ደኣንት</option>
                            <option>መምህር</option>
                            <option>ተምሃራይ</option>
                            <option>ነጋዲይ</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                            <label class="control-label col-sm-2" for="amount1">መጠን</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="amount1"  >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="deadline1">ዝኽፈለሉ ዕለት</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="deadline1">
                            </div>
                        </div>
                        </div>
                        <p class="fname_error error text-center alert alert-danger hidden"></p>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                         
                        </div>
                        
                        
                        
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
							<label class="control-label col-sm-2" for="nameMew">ሽም መዋጮ</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" class="form-control" id="nameMew">
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-2" for="purpose">ዕላማ</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="name" class="form-control" id="purpose">
							</div>
						</div>
						<div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-2"for="mtype">ዓይነት ኣባል</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control col-md-6 col-sm-6 col-xs-12" id="mtype">
                            <option selected disabled>~ምረፅ~</option>
							<!-- <option>ኩሉ ኣባል</option> -->
                            <option>ገባር</option>
							<option>ሸቃላይ</option>
							<option>ምሁር</option>
							<option>ደኣንት</option>
							<option>መምህር</option>
							<option>ተምሃራይ</option>
							<option>ነጋዲይ</option>
                          </select>
                        </div>
                      </div>
					  <div class="form-group">
							<label class="control-label col-sm-2" for="amount">መጠን</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" class="form-control" id="amount">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="deadline">ዝኽፈለሉ ዕለት</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" class="form-control" id="deadline">
							</div>
						</div>
						</div>
						<p class="fname_error error text-center alert alert-danger hidden"></p>
								
											
					
					</form>
					
					<div class="modal-footer">
					<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
						<button type="button" class="btn actionBtn">
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
    <script type="text/javascript" src="js/jquery.calendars.js"></script> 
      <script type="text/javascript" src="js/jquery.calendars.plus.min.js"></script>
      <link rel="stylesheet" type="text/css" href="css/jquery.calendars.picker.css"> 
      <script type="text/javascript" src="js/jquery.plugin.min.js"></script> 
      <script type="text/javascript" src="js/jquery.calendars.picker.js"></script>
      <script type="text/javascript" src="js/jquery.calendars.ethiopian.min.js"></script>
	<script>
 
 
	 $(document).ready(function() {
      $('#table2').DataTable({
        @include('layouts.partials.lang'),
        "order": []
      });
        } );
    var row, stuff;
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
        row = $($($(this).parent()).parent()).children();
        stuff = [$(row[0]).html(),$(row[1]).html(),$(row[2]).html(),$(row[3]).html(),$(row[4]).html(),$(row[5]).html()];
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
        row = $($($(this).parent()).parent()).children();
		
	     
        $('.did').text($(row[0]).html());
		
	
        // $('.dname').html(stuff[1]);
        $('#myModal').modal('show');
    });

function fillmodalData(details){
    $('#fid').val(details[1]);
    $('#fname').val(details[2]);
    $('#mtype1').val(details[3]);
    $('#amount1').val(details[4]);
    $('#deadline1').val(details[5]);
    
}

    $('.modal-footer').on('click', '.edit', function() {
        $.ajax({
            type: 'post',
            url: 'mewachoedit',
            data: {
                '_token': $('input[name=_token]').val(),			
                'id': stuff[0],
                'name': $("#fid").val(),
                'purpose': $('#fname').val(),
                'mtype': $('#mtype1').val(),
                'amount': $('#amount1').val(),
                'deadline': $('#deadline1').val(),
              
            },
			
            success: function(data) {
                	if(data[0] == true){
                        $(row[1]).html($('#fid').val());
                        $(row[2]).html($('#fname').val());
                        $(row[3]).html($('#mtype1').val());
                        $(row[4]).html($('#amount1').val());
                        $(row[5]).html($('#deadline1').val());
                        $('#fid').val('');
                        $('#fname').val('');
                        $('#mtype1').val('');
                        $('#amount1').val('');
                        $('#deadline1').val('');
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
            url: 'mewachosetting',
            data: {
                '_token': $('input[name=_token]').val(),				
                'name': $('#nameMew').val(),
                'mtype': $('#mtype').val(),
                'purpose': $('#purpose').val(),
                'deadline': $('#deadline').val(),
                'amount': $('#amount').val()
              
            },
			
            success: function(data) {
			     if(data[0] == true){
                    var n_row = '<tr>'+
                    '<td>'+data[3]+'</td>'+
                    '<td>'+$('#nameMew').val()+'</td>'+
                    '<td>'+$('#purpose').val()+'</td>'+
                    '<td>'+$('#mtype').val()+'</td>'+
                    '<td>'+$('#amount').val()+'</td>'+
                    '<td>'+$('#deadline').val()+'</td>'+
                    '<td>'+
                    '<button class="edit-modal btn btn-info"><span class="glyphicon glyphicon-edit"></span> ኣስተኻኽል</button>'+
                    ' <button class="delete-modal btn btn-danger"><span class="glyphicon glyphicon-trash"></span> ሰርዝ</button>'+
                    '</td>'+
                    '</tr>';
                    $($('tbody')[0]).append(n_row);
                    $('#nameMew').val('');
                    $('#mtype').val('');
                    $('#purpose').val('');
                    $('#deadline').hide();
                    $('#amount').hide();
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
    $('.modal-footer').on('click', '.delete', function() {
        $.ajax({
            type: 'post',
            url: 'mewachodelete',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('.did').text()
				
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
    $('#deadline').calendarsPicker({calendar: $.calendars.instance('ethiopian')});
    $('#deadline1').calendarsPicker({calendar: $.calendars.instance('ethiopian')});
</script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css"></style>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
@endsection

