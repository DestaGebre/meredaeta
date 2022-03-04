@extends('layouts.app')

@section('htmlheader_title')
     ስልጠና
@endsection

@section('contentheader_title')
    ምሕደራ ስልጠና
@endsection

@section('header-extra')
<style type="text/css">
  tr{
    cursor: pointer;
  }
</style>

@endsection
@section('main-content')
<form method="get" action="{{ url('training') }}">
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
            <div class="col-md-2 col-sm-4 col-xs-4">
                <select name="widabe" id="widabe_filter" class="form-control hide-print" >
                    <option value="" selected disabled>~መሰረታዊ ውዳበ ምረፅ~</option>
                    @foreach ($widabe_l as $key => $value)
                        <option value="{{ $key }}" 
                        @if ($widabe && $widabe->widabeCode == $key)
                            {{ 'selected' }}
                        @endif 
                        >{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-4">
                <select name="wahio" id="wahio_filter" class="form-control hide-print" >
                    <option value="" selected disabled>~ዋህዮ ምረፅ~</option>
                    @foreach ($wahio_l as $key => $value)
                        <option value="{{ $key }}" 
                        @if ($wahio && $wahio->id == $key)
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
        <div class="pull-right" style="padding-bottom: 10px;">
        <button class="add-modal btn btn-success"
          data-info="">
          <span class="glyphicon glyphicon-tick"></span> ስልጠና መዝግብ
        </button>
      </div>
        <table class="table table-borderless" id="table2">
          <thead>
            <tr>
              <th><input type="checkbox" id="select_all" value="">ኩሎም ምረፅ</th>
              <th class="text-center">መለለዪ ሕፁይ</th>
              <th class="text-center">ሽም ኣባል</th>
              <th class="text-center">ዝወሰዶ ስልጠና</th>
            </tr>
          </thead>
          <tbody  id="products-list" name="products-list">
            @foreach ($data as $mytraining)
                <tr>
                  <td><input style="display: inline;" type="checkbox" class="checkbox" name="check[]" value="{{{ $mytraining->hitsuyID }}}"></td>
                  <td>{{ $mytraining->hitsuyID }}</td>  
                  <td>{{ $mytraining->hitsuy->name }} {{ $mytraining->hitsuy->fname }} {{ $mytraining->hitsuy->gfname }}</td>
                 
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
                  <label for="trainingLevel" class="control-label col-md-3 col-sm-3 col-xs-">ዝወሰዶ ስልጠና <span class="required">（*）</span></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="trainingLevel" name="trainingLevel" class="form-control">
                      <option selected disabled>~ዝወሰዶ ስልጠና ምረፅ~</option>
                      <option>ጀማሪ ኣመራርሓ ስልጠና</option>                  
                      <option>ማእኸላይ ኣመራርሓ ስልጠና</option>
                      <option>ላዕለዋይ ኣመራርሓ ስልጠና</option>
                    </select>
                  </div>
                </div>
				<div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="trainer">ስልጠና ዝሃበ ትካል<span class="required">（*）</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="trainer" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>   	
                 <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="startDate">ስልጠና ዝጀመረሉ ዕለት<span class="required">（*）</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="startDate" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div> 			  
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="numDays">ጠቅላላ ናይ ስልጠና መዓልትታት    <span class="required">（*）</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="numDays" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>   		
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="trainingPlace">ናይ ስልጠና ቦታ    <span class="required"></span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="trainingPlace" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">መበገሲ ሓሳብ ዘቕረበ ኣካል     <span class="required"></span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>   
				<div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ርእይቶ ዝሃበ ኣካል    <span class="required"></span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div>   		
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ዘፅደቐ ኣካል <span class="required"></span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
                  </div>
                </div> 
				<label>ቕድሚ ምምዝጋቡ እዞም ዝስዕቡ ከም ዝተማለኡ አረጋግፅ</label>
                <p style="padding: 5px;">
                  <div class="checkbox1">
                  <label>
                  <input type="checkbox" id="zoneDecision" value="1" class="flat" /> ካብ ናይ ኣመራርሓ ስልጠና ወፃኢ ዘሎ መደብ ናይ ዞባ ውሳነ ቐሪቡ እዩ </label>
                  <br /></div>
                  <div class="checkbox1">
                  <label>
                  <input type="checkbox" id="woredaApproved" value="1" class="flat" />  ናይ ጀማሪ/ማእኸላይ/ላዕለዋይ ኣመራርሓ ስልጠና ኣብ ወረዳ ኮሚቴ/ዞባ ኮሚቴ/ቤት ፅሕፈት ህወሓት ቀሪቡ ፀዲቑ 
                  እዩ </label></div>
                  <br />
                  <div class="checkbox1">
                  <label>
                  <input type="checkbox" id="isDocumented" value="1" class="flat" /> እቲ ውልቀሰብ ነቲ ተገሊፁ ዘሎ ስልጠና ምውሳዱ ዘርእይ ኣድላይ መረዳእታ ቀሪቡ እዩ  </label></div> 							

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
            $('.modal-title').text('ትልሚ ውልቀ ሰብ መመዝገቢ ቕጥዒ');
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
			$('#membertype').val('');
			$('#trainingLevel').val('');
			$('#trainer').val('');
			$('#startDate').val('');
			$('#numDays').val('');
			$('#trainingPlace').val('');
			$('#zoneDecision').prop("checked", false);
			$('#woredaApproved').prop("checked", false);
			$('#isDocumented').prop("checked", false); 
            $('#myModaladd').modal('show');
			
      }  
    });
    $('.modal-footer').on('click', '.add', function() {
      $.ajax({
        type: 'post',
        url: 'training',
        data: {
          '_token': $('input[name=_token]').val(),        
          'memeberID': $('#memeberID').val(),
          'membertype': $('#membertype').val(),      
		  'trainingLevel': $('#trainingLevel').val(),
		  'trainer': $('#trainer').val(),
		  'startDate': $('#startDate').val(),
		  'numDays': $('#numDays').val(),
		  'trainingPlace': $('#trainingPlace').val(),
		  'zoneDecision': ($('#zoneDecision').prop("checked")?1:0),
		  'woredaApproved': ($('#woredaApproved').prop("checked")?1:0),
		  'isDocumented': ($('#isDocumented').prop("checked")?1:0)
        },

        success: function(data) {      
           if(data[0] == true){
              for(var i=0; i<checkedArray.length;i++){
                  var tr = $($(checkedArray[i]).parent()).parent();
                  var plan_last = $(tr.children()[3]).html();
                  $(checkedArray[i]).prop('checked', false);
                  
                  
              }
              $("#memeberID").val('');
              $('#membertype').val('');
			  $('#trainingLevel').val('');
			  $('#trainer').val('');
			  $('#startDate').val('');
			  $('#numDays').val('');
			  $('#trainingPlace').val('');
			  $('#zoneDecision').prop("checked", false);
			  $('#woredaApproved').prop("checked", false);
			  $('#isDocumented').prop("checked", false); 
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
  $('#widabe_filter').on('change', function() {
      var stateID = $(this).val();

         if(stateID) {
          $.ajax({
              url: 'myform2/ajax/wahio/meseretawi/'+stateID,
              type: "GET",
              dataType: "json",
              success:function(data) {

                  
                  $('#wahio_filter').empty();
                  $('#wahio_filter').append('<option value="'+ " " +'">'+ "~ዋህዮ ምረፅ~" +'</option>');
                  $.each(data, function(key, value) {
                      $('#wahio_filter').append('<option value="'+ key +'">'+ value +'</option>');
                  });

              },
              error: function(xhr,errorType,exception){                        
                alert(exception);                      
              }
          });
      }else{
          $('#wahio_filter').empty();
      }
  });
  $('#wahio_filter').on('change', function() {
      var stateID = $(this).val();

         if(stateID) {
          $.ajax({
              url: 'myform2/ajax/hitsuy/'+stateID,
              type: "GET",
              dataType: "json",
              success:function(data) {

                  
                  $('select[name="members"]').empty();
                  $('select[name="members"]').append('<option value="'+ " " +'">'+ "~ኣባል ምረፅ~" +'</option>');
                  $.each(data, function(key, value) {
                      $('select[name="members"]').append('<option value="'+ key +'">'+key+': '+value +'</option>');
                  });

              },
              error: function(xhr,errorType,exception){                        
                alert(exception);                      
              }
          });
      }else{
          $('#wahio_filter').empty();
      }
  });
</script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css"></style>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
@endsection
