@section('htmlheader_title')
    ቅፅዓት 
@endsection

@section('contentheader_title')
   ምሕደራ ቅፅዓት ኣባላት
@endsection

@section('header-extra')
  
@endsection

@section('main-content')
    
            <!-- Profile Image -->
<body OnLoad="myFunction()">
	<div class="box box-primary" role="tabpanel" data-example-id="togglable-tabs">
        <div class="pull-right">
			        
			   <button onclick="myFunction()"   class="btn btn-info btn-lg">ሓዱሽ መዝግብ </button> 
	   </div>		
		<div id ="penaltydiv">
		    </br>
            <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
					</br>
				  <div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">መፍለይ ቑፅሪ ኣባል  <span class="required">（*）</span>
					</label>
					<div class="col-md-3 col-sm-6 col-xs-12">
					  <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
					</div>
					<button type="submit" class="btn btn-search">ካብ ማህደር ድለ</button>
				  </div>   
				   <div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-">ዓይነት ጥፍኣት </label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <select class="form-control">
						<option>ምረፅ</option>
						<option>ቀሊል ናይ ስነምግባር ጉድለት</option>
						<option>ወርሓዊ ክፍሊት  ንልዕሊ ሓደ ወርሒ ምሕላፍ</option>
						<option>ንናይ ህወሓት ፕሮግራምን ሕገ ደንቢን ዘይምቕባል</option>
						 <option>ብኸቢድ ገበን ተኸሲሱ ገበነኛ ዝተብሃለ</option>
						<option>ናይ ጉጅለ ምንቅስቓስ ምክያድ</option>
						 <option>ናይ ስነምግባር መጠንቐቕታ ተዋሂብዎ ዝደገመ</option>
						  <option>ናይ ኣባልነት ወፈያ ብእዋኑ ዘይምኽፋልን ልዕሊ ክልተ ጊዜ መጠንቐቕታ ዝተውሃቦ</option>
						   <option>መሰል ኣባል እንትግሃስ ብተደጋጋሚ እናገጠሞን እናፈለጠን ብዝግባእ ዘይተቓለሰ</option>
							<option>ገምጋምን ምንቅቓፍን ብተደጋጋሚ ንሰብ መጥቕዒ ወይ መጥቀሚ ክጥቀም ዝሃቀነን</option>
					  </select>
					</div>
				  </div>	
					 <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-">ደረጃ ጥፍኣት </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control">
                            <option>ምረፅ</option>
                            <option> ቀሊል     </option>
                            <option>  ኸቢድ      </option>
                          </select>
                        </div>
                      </div>	
                       						  
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-">ዝተውሃቦ ቅፅዓት </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control">
                            <option>ምረፅ</option>
                            <option> መጠንቀቕታ  </option>
                            <option>  ናይ ሕፀ እዋን ምንዋሕ     </option>
                            <option> ካብ ሕፁይነት ምብራር  </option>
							 <option>  ካብ ሙሉእ ናብ ሕፁይ ኣባልነት ምውራድ    </option>
                            <option>  ካብ ሓላፍነት ንውሱን ጊዜ ምእጋድ   </option>
							 <option> ካብ ሓላፍነት ምውራድ  </option>
							  <option> ካብ ኣባልነት ንውሱን ጊዜ ምእጋድ    </option>
							   <option>  ካብ ኣባልነት ምብራር  </option>
                          </select>
                        </div>
                      </div>			
                     <div class="form-group">
                       
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">መበገሲ ሓሳብ ዘቕረበ ኣካል<span class="required">（*）</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div> 
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ዘፅደቐ (ዝወሰነ) ኣካል<span class="required"></span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>   		
					<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ቕፅዓት ዝፀንሐሉ እዋን    <span class="required"></span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
						<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ቕፅዓት ዝተውሃበሉ ዕለት     <span class="required"></span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
					  <br/>
						<br/>
	                    <p style="padding: 0px;">ቕድሚ ምምዝጋቡ እዞም ዝስዕቡ ከም ዝተማለኡ አረጋግፅ
                      <p style="padding: 5px;">
                        <input type="checkbox" name="hobbies[]" id="hobby1" value="ski" data-parsley-mincheck="2" required class="flat" /> ናይ ስንብት መበገሲ ሓሳብ እቲ ውልቀሰብ ኣባል ካብ ዝኾነሉ ውዳበ ናብ ልዕሊኡ ናብ ዘሎ ውዳበ ቐሪቡ እዩ 
                        <br />

                        <input type="checkbox" name="hobbies[]" id="hobby2" value="run" class="flat" />   መበገሲ ሓሳብ ዝቐረበሉ ውዳበ ነቲ ካብ ብትሕቲኡ ዘሎ ውዳበ ዝቐረበሉ ኣፅዲቕዎ እዩ 
                        <br />
	
		 
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">                         
						
                          <button type="submit" class="btn btn-success">ኣቐምጥ</button>
                        </div>
                      </div>

                 </form>
            </div>
                      
		<div id="penaltylist">
		  <div class="col-sm-12">
			<div class="card-box table-responsive">
			  <p class="text-muted font-13 m-b-30">
			  </p>

			  <table id="datatable-keytable" class="table table-striped table-bordered">
				<thead>
				  <tr>
					<th>መፍለይ ቑፅሪ ኣባል</th>
					<th>ዓይነት ጥፍኣት<th>
					<th>ደረጃ ጥፍኣት</th>
					<th>ዝተውሃቦ ቅፅዓት</th>
					<th>መበገሲ ሓሳብ ዘቕረበ ኣካል</th>
					<th>ዘፅደቐ ኣካል</th>
					 <th>ቕፅዓት ዝፀንሐሉ እዋን</th>
					<th>ቕፅዓት ዝተውሃቦ ዕለት</th>
					
				  </tr>
				</thead>


				<tbody>
				  <tr>
					<td>012 </td>
					<td>ቕፅዓት </td>
					<td>ቕፅዓት </td>
					<td>ቕፅዓት </td>
					<td>ቕፅዓት </td>
					<td>ቕፅዓት </td>
					<td>ቕፅዓት </td>
					<td>ቕፅዓት </td>
					<td><button class="edit-modal btn btn-info"
							<span class="glyphicon glyphicon-edit"></span>ኣመሓይሽ</button>
						<button class="delete-modal btn btn-danger"
							<span class="glyphicon glyphicon-trash"></span>ሰርዝ</button></td>  						  
				  </tr>
				   <tr>
					<td>012 </td>
					<td>ቕፅዓት </td>
					<td>ቕፅዓት </td>
					<td>ቕፅዓት </td>
					<td>ቕፅዓት </td>
					<td>ቕፅዓት </td>
					<td>ቕፅዓት </td>
					<td>ቕፅዓት </td>
					<td><button class="edit-modal btn btn-info"
							<span class="glyphicon glyphicon-edit"></span>ኣመሓይሽ</button>
						<button class="delete-modal btn btn-danger"
							<span class="glyphicon glyphicon-trash"></span>ሰርዝ</button></td>   						  
				  </tr>
				   <tr>
					<td>012 </td>
					<td>ቕፅዓት </td>
					<td>ቕፅዓት </td>
					<td>ቕፅዓት </td>
					<td>ቕፅዓት </td>
					<td>ቕፅዓት </td>
					<td>ቕፅዓት </td>
					<td>ቕፅዓት </td>
					<td><button class="edit-modal btn btn-info"
							<span class="glyphicon glyphicon-edit"></span>ኣመሓይሽ</button>
						<button class="delete-modal btn btn-danger"
							<span class="glyphicon glyphicon-trash"></span>ሰርዝ</button></td> 						  
				  </tr>
				</tbody>
			  </table>
			</div>
		  </div>
		</div>
	</div>                     
</body>    
 
@endsection
@section('scripts-extra')
  <script>
function myFunction() {
    var x = document.getElementById('penaltylist');
	var y = document.getElementById('penaltydiv');
    if (y.style.display === 'none') {
		y.style.display = 'block';
		x.style.display = 'none';
    } else {
        x.style.display = 'block';
		y.style.display = 'none';
    }
}
function myFun() {
     var x = document.getElementById('penaltydiv');
	var y = document.getElementById('penaltylist');
    if (x.style.display === 'none') {
        y.style.display = 'block';
		x.style.display = 'none';
    } else {
        x.style.display = 'block';
		y.style.display = 'none';
    }
}
  </script>
 
@endsection
