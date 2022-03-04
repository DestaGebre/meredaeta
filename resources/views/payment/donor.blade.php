@extends('layouts.app')

@section('htmlheader_title')
     መረዳእታ ለገስቲ
@endsection

@section('contentheader_title')
 ምሕደራ መረዳእታ ለገስቲ
@endsection

@section('header-extra')


@endsection
@section('main-content')

<?php $cnt = (count($errors) > 0); ?>
	<div class="box box-primary">
        <div class="myswitch pull-right">             
	        <button class="btn switchBtn btn-info"><span class="glyphicon glyphicon-plus"></span> ሓዱሽ መዝግብ </button> 
	    </div>
	    <div class="mytoggle hidden pull-right">           
	      <button class="btn toggleBtn btn-info"><span class="glyphicon glyphicon-arrow-up"></span></button>          
	    </div>
	    <div id ="donordiv" class="form-group hidden">
        @if (count($errors) > 0)
             <div class = "alert alert-danger">
                <ul>
                   @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                   @endforeach
                </ul>
             </div>
          @endif    
      	</br> 
        <form id="demo-form2" method="POST" action= "{{URL('donor')}}" data-parsley-validate class="form-horizontal form-label-left">
        {{ csrf_field() }}</br>
        <div class="form-group">
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="donorType1">ዓይነት ለጋሲ:<span class="text-danger">*</span></label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			 <select class="form-control" id="donorType1" name="donorType" required="required">
			    <option selected disabled>~ምረፅ~</option>
				<option>ኣባል</option>
	            <option>ደጋፊ</option>
	            <option>ካሊእ</option>
			 </select>
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="donorName1">ሽም ለጋሲ<span class="required">（*）</span>
			</label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <input type="text" id="donorName1" name="donorName" required="required" class="form-control col-md-7 col-xs-12" value="{{ $cnt ? Request::old('donorName') : '' }}">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="occupationArea1">ዝተዋፈርሉ ዘርፊ<span class="required">（*）</span>
			</label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <input type="text" id="occupationArea1" name="occupationArea" required="required" class="form-control col-md-7 col-xs-12" value="{{ $cnt ? Request::old('occupationArea') : '' }}">
			</div>
		 </div>
		 <div class="form-group">
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="address1">ኣድራሻ:<span class="required">（*）</span>
			</label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <input type="text" id="address1" name="address" required="required" class="form-control col-md-7 col-xs-12" value="{{ $cnt ? Request::old('address') : '' }}">
			</div>
		 </div>
		 <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">                         
			
              <button type="submit" class="btn btn-success">ኣቐምጥ</button>
            </div>
          </div>
		</form>
	</div>

	<div id="donorlist">
		  <div class="col-sm-12">
			<div class="card-box table-responsive">
			  <p class="text-muted font-13 m-b-30">
			  </p>

		<div class="container ">        
        <div class="table-responsive text-center">
          <table class="table table-striped table-bordered" id="table2">
				<thead>
				  <tr>
					<th class="text-center">ኮድ</th>
					<th class="text-center">ዓይነት ለጋሲ</th>
					<th class="text-center">ሽም ለጋሲ</th>
					<th class="text-center">ዝተዋፈርሉ ዘርፊ</th>
					<th class="text-center">ኣድራሻ</th>
					<th class="text-center">ተግባር</th>					
				  </tr>
				</thead>
				<tbody>
					@foreach ($data as $donor)
				  <tr>
					<td>{{ $donor->donorId }}</td>
					<td>{{ $donor->donorType }} </td>
					<td>{{ $donor->donorName }} </td>
					<td>{{ $donor->occupationArea }} </td>
					<td>{{ $donor->address }} </td>
					<td><button class="edit-modal btn btn-info" data-info="{{$donor->donorId}},{{$donor->donorType}},{{$donor->donorName}},{{$donor->occupationArea}},{{$donor->address}}">
	                  <span class="glyphicon glyphicon-edit"></span>ኣመሓይሽ</button>
	                  <button class="delete-modal btn btn-danger" data-info="{{$donor->donorId}},{{$donor->donorName}}">
	                  <span class="glyphicon glyphicon-trash"></span>ሰርዝ</button>
                	</td>  						  
				  </tr>
				 @endforeach
				 </tbody>
				</table>
		</div>
    {{ $data->links() }}
	</div>
	</div>
	</div>
	</div>

	<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog"> <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal formadder" role="form">
          <input type="hidden" class="form-control" id="id">
          	<!-- <div class="form-group">
	            <label class="control-label col-md-2 col-sm-3 col-xs-12" for="donorId">መፍለይ ቑፅሪ ለጋሲ<span class="required">（*）</span>
	            </label>
	            <div class="col-md-3 col-sm-6 col-xs-12">
	              <input type="text" id="donorId" name="donorId" required="required" readonly class="form-control col-md-7 col-xs-12">
	             </div>
            </div>   -->
          	<div class="form-group">
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="donorType">ዓይነት ለጋሲ:<span class="text-danger">*</span></label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			 <select class="form-control" id="donorType" name="donorType" required="required">
			    <option selected disabled>~ምረፅ~</option>
				<option>ኣባል</option>
	            <option>ደጋፊ</option>
	            <option>ካሊእ</option>
			 </select>
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="donorName">ሽም ለጋሲ<span class="required">（*）</span>
			</label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <input type="text" id="donorName" name="donorName" required="required" class="form-control col-md-7 col-xs-12">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="occupationArea">ዝተዋፈርሉ ዘርፊ<span class="required">（*）</span>
			</label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <input type="text" id="occupationArea" name="occupationArea" required="required" class="form-control col-md-7 col-xs-12">
			</div>
		 </div>
		 <div class="form-group">
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="address">ኣድራሻ:<span class="required">（*）</span>
			</label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <input type="text" id="address" name="address" required="required" class="form-control col-md-7 col-xs-12">
			</div>
		 </div>
		 </form> 
		 <div class="deleteContent">
             <span class="dname"></span>  ብትክክል ክጠፍአ ይድለ ድዩ ? <span class="hidden did"></span>
              <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
          </div>

			<div class="modal-footer">
            <button type="button" class="btn actionBtn">
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

	  </div>
