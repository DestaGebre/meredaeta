@extends('layouts.app')

@section('htmlheader_title')
      ስርርዕ መሰረታዊ ውዳበ
@endsection

@section('contentheader_title')
 ምሕደራ ስርርዕ መሰረታዊ ውዳበ
@endsection

@section('header-extra')
<style type="text/css">
  tr{
    cursor: pointer;
  }
</style>
@endsection
@section('main-content')
<body>
<div class="row">
        <!-- <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="form-group col-md-12 col-sm-12 col-xs-12">                          
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
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="form-group col-md-12 col-sm-12 col-xs-12">                          
                    <div class="col-md-6 col-sm-6 col-xs-6 hidden">    
                        <select name="tabiaID" id="tabiaID" class="form-control">
                          <option value="">~ጣብያ ምረፅ~</option>
                        </select>
                    </div>   
                    <div class="col-md-6 col-sm-6 col-xs-6">                            
                    </div>   
                </div>    
            </div>   -->
    </div>
<div class="box box-primary">
    <div class="box-header with-border">
        <?php
           $show_zone = $show_woreda = $hide_widabe = $hide_wahio = true;
        ?>
        @include('layouts.partials.filter_html', ['address' => 'rankmwidabe'])

        <div class="">
            {{ csrf_field() }}
            <div class="table-responsive text-center">
              <div class="pull-left">
                <form method="get" action="{{ URL('rankmwidabelist')}}">
                  <button class="btn btn-success"  style="margin-top: 5px;" data-info="">
                      ዝርዝር ይርኣዩ
                  </button>
                </form>
              </div>
              <div class="pull-right">
                  <button class="add-modal btn btn-success" style="margin-top: 5px;" data-info="">
                      <span class="glyphicon glyphicon-tick"></span> ስርርዕ መዝግብ
                  </button><br><br>
              </div>
                <table class="table table-borderless table-hover" id="table2">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select_all" value=""> ኩሎም ምረፅ<th>
                        <th class="text-center hidden">መ.ቑ</th>
                        <!-- <th class="text-center hidden">መ.ቑ ወረዳ</th> -->
                        <th class="text-center hidden">መ.ቑ ዞባ</th>
                        <th class="text-center">ኮድ መ.ውዳበ</th>                     
                        <th class="text-center">ሽም መ.ውዳበ</th>                                                                            
                        <th class="text-center">ሕሉፍ ስርርዕ ዓመት</th>  
                        <th class="text-center">ወቕቲ</th>
						<th class="text-center">ደረጃ</th>
                    </tr>
                </thead>
            <tbody>
                        @foreach ($data as $mywidabe)
                          <tr>
                            <th><input style="display: inline;" type="checkbox" class="checkbox" name="check[]" value="{{{ $mywidabe->widabeCode }}}"><th>
                            <input type="hidden" value="{{ $mywidabe->tabiaCode }}">
                            <td class="hidden">{{ $tabiadata[$mywidabe->tabiaCode] }}</td>  
                            <td class="hidden">{{ $woredadata[$tabiadata[$mywidabe->tabiaCode]] }}</td>  
                            <td>{{ $mywidabe->widabeCode }}</td>                                                      
                            <td>{{ $mywidabe->widabeName }}</td>                            
                            <td>{{ $collectionyear[$mywidabe->widabeCode] }}</td>     
                            <td>{{ $collectionhalf[$mywidabe->widabeCode] }}</td>
							<td>{{ $mywidabe->result }}</td>  
                          </tr>                       
                        @endforeach    
                    </tbody>
                </table>
            </div>
            {{ $data->links() }}
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
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="memeberID">መፍለይ ቑፅሪ መሰረታዊ ውዳበ<span class="required">（*）</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="memeberID" required="required" class="form-control col-md-7 col-xs-12" readonly>
                          </div>
                      </div>  
                      <input type="hidden" id="type" value="መሰረታዊ ውዳበ" class="form-control col-md-7 col-xs-12">
		              <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="year">ዓመት<span class="required"></span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="year" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div> 
                      <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-3" for="half">እዋን ገምጋም</label>
                        <div class="col-md-6 col-sm-6 col-xs-12" >
                          <select class="form-control" id="half" name="half">
                                  <option selected disabled>~እዋን ገምጋም~</option>
                                  <option>6 ወርሒ</option>
                                  <option>ዓመት</option>      
                          </select>
                        </div>
                      </div>
					  <div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-3" for="result">ውፅኢት ስርርዕ</label>
				<div class="col-md-6 col-sm-6 col-xs-12" >
				  <select class="form-control" id="result">
					<option selected disabled>~ውፅኢት ስርርዕ ይምረፁ~</option>
                    <option>ቅድሚት</option>
					<option>ማእኸላይ</option>
					<option>ድሕሪት</option>					
				  </select>
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
	</div>
   </div>
   </div>
  </div>
  </div>
	</body>
