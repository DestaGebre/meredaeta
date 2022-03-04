@extends('layouts.app')

@section('htmlheader_title')
    ውህብቶ
@endsection

@section('contentheader_title')
    ወርሓዊ ክፍሊት ሪፖርት 
@endsection

@section('header-extra')
@endsection

@section('main-content')


<body OnLoad="myFunction()">
<div class="box box-primary">
	


</div>
  
  <div id="giftlist">
      <div class="col-sm-12">
      <div class="card-box table-responsive">
        <p class="text-muted font-13 m-b-30">
        </p>
		<div class="container ">
			{{ csrf_field() }}
			<div class="table-responsive text-center">
				<table border="1" width="100%" cellpadding="2"  >
  <thead>
  <tr>
    <th rowspan="2"> ተ.ቁ</th>
    <th rowspan="2"> መሰረታዊ ውዳበ</th>
    <th rowspan="2">ዓይነት ኣባላት</th>
    <th rowspan="2"> በዝሒ ኣባላት</th>
    <th  rowspan="2" > ዝኸፈሉ</th>
    <th rowspan="2"> ዘይኸፈሉ</th>
    <th colspan="2"> ድምር ክፍሊት</th>
    <th rowspan="2"> ዘይተኸፈለ መጠን</th>
    <th  rowspan="2"> ሪኢቶ</th>
  </tr>
  
  <tbody>
    <?php $i = 1; ?> <?php $s = " "; ?>
  @foreach($Tabias as $key => $tabia)
<tr >
      <td ><?php echo $i; ?></td>
      <td ><?php echo $tabia->name.$s.$tabia->fname.$s.$tabia->gfname ?></td>
      <td >{{$tabia->gender}}</td>
      <td ><?php $from = new DateTime($tabia->dob); $to= new DateTime('today'); echo $from->diff($to)->y;?></td>
      <td >{{$tabia->position}}</td>
      <td >{{$tabia->tabiaID}}</td>
      <td ></td>
      <td ></td>
      <td ></td>
      <td></td>
  </tr>
    <?php $i++; ?>
  @endforeach 
  <tr >
      <th colspan="3">ጠቕላላ</th>
      <td ></td>
      <td ></td>
      <td ></td>
      <td ></td>
      <td ></td>
      <td></td>
      <td></td>
     
  </tr>
  </tbody>
</table>
</br>
<div>
      <a href="{{ route('HtmlToPDF') }}" class="btn btn-primary">Download in PDF</a>
  </div>
</br>
			</div>
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
            <button type="button" class="btn actionBtn" data-dismiss="modal">
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
                 
  </body>   
@endsection


	@section('scripts-extra')
	<script>
 
 
	 $(document).ready(function() {
      $('#table2').DataTable();
        } );
    $(document).on('click', '.switchBtn', function() {
      $('#giftlist').addClass('hidden');
      $('.myswitch').addClass('hidden');
        $('#giftdiv').removeClass('hidden');                 
        $('.mytoggle').removeClass('hidden');                 
    }); 
    $(document).on('click', '.toggleBtn', function() {
      $('#giftdiv').addClass('hidden');
      $('.mytoggle').addClass('hidden');
        $('#giftlist').removeClass('hidden');                 
        $('.myswitch').removeClass('hidden'); 
    });
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
        var stuff = $(this).data('info').split(',');          
         $('.did').text(stuff[0]);   
        $('.dname').html(stuff[1]);
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
        var stuff = $(this).data('info').split(',');
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
            url: '/editgift',
            data: {
                '_token': $('input[name=_token]').val(),        
                'donorId': $('#id').val(),
                'giftType': $('#giftType').val(),
                'purpose': $('#purpose').val(),
                'giftName': $('#giftName').val(),
                'valuation': $('#valuation').val(),
                'status': $('#status').val(),
                'donationDate': $('#donationDate').val()               
              
            },
      
            success: function(data) {
               //$('.item' + data.id).replaceWith("<tr class='item" + data.id + "'> <td>" + data.id +
                      //"</td><td>" + data.donorId + "</td><td>" + data.giftType + "</td><td>" + data.purpose + "</td><td>" + data.giftName + "</td><td>" + data.valuation + "</td><td>" + data.status + "</td><td>" + data.donationDate + "</td><td><button class='edit-modal btn btn-info' data-info='" + data.id+","+data.donorId+","+data.giftType+","+data.purpose+","data.giftName+","+data.valuation+","data.status+","+data.donationDate"'><span class='glyphicon glyphicon-edit'></span> Edit</button> <button class='delete-modal btn btn-danger' data-info='" + data.id+","+data.donorId+"' ><span class='glyphicon glyphicon-trash'></span> Delete</button></td></tr>");
                
                document.getElementById("id").value="";
                document.getElementById("donorId").value="";
            document.getElementById("giftType").value="";
            document.getElementById("purpose").value="";
            document.getElementById("giftName").value="";
            document.getElementById("valuation").value="";
            document.getElementById("status").value="";
            document.getElementById("donationDate").value="";          
               },

            error: function(xhr,errorType,exception){
                
                  alert(exception);
                        
            }
        });
    });
  
  $('.modal-footer').on('click', '.delete', function() {
        $.ajax({
            type: 'post',
            url: '/deletegift',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('.did').text()
        
            },
      
            success: function(data) {
              
         $('.item' + $('.did').text()).remove();
         
          
            }
        });
    });
</script>
<link href="css/bootstrap.min.css" rel="stylesheet">   
<script src="js/jquery.min.js"></script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css"></style>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
@endsection
