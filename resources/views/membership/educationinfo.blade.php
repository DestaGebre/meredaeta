
@extends('layouts.app')

@section('htmlheader_title')
ት/ቲ ማህደር
@endsection

@section('contentheader_title')
ት/ቲ ማህደር
@endsection

@section('header-extra')
<!-- <script src="//code.jquery.com/jquery-1.12.3.js"></script>
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
 -->

@endsection
@section('main-content')
    @include('layouts.partials.filter_html', ['address' => 'educationinfo'])
	<div class="row ">
		<div class="col-md-6 col-sm-6 col-xs-6">
				<!-- <div class="form-group col-md-12 col-sm-12 col-xs-12">			                
					<div class="col-md-6 col-sm-6 col-xs-6">    
						<select name="zone" id="zone" class="form-control" >
							<option value=""selected disabled>~ዞባ ምረፅ~</option>
							@foreach ($zobadatas as $key => $value)
							<option value="{{ $key }}">{{ $value }}</option>
							@endforeach
						</select>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-6">    
						<select name="woreda" id="woreda" class="form-control">
							<option value="">~ወረዳ ምረፅ~</option>
						</select>
					</div>
				</div> -->
			</div>
			<div class="col-md-6 col-sm-6 col-xs-6">
			</div>	
	</div>
	
	<div class="box box-primary">
		<div id="tableofContents">
		<div class="box-header with-border">			
			
				{{ csrf_field() }}
				<div class="table-responsive text-center">
					<table class="table table-borderless" id="table2">
						<thead>
							<tr>
								<th class="text-center">ሽም ኣባል</th>								
								<th class="text-center">ዓይነት ትምህርቲ</th>
								<th class="text-center">ደረጃ ትምህርቲ</th>								
								<th class="text-center">ዝሃቦ ትካል</th>
								<th class="text-center">ዝተመረቀሉ ዓመት</th>
                @if (Auth::user() && array_search(Auth::user()->usertype, ['admin', 'zoneadmin', 'woredaadmin']) !== false)
								<th class="text-center">ተግባር</th>								<!-- <th class="text-center">ተግባር</th> -->
                @endif
								
							</tr>					
						</thead>
						<tbody>
							@foreach ($data as $mydata)										
							<tr>
                <input type="hidden" value="{{$mydata->id}}">
                <input type="hidden" value="{{$mydata->hitsuyID}}">
								<td>{{ $mydata->hitsuyedu->name }} {{ $mydata->hitsuyedu->fname }} {{ $mydata->hitsuyedu->gfname }}</td>                          
								<td>{{ $mydata->educationType }}</td>								
								<td>{{ $mydata->educationLevel }}</td>
								<td>{{ $mydata->institute }}</td>
								<td>{{ $mydata->graduationDate }}</td>
                @if (Auth::user() && array_search(Auth::user()->usertype, ['admin', 'zoneadmin', 'woredaadmin']) !== false)
								<td><button class="edit-modal btn btn-primary">
                  					<span class="glyphicon glyphicon-edit"></span></button>
                  					<button class="delete-modal btn btn-warning" data-info="">
                  					<span class="glyphicon glyphicon-trash"></span></button>
								</td>
                @endif
												
						   </tr>
							@endforeach
							</tbody>
						</table>
						</div>
          {{ $data->links() }}
	 </div>
	 </div>
	 
<!---     -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"></h4>

        </div>
        <div class="modal-body">
          <form class="form-horizontal formadder" role="form">
	<div class="form-group ">                     
            <label class="control-label col-md-2 col-sm-2" for="fullname">ሽም:</label>
            <div class="col-md-4 col-sm-4 col-xs-4">
                <input type="text" id="fullname" name="fullname" readonly class="form-control">
                <input type="hidden" id="hitsuyID" name="hitsuyID" >
                <input type="hidden" id="hhID" name="hhID" >
            </div>
            <label class="control-label col-md-2 col-sm-2" for="educationType">ዓይነት ትምህርቲ:</label>
            <div class="col-md-4 col-sm-4 col-xs-4">
                <input type="text" id="educationType" name="educationType" class="form-control">
            </div>
        </div>
        <div class="form-group ">
            <label class="control-label col-md-2 col-sm-2" for="educationLevel">ደረጃ ትምህርቲ:</label>
            <div class="col-md-4 col-sm-4 col-xs-4">
              <select id="educationLevel" name="educationLevel" class="form-control">
                    <option selected="" disabled="">~ምረፅ~</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    <option>6</option>
                    <option>7</option>
                    <option>8</option>
                    <option>9</option>
                    <option>10</option>
                    <option>11</option>
                    <option>12</option>
                    <option>ሰርቲፊኬት</option>
                    <option>ዲፕሎማ</option>
                    <option>ዲግሪ</option>
                    <option>ማስተርስ</option>
                    <option>ፒ.ኤች.ዲ</option>
                </select>
                <!-- <input type="text" id="educationLevel" name="educationLevel" class="form-control"> -->
            </div>
            <label class="control-label col-md-2 col-sm-2" for="institute">ዝሃቦ ትካል:</label>
            <div class="col-md-4 col-sm-4 col-xs-4">
                <input type="text" id="institute" name="institute" class="form-control">
            </div>          
        </div>
        <div class="form-group"> 
        	<label class="control-label col-md-2 col-sm-2" for="graduationDate">ዝተመረቀሉ ዓመት:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="graduationDate" name="graduationDate" class="form-control">
            </div>
		</div> 
		<div class="ln_solid"></div>
                      

	</form>
	<div class="deleteContent">
            ናይ <span class="dname"></span> ትምህርቲ ሓበሬታ ብትክክል ክጠፍአ ይድለ ድዩ ? <span class="hidden did"></span>
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
		<!--    -->

    </div>
