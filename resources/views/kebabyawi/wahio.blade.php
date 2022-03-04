@extends('layouts.app')

@section('htmlheader_title')
  ዋህዮ   
@endsection

@section('contentheader_title')
   ዋህዮ     
@endsection

@section('header-extra')
@endsection

@section('main-content')
    
           

<div>
<div class="box box-primary">
    <div class="box-header with-border">
      <?php
       $show_zone = $show_woreda = $hide_wahio = true;
      ?>
      @include('layouts.partials.filter_html', ['address' => 'wahio'])
    <div class="" style="height: 50px;">

           <button class="pull-right add-modal btn btn-success"
           data-info="">
           <span class="glyphicon glyphicon-plus"></span> ሓዱሽ መዝግብ
       </button>
    </div>
	<div class="">
        {{ csrf_field() }}
        <div class="table-responsive text-center">
            <table class="table table-borderless" id="table2">
                <thead>
                    <tr>                       
                        <th class="text-center">ዝርከበሉ መሰረታዊ ውዳበ</th>
                        <th class="text-center">ሽም ዋህዮ</th>
                        <th class="text-center">ዓይነት ዋህዮ</th>
                        <th class="text-center">ተግባር</th>
                    </tr>
                </thead>
            <tbody  id="products-list" name="products-list">
                @foreach($data as $item)
                <tr class="item{{$item->id}}" >
                    <input type="hidden" value="{{$item->id}}">
                    <input type="hidden" value="{{$item->wahiosmw->widabes->tabiatat->zonat->zoneName}}">
                    <input type="hidden" value="{{$item->wahiosmw->widabes->tabiatat->name}}">
                    <input type="hidden" value="{{$item->wahiosmw->widabes->tabiaName}}">
                    <td>{{$item->wahiosmw->widabeName}}</td>
                    <td>{{$item->wahioName}}</td>
                    <td>{{$item->type}}</td>
                    
                    <td><button class="edit-modal btn btn-info"
                            data-info="{{$item->id}},{{$item->wahioName}}">
                            <span class="glyphicon glyphicon-edit"></span> ኣስተኻኽል
                        </button>
                        <button class="delete-modal btn btn-danger"
                            data-info="{{$item->id}},{{$item->wahioName}}">
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
                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="woredaCode"> ሽም ዞባ <span class="required"></span>
          </label>
                <div class="col-md-6 col-sm-6 col-xs-6">    
                <select name="zoba" id="zoba1" class="form-control" >
                    <option value=""selected disabled>~ዞባ ምረፅ~</option>
                    @foreach ($zobadatas as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
                </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-3" for="woredaCode"> ሽም ወረዳ <span class="required"></span>
          </label>
                <div class="col-md-6 col-sm-6 col-xs-6">    
                <select name="woreda" id="woreda1" class="form-control">
        <option value="">~ወረዳ ምረፅ~</option>
                </select>
                </div>
            </div>
      <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-3" for="tabiaCode">ሽም ጣብያ <span class="required"></span>
          </label>
                <div class="col-md-6 col-sm-6 col-xs-6">    
                <select name="tabiatoadd" id="tabiatoadd1" class="form-control" >
        <option value=""selected disabled>~ጣብያ ምረፅ~</option>
                </select>
                </div>
            </div>
      
                  <div    class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-3" for="meseretawiwdabetoadd"> ሽም መሰረታዊ ውዳበ <span class="required"></span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-6">    
                        <select name="meseretawiwdabetoadd" id="meseretawiwdabetoadd1" class="form-control">
                            <option value=""selected disabled>~መሰረታዊ ውዳበ ምረፅ~</option>
                        </select>
                    </div>
                </div> 
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wahioNameadd"> ሽም ዋህዮ  <span class="required"></span>
                  </label>

                  <div class="col-md-6 col-sm-6 col-xs-6">
                      <input type="text" id="wahioNameadd1" name="wahioNameadd" required="required" class="form-control">
                  </div>
              </div> 
              <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wahioType1"> ዓይነት ዋህዮ  <span class="required"></span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <select class="form-control" name="wahioType"  id ="wahioType1">
                            <option value=""selected disabled>~ዓይነት ዋህዮ ምረፅ~</option>
                            <option>ሓረስታይ</option>
						    <option>ደቂ ኣንስትዮ</option>
                            <option>መንእሰይ</option>
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
          
          
              <p class="fname_error error text-center alert alert-danger hidden"></p>
              
              
              
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
                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="woredaCode"> ሽም ዞባ <span class="required"></span>
					</label>
                <div class="col-md-6 col-sm-6 col-xs-6">    
                <select name="zoba" id="zoba" class="form-control" >
                    <option value=""selected disabled>~ዞባ ምረፅ~</option>
                    @foreach ($zobadatas as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
                </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-3" for="woredaCode"> ሽም ወረዳ <span class="required"></span>
					</label>
                <div class="col-md-6 col-sm-6 col-xs-6">    
                <select name="woreda" id="woreda" class="form-control">
				<option value="">~ወረዳ ምረፅ~</option>
                </select>
                </div>
            </div>
			<div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-3" for="tabiaCode">ሽም ጣብያ <span class="required"></span>
					</label>
                <div class="col-md-6 col-sm-6 col-xs-6">    
                <select name="tabiatoadd" id="tabiatoadd" class="form-control" >
				<option value=""selected disabled>~ጣብያ ምረፅ~</option>
                </select>
                </div>
            </div>
      
                  <div    class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-3" for="meseretawiwdabetoadd"> ሽም መሰረታዊ ውዳበ <span class="required"></span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-6">    
                        <select name="meseretawiwdabetoadd" id="meseretawiwdabetoadd" class="form-control">
                            <option value=""selected disabled>~መሰረታዊ ውዳበ ምረፅ~</option>
                        </select>
                    </div>
                </div> 
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wahioNameadd"> ሽም ዋህዮ  <span class="required"></span>
                  </label>

                  <div class="col-md-6 col-sm-6 col-xs-6">
                      <input type="text" id="wahioNameadd" name="wahioNameadd" required="required" class="form-control">
                  </div>
              </div> 
              <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wahioType"> ዓይነት ዋህዮ  <span class="required"></span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <select class="form-control" name="wahioType"  id ="wahioType">
                            <option value=""selected disabled>~ዓይነት ዋህዮ ምረፅ~</option>
                           <option>ሓረስታይ</option>
						    <option>ደቂ ኣንስትዮ</option>
                            <option>መንእሰይ</option>
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
          
          
              <p class="fname_error error text-center alert alert-danger hidden"></p>
              
              
              
          </form>
			    </div>
				

					
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
	</div>
  @endsection
	@section('scripts-extra')
	@include('layouts.partials.filter_js')
  <script >
  $(document).ready(function() {
        $('#table2').DataTable({
            @include("layouts.partials.lang"),
            "order": []
        });
    });
 
        $('select[name="zoba"]').on('change', function() {
            var stateID = $(this).val();
				
        

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
                        if(update){
                            setIt('woreda1',stuff[2]);
                            $('#woreda1').change();
                        }
                    }
                });
            }else{
                $('select[name="woreda"]').empty();
            }
        });
		$('select[name="woreda"]').on('change', function() {
            var stateID = $(this).val();
				
        

               if(stateID) {
                $.ajax({
                    url: 'myform2/ajax/'+stateID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {

                        
                        $('select[name="tabiatoadd"]').empty();
						$('select[name="tabiatoadd"]').append('<option value="'+ " " +'" selected disabled>'+ "~ጣብያ ምረፅ~" +'</option>');
                        $.each(data, function(key, value) {
                            $('select[name="tabiatoadd"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                        if(update){
                            setIt('tabiatoadd1',stuff[3]);
                            $('#tabiatoadd1').change();
                        }
                    }
                });
            }else{
                $('select[name="tabiatoadd"]').empty();
            }
        });
		$('select[name="tabiatoadd"]').on('change', function() {
            var stateID = $(this).val();
            

               if(stateID) {
                $.ajax({
                    url: 'myform2/ajax/wahio/'+stateID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {

                        
                        $('select[name="meseretawiwdabetoadd"]').empty();
						$('select[name="meseretawiwdabetoadd"]').append('<option value="'+ " " +'" selected disabled >'+ "~መሰረታዊ ውዳበ ምረፅ~" +'</option>');
                        $.each(data, function(key, value) {
                            $('select[name="meseretawiwdabetoadd"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                        if(update){
                            setIt('meseretawiwdabetoadd1',stuff[4]);
                            $('#meseretawiwdabetoadd1').change();
                            $('#myModal').modal('show');
                            update = false;
                        }
                    }
                });
            }else{
                $('select[name="meseretawiwdabetoadd"]').empty();
            }
        });
		// $('select[name="meseretawiwdabetoadd"]').on('change', function() {
  //           var stateID = $(this).val();
            

  //              if(stateID) {
  //               $.ajax({
  //                   url: 'myform2/ajax/wahio/meseretawi'+stateID,
  //                   type: "GET",
  //                   dataType: "json",
  //                   success:function(data) {

                        
  //                       $('select[name="wahiotoadd"]').empty();
		// 				$('select[name="wahiotoadd"]').append('<option value="'+ " " +'">'+ "~ዋህዮ ምረፅ~" +'</option>');
  //                       $.each(data, function(key, value) {
  //                           $('select[name="wahiotoadd"]').append('<option value="'+ key +'">'+ value +'</option>');
  //                       });

  //                   }
  //               });
  //           }else{
  //               $('select[name="wahiotoadd"]').empty();
  //           }
  //       });
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
        stuff = [$(row[0]).val(),$(row[1]).val(),$(row[2]).val(),$(row[3]).val(),$(row[4]).html(),$(row[5]).html(),$(row[6]).html()];
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
      setIt('zoba1',details[1]);
      $('#zoba1').change();
      $('#wahioNameadd1').val(details[5]);
      $('#wahioType1').val(details[6]);
    }
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
        
         
        $('.did').text($(row[0]).val());
        // $('.dname').html(stuff[1]);
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
    $('.modal-footer').on('click', '.add', function() {        
        $.ajax({
            type: 'post',
            url: 'addWahio',          
            data: {
                '_token': $('input[name=_token]').val(),             
                'whname': $('#wahioNameadd').val(),
                'widabeCode': $('#meseretawiwdabetoadd').val(),
                'wtype': $('#wahioType').val(),
            },
                        
            success: function(data) {
              if(data[0] == true){
                    var n_row = '<tr>'+
                    '<input type="hidden" value=">'+data[3]+'">'+
                    '<input type="hidden" value="'+$('#zoba option:selected').html()+'">'+
                    '<input type="hidden" value="'+$('#woreda option:selected').html()+'">'+
                    '<input type="hidden" value="'+$('#tabiatoadd option:selected').html()+'">'+
                    '<td>'+$('#meseretawiwdabetoadd option:selected').html()+'</td>'+
                    '<td>'+$('#wahioNameadd').val()+'</td>'+
                    '<td>'+$('#wahioType').val()+'</td>'+
                    '<td>'+
                    '<button class="edit-modal btn btn-info"><span class="glyphicon glyphicon-edit"></span> ኣስተኻኽል</button>'+
                    ' <button class="delete-modal btn btn-danger"><span class="glyphicon glyphicon-trash"></span> ሰርዝ</button>'+
                    '</td>'+
                    '</tr>';
                    $($('tbody')[0]).append(n_row);
                    $('#zoba').prop('selectedIndex', 0);
                    $('#woreda').prop('selectedIndex', 0);
                    $('#tabiatoadd').prop('selectedIndex', 0);
                    $('#meseretawiwdabetoadd').prop('selectedIndex', 0);
                    $('#wahioNameadd').val('');
                    $('#myModaladd').modal('hide');
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
    $('.modal-footer').on('click', '.edit', function() {
        $.ajax({
            type: 'post',
            url: 'editWahio',
            data: {
                '_token': $('input[name=_token]').val(),
                'wcode': stuff[0],
                'whname': $('#wahioNameadd1').val(),
                'widabeCode': $('#meseretawiwdabetoadd1').val(),
                'wtype': $('#wahioType1').val(),
              
            },
      
            success: function(data) {
                if(data[0] == true){
                    $(row[1]).val($('#zoba1 option:selected').html());
                    $(row[2]).val($('#woreda1 option:selected').html());
                    $(row[3]).val($('#tabiatoadd1 option:selected').html());
                    $(row[4]).html($('#meseretawiwdabetoadd1 option:selected').html());
                    $(row[5]).html($('#wahioNameadd1').val());
                    $(row[6]).html($('#wahioType1').val());
                    $('#zoba1').prop('selectedIndex', 0);
                    $('#woreda1').prop('selectedIndex', 0);
                    $('#tabiatoadd1').prop('selectedIndex', 0);
                    $('#meseretawiwdabetoadd1').prop('selectedIndex', 0);
                    $('#wahioNameadd1').val('');
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
    $('.modal-footer').on('click', '.delete', function() {
        $.ajax({
            type: 'post',
            url: 'deleteWahio',
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


