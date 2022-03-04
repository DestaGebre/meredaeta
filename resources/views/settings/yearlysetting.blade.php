@extends('layouts.app')

@section('htmlheader_title')
     ምሕደራ ዓመታዊ ክፍሊት
@endsection

@section('contentheader_title')
 ምሕደራ ዓመታዊ ክፍሊት
@endsection

@section('header-extra')


@endsection
@section('main-content')


<div>

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
						
						<th class="text-center">ኮድ</th>
						<th class="text-center">ዓይነት ኣባል</th>
						<th class="text-center">መጠን ክፍሊት</th>
						<th class="text-center">ተግባር</th>
					</tr>
				</thead>
				<tbody	id="products-list" name="products-list">
					@foreach($data as $item)
					<tr class="item{{$item->code}}" >
						<td>{{$item->code}}</td>
						<td>{{$item->type}}</td>
						<td>{{$item->amount}}</td>						
						
						<td><button class="edit-modal btn btn-info">
								<span class="glyphicon glyphicon-edit"></span> ኣስተኻኽል
							</button>
							<button class="delete-modal btn btn-danger">
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
							<label class="control-label col-sm-2" for="yid">ኮድ</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="yid">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="mtype">ዓይነት ኣባል</label>
							<div class="col-sm-10">
								<input type="name" class="form-control" id="mtype">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="amount">መጠን ክፍሊት</label>
							<div class="col-sm-10">
								<input type="name" class="form-control" id="amount">
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
							<label class="control-label col-sm-2" for="code">ኮድ</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="code"  >
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="mytype">ዓይነት ኣባል</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="mytype">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="myamount">መጠን ክፍሊት</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="myamount">
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
        stuff = [$(row[0]).html(),$(row[1]).html(),$(row[2]).html()];
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
        
        $('.yid').text($(row[0]).html());
		
	
        // $('.dname').html(stuff[1]);
        $('#myModal').modal('show');
    });

function fillmodalData(details){
    $("#yid").val(details[0]);
    $('#mtype').val(details[1]);
    $('#amount').val(details[2]);
    
}

    $('.modal-footer').on('click', '.edit', function() {
        $.ajax({
            type: 'post',
            url: 'yearlyedit',
            data: {
                '_token': $('input[name=_token]').val(),				
                'code': $("#yid").val(),
                'type': $('#mtype').val(),
                'amount': $('#amount').val()
              
            },
			
            success: function(data) {
                if(data[0] == true){
                    $(row[1]).html($('#mtype').val());
                    $(row[2]).html($('#amount').val());
                    $('#yid').val('');
                    $('#mtype').val('');
                    $('#amount').val('');
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
            url: 'yearlysetting',
            data: {
                '_token': $('input[name=_token]').val(),				
                'code': $('#code').val(),
                'type': $('#mytype').val(),
                'amount': $('#myamount').val()
              
            },
			
            success: function(data) {
			     if(data[0] == true){
                    var n_row = '<tr>'+
                    '<td>'+$('#code').val()+'</td>'+
                    '<td>'+$('#mytype').val()+'</td>'+
                    '<td>'+$('#myamount').val()+'</td>'+
                    '<td>'+
                    '<button class="edit-modal btn btn-info"><span class="glyphicon glyphicon-edit"></span> ኣስተኻኽል</button>'+
                    ' <button class="delete-modal btn btn-danger"><span class="glyphicon glyphicon-trash"></span> ሰርዝ</button>'+
                    '</td>'+
                    '</tr>';
                    $($('tbody')[0]).append(n_row);
                    $('#code').val('');
                    $('#mytype').val('');
                    $('#myamount').val('');
                    $('#myModaladd').hide();
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
            url: 'yearlydelete',
            data: {
                '_token': $('input[name=_token]').val(),
                'code': $('.yid').text()
				
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

