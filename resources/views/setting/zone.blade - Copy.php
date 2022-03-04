@extends('layouts.app')

@section('htmlheader_title')
     ከባብያዊ ኣቀማምጣ 
@endsection

@section('contentheader_title')
    ምሕደራ ከባብያዊ ኣቀማምጣ
@endsection

@section('header-extra')
 

@endsection

@section('main-content')
    
            <!-- Profile Image -->
<body OnLoad="myFunction()">
		<div class="box box-primary" role="tabpanel" data-example-id="togglable-tabs">
                      
					  <ul class="nav nav-tabs" id="geo">
                        <li role="presentation" class="active"><a href="#tab_content11" id="zone-tab" role="tab" data-toggle="tab" aria-controls="zone" aria-expanded="true">ዞባታት</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content22" role="tab" id="woreda-tab" data-toggle="tab" aria-controls="woreda" aria-expanded="false">ወረዳታት</a>
                        </li>
						<li role="presentation" class=""><a href="#tab_content33" role="tab" id="tabia-tab" data-toggle="tab" aria-controls="tabia" aria-expanded="false">ጣብያታት</a>
                        </li>
					    
                      </ul>
						<div class="pull-right">
			        
                       <button type="submit" onclick="myFunction()"   class="btn btn-info btn-lg">ሓዱሽ መዝግብ </button> 
			   </div>
         
               <div id="myTabContent2" class="tab-content">
                  <div role="tabpanel" class="tab-pane fade active in" id="tab_content11" aria-labelledby="zone-tab">
                   <div class="x_content" id="zonelist">
                    <div class="row">					
                      <div class="col-sm-12">
					  <table id="example"  name ="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>ሽም ዞባ</th>              
								<th>ተግባር</th>
							</tr>
						</thead>

						<tr>
						@foreach ($zones as $zone)
						<td>{{ $zone->zoneName }} </td>
						 <td><span class="label label-primary">ኣስተኻኽል</span>
						
						 <a href="/profile/{{ $zone->id }}/edit" class="btn btn-xs btn-simple text-green"><i class="fa fa-pencil"></i> </a>
						 </td>
						 <td><span class="label label-primary">ደምስስ</span></td>
						 <td>
						 <a href="/zonepages/{{ $zone->id }}/edit" class="btn btn-xs btn-simple text-green"><i class="fa fa-pencil"></i> </a>
						  </td>
						</tr>
						 @endforeach
					</table>
                        <div class="card-box table-responsive">
                         
                        </div>
                      </div>
                    </div>
                  </div>
				  <div id="zoneform">
				   <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left"  action="{{ url('zone') }}" method="post">
				   {!! csrf_field() !!}
					  <div class="form-group">
                       
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ሽም ዞባ<span class="required"></span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="name" name ="name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div> 
						
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">                         
						<button type="submit" class="btn btn-success">ኣቐምጥ</button>
						  <button type="submit" onclick="myFun()" class="btn btn-success">ካንስል</button>
                        </div>
                      </div>
                </form>
			</div>	
          </div>
           <div role="tabpanel" class="tab-pane fade" id="tab_content22" aria-labelledby="woreda-tab">
                <div class="x_content" id="woredalist">
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="card-box table-responsive">
                         
                          <table id="datatable-keytable" class="table table-striped table-bordered">
                            <thead>
                             <tr>
                                <th>ተቁ</th>
								 <th>ዝርከበሉ ዞባ</th>
								 <th>ስም ወረዳ</th>
								<th>ዓይነት ወረዳ</th>
                              </tr>
                            </thead>
                            <tr>
								@foreach ($woredas as $woreda)
								<td>{{ $woreda->zoneName}} </td>
								<td>{{ $woreda->woredaName}} </td>
								<td>{{ $woreda->isUrban}} </td>
								 <td><span class="label label-primary">ኣስተኻኽል</span>
								
								 <a href="/profile/{{ $zone->id }}/edit" class="btn btn-xs btn-simple text-green"><i class="fa fa-pencil"></i> </a>
								 </td>
								 <td><span class="label label-primary">ደምስስ</span></td>
								 <td>
								 <a href="/zonepages/{{ $zone->id }}/edit" class="btn btn-xs btn-simple text-green"><i class="fa fa-pencil"></i> </a>
								  </td>
								</tr>
								 @endforeach
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
				 <div id="woredaform">
				   <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="{{ url('woreda') }}" method="post">
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
									   @foreach ($zones as $zone)
									   <option >{{$zone->zoneName}}</option>
									   @endforeach
									 
									 </select>
									</div>	
							   </div>
							   <div class="form-group">
                       
						<label class="control-label col-sm-2" for="first-name">ስም ወረዳ<span class="required"></span>
                        </label>
                        <div class="col-md-6 col-sm-5 col-xs-12">
                          <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div> 
					          
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-5 col-md-offset-5">                         
						<button type="submit" class="btn btn-success">ኣቐምጥ</button>
						  <button type="submit" onclick="myFun()" class="btn btn-success">ካንስል</button>
                        </div>
                      </div>
                </form>
             </div>
			</div>
			  <div role="tabpanel" class="tab-pane fade" id="tab_content33" aria-labelledby="tabia-tab">
                <div class="x_content" id="tabialist">
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="card-box table-responsive">
                         
                          <table id="datatable-keytable" class="table table-striped table-bordered">
                            <thead>
                              <tr>
                                <th>ተቁ</th>
								 <th>ዝርከበሉ ዞባ</th>
								 <th>ዝርከበሉ ወረዳ</th>
								 <th>ስም ጣብያ</th>
								<th>ዓይነት ጣብያ</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                             
								                            <td>                     
                          <button type="button" class="btn btn-primary">አስተኻኽል </button>   
                          <button type="button" class="btn btn-primary">አጥፍእ </button> 
                                </td>   						  
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
				 <div id="tabiaform">
				   <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
					  <label> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 
						 &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbspዓይነት ዞባ *:</label>

                        ከተማ:
                        <input type="radio" class="flat" name="gender" id="genderM" value=1" checked="" required /> ገጠር:
                        <input type="radio" class="flat" name="gender" id="genderF" value="0" />
						</br>
					  <div class="form-group">
									<label class="control-label col-sm-2" for="postion">ዝርከበሉ ዞባ:<span class="text-danger">*</span></label>
									<div class="col-sm-3">

									 <select class="form-control" name="position" required="required">
									   <option selected disabled>~ምረፅ~</option>
									   @foreach ($zones as $zone)
									   <option >{{$zone->zoneName}}</option>
									   @endforeach
									 
									 </select>
									</div>	
							   </div>

							 <div class="form-group">
									<label class="control-label col-sm-2" for="postion">ዝርከበሉ ወረዳ:<span class="text-danger">*</span></label>
									<div class="col-sm-3">

									 <select class="form-control" name="position" required="required">
									   <option selected disabled>~ምረፅ~</option>
									   @foreach ($woredas as $woreda)
									   <option >{{$woreda->woredaName}}</option>
									   @endforeach
									 
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
							   </div>
					  <div class="form-group">
                       
						<label class="control-label col-sm-2" for="first-name">ስም ጣብያ<span class="required"></span>
                        </label>
                        <div class="col-md-6 col-sm-5 col-xs-12">
                          <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div> 
					  </br>
						
						</br>
	                  <br>                 
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">                         
						
                          <button type="submit" class="btn btn-success">ኣቐምጥ</button>
						  <button type="submit" onclick="myFun()" class="btn btn-success">ካንስል</button>
                        </div>
                      </div>
                </form>
             </div>
          </div>
		  <div id ="selectedtab" name="selectedtab">
			 <p  id="test" class="act" > <span></span></p>

		</div>
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
	
	var activetab = $('.nav-tabs .active > a').attr('href') 
	var text1=activetab;
	var text2 ='#tab_content11';
	var text3 ='#tab_content22';
	var text4 ='#tab_content33';
	
	if(text1 ==text2)
	{
	
    var x = document.getElementById('zoneform');
	var y = document.getElementById('zonelist');
	}
	if(activetab==text3)
	{
    var x = document.getElementById('woredaform');
	var y = document.getElementById('woredalist');
	}
	if(activetab==text4)
	{
    var x = document.getElementById('tabiaform');
	var y = document.getElementById('tabialist');
	}
	
    if (x.style.display === 'none') {
        x.style.display = 'block';
		y.style.display = 'none';
    } else {
        y.style.display = 'block';
		x.style.display = 'none';
    }
	
}
function myFun() {
    var activetab = $('.nav-tabs .active > a').attr('href') 
	var text1=activetab;
	var text2 ='#tab_content11';
	var text3 ='#tab_content22';
	var text4 ='#tab_content33';
	
	if(text1 ==text2)
	{
	
    var x = document.getElementById('zoneform');
	var y = document.getElementById('zonelist');
	}
	if(activetab==text3)
	{
    var x = document.getElementById('woredaform');
	var y = document.getElementById('woredalist');
	}
	if(activetab==text4)
	{
    var x = document.getElementById('tabiaform');
	var y = document.getElementById('tabialist');
	}
	
    if (x.style.display === 'none') {
        x.style.display = 'block';
		y.style.display = 'none';
    } else {
        y.style.display = 'block';
		x.style.display = 'none';
    }
}
  </script>
  <script>
  $(document).ready(function(){
  $( "#zoneName" ).change(function() {
  var firstdropselectedvalue= $("#zoneName").val();   
  var url= test.php?selected=firstdropselectedvalue;
    $.getJSON(url, function(data){
  $.each(data, function(index, text) {
    $('#woredaName').append(
        $('<option></option>').val(index).html(text);
    );
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