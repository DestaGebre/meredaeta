@extends('layouts.app')

@section('htmlheader_title')
  መሰረታዊ ውዳበ  
@endsection

@section('contentheader_title')
     መሰረታዊ ውዳበ  
@endsection



@section('main-content')
    
           
<div>
<div class="box box-primary">
    <div class="box-header with-border">
    <?php
       $show_zone = $show_woreda = $hide_widabe = $hide_wahio = true;
    ?>
    @include('layouts.partials.filter_html', ['address' => 'meseretawiwdabe'])
    <div class="" style="height: 50px;">
        <button class="pull-right add-modal btn btn-success" data-info=""><span class="glyphicon glyphicon-plus"></span> ሓዱሽ መዝግብ</button>
    </div>
	<div class="">
		{{ csrf_field() }}
		<div class="table-responsive text-center">
			<table class="table table-borderless" id="table">
				<thead>
					<tr>
                     <th class="text-center">መሰረታዊ ውዳበ ኮድ</th>
			         <th class="text-center">ዝርከበሉ ጣብያ</th>								 
					<th class="text-center">ሽም መሰረታዊ ውዳበ</th>
                    <th class="text-center">ዓይነት ውዳበ</th>
					<th class="text-center">ተግባር</th>
					</tr>
				</thead>
				<tbody	id="products-list" name="products-list"> 				
				@foreach($data as $mwidabe)					
				<tr class="item{{$mwidabe->widabeCode}}" >
                    <td>{{$mwidabe->widabeCode}}</td>
                    <input type="hidden" value="{{$mwidabe->widabes->tabiatat->zonat->zoneName}}">
                    <input type="hidden" value="{{$mwidabe->widabes->tabiatat->name}}">
					<td>{{$mwidabe->widabes->tabiaName}}</td>
					<td>{{$mwidabe->widabeName}}</td>
                    <td>{{$mwidabe->type}}</td>			
					<td><button class="edit-modal btn btn-info" data-info="{{$mwidabe->widabeCode}},{{$mwidabe->widabeName}},{{$mwidabe->widabes->tabiaCode}},{{$mwidabe->widabes->tabiatat->woredacode}},{{$mwidabe->widabes->tabiatat->zonat->zoneCode}}">
							<span class="glyphicon glyphicon-edit"></span> ኣስተኻኽል
						</button>
						<button class="delete-modal btn btn-danger"
							data-info="{{$mwidabe->widabeCode}},{{$mwidabe->widabeName}},{{$mwidabe->widabes->tabiaName}}">
							<span class="glyphicon glyphicon-trash"></span> ሰርዝ
						</button></td>
				</tr>
				@endforeach
				</tbody>				
			</table>
		</div>
        {{ $data->links() }}
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
                            <label class="control-label col-md-3 col-sm-3 col-xs-3" for="state1"> ሽም ዞባ <span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-6">   
                                <select name="state" id="state1" class="form-control col-md-6 col-sm-6 col-xs-6">
                                    
                                    @foreach ($zobadatas as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-3" for="city1"> ሽም ወረዳ <span class="required"></span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-6">    
                            <select class="form-control" name="city"  id ="city1" >                                        
                         </select>
                        </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-3" for="tabiaCode1"> ሽም ጣብያ <span class="required"></span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-6"> 
                        <select class="form-control" name="tabiatoadd"  id ="tabiaCode1" >  
                        </select>   
                      </div>
                    </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3" for="meseretawiWNameadd1"> ሽም መሰረታዊ ውዳበ  <span class="required"></span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                      <input type="text" id="meseretawiWNameadd1" name="meseretawiWNameadd" required="required" class="form-control">
                  </div>
                </div>   
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3" for="meseretawiWType1"> ዓይነት ውዳበ  <span class="required"></span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <select class="form-control" name="meseretawiWType"  id ="meseretawiWType1" >
                            <option value=""selected disabled>~ዓይነት ውዳበ ምረፅ~</option>
                            <option>ገባር</option>
                            <option>ተምሃሮ</option>
                            <option>መምህራን</option>
                            <option>ሰብሞያ</option>
                            <option>ሸቃሎ</option>
							 <option>መፍረይቲ</option>
                            <option>ከተማሕርሻ</option>
                            <option>ኮንስትራክሽን</option>
                            <option>ንግዲ</option>
                            <option>ግልጋሎት</option>
                        </select>   
                  </div>
                </div>   
              <!-- <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="meseretawiwCodeadd1">ኮድ መሰረታዊ ውዳበ <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                  <input type="text" id="meseretawiwCodeadd1" name="meseretawiwCodeadd" required="required" class="form-control col-md-7 col-xs-12">
              </div>
            </div>        -->
        </form>
         <div class="deleteContent">
                        ብትክክል ክጠፍአ ይድለ ድዩ <span class="dname"></span> ? <span
                            class="hidden did"></span>
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
                            <label class="control-label col-md-3 col-sm-3 col-xs-3" for="state"> ሽም ዞባ <span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-6">   
                                <select name="state" id="state" class="form-control col-md-6 col-sm-6 col-xs-6">
                                    <option value=""selected disabled>~ዞባ ምረፅ~</option>
                                    @foreach ($zobadatas as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-3" for="city"> ሽም ወረዳ <span class="required"></span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-6">    
                            <select name="city" id="city" class="form-control col-md-6 col-sm-6 col-xs-6" >
                                <option value="" selected disabled>~ወረዳ ምረፅ~</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-3" for="tabiatoadd"> ሽም ጣብያ <span class="required"></span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-6">   
                        <select name="tabiatoadd" id="tabiatoadd" class="form-control col-md-6 col-sm-6 col-xs-6" >
                            <option value="" selected disabled>~ጣብያ ምረፅ~</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3" for="meseretawiWNameadd"> ሽም መሰረታዊ ውዳበ  <span class="required"></span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                      <input type="text" id="meseretawiWNameadd" name="meseretawiWNameadd" required="required" class="form-control">
                  </div>
              </div>   
              <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3" for="meseretawiWType"> ዓይነት ውዳበ  <span class="required"></span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <select class="form-control" name="meseretawiWType"  id ="meseretawiWType" >
                            <option value=""selected disabled>~ዓይነት ውዳበ ምረፅ~</option>
                             <option>ገባር</option>
                            <option>ተምሃሮ</option>
                            <option>መምህራን</option>
                            <option>ሰብ ሞያ</option>
                            <option>ሸቃሎ</option>
							 <option>መፍረይቲ</option>
                            <option>ከተማ ሕርሻ</option>
                            <option>ኮንስትራክሽን</option>
                            <option>ንግዲ</option>
                            <option>ግልጋሎት</option>
                        </select>   
                  </div>
                </div>   
              <!-- <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="meseretawiwCodeadd">ኮድ መሰረታዊ ውዳበ <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                  <input type="text" id="meseretawiwCodeadd" name="meseretawiwCodeadd" required="required" class="form-control col-md-7 col-xs-12">
              </div>
            </div>        -->
        </form>
        
                    <div class="modal-footer">
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

	</div>
@endsection

	@section('scripts-extra')
	@include('layouts.partials.filter_js')
  <script >
 $(document).ready(function() {
        $('#table').DataTable({
            @include("layouts.partials.lang"),
            "order": []
        });
    });
        $('select[name="state"]').on('change', function() {
            var stateID = $(this).val();
				
        

               if(stateID) {
                $.ajax({
                    url: 'myform/ajax/'+stateID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {

                        
                        $('select[name="city"]').empty();
                        $('select[name="city"]').append('<option value="" selected disabled>~ወረዳ ምረፅ~</option>');
                        $.each(data, function(key, value) {
                            $('select[name="city"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                        if(update){
                            setIt('city1',stuff[2]);
                            $('#city1').change();
                        }

                    }
                });
            }else{
                $('select[name="city"]').empty();
            }
        });
		$('select[name="city"]').on('change', function() {
            var cityID = $(this).val();
				                

               if(cityID) {
                $.ajax({
                    url: 'myform2/ajax/'+cityID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {

                        
                        $('select[name="tabiatoadd"]').empty();
                        $('select[name="tabiatoadd"]').append('<option value="" selected disabled>~ጣብያ ምረፅ~</option>');
                        $.each(data, function(key, value) {
                            $('select[name="tabiatoadd"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                        if(update){
                            setIt('tabiaCode1',stuff[3]);
                            $('#tabiaCode1').change();
                            $('#myModal').modal('show');
                            update = false;
                        }

                    }
                });
            }else{
                $('select[name="tabiatoadd"]').empty();
            }
        });
    var row,stuff,update=false;
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
        stuff = [$(row[0]).html(),$(row[1]).val(),$(row[2]).val(),$(row[3]).html(),$(row[4]).html(),$(row[5]).html()];
        update=true;
        fillmodalData(stuff);
    });
    function setIt(id,value){
    $('#'+id+' option').each(function(){
         if($(this).html() == value){
            $(this).prop('selected',true);
         }
        });
    }
    function fillmodalData(details){
        setIt('state1',details[1]);
        $('#state1').change();
        $('#meseretawiWNameadd1').val(details[4]);
        $('#meseretawiWType1').val(details[5]);
    }
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
        // $('.dname').html(stuff[1]);
        $('#myModal').modal('show');
    });



    $('.modal-footer').on('click', '.edit', function() {
        $.ajax({
            type: 'post',
            url: 'editWidabe',
            data: {
                '_token': $('input[name=_token]').val(),				
                'tbid': $('#tabiaCode1').val(),             
                'wname': $('#meseretawiWNameadd1').val(),
                'wtype': $('#meseretawiWType1').val(),
                'wcode': stuff[0]
              
            },
			
            success: function(data) {
                if(data[0] == true){
                    $(row[1]).val($('#state1 option:selected').html());
                    $(row[2]).val($('#city1 option:selected').html());
                    $(row[3]).html($('#tabiaCode1 option:selected').html());
                    $(row[4]).html($('#meseretawiWNameadd1').val());
                    $(row[5]).html($('#meseretawiWType1').val());
                    $('#state1').prop('selectedIndex',0);
                    $('#city1').prop('selectedIndex',0);
                    $('#tabiaCode1').prop('selectedIndex',0);
                    $('#meseretawiWNameadd1').val('');
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
            url: 'addWidabe',			
            data: {
                '_token': $('input[name=_token]').val(),				
                'tbid': $('#tabiatoadd').val(),				
                'wname': $('#meseretawiWNameadd').val(),
                'wtype': $('#meseretawiWType').val()
            },
						
            success: function(data) {
                 if(data[0] == true){
                    var n_row = '<tr>'+
                    '<td>'+data[3]+'</td>'+
                    '<input type="hidden" value="'+$('#state option:selected').html()+'">'+
                    '<input type="hidden" value="'+$('#city option:selected').html()+'">'+
                    '<td>'+$('#tabiatoadd option:selected').html()+'</td>'+
                    '<td>'+$('#meseretawiWNameadd').val()+'</td>'+
                    '<td>'+$('#meseretawiWType').val()+'</td>'+
                    '<td>'+
                    '<button class="edit-modal btn btn-info"><span class="glyphicon glyphicon-edit"></span> ኣስተኻኽል</button>'+
                    ' <button class="delete-modal btn btn-danger"><span class="glyphicon glyphicon-trash"></span> ሰርዝ</button>'+
                    '</td>'+
                    '</tr>';
                    $($('tbody')[0]).append(n_row);
                    $('#state').prop('selectedIndex', 0);
                    $('#city').prop('selectedIndex', 0);
                    $('#tabiatoadd').prop('selectedIndex', 0);
                    $('#tabiaNameadd').val('');
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
            url: 'deleteWidabe',
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

