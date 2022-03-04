
@extends('layouts.app')

@section('htmlheader_title')
ዝተመዝገቡ ናይ ታሕተዋይ ኣመራርሓ ኣባላት ህወሓት መምልኢ ማህደር
@endsection

@section('contentheader_title')
ናይ ታሕተዋይ ኣመራርሓ ኣባላት ህወሓት መምልኢ ማህደር
@endsection

@section('header-extra')
<style type="text/css">
    .form-control:read-only {
        background-color: #fff;
        cursor: default;
    }
    @media print {
      #print,.switchBtn {
        display: none;
      }
    }
</style>

@endsection
@section('main-content')
<body>
	<div class="box box-primary">
		<div class="box-header with-border">
			
			<div class="myTable">
                @include('layouts.partials.filter_html', ['address' => 'lowerleaderslist'])
				<div class="" style="height: 50px;">	
				  <form method="GET" action= "{{URL('lowleaderform')}}" class="form-inline">			
					<button  class="pull-right btn btn-info btn-md"><span class="glyphicon glyphicon-plus"></span> ሓዱሽ መዝግብ </button> 
				  </form>
				</div>
				<div class="table-responsive text-center">
					<table class="table table-borderless" id="table2">
						<thead>
							<tr>
								<th class="text-center">መ.ቑ</th>
								<th class="text-center">ሽም ኣባል</th>
								<th class="text-center">ፆታ</th>
								<th class="text-center">ዝተዋፈርሉ ስራሕ</th>
								<th class="text-center">ዘለዎ ሓላፍነት</th>								
								<th class="text-center">ዝተገምገመሉ ዓመት</th>								
								<th class="text-center">ተግባር</th>								
							</tr>					
						</thead>
						<tbody>
							@foreach ($data as $mydata)						  
							<tr>
								<td>{{ $mydata->hitsuyID }}</td>	
								<td>{{ $mydata->hitsuy->name }} {{ $mydata->hitsuy->fname }}</td>                          
								<td>{{ $mydata->hitsuy->gender }}</td>
								<td>{{ $mydata->hitsuy->occupation }}</td>
								<td>{{ $mydata->hitsuy->position }}</td>															
								<td>{{ $mydata->year }}</td>
								<td>
                                    <!-- <button class="show-detail btn btn-success" data-info="{{ $mydata->hitsuyID }},{{ $mydata->hitsuy->name }} {{ $mydata->hitsuy->fname }},{{ $mydata->hitsuy->gender }},{{ $mydata->hitsuy->occupation }},{{ $mydata->hitsuy->position }},{{ $zobadatas[$woredadata[$tabiadata[$mydata->hitsuy->tabiaID]]] }},{{ $woredaname[$tabiadata[$mydata->hitsuy->tabiaID]] }},{{ $tabianame[$mydata->hitsuy->tabiaID] }},{{ $mydata->model }},{{ $mydata->evaluation }},{{ $mydata->remark }},{{ $mydata->hitsuy->approvedhitsuy->membershipDate }}">
									<span class="glyphicon glyphicon-edit"></span>ዝርዝር ርኣይ</button> -->
                                    <a href="{{ url('lowleaderdetails') }}?id={{ str_replace('/', '_', $mydata->hitsuyID) }}&year={{$mydata->year}}&period={{$mydata->half}}" class="btn btn-success">ዝርዝር ርኣይ</a>
                                    <!-- <button class="-modal btn btn-danger" data-info="">
                                    <span class="glyphicon glyphicon-trash"></span>ሰርዝ</button> -->
									
								</td> 									
						   </tr>
							@endforeach
							</tbody>
						</table>
						</div>
                        {{ $data->links() }}
						</div>						
	

		
	<div id="myModalDelete" class="modal fade" role="dialog">
		 <div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"></h4>

				</div>
				<div class="modal-body">
					<form class="form-horizontal" role="form">
						
					</form>					
					<div class="modal-footer">
					<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
						<button type="button" class="btn actionBtn1" data-dismiss="modal">
							<span id="footer_action_button1" class='glyphicon'> </span>
						</button>
						<button type="button" class="btn btn-warning" data-dismiss="modal">
							<span class='glyphicon glyphicon-remove'></span> ዕፀው
						</button>
					</div>
				</div>
			</div>
		</div>
	</div><!-- Modal Delete -->
	<div id="myDetails" class="hidden">
		<!-- Button ይመለሱ -->
		<div class="pull-right">					  
			<button class="btn switchBtn btn-info"><span class="glyphicon glyphicon-arrow-up"></span></button> 				  
		</div>
		<form id="detail-form">
			<!-- Step 1 -->
		<div class="form-group col-sm-12 col-md-12">                     
            <label class="control-label col-md-1 col-sm-1" for="hitsuyID">መ.ቑ:</label>
            <div class="col-md-1 col-sm-1 col-xs-1">
                <input type="text" id="hitsuyID" name="hitsuyID" class="form-control" readonly>
            </div>
            <label class="control-label col-md-1 col-sm-1" for="fullName">ሙሉእ ሽም:</label>
            <div class="col-md-3 col-sm-3 col-xs-3">
                <input type="text" id="fullName" name="fullName" class="form-control" readonly>
            </div>
            <label class="control-label col-md-1 col-sm-1" for="gender">ፆታ:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="gender" name="gender" class="form-control" readonly>
            </div>
            <label class="control-label col-md-1 col-sm-1" for="occupation">ዘለዎ ሞያ:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="occupation" name="occupation" class="form-control" readonly>
            </div>          
        </div>
        <div class="form-group col-sm-12 col-md-12"> 
        	<label class="control-label col-md-1 col-sm-1" for="position">ዘለዎ ሓላፍነት:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="position" name="position" class="form-control" readonly>
            </div>
            <label class="control-label col-md-1 col-sm-1" for="zone">ዞባ:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="zone" name="zone" class="form-control" readonly>
            </div>
            <label class="control-label col-md-1 col-sm-1" for="woreda">ወረዳ:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="woreda" name="woreda" class="form-control" readonly>
            </div>
            <label class="control-label col-md-1 col-sm-1" for="tabia">ጣብያ/ቀበሌ:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="tabia" name="tabia" class="form-control" readonly>
            </div>
            
		</div>    
		<div class="form-group col-sm-12 col-md-12">
            <label class="control-label col-md-1 col-sm-1" for="position">ቤ/ፅሕፈት:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="position" name="position" class="form-control" readonly>
            </div>
            <label class="control-label col-md-1 col-sm-1" for="membershipDate">ናይ ኣባልነት ዘመን:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="membershipDate" name="membershipDate" class="form-control" readonly>
            </div>
        </div>    	
        <div class="form-group col-sm-12 col-md-12"> 
                        <label class="control-label" for="model">1 ዓይነት ኣባል ፤ </label>
                        <div class="col-sm-12 col-md-12">
                            <input type="text" class="form-control" id="model" name="model" required readonly>
                        </div><br/>
                        
                    </div>

                    <div class="form-group col-sm-12 col-md-12"> 
                        <label class="control-label" for="evaluation">2 ውፅኢት ገምጋም ፤</label>
                        <div class="col-sm-12 col-md-12">
                            <input type="text" class="form-control" id="evaluation" name="evaluation" required readonly>
                        </div><br/>
                        
                    </div>

                    
         

        <div class="form-group col-sm-12 col-md-12">                     
            <label class="control-label" for="remark">3. ናይ በዓል ዋና ሪኢቶን</label>
            <div class="col-sm-12 col-md-12">
                <textarea rows="4" class="form-control" id="remark" name="remark" required readonly></textarea>
            </div> 
        </div>
            <br/>
            <br/>
            <br/>
        <div class="col-sm-12 col-md-12"> 
            <label class="col-sm-2 col-md-12 control-label">ፌርማ:______________________</label>                                 
        
        </div>
        <br/>
            <br/>
            <br/>
         <div class="form-group col-sm-12 col-md-12">                    
        	<label class="control-label" >4. ነዚ ማህደር ዘረጋገፀ ውዳበ ሓላፊ:______________________________________________________________________ ፌርማ:____________________ ዕለት:________________</label><br/>            
        	  </div>
        <hr style="border:groove 1px #79D57E;"/>       
      </form>
      	 <div class="text-center">					  
			<button  id="print" class="btn printerBtn btn-info" onclick="window.print();return false;">Print </button> 				  
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
     });
    //
	$(document).on('click', '.show-detail', function() {

        $('#myDetails').removeClass('hidden');
        $('.myTable').addClass('hidden');        
        var stuff = $(this).data('info').split(',');
        fillmodalData(stuff)
                
    });
    $(document).on('click', '.switchBtn', function() {
    	$('#myDetails').addClass('hidden');
        $('.myTable').removeClass('hidden');        
                
    });

    function fillmodalData(details){
	    $('#hitsuyID').val(details[0]);
	    $('#fullName').val(details[1]);	  
	    $('#gender').val(details[2]);
	    $('#occupation').val(details[3]);
	    $('#position').val(details[4]);
	    $('#zone').val(details[5]);
	    $('#woreda').val(details[6]);
        $('#tabia').val(details[7]);
	    $('#model').val(details[8]);
	    $('#evaluation').val(details[9]);
	    $('#remark').val(details[10]);
	    $('#membershipDate').val(details[11]);	  
	}
    $(document).on('click', '.delete-modal', function() {
        $('#footer_action_button1').text("ታሕተዋይ ኣመራርሓ ካብ ኣባልነት ይሰረዝ");
        $('#footer_action_button1').addClass('glyphicon-check');
        $('#footer_action_button1').removeClass('glyphicon-trash');
        $('.actionBtn1').addClass('btn-success');
        $('.actionBtn1').removeClass('btn-danger');
        $('.actionBtn1').removeClass('edit');
        $('.actionBtn1').addClass('delete');
        $('.modal-title').text('ታሕተዋይ ኣመራርሓ ካብ ኣባልነት መሰረዚ ቕጥዒ');
        $('.deleteContent').hide();
        $('.form-horizontal').show();
        var stuff = $(this).data('info').split(',');
        fillmodalDelete(stuff)
        $('#myModalDelete').modal('show');
    });

    
    

</script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css"></style>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
@endsection

