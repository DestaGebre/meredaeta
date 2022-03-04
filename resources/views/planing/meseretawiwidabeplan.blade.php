@extends('layouts.app')

@section('htmlheader_title')
      ትልሚ መሰረታዊ ውዳበ
@endsection

@section('contentheader_title')
    ትልሚ መሰረታዊ ውዳበ
@endsection

@section('header-extra')
<style type="text/css">
  tr{
    cursor: pointer;
  }
</style>

@endsection
@section('main-content')
<form method="get" action="{{ url('meseretawiwidabeplan') }}">
        @if (Auth::user()->usertype == 'admin')
            <div class="col-md-2 col-sm-4 col-xs-4">
                <select name="zone" id="zone_filter" class="form-control hide-print" >
                    <option value="" selected disabled>~ዞባ ምረፅ~</option>
                    <!-- <option value="0" 
                        @if ($zoneCode == '0')
                            {{ 'selected' }}
                        @endif 
                        >ኩሎም</option> -->
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
        @if(array_search(Auth::user()->usertype, ['admin', 'zone','zoneadmin']) !== false)
            <div class="col-md-2 col-sm-4 col-xs-4">
                <select name="woreda" id="woreda_filter" class="form-control hide-print" >
                    <option value="" selected disabled>~ወረዳ ምረፅ~</option>
                    @foreach ($woreda_l as $key => $value)
                        <option value="{{ $key }}" 
                        @if ($woreda && $woreda->woredacode == $key)
                            {{ 'selected' }}
                        @endif 
                        >{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        @endif
            <div class="col-md-2 col-sm-4 col-xs-4">
                <select name="tabia" id="tabia_filter" class="form-control hide-print" >
                    <option value="" selected disabled>~ጣብያ ምረፅ~</option>
                    @foreach ($tabia_l as $key => $value)
                        <option value="{{ $key }}" 
                        @if ($tabia && $tabia->tabiaCode == $key)
                            {{ 'selected' }}
                        @endif 
                        >{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        <button class="btn btn-success hide-print" type="submit">ኣርእይ</button>
    </form><br><br>
<div class="box box-primary">
  <div class="box-header with-border">
    
    <div class="">
      {{ csrf_field() }}
      <div class="table-responsive text-center">
        <div class="pull-left">
          <form method="get" action="{{ URL('meseretawiwidabeplanlist')}}">
            <button class="btn btn-success"  style="margin-top: 5px;" data-info="">
                ዝርዝር ይርኣዩ
            </button>
          </form>
        </div>
        <div class="pull-right" style="padding-bottom: 10px;">
        <button class="add-modal btn btn-success"
          data-info="">
          <span class="glyphicon glyphicon-tick"></span>ትልሚ መዝግብ
        </button>
      </div>
        <table class="table table-borderless" id="table2">
          <thead>
            <tr>
              <th><input type="checkbox" id="select_all" value="">ኩሎም ምረፅ</th>
              <th class="text-center">ኮድ መሰረታዊ ውዳበ</th>
              <th class="text-center">ሽም ኣባል</th>
              <th class="text-center">መጨረሻ ትልሚ ዝተለመሉ ዓመት</th>
            </tr>
          </thead>
          <tbody  id="products-list" name="products-list">
            @foreach ($data as $myindividual)
                <tr>
                  <td><input style="display: inline;" type="checkbox" class="checkbox" name="check[]" value="{{{ $myindividual->widabeCode }}}"></td>
                  <td>{{ $myindividual->widabeCode }}</td>  
                  <td>{{ $myindividual->widabeName }}</td>
                  <td>{{ $collectionyear[$myindividual->widabeCode] }}</td>
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
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="memeberID">መፍለይ ቑፅሪ ኣባላት  <span class="required">（*）</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="memeberID" required="required" class="form-control col-md-7 col-xs-12" readonly>
                      </div>
                    </div>
                  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="yearly">ዓመት<span class="required"></span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="yearly" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                  </div>
                  <!-- <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="quarter">ሪብዒ ዓመት:<span class="required"></span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select id="quarter" required="required" class="form-control col-md-7 col-xs-12">
                            <option value="" selected disabled>~ምረፅ~</option>
                            <option>3 ወርሒ</option>
                            <option>6 ወርሒ</option>
                            <option>9 ወርሒ</option>
                            <option>ዓመት</option>
                          </select>
                        </div>
                  </div> --> 
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
@endsection

  @section('scripts-extra')
  <script>
 
 
   $(document).ready(function() {
      $('#table2').DataTable({
    @include('layouts.partials.lang'),
    "order": []
  });
        } );
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
            // $('#table2').DataTable().column(0).search('^'+stateID,true,false).draw();
        });
     $('select[name="woreda"]').on('change', function() {
            var stateID = $(this).val();
            // $('#table2').DataTable().column(0).search('^[0-9]{2}'+stateID,true,false).draw();   
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
            toastr.clear();
            toastr.warning("ዝተመረፀ ነገር የለን!! በይዘኦም ይምረፁ");
      }else{
            $('#footer_action_button2').text(" ኣቕምጥ");
            $('#footer_action_button2').addClass('glyphicon-check');
            $('#footer_action_button2').removeClass('glyphicon-trash');
            $('.actionBtn').addClass('btn-success');
            $('.actionBtn').removeClass('btn-danger');
            $('.actionBtn').removeClass('delete');
            $('.actionBtn').addClass('add');
            $('.modal-title').text('ዓመታዊ ክፍሊት መመዝገቢ ቕጥዒ');
            $('.deleteContent').hide();
            $('.form-horizontal').show();

            var idVals=[];
            checkedArray = [];

            $('.checkbox').each(function(){
                if(this.checked){
                  checkedArray.push(this);
                  var myVal=$(this).val();
                  idVals.push(myVal);
                }
            });

            $('#memeberID').val(JSON.stringify(idVals));        
            $('#myModaladd').modal('show');
      }  
    });
    var quarter_list = ['3 ወርሒ', '6 ወርሒ', '9 ወርሒ', 'ዓመት'];
    $('.modal-footer').on('click', '.add', function() {
      $.ajax({
        type: 'post',
        url: 'meseretawiwidabeplan',
        data: {
          '_token': $('input[name=_token]').val(),        
          'memeberID': $('#memeberID').val(),
          'year': $('#yearly').val()
          //'quarter': $('#quarter').val()
        },

        success: function(data) {      
           if(data[0] == true){
            for(var i=0; i<checkedArray.length;i++){
                var tr = $($(checkedArray[i]).parent()).parent();
                var plan_last = $(tr.children()[3]).html();
                $(checkedArray[i]).prop('checked', false);
                if(!plan_last){
                  $(tr.children()[3]).html($("#yearly").val()); //+ '(' + $("#quarter").val() + ')');
                  continue;
                }
                var last = [plan_last.slice(0,plan_last.indexOf('(')), plan_last.slice(plan_last.indexOf('(')+1, -1)];
                if(last[0] > $("#yearly").val()){
                  $(tr.children()[3]).html($("#yearly").val());// + '(' + $("#quarter").val() + ')');
                }
                else if(last[0] == $("#yearly").val()){
                  if(quarter_list.indexOf($('#quarter').val()) > quarter_list.indexOf(last[1])){
                    $(tr.children()[3]).html($("#yearly").val());// + '(' + $("#quarter").val() + ')');   
                  }

                }
            }
            $("#memeberID").val('');
            $("#yearly").val('');
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
    
    $(document).on('click', 'tbody tr', function() {
      var checkBox = $($(this).find('input')[0])
      checkBox.click();
    });
    $('tr').on('click', 'input[type="checkbox"]', function(e){
      e.stopPropagation();
    });
    $('#zone_filter').on('change', function() {
      var stateID = $(this).val();                

         if(stateID) {
          $.ajax({
              url: 'myform/ajax/'+stateID,
              type: "GET",
              dataType: "json",
              success:function(data) {

                  
                  $('#woreda_filter').empty();
                  $('#woreda_filter').append('<option value="'+ " " +'" selected disabled>'+ "~ወረዳ ምረፅ~" +'</option>');
                  $.each(data, function(key, value) {
                      $('#woreda_filter').append('<option value="'+ key +'">'+ value +'</option>');
                  });

              }
          });
      }else{
          $('#woreda_filter').empty();
      }
  });
  $('#woreda_filter').on('change', function() {
      var stateID = $(this).val();
          


         if(stateID) {
          $.ajax({
              url: 'myform2/ajax/'+stateID,
              type: "GET",
              dataType: "json",
              success:function(data) {

                  
                  $('#tabia_filter').empty();
                  $('#tabia_filter').append('<option value="'+ " " +'" selected disabled>'+ "~ጣብያ ምረፅ~" +'</option>');
                  $.each(data, function(key, value) {
                      $('#tabia_filter').append('<option value="'+ key +'">'+ value +'</option>');
                  });

              }
          });
      }else{
          $('#tabia_filter').empty();
      }
  });
  $('#tabia_filter').on('change', function() {
      var stateID = $(this).val();
      

         if(stateID) {
          $.ajax({
              url: 'myform2/ajax/wahio/'+stateID,
              type: "GET",
              dataType: "json",
              success:function(data) {

                  
                  $('#widabe_filter').empty();
                  $('#widabe_filter').append('<option value="'+ " " +'" selected disabled >'+ "~መሰረታዊ ውዳበ ምረፅ~" +'</option>');
                  $.each(data, function(key, value) {
                      $('#widabe_filter').append('<option value="'+ key +'">'+ value +'</option>');
                  });

              }
          });
      }else{
          $('#widabe_filter').empty();
      }
  });
</script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css"></style>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
@endsection
