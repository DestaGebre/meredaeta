
@extends('layouts.app')

@section('htmlheader_title')
ዝተመዝገቡ ናይ ሰብ ሞያ ኣባላት ህወሓት መምልኢ ማህደር
@endsection

@section('contentheader_title')
ዝተመዝገቡ ናይ ሰብ ሞያ ኣባላት ህወሓት መምልኢ ማህደር
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
	<div class="box box-primary">
	
		<div class="box-header with-border">
			<div class="pull-right">                      
            <a class="btn switchBtn btn-info" href="{{ url('expert#step-1') }}"><span class="glyphicon glyphicon-arrow-up"></span></a>
        </div>
			<div class="myTable">
                @include('layouts.partials.filter_html', ['address' => 'expertslist'])
				<div class="" style="height: 50px;">
				  <form method="GET" action= "{{URL('expertform')}}" class="form-inline">			
					<button  class="pull-right btn btn-info btn-md"><span class="glyphicon glyphicon-plus"></span> ሓዱሽ መዝግብ emo </button> 
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
                                    <!-- <button class="show-detail btn btn-success" data-info="{{ $mydata->hitsuyID }},{{ $mydata->hitsuy->name }} {{ $mydata->hitsuy->fname }},{{ $mydata->hitsuy->gender }},{{ $mydata->hitsuy->occupation }},{{ $mydata->hitsuy->position }},{{ $mydata->answer1 }},{{ $mydata->answer2 }},{{ $mydata->answer3 }},{{ $mydata->answer4 }},{{ $mydata->answer5 }},{{ $mydata->answer6 }},{{ $mydata->answer7 }},{{ $mydata->answer8 }},{{ $mydata->answer9 }},{{ $mydata->answer10 }},{{ $mydata->result1 }},{{ $mydata->result2 }},{{ $mydata->result3 }},{{ $mydata->result4 }},{{ $mydata->result5 }},{{ $mydata->result6 }},{{ $mydata->result7 }},{{ $mydata->result8 }},{{ $mydata->remark }},{{ $zobadatas[$woredadata[$tabiadata[$mydata->hitsuy->tabiaID]]] }},{{ $woredaname[$tabiadata[$mydata->hitsuy->tabiaID]] }},{{ $mydata->hitsuy->approvedHitsuy->membershipDate }}">
									<span class="glyphicon glyphicon-edit"></span>ዝርዝር ርኣይ</button> -->
                                    <a href="{{ url('expertdetails') }}?id={{ str_replace('/', '_', $mydata->hitsuyID) }}&year={{$mydata->year}}&period={{$mydata->half}}" class="btn btn-success">ዝርዝር ርኣይ</a>
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
            <label class="control-label col-md-1 col-sm-1" for="zone">ኣድራሻ ዞባ:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="zone" name="zone" class="form-control" readonly>
            </div>
            <label class="control-label col-md-1 col-sm-1" for="woreda">ወረዳ:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="woreda" name="woreda" class="form-control" readonly>
            </div>
            <label class="control-label col-md-1 col-sm-1" for="office">ቤ/ፅሕፈት:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="office" name="office" class="form-control" readonly>
            </div>
		</div>  
        <div class="form-group col-sm-12 col-md-12">
            <label class="control-label col-md-1 col-sm-1" for="membershipDate">ናይ ኣባልነት ዘመን:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="membershipDate" name="membershipDate" class="form-control" readonly>
            </div>
        </div>      	
        <div class="form-group col-sm-12 col-md-12"> 
                        <label class="control-label" for="answer1">1 ካብ ኣተሓሳስባን ተግባርን ክራይ ኣካብነት ንባዕልኻ ነፃ ኣብ ምኻንን ኣብ ካልኦት ንዝረኣዩ ፀገማት ብትረት ኣብ ምቅላስን ፤ </label>
                        <div class="col-sm-12 col-md-12">
                            <textarea rows="4" class="form-control" id="answer1" name="answer1" required readonly></textarea>
                        </div><br/>
                        <label class="col-sm-12 col-md-12 control-label" for="result1"></label>
                        <div class="col-sm-2 col-md-2">
                            <input class="form-control" id="result1" type="number" min="0" max="10" placeholder="ዝረኸቦ ውፅኢት ካብ 10" name="Result1"  required="required" readonly>
                        </div>
                    </div>

                    <div class="form-group col-sm-12 col-md-12"> 
                        <label class="control-label" for="answer2">2 ብቁዕ በዓል ሞያ ሰራሕተኛ ኣብ ምኻንን ውፅኢታዊ ስራሕ ኣብ ምስራሕን ፤ ካብቲ ዝርከብ ለውጢ ፍትሓዊ ብዝኾነ ኣብ ምጥቃምን ፤</label>
                        <div class="col-sm-12 col-md-12">
                            <textarea rows="4" class="form-control" id="answer2" name="Answer2" required readonly></textarea>
                        </div><br/>
                        <label class="col-sm-12 col-md-12 control-label" for="result2"></label>
                        <div class="col-sm-2 col-md-2">
                            <input class="form-control" id="result2" type="number" min="0" max="10" placeholder="ዝረኸቦ ውፅኢት ካብ 10" name="Result2"  required="required" readonly>
                        </div>
                    </div>

                    <div class="form-group col-sm-12 col-md-12">
                                        
                        <label class="control-label" for="answer3">3 ኣብ ዝተዋፈረሉ ዓውደ ስራሕ ጉብእኻ ኣብ ምፍፃምን መርኣያ ኮይንካ ኣብ ምስራሕን ምምራሕን ፤</label>
                        <div class="col-sm-12 col-md-12">
                            <textarea rows="4" class="form-control" id="answer3" name="Answer3" required readonly></textarea>
                        </div><br/>
                        <label class="col-sm-12 col-md-12 control-label" for="result3"></label>
                        <div class="col-sm-2 col-md-2">
                            <input class="form-control" id="result3" type="number" min="0" max="10" placeholder="ዝረኸቦ ውፅኢት ካብ 10" name="Result3"  required="required" readonly>
                        </div>
                    </div>

                    <div class="form-group col-sm-12 col-md-12">                     
                        <label class="col-sm-12 col-md-12 control-label" for="answer4">4 ሰናይ ምምሕዳር ኣብ ምርጋፅን ቁልጡፍን ፅሬትን ዘለዎ ግልጋሎት ኣብ ምሃብን ዘለዎ ኩነታት ፤</label>
                        <div class="col-sm-12 col-md-12">
                            <textarea rows="4" class="form-control" id="answer4" name="Answer4" required readonly></textarea>
                        </div><br/>
                        <label class="col-sm-12 col-md-12 control-label" for="result4"></label>
                        <div class="col-sm-2 col-md-2">
                            <input class="form-control" id="result4" type="number" min="0" max="10" placeholder="ዝረኸቦ ውፅኢት ካብ 10" name="Result4"  required="required" readonly>
                        </div>
                    </div>
        <!-- Step 2 -->
         <div class="form-group col-sm-12 col-md-12">                     
                        <label class="col-sm-12 col-md-12 control-label" for="answer5">5 ንልምዓትን ህንፀት ዲሞክራሲን ዘዐንቁፉ ድሑራት ኣተሓሳስባ ፊት ንፊት ብፅንዓት ኣብ ምቅላስን ፤</label>
                        <div class="col-sm-12 col-md-12">
                            <textarea rows="4" class="form-control" id="answer5" name="Answer5" required readonly></textarea>
                        </div><br/>
                        <label class="col-sm-12 col-md-12 control-label" for="result5"></label>
                        <div class="col-sm-2 col-md-2">
                            <input class="form-control" id="result5" type="number" min="0" max="10" placeholder="ዝረኸቦ ውፅኢት ካብ 10" name="Result5"  required="required" readonly>
                        </div>
                    </div>               
                   <div class="form-group col-sm-12 col-md-12">                     
                        <label class="control-label" for="answer6">6 ኣብ ዝተዋፈረሉ ቤት ፅሕፈት ወይ ቀበሌ ቅልጡፍን ኩለ መዳያዊ ለውጢ ንምምፃእ ዝመፁ ሓደሽቲ ቴክኖሎጂ ወይ እታወት ንባዕልኻ ኣብ ምእማንን ንኻልኦት ንምእማን ዘለዎ ዓቅምን ድልውነትን ፤</label>
                        <div class="col-sm-12 col-md-12">
                            <textarea rows="4" class="form-control" id="answer6" name="Answer6" required readonly></textarea>
                        </div><br/>
                        <label class="col-sm-12 col-md-12 control-label" for="result6"></label>
                        <div class="col-sm-2 col-md-2">
                            <input class="form-control" id="result6" type="number" min="0" max="10" placeholder="ዝረኸቦ ውፅኢት ካብ 10" name="Result6"  required="required" readonly>
                        </div>
                    </div>
                    <div class="form-group col-sm-12 col-md-12"> 
                        <label class="control-label" for="answer7">7 ሕግታትን ደንብታትን ውድብን መንግስትን ኣብ ምኽባርን ምትግባርን ዘለዎ ኩነታት ፤</label>
                        <div class="col-sm-12 col-md-12">
                            <textarea rows="4" class="form-control" id="answer7" name="Answer7" required readonly></textarea>
                        </div><br/>
                        <label class="col-sm-12 col-md-12 control-label" for="result7"></label>
                        <div class="col-sm-2 col-md-2">
                            <input class="form-control" id="result7" type="number" min="0" max="10" placeholder="ዝረኸቦ ውፅኢት ካብ 10" name="Result7"  required="required" readonly>
                        </div>
                    </div>
                    
                    <div class="form-group col-sm-12 col-md-12">                     
                        <label class="control-label" for="answer8">8 ብሕገ ደንቢ ውድብ ሓደሽቲ ኣባላት ብፅሬት ኣብ ምምልማልን ልኡኽ እናሃብካ ብቀፃልነት ኣብ ምህናፅን ፤</label>
                        <div class="col-sm-12 col-md-12">
                            <textarea rows="4" class="form-control" id="answer8" name="Answer8" required readonly></textarea>
                        </div><br/>
                        <label class="col-sm-12 col-md-12 control-label" for="result8"></label>
                        <div class="col-sm-2 col-md-2">
                            <input class="form-control" id="result8" type="number" min="0" max="10" placeholder="ዝረኸቦ ውፅኢት ካብ 10" name="Result8"  required="required" readonly>
                        </div>
                    </div> 

        
        <!-- Step 3 -->                   

                <div class="form-group col-sm-12 col-md-12">                     
                        <label class="control-label" for="answer9">9. መለለይ ጠንካራ ጎኒ</label>
                        <div class="col-sm-12 col-md-12">
                            <textarea rows="4" class="form-control" id="answer9" name="Answer9" required readonly></textarea>
                        </div>                        
                    </div>

                    <div class="form-group col-sm-12 col-md-12">                     
                        <label class="control-label" for="answer10">10. መለለይ ደካማ ጎኒ</label>
                        <div class="col-sm-12 col-md-12">
                            <textarea rows="4" class="form-control" id="answer10" name="Answer10" required readonly></textarea>
                        </div>                        
                    </div>

        <div class="form-group col-sm-12 col-md-12">                     
        	<label class="control-label" >11. ድምር ዝረኸቦ ማርኪ: (<span id="totalResult"></span>/100)</label><br/>            
        	<label class="control-label" >&nbsp &nbsp ድምር ሚዛን/ስርርዕ: <span id="totalWeight"></span></label>
        </div>

        <div class="form-group col-sm-12 col-md-12">                     
            <label class="control-label" for="remark">13. ናይ በዓል ዋና ሪኢቶን</label>
            <div class="col-sm-12 col-md-12">
                <textarea rows="4" class="form-control" id="remark" name="Remark" required readonly></textarea>
            </div>  
            <label class="col-sm-2 col-md-12 control-label">ፌርማ:______________________</label>                                 
        </div>
         <div class="form-group col-sm-12 col-md-12">                     
        	<label class="control-label" >14. ነዚ ማህደር ዘረጋገፀ ውዳበ ሓላፊ:_______________________________________ ፌርማ:____________________ ዕለት:________________</label><br/>            
        	  </div>
        <hr style="border:groove 1px #79D57E;"/>       
      </form>
      	 <div class="text-center">					  
			<button  id="print" class="btn printerBtn btn-info" onclick="window.print();return false;">Print</button> 				  
		</div>
	</div>
		
	 </div>
    </div>
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
	    $('#answer1').val(details[5]);
	    $('#answer2').val(details[6]);
	    $('#answer3').val(details[7]);
	    $('#answer4').val(details[8]);
	    $('#answer5').val(details[9]);
	    $('#answer6').val(details[10]);
	    $('#answer7').val(details[11]);
	    $('#answer8').val(details[12]);
	    $('#answer9').val(details[13]);
	    $('#answer10').val(details[14]);
	   // $('#answer11').val(details[15]);
	    //$('#answer12').val(details[16]);
	    //$('#answer13').val(details[17]);
	    //$('#answer14').val(details[18]);
	    //$('#answer15').val(details[19]);
	    //$('#answer16').val(details[20]);
	    $('#result1').val(details[15]);
	    $('#result2').val(details[16]);
	    $('#result3').val(details[17]);
	    $('#result4').val(details[18]);
	    $('#result5').val(details[19]);
	    $('#result6').val(details[20]);
	    $('#result7').val(details[21]);
	    $('#result8').val(details[22]);
	   // $('#result9').val(details[25]);
	    //$('#result10').val(details[26]);
	    //$('#result11').val(details[27]);
	    //$('#result12').val(details[28]);
	    //$('#result13').val(details[29]);
	   // $('#result14').val(details[30]);
	    $('#remark').val(details[23]);
        $('#zone').val(details[24]);
        $('#woreda').val(details[25]);	  
        $('#membershipDate').val(details[26]);    
	   
	    var sumtotal=parseInt(details[15])+parseInt(details[16])+parseInt(details[17])+parseInt(details[18])+parseInt(details[19])+parseInt(details[20])+parseInt(details[21])+parseInt(details[22]);
	    $('#totalResult').text(sumtotal);  
	}
    $(document).on('click', '.delete-modal', function() {
        $('#footer_action_button1').text("ሰብ ሞያ ካብ ኣባልነት ይሰረዝ");
        $('#footer_action_button1').addClass('glyphicon-check');
        $('#footer_action_button1').removeClass('glyphicon-trash');
        $('.actionBtn1').addClass('btn-success');
        $('.actionBtn1').removeClass('btn-danger');
        $('.actionBtn1').removeClass('edit');
        $('.actionBtn1').addClass('delete');
        $('.modal-title').text('ሰብ ሞያ ካብ ኣባልነት መሰረዚ ቕጥዒ');
        $('.deleteContent').hide();
        $('.form-horizontal').show();
        var stuff = $(this).data('info').split(',');
        fillmodalDelete(stuff)
        $('#myModalDelete').modal('show');
    });

    function fillmodalDelete(details){
	     $('#hitsuyID2').val(details[0]);
	    $('#fullName2').val(details[1]);
	    
	}
     
    $('.modal-footer').on('click', '.delete', function() {
        $.ajax({
            type: 'post',
            url: 'hitsuyreject',
            data: {
                '_token': $('input[name=_token]').val(),				
                'hitsuyID': $("#hitsuyID2").val(),
                'rejectionReason': $("#rejectionReason").val(),
                'rejectionDate': $('#rejectionDate').val()
				
            },
			
            success: function(data) {
			      document.getElementById("hitsuyID2").value="";
			      document.getElementById("fullName2").value="";
            	},

            error: function(xhr,errorType,exception){
            		
            			alert(exception);
                        
            }
        });
    });

</script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css"></style>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
@endsection

