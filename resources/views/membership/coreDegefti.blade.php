@extends('layouts.app')

@section('htmlheader_title')
    ቀወምቲ ደገፍቲ
@endsection

@section('contentheader_title')
  ምዝገባ መረዳእታ ቀወምቲ ደገፍቲ
@endsection

@section('header-extra')

@endsection

@section('main-content')
<div class="box">
<div id="myTabContent" class="main_container" style="padding-bottom: 10px;">
<?php $cnt = (count($errors) > 0); ?>
   <form id="profile-form" method="POST" action= "{{URL('coreDegefti')}}" data-parsley-validate class="form-horizontal form-label-left">
	<div class="col-md-6">	 
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">ውልቃዊ መረዳእታ</h3>			  
			</div>
			<div class="box-body">		
				@if (count($errors) > 0)
					<div class="alert alert-danger">
						@foreach ($errors->all() as $error)
						<p>{!! $error !!}</p>
						@endforeach
					</div>
					@endif			 			
						{{ csrf_field() }}
							
						   <div class="form-group">
								 <label class="col-md-2 control-label" for="name" >ሽም ደጋፊ</label>
								 <div class="col-md-4">
								 <input id="name" name="name" type="text" placeholder="" class="form-control" required="" value="{{ $cnt ? Request::old('name') : '' }}"></div>

								 <label class="col-md-2 control-label" for="fname">ሽም ኣቦ</label>
								 <div class="col-md-4">
								 <input id="fname" name="fname" type="text" placeholder="" class="form-control" required value="{{ $cnt ? Request::old('fname') : '' }}"></div>
						   </div>		  
							<div class="form-group">
								<label class="col-md-2 control-label" for="gfname">ሽም ኣባሕጎ</label>
								<div class="col-md-4">
									<input id="gfname" name="gfname" type="text" placeholder="" class="form-control" required value="{{ $cnt ? Request::old('gfname') : '' }}"></div>

									<label class="control-label col-md-2 col5sm-2 col-xs-12">ፆታ</label>
									<div class="col-md-4 col-sm-7 col-xs-12">							
                                <label  class="radio-inline">
                                <input type="radio" name="gender" id="male" value="ተባ" checked="checked" required>ተባ</label>
                                <label  class="radio-inline">
                                <input type="radio" name="gender" id="female" value="ኣን" required>ኣን</label>

							</div>
						</div>
							<div class="form-group">
							<label class="col-md-2 control-label" for="birthPlace">ትውልዲ ቦታ</label>
							<div class="col-md-4">
								<input id="birthPlace" name="birthPlace" type="text" placeholder="" class="form-control" value="{{ $cnt ? Request::old('birthPlace') : '' }}"></div>

								<label class="col-md-2 control-label" for="dob">ዕለት ትውልዲ</label>
								<div class="col-md-4">
									<input id="dob" name="dob" type="text" placeholder="" class="form-control" value="{{ $cnt ? Request::old('dob') : '' }}"></div>
								</div>
							  <div class="form-group">
									<label class="control-label col-sm-2" for="position">ደረጃ ትምህርቲ:<span class="text-danger">*</span></label>
									<div class="col-sm-4">

									 <select class="form-control" name="position" required="required">
									   <option selected disabled>~ምረፅ~</option>
									   <option >ዘይጀመረ</option>
									   <option >1-4</option>
									   <option >5-8</option>
									   <option >9-10</option>
									   <option >ዲፕሎማ</option>
									   <option >ዲግሪን ሊዕሊኡን</option>
									   </select>
									</div>	
							   
								 <label class="col-md-2 control-label" for="occupation">ማሕበራዊ መሰረት</label>
								 <div class="col-md-4">
								 <input id="occupation" name="occupation" type="text" placeholder="" class="form-control" value="{{ $cnt ? Request::old('occupation') : '' }}"></div>
							  </div>
							  <div class="form-group">
									<label class="col-md-2 control-label" for="coreDegafiregDate">ቀዋሚ ደጋፊ ዝኾነሉ ዕለት:</label>
									<div class="col-md-4">
								 <input id="coreDegafiregDate" name="coreDegafiregDate" type="text" placeholder="" class="form-control" value="{{ $cnt ? Request::old('coreDegafiregDate') : '' }}"></div>
								 <label class="col-md-2 control-label" for="proposerMem">ዝመልመሎ ውልቀ ሰብ:</label>
								 <div class="col-md-4">
								 <input id="proposerMem" name="proposerMem" type="text" placeholder="" class="form-control" value="{{ $cnt ? Request::old('proposerMem') : '' }}"></div>
								 
							  </div>

							  
							  <div class="form-group">
									<label class="col-md-2 control-label" for="degaficonfirmedWidabe">ናይ ደጋፊ ኣባልነት ውሳነ ዘፅደቐ ውዳበ:</label>
									<div class="col-md-4">
								 	<input id="degaficonfirmedWidabe" name="degaficonfirmedWidabe" type="text" placeholder="" class="form-control" value="{{ $cnt ? Request::old('degaficonfirmedWidabe') : '' }}">
								    </div>
								 	<label class="col-md-2 control-label" for="assignedWidabe">እቲ ደጋፊ ዝተመደበሉ ውዳበ</label>
									<div class="col-md-4">
									<input id="assignedWidabe" name="assignedWidabe" type="text" placeholder="" class="form-control" value="{{ $cnt ? Request::old('assignedWidabe') : '' }}"></div>
							  </div>

							  <div class="form-group">
								 
							  </div>
							  <div class="form-group">
									<label class="control-label col-sm-2" for="participatedCommittee">ዝተሳተፈሉ ብርኪ ኮሚቴ:<span class="text-danger">*</span></label>
									<div class="col-sm-4">

							 <select class="form-control" name="participatedCommittee" required="required">
							   <option selected disabled>~ምረፅ~</option>
							   <option >ናይ ኣመራርሓ ኮሚቴ</option>
							   <option >ምልዕዓል ንኡስ ኮሚቴ</option>
							   <option >ውዳበ ንኡስ ኮሚቴ</option>
							   <option >ሓገዝን ንኡስ ፋይናንስን ንኡስ ኮሚቴ</option>
							   </select>
							</div>	
					   
							<label class="control-label col-sm-2" for="degafiparticipationinCommittee">ኣብ ኮሚቴ ዘለዎ ተሳትፎ:<span class="text-danger">*</span></label>
							<div class="col-sm-4">

							 <select class="form-control" name="degafiparticipationinCommittee" required="required">
							   <option selected disabled>~ምረፅ~</option>
							   <option >ኣቦ ወንበር</option>
							   <option >ፀሓፊ</option>
							   <option >ኣባል</option>
							   </select>
							</div>	
					   </div>			  
		    </div>
		</div>
	</div>
	<div class="col-md-6 col-md-offset-0">
		<div class="box box-primary" style="padding-right: 5px;">
			<div class="box-header with-border">
				<h3 class="box-title">መረዳእታ ኣድራሻ</h3>
			</div>
			<div class="box-body">
					  				
						{{ csrf_field() }}				
						
					  <div class="form-group">
						<label class="control-label col-md-2 col-sm-3 col-xs-3" for="address" >ኣድራሻ：</label>
						<div class="col-md-4 col-sm-9 col-xs-9">
						  <input type="text" class="form-control" id="address" name="address" data-inputmask="'mask': '99/99/9999'" value="{{ $cnt ? Request::old('address') : '' }}">
					  <!-- <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span> -->
						</div>
					  
						<label class="control-label col-md-2 col-sm-3 col-xs-3" for="tell">ቁፅሪ ስልኪ</label>
						<div class="col-md-4 col-sm-9 col-xs-9">
						  <input type="text" class="form-control" id="tell" name="tell" data-inputmask="'mask': '99/99/9999'" value="{{ $cnt ? Request::old('tell') : '' }}">
						  <!-- <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span> -->
						</div>
					  </div>

					  <div class="form-group">
						<label class="control-label col-md-2 col-sm-3 col-xs-3" for="poBox">ቁ.ሳ.ፖ</label>
						<div class="col-md-4 col-sm-9 col-xs-9">
						  <input type="text" class="form-control" id="poBox" name="poBox" data-inputmask="'mask': '99/99/9999'" value="{{ $cnt ? Request::old('poBox') : '' }}">
						  <!-- <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span> -->
						</div>
					  
							 <label class="col-md-2 control-label" for="fileNumber">ቁፅሪ ፋይል</label>
							 <div class="col-md-4">
							 <input id="fileNumber" name="fileNumber" type="text" placeholder="" class="form-control" value="{{ $cnt ? Request::old('fileNumber') : '' }}"></div>
				  </div>
				  					  <div class="form-group">
						<label class="control-label col-md-2 col-sm-2 col-xs-2">ኢሜይል</label>
						<div class="col-md-4 col-sm-4 col-xs-4">
						   <input id="email" name="email" type="text" placeholder="" class="form-control" value="{{ $cnt ? Request::old('email') : '' }}"></div>
						  <!-- <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span> -->
						</div>
					  </div>
				  					<div class="form-group">&nbsp &nbsp &nbsp &nbsp &nbsp
						<label>&nbsp &nbspናይ ደጋፊ መረዳእታ ቕድሚ ምምዝጋቡ እዞም ዝስዕቡ ከም ዝተማለኡ አረጋግፅ </label>
						
						<div class="checkbox">&nbsp &nbsp &nbsp &nbsp &nbsp
							<label>&nbsp &nbsp &nbsp &nbsp &nbsp<input type="hidden" name="bosSubmittedTsebtsab" value="0">
							 &nbsp &nbsp &nbsp &nbsp &nbsp  <input type="checkbox" name="bosSubmittedTsebtsab" value="1">ናይ መልማላይ ወይድማ ውዳበ ኣቦ ወንበር ርእይቶ ዝሓዘ ፀብፃብ ምስ ናይቲ ውልቀሰብ ርኢቶ ናብ ውዳበ ቐሪቡ እዩ
							</label>
						</div>
						<div class="checkbox">&nbsp &nbsp &nbsp &nbsp
							<label>&nbsp &nbsp &nbsp &nbsp &nbsp<input type="hidden" name="widabeacceptedDegafi" value="0">
							   <input type="checkbox" name="widabeacceptedDegafi" value="1">እቲ ዝምልከቶ ውዳበ ነቲ ደጋፊ ከም ዝተቐበሎ ዘርእይ መረዳእታ ቀሪቡ እዩ
							</label>
						</div>
					</div>
				  <br> 
					  <br>			
		</div>
	</div>
	<div class="ln_solid"></div>
    <div class="form-group">
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
            <button type="submit" class="btn btn-block btn-success">ኣቐምጥ</button>
        </div>
    </div>
