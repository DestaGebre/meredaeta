
@extends('layouts.app')

@section('htmlheader_title')
ዝተዘዋወሩ ኣባላት
@endsection

@section('contentheader_title')
ዝተዘዋወሩ ኣባላት
@endsection

@section('header-extra')
<!-- <script src="//code.jquery.com/jquery-1.12.3.js"></script>
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
 -->

@endsection
@section('main-content')

<body>
	
	<div class="row ">
		<div class="col-md-6 col-sm-6 col-xs-6">
				<div class="form-group col-md-12 col-sm-12 col-xs-12">	
				<label class="control-label col-md-1 col-sm-1" for="zone">ካብ ዞባ:</label>		                
					<div class="col-md-5 col-sm-5 col-xs-5">    
						<select name="zone" id="zone" class="form-control" >
							<option value=""selected disabled>~ዞባ ምረፅ~</option>
							@foreach ($zobadatas as $key => $value)
							<option value="{{ $key }}">{{ $value }}</option>
							@endforeach
						</select>
					</div>
					<label class="control-label col-md-1 col-sm-1" for="woreda">ናብ ዞባ:</label>		                
					<div class="col-md-5 col-sm-5 col-xs-5">    
						<select name="woreda" id="woreda" class="form-control">
							<option value="">~ዞባ ምረፅ~</option>
							@foreach ($zobadatas as $key => $value)
							<option value="{{ $key }}">{{ $value }}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-6">
			</div>	
	</div>
	
	<div class="box box-primary row">
		<div id="tableofContents">
		<div class="box-header with-border">			
			
				{{ csrf_field() }}
				<div class="table-responsive text-center">
					<table class="table table-borderless" id="table2">
						<thead>
							<tr>
								
								<th class="text-center">መ.ቑ</th>
								<th class="text-center">ሽም ኣባል</th>
								<th class="text-center">ፆታ</th>
								<th class="text-center">ዕድመ</th>
								
								<!-- <th class="text-center">ዝተወደበሉ ማሕበር</th>
								<th class="text-center">ዓይነት ኣባል</th>
								<th class="text-center">ዝተፃረየ ወርሓዊ መሃያ</th>
								<th class="text-center">ወርሓዊ ኣባልነት ክፍሊት</th> -->
								<!-- <th class="text-center">ተግባር</th> -->
								
							</tr>					
						</thead>
						<tbody>
							@foreach ($data as $mydata)										
							<tr>									
								<td>{{ $mydata->hitsuyID }} </td>
								<td>{{ $mydata->hitsuytrans->name }} {{ $mydata->hitsuytrans->fname }} {{ $mydata->hitsuytrans->gfname }}</td>                          
								<td>{{ $mydata->hitsuytrans->gender }}</td>
								<td>{{ (date('Y') - date('Y',strtotime($mydata->hitsuytrans->dob))) }}</td>
											
						   </tr>
							@endforeach
							</tbody>
						</table>
						</div>
												
	
		
	 </div>
	 </div>
	 