@endsection

@section('scripts-extra')

    @include('layouts.partials.filter_js')
	<script>
 
 
	 $(document).ready(function() {
      $('#table2').DataTable({
        @include('layouts.partials.lang'),
        "order": []
      });
     });
     var row, stuff;
     $(document).on('click', '.edit-modal', function() {
        $('#footer_action_button').text(" ኣስተኻኽል");
        $('#footer_action_button').addClass('glyphicon-check');
        $('#footer_action_button').removeClass('glyphicon-trash');
        $('#footer_action_button').removeClass('glyphicon-search');
        $('.actionBtn').addClass('btn-success');
        $('.actionBtn').removeClass('btn-danger');
        $('.actionBtn').removeClass('search');
        $('.actionBtn').removeClass('delete');
        $('.actionBtn').addClass('edit');
        $('.modal-title').text('ስራሕ ልምዲ መስተኻኸሊ');
        $('.deleteContent').hide();
        $('.searchContent').hide();
        $('.formadder').show();
        $('#myModal').modal('show');
        row = $($($(this).parent()).parent()).children();
        stuff = [$(row[0]).val(), $(row[1]).val(), $(row[2]).html(), $(row[3]).html(), $(row[4]).html(), $(row[5]).html(), $(row[6]).html()];
        fillData(stuff);
        
    });
  function fillData(details){ 
      $('#hhID').val(details[0]);
      $('#hitsuyID').val(details[1]);
      $('#fullname').val(details[2]);
      $('#educationType').val(details[3]);
      $('#educationLevel').val(details[4]);
      $('#institute').val(details[5]);
      $('#graduationDate').val(details[6]);
      
         
    } 
    var row;
    $(document).on('click','.edit-modal,.delete-modal',function(){
        row = $($(this).parent()).parent();
    })
    $('.modal-footer').on('click', '.edit', function() {
        $.ajax({
            type: 'post',
            url: 'editeducation',
            data: {
                '_token': $('input[name=_token]').val(),        
                'id': stuff[0],
                'hitsuyID': stuff[1],
                'educationType': $('#educationType').val(),
                'educationLevel': $('#educationLevel').val(),
                'institute': $('#institute').val(),
                'graduationDate': $('#graduationDate').val()
                
              
            },
      
            success: function(data) {
              if(data[0] == true){
                    $(row.children()[3]).html($("#educationType").val());
                    $(row.children()[4]).html($("#educationLevel").val());
                    $(row.children()[5]).html($("#institute").val());
                    $(row.children()[6]).html($("#graduationDate").val());
                    $("#hitsuyID").val('');
                    $("#hhID").val('');
                    $("#educationType").val('');
                    $("#educationLevel").val('');
                    $("#institute").val('');
                    $("#graduationDate").val('');
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
        $('.modal-title').text(' ፎርጅድ ናይ ትምህርቲ መረዳእታ መሰረዚ');
        $('.deleteContent').show();
        $('.form-horizontal').hide();
        row = $($($(this).parent()).parent()).children();
         $('.did').text($(row[0]).val());   
        $('.dname').html($(row[2]).html());
        $('#myModal').modal('show');
    });
	$('.modal-footer').on('click', '.delete', function() {
        $.ajax({
            type: 'post',
            url: 'deleteducation',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('.did').text()
        
            },
      
            success: function(data) {
              if(data[0] == true){
                $('#myModal').modal('hide');
                toastr.info(data[1]);
                setTimeout(function() {row.remove();}, 250);
              }
            }
        });
    });

     $('select[name="zone"]').on('change', function() {
            var stateID = $(this).val();				
            //instead of ዞባ ምረፅ => ኩለን ዞባታት value="" selected,
               if(stateID) {
                $.ajax({
                    url: 'myform/ajax/'+stateID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {

                        
                        $('select[name="woreda"]').empty();
						$('select[name="woreda"]').append('<option value="'+ " " +'" selected disabled>'+ "~ወረዳ ምረፅ~" +'</option>');
                        $.each(data, function(key, value) {
                            $('select[name="woreda"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });

                    }
                });
            }else{
                $('select[name="woreda"]').empty();
            }
            // $('#table2').DataTable().column(0).search('^'+stateID,true,false).draw();
        });
     $('select[name="woreda"]').on('change', function() {
            var stateID = $(this).val();
			// $('#table2').DataTable().column(0).search('^[0-9]{2}'+stateID,true,false).draw();	
        });
    //
	
</script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css"></style>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>

@endsection