@endsection

	@section('scripts-extra')
    @include('layouts.partials.filter_js')
	<script>
 
 
     $(document).ready(function() {
      $('#table2').DataTable({
        @include('layouts.partials.lang'),
        "order": []
      });
        } );
     var rows = [];
     $(document).ready(function(){

        //select all checkboxes
        $('#select_all').change(function(){
          var status=this.checked;
          $('.checkbox').each(function(){
            this.checked=status;
          });
        });
        //
        $('.checkbox').change(function(){
          if(this.checked==false){
            $('#select_all')[0].checked=false;
          }

          if($('.checkbox:checked').length==$('.checkbox').length){
            $('#select_all')[0].checked=true;
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
            // $('#table2').DataTable().column(2).search('^'+stateID,true,false).draw();
     });

     $('select[name="woreda"]').on('change', function() {
            var stateID = $(this).val();

               if(stateID) {
                $.ajax({
                    url: 'myform2/ajax/'+stateID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {

                        
                        $('select[name="tabiaID"]').empty();
                        $('select[name="tabiaID"]').append('<option value="'+ " " +'" selected disabled>'+ "~ጣብያ ምረፅ~" +'</option>');
                        $.each(data, function(key, value) {
                            $('select[name="tabiaID"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });

                    }
                });
            }else{
                $('select[name="tabiaID"]').empty();
            }             
            // $('#table2').DataTable().column(1).search('^'+stateID,true,false).draw();
     });

     $('select[name="tabiaID"]').on('change', function() {
            var stateID = $(this).val();            
            $('#table2').DataTable().column(0).search('^'+stateID,true,false).draw();
     });



    $(document).on('click', '.edit-modal', function() {
        $('#footer_action_button').text(" Update");
        $('#footer_action_button').addClass('glyphicon-check');
        $('#footer_action_button').removeClass('glyphicon-trash');
        $('.actionBtn').addClass('btn-success');
        $('.actionBtn').removeClass('btn-danger');
        $('.actionBtn').removeClass('delete');
        $('.actionBtn').addClass('edit');
        $('.modal-title').text('Edit');
        $('.deleteContent').hide();
        $('.form-horizontal').show();
        var stuff = $(this).data('info').split(',');
        fillmodalData(stuff)
        $('#myModal').modal('show');
    });
    
    $(document).on('click', '.add-modal', function() {
       if($('.checkbox:checked').length==0){
            alert("ዝተመረፀ ነገር የለን!! በይዘኦም ይምረፁ");
      }else{
            $('#footer_action_button2').text(" ኣቕምጥ");
            $('#footer_action_button2').addClass('glyphicon-check');
            $('#footer_action_button2').removeClass('glyphicon-trash');
            $('.actionBtn').addClass('btn-success');
            $('.actionBtn').removeClass('btn-danger');
            $('.actionBtn').removeClass('delete');
            $('.actionBtn').addClass('add');
            $('.modal-title').text('ስርርዕ መሰረታዊ ውዳበ መመዝገቢ ቕጥዒ');
            $('.deleteContent').hide();
            $('.form-horizontal').show();

            var idVals=[];
            rows = [];

            $('.checkbox:checked').each(function(){
                // if(this.checked){
                  rows.push($(this).parent().parent().children()[6]);
                  var myVal=$(this).val();
                  idVals.push(myVal);            
                // }
            });

            $('#memeberID').val(JSON.stringify(idVals));        
            $('#myModaladd').modal('show');
      }  
    });
    $('.modal-footer').on('click', '.add', function() {
      $.ajax({
        type: 'post',
        url: 'storerankmwidabe',
        data: {
          '_token': $('input[name=_token]').val(),        
          'memeberID': $('#memeberID').val(),
          'type': $('#type').val(),
          'result': $('#result').val(),
          'year': $('#year').val(),
          'half': $('#half').val()
        },

        success: function(data) {      
           if(data[0] == true){
                rows.forEach(function(t){
                    t.innerHTML = $("#year").val();
                });
              $("#memeberID").val('');
              $("#year").val('');
              $("#half").prop('selectedIndex', 0);
              $("#result").prop('selectedIndex', 0);
              $('#myModaladd').modal('hide');
            }
            else{
              if(Array.isArray(data[2]))
                  data[2] = data[2].join('<br>');
            }
          
            toastr.clear();
            toastr[data[1]](data[2]);
            if(data[0] == true){
              // window.location.reload();
            }

        },
        error:function(xhr,err,exception){
            // alert(exception);
        }
      });
    });

    $(document).on('click', '.delete-modal', function() {
        $('#footer_action_button').text("Delete");
        $('#footer_action_button').removeClass('glyphicon-check');
        $('#footer_action_button').addClass('glyphicon-trash');
        $('.actionBtn').removeClass('btn-success');
        $('.actionBtn').addClass('btn-danger');
        $('.actionBtn').removeClass('edit');
        $('.actionBtn').addClass('delete');
        $('.modal-title').text('Delete');
        $('.deleteContent').show();
        $('.form-horizontal').hide();
        var stuff = $(this).data('info').split(',');
        
         
        $('.did').text(stuff[0]);
        
    
        $('.dname').html(stuff[1]);
        $('#myModal').modal('show');
    });

function fillmodalData(details){
     $('#fid').val(details[0]);
    $('#fname').val(details[1]);
    
}

    $('.modal-footer').on('click', '.edit', function() {
        $.ajax({
            type: 'post',
            url: 'zoneedit',
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
                $('.item' + data.zoneCode).replaceWith("<tr class='item" + data.zoneCode + "'> <td>" + data.zoneCode +
                        "</td><td>" + data.zoneName + "</td><td><button class='edit-modal btn btn-info' data-info='" + data.zoneCode+","+data.zoneName+"'><span class='glyphicon glyphicon-edit'></span> Edit</button> <button class='delete-modal btn btn-danger' data-info='" + data.zoneCode+","+data.zoneName+"' ><span class='glyphicon glyphicon-trash'></span> Delete</button></td></tr>");

                 }}
        });
    });
    $('.modal-footer').on('click', '.add', function() {
        $.ajax({
            type: 'post',
            url: 'zoneadd',
            data: {
                '_token': $('input[name=_token]').val(),                
                'fname': $('#fid2').val(),
                'lname': $('#fname2').val()
              
            },
            
            success: function(data) {
                 $('#products-list').append("<tr class='item" + data.zoneCode + "'> <td>" + data.zoneCode +
                        "</td><td>" + data.zoneName + "</td><td><button class='edit-modal btn btn-info' data-info='" + data.zoneCode+","+data.zoneName+"'><span class='glyphicon glyphicon-edit'></span> Edit</button> <button class='delete-modal btn btn-danger' data-info='" + data.zoneCode+","+data.zoneName+"' ><span class='glyphicon glyphicon-trash'></span> Delete</button></td></tr>");
               
            
                }
        });
    });
    $('.modal-footer').on('click', '.delete', function() {
        $.ajax({
            type: 'post',
            url: 'zonedelete',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('.did').text()
                
            },
            
            success: function(data) {
              
                 $('.item' + $('.did').text()).remove();
                 
                  
            }
        });
    });
    $(document).on('click', 'tbody tr', function() {
        var checkBox = $($(this).find('input')[0])
        checkBox.click();
    });
    $('tr').on('click', 'input[type="checkbox"]', function(e){
        e.stopPropagation();
    });
</script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css"></style>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
@endsection
