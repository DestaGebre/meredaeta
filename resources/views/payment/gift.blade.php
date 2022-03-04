@extends('layouts.app')

@section('htmlheader_title')
    ውህብቶ
@endsection

@section('contentheader_title')
    ምሕደራ መረዳእታ ውህብቶ 
@endsection

@section('header-extra')
@endsection

@section('main-content')
<div class="box box-primary">
	<div class="myswitch pull-right">             
         <button class="btn switchBtn btn-info"><span class="glyphicon glyphicon-plus"></span> ሓዱሽ መዝግብ </button> 
     </div> 
     <div class="mytoggle hidden pull-right">           
      <button class="btn toggleBtn btn-info"><span class="glyphicon glyphicon-arrow-up"></span></button>          
    </div>

    <div id ="giftdiv" class="form-group hidden">
    <?php $cnt = (count($errors) > 0); ?>
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
      
         <form id="demo-form2" method="POST" action= "{{URL('gift')}}" data-parsley-validate class="form-horizontal form-label-left">
              {{ csrf_field() }}
            </br>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="donorId1">መፍለዪ ቑፅሪ ወሃቢ <span class="required">（*）</span>
            </label>                            
                <div class="col-md-6 col-sm-6 col-xs-6">    
                      <select name="donorId" id="donorId1" class="form-control" >
                          <option value=""selected disabled>~ለጋሲ ምረፅ~</option>
                          @foreach ($donordatas as $donorId => $donorName)
                              <option value="{{$donorId}}">{{$donorName}}</option>
                          @endforeach
                      </select>
                </div>

          </div>   
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="giftType1">ዓይነት ውህብቶ</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control" id="giftType1" name="giftType" required="required">
                <option selected disabled>~ምረፅ</option>
                <option>ተሽከርከርቲ</option>
                <option>ህንፃ</option>
                <option>ቀዋሚ ንብረት</option>
                 <option>ሃላቂ ኣቕሓ</option>
                <option>ጥረ ገንዘብ</option>                         
              </select>
            </div>
          </div>
          <div class="form-group">
             <label class="control-label col-md-3 col-sm-3 col-xs-12" for="purpose1">ዕላማ ውህብቶ<span class="required"></span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="purpose1" name="purpose" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div> 
         <div class="form-group">           
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="giftName1">ሽም ውህብቶ<span class="required"></span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="giftName1" name="giftName" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>  
       <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="valuation1">ግምት ውህብቶ<span class="required"></span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="valuation1" name="valuation" required="required" class="form-control col-md-7 col-xs-12">
            </div>
      </div>  
       <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-" for="status1">ኩነታት ውህብቶ<span class="required"></span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control" id="status1" name="status" required="required">
                <option selected disabled>~ምረፅ</option>
                <option>ቃል ዝተኣተወ</option>
                <option>ዝተወሃበ</option>                                   
              </select>
            </div>
      </div>
      <div class="form-group"> 
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="donationDate1">ዝተዋሃበሉ ዕለት<span class="required"></span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <input type="text" id="donationDate1" name="donationDate" required="required" class="form-control col-md-7 col-xs-12">
        </div>
      </div>
      
        <div class="ln_solid"></div>
      <div class="form-group">
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">                         
        
          <button type="submit" class="btn btn-success">መዝግብ</button>
        </div>
      </div>
