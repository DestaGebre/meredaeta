
@extends('layouts.app')

@section('htmlheader_title')
ማህደር ልምዲ ስራሕ
@endsection

@section('contentheader_title')
ማህደር ልምዲ ስራሕ
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
    @include('layouts.partials.filter_html', ['address' => 'careerinfo'])
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
								<th class="text-center">ዓይነት</th>
								<th class="text-center">ስራሕ መደብ</th>								
								<th class="text-center">ሓላፍነት</th>
								<th class="text-center">ትካል</th>
								<th class="text-center">ኣድራሻ</th>
								<th class="text-center">ዝጀመረሉ</th>
                <th class="text-center">ዝወድአሉ</th>
                <th class="text-center">ደመወዝ</th>
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
								<td>{{ $mydata->hitsuyexp->name }} {{ $mydata->hitsuyexp->fname }} {{ $mydata->hitsuyexp->gfname }}</td>                          
								<td>{{ $mydata->exprienceType }}</td>								
								<td>{{ $mydata->career }}</td>
								<td>{{ $mydata->position }}</td>
								<td>{{ $mydata->institute }}</td>
								<td>{{ $mydata->address }}</td>
								<td>{{ App\DateConvert::toEthiopian(date('d/m/Y',strtotime($mydata->startDate))) }}</td>
                <td>{{ $mydata->endDate ? App\DateConvert::toEthiopian(date('d/m/Y',strtotime($mydata->endDate))) : ''}}</td>
                <td>{{ $mydata->salary }}</td>
                @if (Auth::user() && array_search(Auth::user()->usertype, ['admin', 'zoneadmin', 'woredaadmin']) !== false)
								<td><button class="edit-modal btn btn-primary" data-info="">
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
            <label class="control-label col-md-2 col-sm-2" for="exprienceType">ዓይነት:</label>
            <div class="col-md-4 col-sm-4 col-xs-4">
                <select name="exprienceType" id="exprienceType" class="form-control">
						<option selected disabled>~ምረፅ~</option>
						<option >ሞያዊ</option>
						<option >ፖለቲካዊ</option>
				</select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2 col-sm-2" for="career">ስራሕ መደብ:</label>
            <div class="col-md-4 col-sm-4 col-xs-4">
                <input type="text" id="career" name="career" class="form-control">
            </div>
            <label class="control-label col-md-2 col-sm-2" for="position">ሓላፍነት:</label>
            <div class="col-md-4 col-sm-4 col-xs-4">
                <input type="text" id="position" name="position" class="form-control">
            </div> 
                   
        </div>
        <div class="form-group"> 
        	
            <label class="control-label col-md-2 col-sm-2" for="institute">ትካል:</label>
            <div class="col-md-4 col-sm-4 col-xs-4">
                <input type="text" id="institute" name="institute" class="form-control">
            </div><label class="control-label col-md-2 col-sm-2" for="address">ኣድራሻ:</label>
            <div class="col-md-4 col-sm-4 col-xs-4">
                <input type="text" id="address" name="address" class="form-control">
            </div>
		</div> 
		<div class="form-group">
			<label class="control-label col-md-2 col-sm-2" for="startDate">ዝጀመረሉ/ትሉ:</label>
        <div class="col-md-4 col-sm-4 col-xs-4">
            <input type="text" id="startDate" name="startDate" class="form-control">
        </div>  
      <label class="control-label col-md-2 col-sm-2" for="endDate">ዝወድአሉ/ትሉ:</label>
      <div class="col-md-4 col-sm-4 col-xs-4">
          <input type="text" id="endDate" name="endDate" class="form-control">
      </div>
		</div>
    <div class="form-group">
      <label class="control-label col-md-2 col-sm-2" for="salary">ደመወዝ:</label>
        <div class="col-md-4 col-sm-4 col-xs-4">
            <input type="text" id="salary" name="salary" class="form-control">
        </div>  
    </div>

		<div class="ln_solid"></div>
                      

	</form>
	<div class="deleteContent form-group">
            ናይ <span class="dname"></span> ስራሕ ልምዲ ብትክክል ክጠፍአ ይድለ ድዩ ? <span class="hidden did"></span>
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
		<!--    -->

    </div>
@endsection

@section('scripts-extra')
  <script type="text/javascript" src="js/jquery.calendars.js"></script> 
      <script type="text/javascript" src="js/jquery.calendars.plus.min.js"></script>
      <link rel="stylesheet" type="text/css" href="css/jquery.calendars.picker.css"> 
      <script type="text/javascript" src="js/jquery.plugin.min.js"></script> 
      <script type="text/javascript" src="js/jquery.calendars.picker.js"></script>
      <script type="text/javascript" src="js/jquery.calendars.ethiopian.min.js"></script>
      <link rel="stylesheet" href="css/jquery.dataTables.min.css"></style>
      <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
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
        $('.detail-form').hide();
        $('.formadder').show();
        $('#myModal').modal('show');
        row = $($($(this).parent()).parent()).children();
        stuff = [$(row[0]).val(), $(row[1]).val(), $(row[2]).html(), $(row[3]).html(), $(row[4]).html(), $(row[5]).html(), $(row[6]).html(), $(row[7]).html(), $(row[8]).html(), $(row[9]).html(), $(row[10]).html()];
        fillData(stuff);
        
    });
  function fillData(details){ 
      $('#hhID').val(details[0]);
      $('#hitsuyID').val(details[1]);
      $('#fullname').val(details[2]);
      $('#exprienceType').val(details[3]);
      $('#career').val(details[4]);
      $('#position').val(details[5]);
      $('#institute').val(details[6]);
      $('#address').val(details[7]);
      $('#startDate').val(details[8]); 
      $('#endDate').val(details[9]); 
      $('#salary').val(details[10]); 
         
    } 
    var row;
    $(document).on('click','.edit-modal,.delete-modal',function(){
        row = $($(this).parent()).parent();
    })
    $('.modal-footer').on('click', '.edit', function() {
        $.ajax({
            type: 'post',
            url: 'editexprience',
            data: {
                '_token': $('input[name=_token]').val(),  
                'id': stuff[0],      
                'hitsuyID': stuff[1],
                'exprienceType': $('#exprienceType').val(),
                'career': $('#career').val(),
                'position': $('#position').val(),
                'institute': $('#institute').val(),
                'address': $('#address').val(),
                'startDate': $('#startDate').val(),
                'endDate': $('#endDate').val(),
                'salary': $('#salary').val()
              
            },
      
            success: function(data) {
            if(data[0] == true){
                $(row.children()[3]).html($("#exprienceType").val());
                $(row.children()[4]).html($("#career").val());
                $(row.children()[5]).html($("#position").val());
                $(row.children()[6]).html($("#institute").val());
                $(row.children()[7]).html($("#address").val());
                $(row.children()[8]).html($("#startDate").val());
                $(row.children()[9]).html($("#endDate").val());
                $(row.children()[10]).html($("#salary").val());
                $("#hitsuyID").val('');
                $("#hhID").val('');
                $("#exprienceType").val('');
                $("#career").val('');
                $("#position").val('');
                $("#institute").val('');
                $("#address").val('');
                $("#startDate").val('');
                $("#endDate").val('');
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
        $('.modal-title').text(' ስራሕ ልምዲ መሰረዚ');
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
            url: 'deletexprience',
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
              $('.item' + $('.did').text()).remove();
         
          
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
     $('#startDate').calendarsPicker({calendar: $.calendars.instance('ethiopian')});
     $('#endDate').calendarsPicker({calendar: $.calendars.instance('ethiopian')});
    //
	
</script>


@endsection

