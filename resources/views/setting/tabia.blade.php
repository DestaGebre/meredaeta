@extends('layouts.app')

@section('htmlheader_title')
     ጣብያ 
@endsection

@section('contentheader_title')
    ምሕደራ ኣቀማምጣ ጣብያታት
@endsection

@section('header-extra')
 

@endsection

@section('main-content')

            <!-- Profile Image -->
<body OnLoad="myFunction()">
	<div class="box box-primary">
		<div class="pull-right">
			        
            <button type="submit" onclick="myFunction()" class="btn btn-info btn-lg">ሓዱሽ መዝግብ </button> 
		</div>
        <div class="x_content" id="tabialist">
            <div class="row">					
				<div class="col-sm-12">
					<table id="example"  name ="tabiatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
							<tr>
								 <th>ዝርከበሉ ዞባ</th>
								 <th>ዝርከበሉ ወረዳ</th>
								 <th>ስም ጣብያ</th>
								<th>ዓይነት ጣብያ</th>             
								<th>ተግባር</th>
							</tr>
						</thead>

						<tr>
						@foreach ($tabias as $tabia)
						<td>{{ $tabia->zoneName }} </td>
						 <td><span class="label label-primary">ኣስተኻኽል</span>
						
						 <a href="/profile/{{ $tabia->id }}/edit" class="btn btn-xs btn-simple text-green"><i class="fa fa-pencil"></i> </a>
						 </td>
						 <td><span class="label label-primary">ደምስስ</span></td>
						 <td>
						 <a href="/geoStructure/{{ $tabia->id }}/edit" class="btn btn-xs btn-simple text-green"><i class="fa fa-pencil"></i> </a>
						  </td>
						  <td>{{ $tabia->woredaName }} </td>
						 <td><span class="label label-primary">ኣስተኻኽል</span>
						
						 <a href="/profile/{{ $tabia->id }}/edit" class="btn btn-xs btn-simple text-green"><i class="fa fa-pencil"></i> </a>
						 </td>
						 <td><span class="label label-primary">ደምስስ</span></td>
						 <td>
						 <td>{{ $tabia->tabiaName }} </td>
						 <td><span class="label label-primary">ኣስተኻኽል</span>
						
						 <a href="/profile/{{ $tabia->id }}/edit" class="btn btn-xs btn-simple text-green"><i class="fa fa-pencil"></i> </a>
						 </td>
						 <td><span class="label label-primary">ደምስስ</span></td>
						 <td>
						 <a href="/geoStructure/{{ $tabia->id }}/edit" class="btn btn-xs btn-simple text-green"><i class="fa fa-pencil"></i> </a>
						  </td>
						  <td>{{ $tabia->isUrban }} </td>
						 <td><span class="label label-primary">ኣስተኻኽል</span>
						
						 <a href="/profile/{{ $tabia->id }}/edit" class="btn btn-xs btn-simple text-green"><i class="fa fa-pencil"></i> </a>
						 </td>
						 <td><span class="label label-primary">ደምስስ</span></td>
						 <td>
						 <a href="/geoStructure/{{ $tabia->id }}/edit" class="btn btn-xs btn-simple text-green"><i class="fa fa-pencil"></i> </a>
						  </td>
						</tr>
						 @endforeach
					</table>
					<div class="card-box table-responsive"></div>
			    </div>
			</div>
        </div>
		<div id="woredaform">
			<form id="woredaform2" data-parsley-validate class="form-horizontal form-label-left" action="{{ url('woreda') }}" method="post">
			    <label> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 
				 &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbspዓይነት ዞባ *:</label>
				ከተማ:
				<input type="radio" class="flat" name="gender" id="genderM" value=1" checked="" required /> ገጠር:
				<input type="radio" class="flat" name="gender" id="genderF" value="0" /> 
	            <br>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-2" for="postion">ዝርከበሉ ዞባ:<span class="text-danger">*</span></label>
					<div class="col-sm-3">

						 <select class="form-control" name="position" required="required">
						   <option selected disabled>~ምረፅ~</option>
						 </select>
					</div>	
			    </div>
				<div class="form-group">
									<label class="control-label col-sm-2" for="postion">ዝርከበሉ ወረዳ:<span class="text-danger">*</span></label>
									<div class="col-sm-3">

									 <select class="form-control" name="position" required="required">
									   <option selected disabled>~ምረፅ~</option>
									   
									 </select>
									</div>	
							   </div>

					  
							   
							   							   <div class="form-group">
									<label class="control-label col-sm-2" for="postion">ዝርከበሉ ወረዳ:<span class="text-danger">*</span></label>
									<div class="col-sm-3">

									 <select class="form-control" name="position" required="required">
									   <option selected disabled>~ምረፅ~</option>
									   <option >መቐለ</option>
									   <option >ምብራቕ</option>
									   <option >ማእኸል</option>
									 </select>
									</div>	
							   </div>				<div class="ln_solid"></div>
				<div class="form-group">
					<div class="col-md-6 col-sm-6 col-xs-5 col-md-offset-5">                         
						<button type="submit" class="btn btn-success">ኣቐምጥ</button>
					    <button type="submit" onclick="myFun()" class="btn btn-success">ካንስል</button>
					</div>
                </div>
            </form>
        </div>
	</div>
</body>             
@endsection
@section('scripts-extra')
 <script>
 
$(document).ready(function() {
    $('#example').DataTable();
} );

function myFunction() {
    var x = document.getElementById('tabiaform');
	var y = document.getElementById('tabialist');
    if (x.style.display === 'none') {
        x.style.display = 'block';
		y.style.display = 'none';
    } else {
        y.style.display = 'block';
		x.style.display = 'none';
    }
	
}
function myFun() {
    var x = document.getElementById('tabiaform');
	var y = document.getElementById('tabialist');
    if (x.style.display === 'none') {
        x.style.display = 'block';
		y.style.display = 'none';
    } else {
        y.style.display = 'block';
		x.style.display = 'none';
    }
}
$(document).ready(function($){
    $('#zone').change(function(){
        $.get("{{ url('api/dropdown')}}", 
        { option: $(this).val() }, 
        function(data) {
            $('#woreda').empty(); 
            $.each(data, function(key, element) {
                $('#woreda').append("<option value='" + key +"'>" + element + "</option>");
            });
        });
    });
});
  </script>
  <script type="text/javascript" src="tplforg/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="tplforg/js/bootstrap.min.js"></script>
<script src="tplforg/js/jquery.min.js"></script>
<link href="tplforg/css/bootstrap.min.css" rel="stylesheet"> 
<link rel="stylesheet" href="tplforg/css/jquery.dataTables.min.css"></style>
@endsection