
@extends('layouts.app')

@section('htmlheader_title')
ምሕደራ ቀወምቲ ደገፍቲ
@endsection

@section('contentheader_title')
ምሕደራ ቀወምቲ ደገፍቲ
@endsection

@section('header-extra')
<link rel="stylesheet" href="css/jquery.dataTables.min.css"></style>
@endsection
@section('main-content')
<div class="box box-primary">
		<div class="myswitch pull-right">			        
			   <button class="btn switchBtn btn-info"><span class="glyphicon glyphicon-plus"></span> ሓዱሽ መዝግብ </button> 
	   </div>		
	   <div class="mytoggle hidden pull-right">					  
			<button class="btn toggleBtn btn-info"><span class="glyphicon glyphicon-arrow-up"></span></button> 				  
		</div>
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
		<div id ="corediv" class="form-group hidden">
		  </br>	
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
							<!--<div class="form-group">
							<label class="col-md-2 control-label" for="birthPlace">ትውልዲ ቦታ</label>
							<div class="col-md-4">
								<input id="birthPlace" name="birthPlace" type="text" placeholder="" class="form-control" value="{{ $cnt ? Request::old('birthPlace') : '' }}"></div>

								<label class="col-md-2 control-label" for="dob">ዕለት ትውልዲ</label>
								<div class="col-md-4">
									<input id="dob" name="dob" type="text" placeholder="" class="form-control" value="{{ $cnt ? Request::old('dob') : '' }}"></div>
								</div>-->
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
							   <label class="control-label col-sm-2" for="occupation">ማሕበራዊ መሰረት:<span class="text-danger">*</span></label>
			                  <div class="col-sm-4">
			                    <select class="form-control" name="occupation" required="required">
			                      <option selected disabled>~ምረፅ~</option>
			                      <option>ሰብ ሞያ</option>
			                      <option>ንግዲ</option>
			                      <option>መፍረይቲ</option>
			                      <option>ኮንስትሩክሽን</option>
			                      <option>ግልጋሎት</option>
			                      <option>ካልእ ኢንቨስትመንት</option>
			                    </select>
			                  </div>
			                  </div>
							  <div class="form-group">
									<label class="col-md-2 control-label" for="coreDegafiregDate">ቀዋሚ ደጋፊ ዝኾነሉ ዕለት:</label>
									<div class="col-md-4">
									<input id="regDate" name="coreDegafiregDate" type="text" placeholder="" class="form-control" value="{{ $cnt ? Request::old('coreDegafiregDate') : '' }}"></div>
               
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
		<div id="corelist" class="form-group">
			<div class="">
				{{ csrf_field() }}
				<div class="table-responsive text-center">
					<table class="table table-borderless" id="table2">
						<thead>
							<tr>
								<th class="text-center">መ.ቑ</th>
								<th class="text-center">ሽም ደጋፊ</th>
								<th class="text-center">ፆታ</th>
								<th class="text-center">ዕድመ</th>
								<th class="text-center">ትውልዲ ቦታ</th>
								<th class="text-center">ዝተመዝገበሉ ዕለት</th>								
								<th class="text-center">ደራጃ ት/ቲ</th>
								<th class="text-center">ዝተወደበሉ ውዳበ</th>
								<th class="text-center">ዝተሳተፈሉ ብርኪ ኮሚቴ</th>
								<th class="text-center">ኣብ ኮሚቴ ዘለዎ ተሳትፎ</th>							
								<!-- <th class="text-center">ተግባር</th> -->
								
							</tr>					
						</thead>
						<tbody>
							@foreach ($data as $mydata)										
							<tr>
								<td>{{ $mydata->id }}</td>	
								<td>{{ $mydata->name }} {{ $mydata->fname }} {{ $mydata->gfname }}</td>                          
								<td>{{ $mydata->gender }}</td>
								<td>{{ (date('Y') - date('Y',strtotime($mydata->dob))) }}</td>
								<td>{{ $mydata->birthPlace }}</td>
								<td>{{ App\DateConvert::toEthiopian(date('d/m/Y',strtotime($mydata->coreDegafiregDate))) }}</td>
								<td>{{ $mydata->position }}</td>
								<td>{{ $mydata->assignedWidabe }}</td>
								<td>{{ $mydata->participatedCommittee}}</td>
								<td>{{ $mydata->degafiparticipationinCommittee }}</td>
								
								<!-- <td><button class="add-modal btn btn-success" data-info="{{ $mydata->hitsuyID }},{{ $mydata->name }} {{ $mydata->fname }} {{ $mydata->gfname }},{{ $mydata->tabiaID }}">
									<span class="glyphicon glyphicon-tick"></span>ኣባልነት ይፅድቕ</button>
									@if($mydata->hitsuy_status=='ሕፁይ')
									<button class="edit-modal btn btn-success" data-info="{{ $mydata->hitsuyID }},{{ $mydata->name }} {{ $mydata->fname }} {{ $mydata->gfname }},{{ $mydata->tabiaID }}">
									<span class="glyphicon glyphicon-plus"></span>ይናዋሕ</button>
									@endif
									<button class="delete-modal btn btn-warning" data-info="{{ $mydata->hitsuyID }},{{ $mydata->name }} {{ $mydata->fname }} {{ $mydata->gfname }},{{ $mydata->tabiaID }}">
									<span class="glyphicon glyphicon-minus"></span>ይሰረዝ</button>
								</td> -->									
						   </tr>
							@endforeach
							</tbody>
						</table>
						</div>
                {{ $data->links() }}
			</div>
                     </div><!-- Modal Delete -->
    </div>
	
@endsection

@section('scripts-extra')
    <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
	<script>
 
 
	 $(document).ready(function() {
      $('#table2').DataTable({
        @include('layouts.partials.lang'),
        "order": []
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
		$(document).on('click', '.switchBtn', function() {
    	$('#corelist').addClass('hidden');
    	$('.myswitch').addClass('hidden');
        $('#corediv').removeClass('hidden');                 
        $('.mytoggle').removeClass('hidden');                 
    });	
    $(document).on('click', '.toggleBtn', function() {
    	$('.alert-danger').remove();
    	$('#corediv').addClass('hidden');
    	$('.mytoggle').addClass('hidden');
        $('#corelist').removeClass('hidden');                 
        $('.myswitch').removeClass('hidden');                 
    });	
	$('#dob').calendarsPicker({calendar: $.calendars.instance('ethiopian')});
$('#coreDegafiregDate').calendarsPicker({calendar: $.calendars.instance('ethiopian')});
    //
	
</script>

@endsection