@endsection

	@section('scripts-extra')
	<script>
 
 
	 $(document).ready(function() {
      $('#table2').DataTable({
        @include('layouts.partials.lang'),
        "order": []
      });
        });
	 $(document).on('click', '.switchBtn', function() {
    	$('#donorlist').addClass('hidden');
    	$('.myswitch').addClass('hidden');
        $('#donordiv').removeClass('hidden');                 
        $('.mytoggle').removeClass('hidden');                 
    });	
    $(document).on('click', '.toggleBtn', function() {
        $('.alert-danger').remove();
    	$('#donordiv').addClass('hidden');
    	$('.mytoggle').addClass('hidden');
        $('#donorlist').removeClass('hidden');                 
        $('.myswitch').removeClass('hidden'); 
        });	
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
        $('.formadder').show();
        row = $($($(this).parent()).parent()).children();
        stuff = [$(row[0]).html(),$(row[1]).html().trim(),$(row[2]).html().trim(),$(row[3]).html().trim(),$(row[4]).html().trim()];
        fillmodalData(stuff)
        $('#myModal').modal('show');
    });

  function fillmodalData(details){
      $('#id').val(details[0]);
      $('#donorType').val(details[1]);
      $('#donorName').val(details[2]);
      $('#occupationArea').val(details[3]);
      $('#address').val(details[4]);         
    } 

    $('.modal-footer').on('click', '.edit', function() {
        $.ajax({
            type: 'post',
            url: 'editdonor',
            data: {
                '_token': $('input[name=_token]').val(),				
                'id': $('#id').val(),
                'donorType': $('#donorType').val(),
                'donorName': $('#donorName').val(),
                'occupationArea': $('#occupationArea').val(),
                'address': $('#address').val()
            },
			
            success: function(data) {
              if(data[0] == true) {
                    $(row[1]).html($("#donorType").val());
                    $(row[2]).html($("#donorName").val());
                    $(row[3]).html($("#occupationArea").val());
                    $(row[4]).html($("#address").val());

                    $("#id").val('');
                    $("#donorType").val('');
                    $("#donorName").val('');
                    $("#occupationArea").val('');
                    $("#address").val('');

                    $('#myModal').modal('hide');
                }
                else{
                    if(Array.isArray(data[2]))
                        data[2] = data[2].join('<br>');
                }
            
              toastr.clear();
                toastr[data[1]](data[2]);
            	 },

            error: function(xhr,errorType,exception){
            		
            			alert(exception);
                        
            }
        });
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
        $('#myModal').modal('show');
    });
     $('.modal-footer').on('click', '.delete', function() {
        $.ajax({
            type: 'post',
            url: 'deletedonor',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('.did').text()
        
            },
      
            success: function(data) {
              if(data[0] == true){
                  $('#myModal').modal('hide');
                  toastr.clear();
                  toastr['warning'](data[1]);
                  setTimeout(function() {row.remove()}, 1000);
                }
            }
        });
    });

    @if (count($errors) > 0)
        $('.switchBtn').click();
    @endif    
    
</script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css"></style>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
@endsection