</form>
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

<link rel="stylesheet" href="css/jquery.dataTables.min.css"></style>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>

<script>


	  $(document).ready(function(){
    
 
    // Toolbar extra buttons
    // var btnFinish = $('<button></button>').text('submit')
    //                                  .addClass('btn btn-info sw-btn-finish')
    //                                  .on('click', function(){ 
    //                                    $.ajax({
    //                                     type: 'post',
    //                                     url: 'coreDegafi',
    //                                     data: {
    //                                        // '_token': $('input[name=_token]').val(),                
    //                                         'va1': $("#name").val(),
    //                                         'va2': $('#fname').val(),
    //                                         'va3': $('#gfName').val(),
    //                                         'va4': $("#gender").val(),
    //                                         'va5': $("#birthPlace").val(),
    //                                         'va6': $("#dob").val(),
    //                                         'va7': $("#position").val(),
    //                                         'va8': $("#occupation").val(),
    //                                         'va9': $("#coreDegafiregDate").val(),
    //                                         'va10': $('#proposerMem').val(),
    //                                         'va11': $("#degaficonfirmedWidabe").val(),
    //                                         'va12': $("#assignedWidabe").val(),
    //                                         'va13': $("#participatedCommittee").val(),
    //                                         'va14': $("#degafiparticipationinCommittee").val(),
    //                                         'va15': $("#tell").val(),
    //                                         'va16': $("#address").val(),
    //                                         'va17': $("#poBox").val(),
    //                                         'va18': $("#fileNumber").val(),
    //                                         'va19': $("#email").val(),
    //                                         'va20': $("#bosSubmittedTsebtsab").val(),
    //                                         'va21': $("#widabeacceptedDegafi").val(),
    //                                         'remark': $('#remark').val()                                                  
    //                                     },
                                        
    //                                     success: function(data) {
    //                                           document.getElementById("name").value="";
    //                                           document.getElementById("fname").value="";
    //                                           document.getElementById("gfName").value="";
    //                                           document.getElementById("birthPlace").value="";
    //                                           document.getElementById("dob").value="";
    //                                           document.getElementById("position").value="";
    //                                           document.getElementById("occupation").value="";
    //                                           document.getElementById("coreDegafiregDate").value="";
    //                                           document.getElementById("proposerMem").value="";
    //                                           document.getElementById("degaficonfirmedWidabe").value="";
    //                                           document.getElementById("assignedWidabe").value="";
    //                                           document.getElementById("participatedCommittee").value="";
    //                                           document.getElementById("degafiparticipationinCommittee").value="";
    //                                           document.getElementById("tell").value="";
    //                                           document.getElementById("address").value="";
    //                                           document.getElementById("poBox").value="";
    //                                           document.getElementById("fileNumber").value="";
    //                                           document.getElementById("email").value="";
    //                                           document.getElementById("bosSubmittedTsebtsab").value="";
    //                                           document.getElementById("widabeacceptedDegafi").value="";
    //                                           document.getElementById("remark").value="";
                                              
    //                                           alert("Success");
                                              
    //                                          },

    //                                     error: function(xhr,errorType,exception){
                                                    
    //                                                 alert(exception, "Please Fill out this this colomun");
                                                    
    //                                     }
    //                                 });

                                        
    //                             });
                            
    
                                                        
                
});   
$('#dob').calendarsPicker({calendar: $.calendars.instance('ethiopian')});
$('#coreDegafiregDate').calendarsPicker({calendar: $.calendars.instance('ethiopian')});
</script>  

@endsection