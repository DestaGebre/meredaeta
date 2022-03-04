@extends('layouts.app')

@section('htmlheader_title')
      መዋጮ
@endsection

@section('contentheader_title')
 ዓይነት መዋጮ - {{$mwname}}
@endsection

@section('header-extra')
<style type="text/css">
  tr{
    cursor: pointer;
  }
</style>
@endsection
@section('main-content')

<div class="row">
  <div class="col-md-8 col-sm-8 col-xs-8">
        <form method="get" action="{{ url('mewachodetail') }}">
        @if (Auth::user()->usertype == 'admin')
            <div class="col-md-3 col-sm-4 col-xs-4">
                <input type="hidden" value="{{$mewachoid}}" name="mewacho" id="mewacho">
                <select name="zone" id="zone" class="form-control hide-print" >
                    <option value="" selected disabled>~ዞባ ምረፅ~</option>
                    <option value="0" 
                        @if ($zoneCode == '0')
                            {{ 'selected' }}
                        @endif 
                        >ኩሎም</option>
                    @foreach ($zobadatas as $key => $value)
                        <option value="{{ $key }}" 
                        @if ($zoneCode == $key)
                            {{ 'selected' }}
                        @endif 
                        >{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        @endif
        <button class="btn btn-success hide-print" type="submit">ኣርእይ</button>
    </form>
  </div>
            <form method="GET" action= "{{URL('mewacho')}}">                           
            <div class="col-md-4 col-sm-4 col-xs-4" style="padding-right:30px">    
                <button class="btn btn-info pull-right" style="" id="detailBtn" type="submit"> <span class='glyphicon glyphicon-chevron-left'> </span>ተመለስ </button>                                                
            </div>  
            </form>
    </div>    
<div class="box box-primary">
    <div class="box-header with-border">
        
        <div class=" ">
            {{ csrf_field() }}

            <div class="table-responsive text-center">
              <div class="pull-right" style="padding-bottom: 5px;">
                <button class="add-modal btn btn-success"
                    data-info="">
                    <span class="glyphicon glyphicon-tick"></span> መዋጮ መዝግብ
                </button><br><br>
            </div>
                <table class="table table-borderless table-hover" id="table2">
                <thead>
                    <tr>
                        <th colspan="2" class="text-center"><input type="checkbox" id="select_all" value=""> ኩሎም ምረፅ</th>
                        <th class="text-center">መ.ቑ</th>
                        <th class="text-center">ሽም ኣባል</th>
                        <th class="text-center">መሰረታዊ ውዳበ</th>
                        <th class="text-center">ዋህዮ</th>
                        <th class="text-center">ስራሕ ዘርፊ</th>
                        <th class="text-center">ክፍሊት መዋጮ</th>
                        <!-- <th class="text-center">ኹነታት</th> -->
                        <!-- <th class="text-center">ዓይነት መዋጮ</th> -->
                    </tr>
                </thead>
            <tbody>

                         @foreach ($data as $mymewacho)    
                           @foreach ($membertype as $occutype) 
                             @if($occutype==$mymewacho->hitsuy->occupation)
                              <tr>
                              @if (isset($collectionmewacho[$mymewacho->hitsuyID]))         
                                    <td>ዝተኸፈለ</td>
                                    <td></td>
                                    <!-- <td><input type="checkbox" class="checkbox" name="check[]" value="{{{ $mymewacho->hitsuyID }}}" data-othervalue="{{ $mewachoamount[$occutype] }}" onclick="return false" disabled="disabled" checked="checked"></td> -->
                                @else
                                    <td>ዘይተኸፈለ</td>
                                    <td><input type="checkbox" class="checkbox" name="check[]" value="{{{ $mymewacho->hitsuyID }}}" data-othervalue="{{ $mewachoamount[$occutype] }}"></td>
                                @endif     
                                <td>{{ $mymewacho->hitsuyID }}</td>  
                                <td>{{ $mymewacho->hitsuy->name }} {{ $mymewacho->hitsuy->fname }} {{ $mymewacho->hitsuy->gfname }}</td>                                                      
                                <td>{{ $mwidabedata[$mymewacho->assignedWudabe] }}</td>
                                <td>{{ $wahiodata[$mymewacho->assignedWahio] }}</td> 
                                <td>{{ $mymewacho->hitsuy->occupation }}</td>                             
                                <td>{{ $mewachoamount[$occutype] }}</td>                                                       
                              </tr>
                             @endif 
                          @endforeach 
                        @endforeach
                    </tbody>
                </table>
            </div>     
            {{ $data->links() }}       
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
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="memeberID">መፍለይ ቑፅሪ ኣባላት<span class="required">（*）</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="memeberID" required="required" class="form-control col-md-7 col-xs-12" readonly>
                          </div>
                      </div>  
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payday">ዝኸፈለሉ ዕለት<span class="required"></span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="payday" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-3">
                          <input type="text" id="myamount" required="required" class="form-control hidden">
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
     });
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
            $('#table2').DataTable().column(0).search('^'+stateID,true,false).draw();
        });
     $('select[name="woreda"]').on('change', function() {
            var stateID = $(this).val();
            $('#table2').DataTable().column(0).search('^[0-9]{2}'+stateID,true,false).draw();   
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

    var checkedArray = null;
    
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
            $('.modal-title').text('ወርሓዊ ክፍሊት መመዝገቢ ቕጥዒ');
            $('.deleteContent').hide();
            $('.form-horizontal').show();

            var idVals=[];
            var mewVals=[];
            checkedArray = [];

            $('.checkbox').each(function(){
                if(this.checked){
                  checkedArray.push(this);
                  var myVal=$(this).val();
                  var myTemp=$(this).attr('data-othervalue');
                  idVals.push(myVal);            
                  mewVals.push(myTemp);            
                }
            });

            $('#memeberID').val(JSON.stringify(idVals));        
            $('#myamount').val(JSON.stringify(mewVals));  
            $('#myModaladd').modal('show');
      }  
    });
    $('.modal-footer').on('click', '.add', function() {       
      $.ajax({
        type: 'post',
        url: 'storemewacho',
        data: {
          '_token': $('input[name=_token]').val(),        
          'memeberID': $('#memeberID').val(),
          'mewacho': $('#mewacho').val(),
          'amount': $('#myamount').val(),
          'payday': $('#payday').val()
        },

        success: function(data) {      
           if(data[0] == true){
              $("#memeberID").val('');
              $("#yearly").val('');
              for(var i=0; i<checkedArray.length;i++){
                  var tr = $($(checkedArray[i]).parent()).parent();
                  $(tr.children()[0]).html('ዝተኸፈለ');
                  $(tr.children()[1]).html('<td></td>');
              }
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
            alert(exception);
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
    $('#payday').calendarsPicker({calendar: $.calendars.instance('ethiopian')});
</script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css"></style>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
@endsection