<!---     -->
<div id="addEdu" class="hidden">
		<!-- Button ይመለሱ -->
		<div class="pull-right">					  
			<button class="btn switchBtn btn-info"><span class="glyphicon glyphicon-arrow-up"></span></button> 				  
		</div>
		<form id="demo-form2" method="POST" action= "{{URL('education')}}" data-parsley-validate class="form-horizontal formadder" role="form">
			{{ csrf_field() }}
		<div class="form-group col-sm-12 col-md-12">                     
            <label class="control-label col-md-1 col-sm-1" for="fullname">ሽም:</label>
            <div class="col-md-4 col-sm-4 col-xs-4">
                <input type="text" id="fullname" name="fullname" readonly class="form-control">
                <input type="hidden" id="hitsuyID" name="hitsuyID" >
            </div>
            <label class="control-label col-md-1 col-sm-1" for="educationType">ዓይነት ትምህርቲ:</label>
            <div class="col-md-4 col-sm-4 col-xs-4">
                <input type="text" id="educationType" name="educationType" class="form-control">
            </div>
        </div>
        <div class="form-group col-sm-12 col-md-12">
            <label class="control-label col-md-1 col-sm-1" for="educationLevel">ደረጃ ትምህርቲ:</label>
            <div class="col-md-4 col-sm-4 col-xs-4">
                <input type="text" id="educationLevel" name="educationLevel" class="form-control">
            </div>
            <label class="control-label col-md-1 col-sm-1" for="institute">ዝሃቦ ትካል:</label>
            <div class="col-md-4 col-sm-4 col-xs-4">
                <input type="text" id="institute" name="institute" class="form-control">
            </div>          
        </div>
        <div class="form-group col-sm-12 col-md-12"> 
        	<label class="control-label col-md-1 col-sm-1" for="graduationDate">ዝተመረቀሉ ዓመት:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="graduationDate" name="graduationDate" class="form-control">
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
	</div>
		<!--    -->
		<div id="addExp" class="hidden">
		<!-- Button ይመለሱ -->
		<div class="pull-right">					  
			<button class="btn switchBtn btn-info"><span class="glyphicon glyphicon-arrow-up"></span></button> 				  
		</div>
		<form id="demo-form2" method="POST" action= "{{URL('exprience')}}" data-parsley-validate class="form-horizontal formadder" role="form">
			{{ csrf_field() }}
		<div class="form-group col-sm-12 col-md-12">                     
            <label class="control-label col-md-1 col-sm-1" for="fullname2">ሽም:</label>
            <div class="col-md-4 col-sm-4 col-xs-4">
                <input type="text" id="fullname2" name="fullname" readonly class="form-control">
                <input type="hidden" id="hitsuyID2" name="hitsuyID" >
            </div>
            <label class="control-label col-md-1 col-sm-1" for="exprienceType">ዓይነት:</label>
            <div class="col-md-4 col-sm-4 col-xs-4">
                <select name="exprienceType" id="exprienceType" class="form-control">
						<option selected disabled>~ምረፅ~</option>
						<option >ሞያዊ</option>
						<option >ፖለቲካዊ</option>
				</select>
            </div>
        </div>
        <div class="form-group col-sm-12 col-md-12">
            <label class="control-label col-md-1 col-sm-1" for="career">ስራሕ መደብ:</label>
            <div class="col-md-4 col-sm-4 col-xs-4">
                <input type="text" id="career" name="career" class="form-control">
            </div>
            <label class="control-label col-md-1 col-sm-1" for="position">ሓላፍነት:</label>
            <div class="col-md-3 col-sm-3 col-xs-3">
                <input type="text" id="position" name="position" class="form-control">
            </div> 
            <label class="control-label col-md-1 col-sm-1" for="startDate">ዝጀመረሉ/ትሉ:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="startDate" name="startDate" class="form-control">
            </div>         
        </div>
        <div class="form-group col-sm-12 col-md-12"> 
        	
            <label class="control-label col-md-1 col-sm-1" for="institute">ትካል:</label>
            <div class="col-md-4 col-sm-4 col-xs-4">
                <input type="text" id="institute" name="institute" class="form-control">
            </div><label class="control-label col-md-1 col-sm-1" for="address">ኣድራሻ:</label>
            <div class="col-md-4 col-sm-4 col-xs-4">
                <input type="text" id="address" name="address" class="form-control">
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
	</div>
		<!--    -->

    
	
</body>
@endsection

@section('scripts-extra')
	<script>
 
 
	 $(document).ready(function() {
      $('#table2').DataTable();
     });
     $(document).on('click', '.switchBtn', function() {
     	$('#addExp').addClass('hidden');
      	$('#addEdu').addClass('hidden');
      	$('#tableofContents').removeClass('hidden');	
     });
	 $(document).on('click', '.addEducation-modal', function() {
	 	$('#addExp').addClass('hidden');
        $('#addEdu').removeClass('hidden');
        $('#tableofContents').addClass('hidden');        
        var stuff = $(this).data('info').split(',');
        fillEduData(stuff)
    });
    function fillEduData(details){
      $('#hitsuyID').val(details[0]);   
      $('#fullname').val(details[1]);      
  }
  $(document).on('click', '.addExprience-modal', function() {
  		$('#addExp').removeClass('hidden');
        $('#addEdu').addClass('hidden');
        $('#tableofContents').addClass('hidden');        
        var stuff = $(this).data('info').split(',');
        fillExpData(stuff)
    });
  function fillExpData(details){
      $('#hitsuyID2').val(details[0]);   
      $('#fullname2').val(details[1]);      
  }

     $('select[name="zone"]').on('change', function() {
            var stateID = $(this).val();				
            //instead of ዞባ ምረፅ => ኩለን ዞባታት value="" selected,
               if(stateID) {
                $.ajax({
                    url: 'myform/ajax/'+stateID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {

                      

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
    //
	
</script>
<link href="css/bootstrap.min.css" rel="stylesheet">   
<script src="js/jquery.min.js"></script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css"></style>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>

@endsection