</form>
</div>
  
  <div id="giftlist">
      <div class="col-sm-12">
      <div class="card-box table-responsive">
        <p class="text-muted font-13 m-b-30">
        </p>
		<div class="container ">
			{{ csrf_field() }}
			<div class="table-responsive text-center">
				<table class="table table-borderless" id="table2">
				<thead>
          <tr>
          <th class="text-center">ኮድ</th>
          <th class="text-center">ቁፅሪ ለጋሲ</th>
          <th class="text-center">ዓይነት ውህብቶ</th>
          <th class="text-center">ዕላማ ውህብቶ</th>
          <th class="text-center">ሽም ውህብቶ</th>
          <th class="text-center">ግምት ውህብቶ</th>
          <th class="text-center">ኩነታት ውህብቶ</th>  
          <th class="text-center">ዕለት ውህብቶ</th>
          <th class="text-center">ተግባር</th>        
          </tr>
        </thead>
        <tbody>
          @foreach ($data as $gift)
          <tr class="item{{$gift->id}}">
          <td>{{ $gift->id }}</td>
          <td>{{ $gift->donorId }} </td>
          <td>{{ $gift->giftType }} </td>
          <td>{{ $gift->purpose }} </td>
          <td>{{ $gift->giftName }} </td>
          <td>{{ $gift->valuation }} </td>
          <td>{{ $gift->status }} </td>
          <td>{{ App\DateConvert::toEthiopian(date('d/m/Y',strtotime($gift->donationDate))) }} </td>
          <td><button class="edit-modal btn btn-info" data-info="{{$gift->id}},{{$gift->donorId}},{{$gift->giftType}},{{$gift->purpose}},{{$gift->giftName}},{{$gift->valuation}},{{$gift->status}},{{$gift->donationDate}}">
                    <span class="glyphicon glyphicon-edit"></span>ኣመሓይሽ</button>
                    <button class="delete-modal btn btn-danger" data-info="{{$gift->id}},{{$gift->donorId}}">
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
								<input type="hidden" class="form-control" id="id">
							</div>
						</div>
                       
						<div class="form-group">
              <label class="control-label col-md-2 col-sm-3 col-xs-12" for="donorId">መፍለይ ቑፅሪ ለጋሲ<span class="required">（*）</span>
              </label>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <input type="text" id="donorId" name="donorId" required="required" readonly class="form-control col-md-7 col-xs-12">
               </div>
            </div> 
					  
						<div class="form-group">
            <label class="control-label col-md-2 col-sm-3 col-xs-12" for="giftType">ዓይነት ውህብቶ</label>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <select class="form-control" id="giftType" name="giftType" required="required">
                <option selected disabled>ምረፅ</option>
                <option>ተሽከርከርቲ</option>
                <option>ህንፃ</option>
                <option>ቀዋሚ ንብረት</option>
                 <option>ሃላቂ ኣቕሓ</option>
                <option>ጥረ ገንዘብ</option>                         
              </select>
            </div>
          </div>
					<div class="form-group">
             <label class="control-label col-md-2 col-sm-3 col-xs-12" for="purpose">ዕላማ ውህብቶ<span class="required"></span>
            </label>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <input type="text" id="purpose" name="purpose" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div> 
         <div class="form-group">           
            <label class="control-label col-md-2 col-sm-3 col-xs-12" for="giftName">ሽም ውህብቶ<span class="required"></span>
            </label>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <input type="text" id="giftName" name="giftName" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>  
       <div class="form-group">
            <label class="control-label col-md-2 col-sm-3 col-xs-12" for="valuation">ግምት ውህብቶ<span class="required"></span>
            </label>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <input type="text" id="valuation" name="valuation" required="required" class="form-control col-md-7 col-xs-12">
            </div>
      </div>  
       <div class="form-group">
            <label class="control-label col-md-2 col-sm-3 col-xs-" for="status">ኩነታት ውህብቶ<span class="required"></span>
            </label>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <select class="form-control" id="status" name="status" required="required">
                <option>ምረፅ</option>
                <option>ቃል ዝተኣተወ</option>
                <option>ዝተወሃበ</option>                                   
              </select>
            </div>
      </div>
      <div class="form-group"> 
        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="donationDate">ዝተዋሃበሉ ዕለት<span class="required"></span>
        </label>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <input type="text" id="donationDate" name="donationDate" required="required" class="form-control col-md-7 col-xs-12">
        </div>
      </div>					
					</form>

          <div class="deleteContent">
             <span class="dname"></span>ብትክክል ክጠፍአ ይድለ ድዩ ? <span class="hidden did"></span>
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
        } );
    $(document).on('click', '.switchBtn', function() {
      $('#giftlist').addClass('hidden');
      $('.myswitch').addClass('hidden');
        $('#giftdiv').removeClass('hidden');                 
        $('.mytoggle').removeClass('hidden');                 
    }); 
    $(document).on('click', '.toggleBtn', function() {
      $('.alert-danger').remove();
      $('#giftdiv').addClass('hidden');
      $('.mytoggle').addClass('hidden');
        $('#giftlist').removeClass('hidden');                 
        $('.myswitch').removeClass('hidden'); 
    });
    var row, stuff;
   $(document).on('click', '.delete-modal', function() {
        $('#footer_action_button').text("ሰርዝ");
        $('#footer_action_button').removeClass('glyphicon-check');
        $('#footer_action_button').addClass('glyphicon-trash');
        $('.actionBtn').removeClass('btn-success');
        $('.actionBtn').addClass('btn-danger');
        $('.actionBtn').removeClass('edit');
        $('.actionBtn').addClass('delete');
        $('.modal-title').text(' መሰረዚ ልገሳ');
        $('.deleteContent').show();
        $('.form-horizontal').hide();
        row = $($($(this).parent()).parent()).children();
         $('.did').text($(row[0]).html());
        $('#myModal').modal('show');
    });
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
        $('.modal-title').text('መስተኻኸሊ ለጋሲ');
        $('.deleteContent').hide();
        $('.searchContent').hide();
        $('.form-horizontal').show();
        row = $($($(this).parent()).parent()).children();
        stuff = [$(row[0]).html(),$(row[1]).html().trim(),$(row[2]).html().trim(),$(row[3]).html().trim(),$(row[4]).html().trim(),$(row[5]).html().trim(),$(row[6]).html().trim(),$(row[7]).html().trim()];
        fillmodalData(stuff)
        $('#myModal').modal('show');
    });

    function fillmodalData(details){
      $('#id').val(details[0]);  
      $('#donorId').val(details[1]);
      $('#giftType').val(details[2]);
      $('#purpose').val(details[3]);
      $('#giftName').val(details[4]);
      $('#valuation').val(details[5]);
      $('#status').val(details[6]);
      $('#donationDate').val(details[7]);
          
    }
    $('.modal-footer').on('click', '.edit', function() {
        $.ajax({
            type: 'post',
            url: 'editgift',
            data: {
                '_token': $('input[name=_token]').val(),     
                'id': $('#id').val(),
                'donorId': $('#id').val(),
                'giftType': $('#giftType').val(),
                'purpose': $('#purpose').val(),
                'giftName': $('#giftName').val(),
                'valuation': $('#valuation').val(),
                'status': $('#status').val(),
                'donationDate': $('#donationDate').val()               
              
            },
      
            success: function(data) {
               if(data[0] == true){

                    $(row[1]).html($("#donorId").val());
                    $(row[2]).html($("#giftType").val());
                    $(row[3]).html($("#purpose").val());
                    $(row[4]).html($("#giftName").val());
                    $(row[5]).html($("#valuation").val());
                    $(row[6]).html($("#status").val());
                    $(row[7]).html($("#donationDate").val());

                    $("#id").val('');
                    $("#donorId").val('');
                    $("#giftType").val('');
                    $("#purpose").val('');
                    $("#giftName").val('');
                    $("#valuation").val('');
                    $("#status").val('');
                    $("#donationDate").val('');

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
  
  $('.modal-footer').on('click', '.delete', function() {
        $.ajax({
            type: 'post',
            url: 'deletegift',
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
    $('#donationDate').calendarsPicker({calendar: $.calendars.instance('ethiopian')});
    $('#donationDate1').calendarsPicker({calendar: $.calendars.instance('ethiopian')});
</script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css"></style>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
@endsection
