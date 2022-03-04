@extends('layouts.app')

@section('htmlheader_title')
    ዝውውር 
@endsection

@section('contentheader_title')
   ምሕደራ ዝውውር ኣባላት
@endsection

@section('header-extra')
  
@endsection

@section('main-content')

            <!-- Profile Image -->
<body>
	<div class="box box-primary">
        <div class="myswitch pull-right">             
         	<button class="btn switchBtn btn-primary"><span class="glyphicon glyphicon-plus"></span> ሓዱሽ መዝግብ </button> 
     	</div>  
     <div class="mytoggle hidden pull-right">           
      <button class="btn toggleBtn btn-info"><span class="glyphicon glyphicon-arrow-up"></span></button>          
    </div>
		@if (count($errors) > 0)
	         <div class = "alert alert-danger">
	            <ul>
	               @foreach ($errors->all() as $error)
	                  <li>{{ $error }}</li>
	               @endforeach
	            </ul>
	         </div>
	      @endif	        
		<div id ="transferdiv" class="form-group hidden">
      </br> 
	      
        <div style="padding: 0px 0px 10px 385px">
          <button class="btn search-modal"><span class="glyphicon glyphicon-search"></span> ካብ ማህደር ድለ</button> 
        </div>
          <form id="demo-form2" method="POST" action= "{{URL('transfer')}}" data-parsley-validate class="form-horizontal form-label-left">
                          
				{{ csrf_field() }}	
            <div class="form-group">
              <label class="control-label col-md-2 col-sm-3 col-xs-12" for="hitsuyID1">መፍለይ ቑፅሪ ኣባል  <span class="required">（*）</span>
              </label>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <input type="text" id="hitsuyID1" name="hitsuyID" required="required" class="form-control col-md-7 col-xs-12" >
              </div>
              <!-- <button class="btn search-modal"><span class="glyphicon glyphicon-search"></span> ካብ ማህደር ድለ</button>           -->
            
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="commite1">ዝተዛወረሉ ኮሚቴ :<span class="text-danger">*</span></label>
			<div class="col-md-3 col-sm-6 col-xs-12">

			 <select class="form-control" id="commite1" name="commite" required="required">
			   <option selected disabled>~ምረፅ~</option>
			   <option >መሰረታዊ ውዳበ ኮሚቴ</option>
			   <option >ጣብያ ኮሚቴ</option>
			   <option >ወረዳ ኮሚቴ</option>
			   <option >ዞባ ኮሚቴ</option>
			   <option >ማእኸላይ ኮሚቴ</option>
			   <option >ማእኸላይ ኮሚቴ</option>
			 </select>
			</div>
			</div>
		 <div class="form-group">
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="level1">ደረጃ ዝውውር:<span class="text-danger">*</span></label>
			<div class="col-md-3 col-sm-6 col-xs-12">

			 <select class="form-control" id="level1" name="level" required="required">
			   <option selected disabled>~ምረፅ~</option>
			   <option >ኣባል</option>
			   <option >ፀሓፊ</option>
			   <option >ሓላፊ</option>
			 </select>
			</div>	
	     
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="place1">ዝተዛወረሉ ቦታ:<span class="text-danger">*</span></label>
			<div class="col-md-3 col-sm-6 col-xs-12">

			 <select class="form-control" id="place1" name="place" required="required">
			   <option selected disabled>~ምረፅ~</option>
			   <option >ናይ ውድብ</option>
			   <option >ናይ መንግስቲ</option>
			 </select>
			</div>	
		</div>

	<!--	<div class="form-group">
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="zone4">ዝተዛወረሉ ዞባ:<span class="text-danger">*</span></label>
			<div class="col-md-3 col-sm-6 col-xs-12">

			 <select class="form-control" id="zone4" name="zone" required="required">
			   <option selected disabled>~ምረፅ~</option>
			   <option >ማእኸላይ</option>
			   <option >ሰሜናዊ ምዕራብ</option>
			   <option >ምዕራብ</option>
			   <option >ምብራቅ</option>
			   <option >ደቡባዊ ምብራቅ</option>
			   <option >መቀለ</option>
			   <option >ደቡብ</option>
			 </select>
			</div>	
	     
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="woreda4">ዝተዛወረሉ ወረዳ:<span class="text-danger">*</span></label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			 <input type="text" id="woreda4" name="woreda" required="required"class="form-control col-md-7 col-xs-12">			   
			</div>	
		</div>

				<div class="form-group">
      			  <div class="col-md-3 col-sm-6 col-xs-12">
				  <input type="text" id="zone0" name="zone0" required="required" class="form-control col-md-7 col-xs-12">
				</div>

				<div class="col-md-3 col-sm-6 col-xs-12">
				  <input type="text" id="woreda0" name="woreda0" required="required" class="form-control col-md-7 col-xs-12">
				</div>

				<div class="col-md-3 col-sm-6 col-xs-12">
				  <input type="text" id="tabiaID0" name="tabiaID0" required="required" class="form-control col-md-7 col-xs-12">
				</div>				
				<div class="col-md-3 col-sm-6 col-xs-12">
				  <input type="text" id="proposerWidabe0" name="proposerWidabe0" required="required" class="form-control col-md-7 col-xs-12">
				</div>
    			
          		</div>
          	    
				<div class="form-group">
      			
      			
            </div>
            <div class="form-group">
      			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="proposerWidabe0">ዝነበረሉ መሰረታዊ ውዳበ<span class="required">（*）</span></label>				
				<div class="col-md-3 col-sm-6 col-xs-12">
				  <input type="text" id="proposerWidabe0" name="proposerWidabe0" required="required" class="form-control col-md-7 col-xs-12">
				</div>
      			
            </div>
		 -->
		<div class="form-group">		            
	          
	          <label class="control-label col-md-2 col-sm-3 col-xs-12" for="zone1">ዝተዛወረሉ ዞባ:<span class="text-danger">*</span></label>
	          <div class="col-md-3 col-sm-6 col-xs-12">
		          <select name="zone" id="zone1" class="form-control" required="required">
		              <option value=""selected disabled>~ዞባ ምረፅ~</option>
		              @foreach ($zobadatas as $key => $value)
		                  <option value="{{ $key }}">{{ $value }}</option>
		              @endforeach
		          </select>
	          </div>
	          <label class="control-label col-md-2 col-sm-3 col-xs-12" for="woreda1">ዝተዛወረሉ ወረዳ:<span class="text-danger">*</span></label>
	              <div class="col-md-3 col-sm-6 col-xs-12">   
	              <select name="woreda" id="woreda1" class="form-control" required="required">
	      				<option value="">~ወረዳ ምረፅ~</option>
	              </select>
	            </div>
          </div>
      		
          	<div class="form-group">

      			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="tabiaID1">ዝተዛወረሉ ጣብያ:<span class="text-danger">*</span></label>
	              <div class="col-md-3 col-sm-6 col-xs-12">   
	                    <select name="tabiaID" id="tabiaID1" class="form-control" required="required">
             				<option value=""selected disabled>~ጣብያ ምረፅ~</option>
                      	</select>
                    </div>
                    <label class="control-label col-md-2 col-sm-3 col-xs-12" for="proposerWidabe1">ዝተዛወረሉ መሰረታዊ ውዳበ:<span class="text-danger">*</span></label>
	              <div class="col-md-3 col-sm-6 col-xs-12">  
                            <select name="proposerWidabe" id="proposerWidabe1" class="form-control" required="required">
                                <option value=""selected disabled>~መሰረታዊ ውዳበ ምረፅ~</option>
                            </select>
                       </div>
            </div>
            
            <div class="form-group">
      			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="proposerWahio1">ዝተዛወረሉ ዋህዮ:<span class="text-danger">*</span></label>
	              	<div class="col-md-3 col-sm-6 col-xs-12">  
                        <select class="form-control" id="proposerWahio1" name="proposerWahio" required="required">
                    		<option selected disabled>~ዋህዮ ምረፅ~</option>
                  		</select>
                    </div>                 
		      		<div class="col-md-3 col-sm-6 col-xs-12">
						  <input type="hidden" id="oldzone" name="oldzone" required="required" value="" class="form-control col-md-7 col-xs-12">
						  <input type="hidden" id="oldworeda" name="oldworeda" required="required" value="" class="form-control col-md-7 col-xs-12">
						  <input type="hidden" id="oldtabia" name="oldtabia" required="required" value="" class="form-control col-md-7 col-xs-12">
					      <input type="hidden" id="oldproposerWidabe" name="oldproposerWidabe" value="" required="required" class="form-control col-md-7 col-xs-12">
					      <input type="hidden" id="oldassignedWahio" name="oldassignedWahio" value="" required="required" class="form-control col-md-7 col-xs-12">
					</div>  
						
          		
                </div>                 
                 <!-- <div class="form-group col-md-12 col-sm-12 col-xs-12">                    
              <div class="col-md-12 col-sm-12 col-xs-12">
                            <select class="form-control" id="members1" name="members" required="required">
                    <option selected disabled>~ኣባል ምረፅ~</option>
                  </select>
                        </div>                        
                  </div> -->
		<div class="form-group">
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="reason1">ዝተዛወረሉ ምኽንያት:<span class="text-danger">*</span></label>
			<div class="col-md-3 col-sm-6 col-xs-12">

			 <select class="form-control" id="reason1" name="reason" required="required">
			   <option selected disabled>~ምረፅ~</option>
			   <option >ቕፅዓት</option>
			   <option >ዕቤት</option>
			   <option >ናይ ውዳበ ውሳነ(ንስራሕ)</option>
			   <option >ናይ ኣባል ሕቶ(ማሕበራዊ)</option>
			   <option >ካሊእ</option>
			 </select>
			</div>	
	     
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="placement1">ምድብ ስራሕ<span class="required">（*）</span>
			</label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <input type="text" id="placement1" name="placement" required="required" class="form-control col-md-7 col-xs-12">
			</div>
			</div>

		<div class="form-group">
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="office1">ቤ/ፅሕፈት(ትካል)<span class="required">（*）</span>
			</label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <input type="text" id="office1" name="office" required="required" class="form-control col-md-7 col-xs-12">
			</div>
		
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="position1">ሓላፍነት<span class="required">（*）</span>
			</label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <input type="text" id="position1" name="position" required="required" class="form-control col-md-7 col-xs-12">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="transby1">ዘዛወረ ኣካል<span class="required">（*）</span>
			</label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <input type="text" id="transby1" name="transby" required="required" class="form-control col-md-7 col-xs-12">
			</div>
		
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="approvedby1">ዘፅደቐ ኣካል<span class="required">（*）</span>
			</label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <input type="text" id="approvedby1" name="approvedby" required="required" class="form-control col-md-7 col-xs-12">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="transStart1">ዝውውር ዝጀመረሉ ዕለት<span class="required">（*）</span>
			</label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <input type="text" id="transStart1" name="transStart" required="required" class="form-control col-md-7 col-xs-12">
			</div>
		 
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="transend1">ዝውውር ዘብቀዐሉ ዕለት<span class="required">（*）</span>
			</label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <input type="text" id="transend1" name="transend" required="required" class="form-control col-md-7 col-xs-12">
			</div>
		 </div> 	

		 <div class="form-group">&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
							<label>&nbsp &nbsp ናይ ዝውውር መረዳእታ ቕድሚ ምምዝጋቡ እዞም ዝስዕቡ ከም ዝተማለኡ አረጋግፅ </label>
							<div class="checkbox" >
								<label>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
									<input type="checkbox" name="isReported" id="isReported" value="1" data-parsley-mincheck="2" class="flat">ናይ መበገሲ ሓሳብ እቲ ውልቀሰብ ኣባል ካብ ዝኾነሉ ውዳበ ናብ ልዕሊኡ ናብ ዘሎ ውዳበ ቐሪቡ እዩ
								</label>
							</div>
							<div class="checkbox">&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
								<label>&nbsp &nbsp &nbsp &nbsp &nbsp
								   <input type="checkbox" name="isApproved" id="isApproved" value="1" class="flat">መበገሲ ሓሳብ ዝቐረበሉ ውዳበ ነቲ ካብ ብትሕቲኡ ዘሎ ውዳበ ዝቐረበሉ ኣፅዲቕዎ እዩ
								</label>
							</div>
							<div class="checkbox">&nbsp &nbsp &nbsp &nbsp &nbsp
								<label>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
									<input type="checkbox" name="isApproved2" id="isApproved2" value="1" class="flat">ብውድብ ንናይ ውድብ ስራሕቲ ዝተመደቡ ኣባላት ዞባን ወረዳን ኮሚቴታት ቢሮ ውዳበ ኣፅዲቕዎ እዩ
								</label>
							</div>
						</div>
			
		 			
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">                         
						
                          <button type="submit" class="btn btn-success">ኣቐምጥ</button>
                        </div>
                      </div>

                    </form>
                </div>
                 </div>
			
                      
		<div id="transferlist" class="form-group">
			<div class="box-header with-border">
		  <div class="col-sm-12">
			<div class="card-box table-responsive">
			  <p class="text-muted font-13 m-b-30">
			  </p>

	
	    {{ csrf_field() }}   
        <div class="table-responsive text-center">
          <table class="table table-striped table-borderless" id="table2">
				<thead>
				  <tr>
					<th class="text-center"> መፍለይ ቑፅሪ ኣባል</th>
					<th class="text-center"> ሽም</th>
					<th class="text-center">ዝተዛወረሉ ኮሚቴ </th>
					<th class="text-center">ደረጃ ዝውውር</th>
					<th class="text-center">ቦታ</th>
					<th class="text-center">ምኽንያት</th>
					<th class="text-center">ምድብ ስራሕ</th>
					<th class="text-center">ቤ/ፅ</th>
					<!-- <th class="text-center">ሓላፍነት</th> -->
					<th class="text-center">ዝጀመረሉ ዕለት</th>
					<th class="text-center">ዘብቀዐሉ ዕለት</th>
					<th class="text-center">ተግባር</th>
					
				  </tr>
				</thead>
				

				<tbody>
					@foreach ($data as $mytrans)
				  <tr>
				  	<td>{{ $mytrans->hitsuyID }} </td>
					<td>{{ $mytrans->hitsuytrans->name }} {{ $mytrans->hitsuytrans->fname }} {{ $mytrans->hitsuytrans->gfname }}</td>
					<td>{{ $mytrans->committee }} </td>
					<td>{{ $mytrans->dereja }} </td>
					<td>{{ $mytrans->place }} </td>
					<td>{{ $mytrans->reason }} </td>
					<td>{{ $mytrans->assignment }} </td>
					<td>{{ $mytrans->office }} </td>
					<!-- <td>{{ $mytrans->position }} </td>	 -->
					<td>{{ $mytrans->startDate }} </td>
					<td>{{ $mytrans->endDate }} </td>
					<td><button class="edit-modal btn btn-info" data-info="{{$mytrans->hitsuyID}},{{$mytrans->committee}},{{$mytrans->dereja}},{{$mytrans->place}},{{$mytrans->reason}},{{$mytrans->assignment}},{{$mytrans->office}},{{$mytrans->position}},{{$mytrans->transferedBy}},{{$mytrans->approvedBy}},{{$mytrans->startDate}},{{$mytrans->endDate}},{{$mytrans->id}},{{$mytrans->zone}},{{$mytrans->woreda}}">
	                  <span class="glyphicon glyphicon-edit"></span></button>
	                  <button class="delete-modal btn btn-danger" data-info="{{$mytrans->hitsuyID}},{{ $mytrans->endDate }},{{$mytrans->id}}">
	                  <span class="glyphicon glyphicon-trash"></span></button>
	                 @if($mytrans->dereja=='ሓላፊ')
                    <button class="view-detail btn btn-warning" data-info="{{ $mytrans->hitsuytrans->name }} {{ $mytrans->hitsuytrans->fname }} {{ $mytrans->hitsuytrans->gfname }},{{ $mytrans->hitsuytrans->gender }},{{ (date('Y') - date('Y',strtotime($mytrans->hitsuytrans->dob))) }},{{ $zobadatas[$woredadata[$tabiadata[$mytrans->hitsuytrans->tabiaID]]] }},{{ $woredaname[$tabiadata[$mytrans->hitsuytrans->tabiaID]] }},{{ $tabianame[$mytrans->hitsuytrans->tabiaID] }},{{ $mytrans->hitsuytrans->position }},{{ $mytrans->hitsuytrans->approvedhitsuy->membershipType }},{{ $mytrans->hitsuytrans->approvedhitsuy->membershipDate }}">
                    <span class="glyphicon glyphicon-eye-open"></span></button>                  
                  @endif
                	</td>  						  
				  </tr>
				 @endforeach
				   
				</tbody>
			  </table>
		
		</div>
		  </div>
		</div>
	  </div>
	  </div>
           
       	<!---     -->

       	<div id="myDetails" class="hidden">
  <form id="detail-form">   
  <div class="form-group">
    <h3><center><u>ናይ ኣመራርሓ ዝውውር ፎርማት /ቅጥዒ/ ዝምልከት</u></center></h3>
  </div> 
    <div class="form-group col-sm-12 col-md-12"> 
    	<label class="control-label col-md-1 col-sm-1" for="zone">ካብ ዞባ:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="zone" name="zone" class="form-control">
            </div>
            <label class="control-label col-md-1 col-sm-1" for="woreda">ወረዳ:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="woreda" name="woreda" class="form-control">
            </div>
            <label class="control-label col-md-1 col-sm-1" for="position">ሓላፍነት:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="position" name="position" class="form-control">
            </div>   
            
    </div>
    <div class="form-group col-sm-12 col-md-12"> 
    	<label class="control-label col-md-1 col-sm-1" for="zone1">ናብ ዞባ:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="zone1" name="zone" class="form-control">
            </div>
            <label class="control-label col-md-1 col-sm-1" for="woreda1">ወረዳ:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="woreda1" name="woreda" class="form-control">
            </div>
            <label class="control-label col-md-1 col-sm-1" for="position1">ሓላፍነት:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="position1" name="position" class="form-control">
            </div>   
            
    </div>
    <div class="form-group col-sm-12 col-md-12">           
    		<label class="control-label col-md-12 col-sm-12">1. ጥረ ሓቅታት ብዝምልከት:</label> 
    	</div>
    <div class="form-group col-sm-12 col-md-12">            
            <label class="control-label col-md-2 col-sm-2" for="fullName2">1.1 ሙሉእ ሽም:</label>
            <div class="col-md-4 col-sm-4 col-xs-4">
                <input type="text" id="fullName2" name="fullName" class="form-control">
            </div>
            <label class="control-label col-md-1 col-sm-1" for="gender2">ፆታ:</label>
            <div class="col-md-1 col-sm-1 col-xs-1">
                <input type="text" id="gender2" name="gender" class="form-control">
            </div>
            <label class="control-label col-md-1 col-sm-1" for="dob2">ዕድመ:</label>
            <div class="col-md-1 col-sm-1 col-xs-1">
                <input type="text" id="dob2" name="dob" class="form-control">
            </div>   
        </div>
            <div class="form-group col-sm-12 col-md-12"> 
            
            <label class="control-label col-md-1 col-sm-1" for="educationLevel2">ት/ደ:</label>
            <div class="col-md-1 col-sm-1 col-xs-1">
                <input type="text" id="educationLevel2" name="educationLevel" class="form-control">
            </div>  
            <label class="control-label col-md-1 col-sm-1" for="educationType">ዓ/ት/ቲ:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="educationType" name="educationType" class="form-control">
            </div> 
            <label class="control-label col-md-1 col-sm-1" for="membershipDate">ናይ ኣ/ዘመን:</label>
            <div class="col-md-1 col-sm-1 col-xs-1">
                <input type="text" id="membershipDate" name="membershipDate" class="form-control">
            </div>                       
        </div>
        <div class="form-group col-sm-12 col-md-12"> 
        	<label class="control-label col-md-1 col-sm-1" for="typeofmember">ዓይነት ኣባል:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="typeofmember" name="typeofmember" class="form-control">
            </div> 
          <label class="control-label col-md-2 col-sm-2" for="numberofyears">ፃኒሒት ግዜ ኣብ ኣመራርሓ:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="numberofyears" name="numberofyears" class="form-control">
            </div>
         </div>
              
        <div class="form-group col-sm-12 col-md-12"> 
            <label class="control-label" >1.2 ምኽንያት ሕቶ ናይ 2ተ ዞባ ስምምዕነት ብዝምልከት__________________________________________________________________________________________________________________________________</label>
        <div>
            <label class="control-label" >______________________________________________________________________________________________________________________________________________________________________</label>
              <label class="control-label" >______________________________________________________________________________________________________________________________________________________________________</label>
        </div>
        </div>
          <div class="form-group col-sm-12 col-md-12"> 
            <label class="control-label" >1.3 ኣጠቃላሊ ገምጋም ብዛዕባ ዝውውር ዝሓተተ ኣካል _____________________________________________________________________________________________________________________________________ </label>
            <div>
             <label class="control-label" >______________________________________________________________________________________________________________________________________________________________________</label>
              <label class="control-label" >______________________________________________________________________________________________________________________________________________________________________</label>
              </div>
              <div>
             <label class="control-label" >1.3.1 ጠ/ጎኒ ________________________________________________________________________________________________________________________________________________________________</label>
              <label class="control-label" >______________________________________________________________________________________________________________________________________________________________________</label>
              <label class="control-label" >______________________________________________________________________________________________________________________________________________________________________</label>
             </div>
              <div>
              <label class="control-label" for="strongFeature">መ/ጠ/ጎኒ ፤ </label>
            <div class="col-sm-12 col-md-12">
                <textarea rows="4" class="form-control" id="strongFeature" name="strongFeature" required></textarea>
            </div>  
            </div>        
            <div>
             <label class="control-label" >1.3.2 ድ/ጎኒ ________________________________________________________________________________________________________________________________________________________________</label>
              <label class="control-label" >______________________________________________________________________________________________________________________________________________________________________</label>
              <label class="control-label" >______________________________________________________________________________________________________________________________________________________________________</label>
             </div>
             <div>
              <label class="control-label" for="weakFeature"> መ/ደ/ጎኒ ፤ </label>
            <div class="col-sm-12 col-md-12">
                <textarea rows="4" class="form-control" id="weakFeature" name="weakFeature" required></textarea>
            </div>
            </div>          
        </div>
        
        <div class="form-group col-sm-12 col-md-12"> 
          <label class="control-label">1.4 ዝውውር ዝፈቀደ ውዳበ ሪኢቶ፤</label>
          <div>
            <label class="control-label" >1.4.1 ናይ ወረዳ ሪኢቶ  _____________________________________________________________________________________________________________________________________</label>
             <label class="control-label" >____________________________________________________________________________________________________________________________________________</label>
              <div>
              <label class="control-label" >ነቲ ዝውውር ዝፈቀደ ሽም ___________________________________________________ፊርማ ___________________________ ዕለት _________________________</label>
              </div>
              <label class="control-label" >1.6.2 ናይ ዞባ ውዳበ ሪኢቶ _________________________________________________________________________________________________________________________________</label>
              <label class="control-label" >____________________________________________________________________________________________________________________________________________</label>
              <div>
              <label class="control-label" >ነቲ ዝውውር ዝፈቀደ ሽም ___________________________________________________ፊርማ __________________________ ዕለት ________________________</label>
              </div>
              <label class="control-label" >1.6.3 ናይ ክልል ውሳነ _________________________________________________________________________________________________________________________________</label>
              <label class="control-label" >____________________________________________________________________________________________________________________________________________</label>
              <div>
              <label class="control-label" > ዝፈቀደ ኣካል ሽም ___________________________________________________ ፊርማ _______________________ ዕለት_________________</label>
          </div>
            </div>
        </div>


    <hr style="border:groove 1px #79D57E;"/>       
      </form>
      <div class="text-center">           
      <button  id="" class="btn printerBtn btn-info">Print </button>          
    </div>
      </div>
<!--  -->
   <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"></h4>

        </div>
        <div class="modal-body">
          <form class="form-horizontal formadder" role="form">

            <div class="form-group">
              <label class="control-label col-md-2 col-sm-3 col-xs-12" for="hitsuyID">መፍለይ ቑፅሪ ኣባል  <span class="required">（*）</span>
              </label>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <input type="text" id="hitsuyID" name="hitsuyID" readonly class="form-control col-md-7 col-xs-12">
                <input type="hidden" id="hhID" name="hhID" >
              </div>              
            
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="commite">ዝተዛወረሉ ኮሚቴ :<span class="text-danger">*</span></label>
			<div class="col-md-3 col-sm-6 col-xs-12">

			 <select class="form-control" id="commite" name="commite" required="required">
			   <option selected disabled>~ምረፅ~</option>
			   <option >መሰረታዊ ውዳበ ኮሚቴ</option>
			   <option >ጣብያ ኮሚቴ</option>
			   <option >ወረዳ ኮሚቴ</option>
			   <option >ዞባ ኮሚቴ</option>
			   <option >ማእኸላይ ኮሚቴ</option>
			   <option >ማእኸላይ ኮሚቴ</option>
			 </select>
			</div>
			</div>
			 <div class="form-group">
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="level">ደረጃ ዝውውር:<span class="text-danger">*</span></label>
			<div class="col-md-3 col-sm-6 col-xs-12">

			 <select class="form-control" id="level" name="level" required="required">
			   <option selected disabled>~ምረፅ~</option>
			   <option >ኣባል</option>
			   <option >ፀሓፊ</option>
			   <option >ሓላፊ</option>
			 </select>
			</div>	
	     
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="place">ዝተዛወረሉ ቦታ:<span class="text-danger">*</span></label>
			<div class="col-md-3 col-sm-6 col-xs-12">

			 <select class="form-control" id="place" name="place" required="required">
			   <option selected disabled>~ምረፅ~</option>
			   <option >ናይ ውድብ</option>
			   <option >ናይ መንግስቲ</option>
			 </select>
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="zone5">ዝተዛወረሉ ዞባ:<span class="text-danger">*</span></label>
			<div class="col-md-3 col-sm-6 col-xs-12">

			 <select class="form-control" id="zone5" name="zone" required="required">
			   <option selected disabled>~ምረፅ~</option>
			   <option >ማእኸላይ</option>
			   <option >ሰሜናዊ ምዕራብ</option>
			   <option >ምዕራብ</option>
			   <option >ምብራቅ</option>
			   <option >ደቡባዊ ምብራቅ</option>
			   <option >መቀለ</option>
			   <option >ደቡብ</option>
			 </select>
			</div>	
	     
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="woreda5">ዝተዛወረሉ ወረዳ:<span class="text-danger">*</span></label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			 <input type="text" id="woreda5" name="woreda" required="required"class="form-control col-md-7 col-xs-12">			   
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="reason">ዝተዛወረሉ ምኽንያት:<span class="text-danger">*</span></label>
			<div class="col-md-3 col-sm-6 col-xs-12">

			 <select class="form-control" id="reason" name="reason" required="required">
			   <option selected disabled>~ምረፅ~</option>
			   <option >ቕፅዓት</option>
			   <option >ዕቤት</option>
			   <option >ናይ ውዳበ ውሳነ(ንስራሕ)</option>
			   <option >ናይ ኣባል ሕቶ(ማሕበራዊ)</option>
			   <option >ካሊእ</option>
			 </select>
			</div>	
	     
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="placement">ምድብ ስራሕ<span class="required">（*）</span>
			</label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <input type="text" id="placement" name="placement" required="required" class="form-control col-md-7 col-xs-12">
			</div>
			</div>
		<div class="form-group">
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="office">ቤ/ፅሕፈት (ትካል)<span class="required">（*）</span>
			</label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <input type="text" id="office" name="office" required="required" class="form-control col-md-7 col-xs-12">
			</div>
		
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="position">ሓላፍነት<span class="required">（*）</span>
			</label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <input type="text" id="position" name="position" required="required" class="form-control col-md-7 col-xs-12">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="transby">ዘዛወረ ኣካል<span class="required">（*）</span>
			</label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <input type="text" id="transby" name="transby" required="required" class="form-control col-md-7 col-xs-12">
			</div>
		
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="approvedby">ዘፅደቐ ኣካል<span class="required">（*）</span>
			</label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <input type="text" id="approvedby" name="approvedby" required="required" class="form-control col-md-7 col-xs-12">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="transStart">ዝውውር ዝጀመረሉ ዕለት<span class="required">（*）</span>
			</label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <input type="text" id="transStart" name="transStart" required="required" class="form-control col-md-7 col-xs-12">
			</div>
		 
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="transend">ዝውውር ዘብቀዐሉ ዕለት<span class="required">（*）</span>
			</label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <input type="text" id="transend" name="transend" required="required" class="form-control col-md-7 col-xs-12">
			</div>
		 </div> 	
         <div class="col-md-6 col-sm-6 col-xs-12">
                         
        </div>
            
          </form> 
          <div class="searchContent">
          
          
                  <div class="form-group col-md-12 col-sm-12 col-xs-12">                      
                      <div class="col-md-6 col-sm-6 col-xs-6">    
                      <select name="zone" id="zone8" class="form-control" >
                          <option value=""selected disabled>~ዞባ ምረፅ~</option>
                          @foreach ($zobadatas as $key => $value)
                              <option value="{{ $key }}">{{ $value }}</option>
                          @endforeach
                      </select>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-6">    
                      <select name="woreda" id="woreda8" class="form-control">
              <option value="">~ወረዳ ምረፅ~</option>
                      </select>
                      </div>
                  </div>
                  <div class="form-group col-md-12 col-sm-12 col-xs-12">
                      <div class="col-md-6 col-sm-6 col-xs-6">    
                      <select name="tabiaID" id="tabiaID8" class="form-control" >
              <option value=""selected disabled>~ጣብያ ምረፅ~</option>
                      </select>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-6">    
                            <select name="proposerWidabe" id="proposerWidabe8" class="form-control">
                                <option value=""selected disabled>~መሰረታዊ ውዳበ ምረፅ~</option>
                            </select>
                       </div>
                  </div>
            <div class="form-group col-md-12 col-sm-12 col-xs-12">                    
              <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="form-control" id="proposerWahio8" name="proposerWahio" required="required">
                    <option selected disabled>~ዋህዮ ምረፅ~</option>
                  </select>
                        </div>                        
                  </div>                 
                  <div class="form-group col-md-12 col-sm-12 col-xs-12">                    
              <div class="col-md-12 col-sm-12 col-xs-12">
                            <select class="form-control" id="members" name="members" required="required">
                    <option selected disabled>~ኣባል ምረፅ~</option>
                  </select>
                        </div>                        
                  </div>
                
                
                    <p class="fname_error error text-center alert alert-danger hidden"></p>
                    
                    
                                    
          </div><!-- searchContent  --> 
            <div class="deleteContent">
             ዝውውር ናይ ኣባል መፍለይ ቑፅሪ "<span class="hID text-danger"></span>" ብትክክል ክዘዋወር ተወሲኑ ድዩ  ? <span
              class="hidden did"></span>
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

<!---     -->
  
                    
     
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
     });
  	$(document).on('click', '.switchBtn', function() {
    	$('#transferlist').addClass('hidden');
    	$('.myswitch').addClass('hidden');
        $('#transferdiv').removeClass('hidden');                 
        $('.mytoggle').removeClass('hidden'); 
        $('#myDetails').addClass('hidden');                
    });	
    $(document).on('click', '.toggleBtn', function() {
    	$('#transferdiv').addClass('hidden');
    	$('.mytoggle').addClass('hidden');
        $('#transferlist').removeClass('hidden');                 
        $('.myswitch').removeClass('hidden'); 
        $('#myDetails').addClass('hidden');                
    });	
    $(document).on('click', '.view-detail', function() {
    	$('#transferdiv').addClass('hidden');
    	$('.mytoggle').removeClass('hidden');
        $('#transferlist').addClass('hidden');                 
        $('.myswitch').addClass('hidden'); 
        $('#myDetails').removeClass('hidden'); 
        var stuff = $(this).data('info').split(',');
        fillComradesData(stuff)               
    });
     function fillComradesData(details){   
      $('#fullName2').val(details[0]);   
      $('#gender2').val(details[1]);
      $('#dob2').val(details[2]); 
      $('#zone').val(details[3]);   
      $('#woreda').val(details[4]); 
      $('#tabia').val(details[5]);
      $('#position').val(details[6]); 
      $('#typeofmember').val(details[7]); 
      $('#membershipDate').val(details[8]); 
  }
	$(document).on('click', '.search-modal', function() {
        $('#footer_action_button').text(" ምረፅ");
        $('#footer_action_button').addClass('glyphicon-search');
        $('#footer_action_button').removeClass('glyphicon-trash');
        $('#footer_action_button').removeClass('glyphicon-check');
        $('.actionBtn').addClass('btn-success');
        $('.actionBtn').removeClass('btn-danger');
        $('.actionBtn').removeClass('delete');
        $('.actionBtn').removeClass('edit');
        $('.actionBtn').addClass('search');
        $('.modal-title').text('ኣባል ካብ ማህደር መድለይ');
        $('.deleteContent').hide();
        $('.searchContent').show();
        $('.formadder').hide();
        $('#myModal').modal('show');
    });
    $('.modal-footer').on('click', '.search', function() {
    	var hID=$('#members').val();
		$('#hitsuyID1').val(hID);
		var zID=$('#zone8').val();
		$('#oldzone').val(zID);
		var wID=$('#woreda8').val();
		$('#oldworeda').val(wID);
		var tID=$('#tabiaID8').val();
		$('#oldtabia').val(tID);
		var pwID=$('#proposerWidabe8').val();
		$('#oldproposerWidabe').val(pwID);
		var pwhID=$('#proposerWahio8').val();
		$('#oldassignedWahio').val(pwhID);
		
    });
    //search chain
    $('select[name="zone"]').on('change', function() {
            var stateID = $(this).val();				

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
        });
		$('select[name="woreda"]').on('change', function() {
            var stateID = $(this).val();
				
        

               if(stateID) {
                $.ajax({
                    url: 'myform2/ajax/'+stateID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {

                        
                        $('select[name="tabiaID"]').empty();
						$('select[name="tabiaID"]').append('<option value="'+ " " +'" selected disabled>'+ "~ጣብያ ምረፅ~" +'</option>');
                        $.each(data, function(key, value) {
                            $('select[name="tabiaID"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });

                    }
                });
            }else{
                $('select[name="tabiaID"]').empty();
            }
        });
        $('select[name="tabiaID"]').on('change', function() {
            var stateID = $(this).val();
            

               if(stateID) {
                $.ajax({
                    url: 'myform2/ajax/wahio/'+stateID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {

                        
                        $('select[name="proposerWidabe"]').empty();
						$('select[name="proposerWidabe"]').append('<option value="'+ " " +'" selected disabled >'+ "~መሰረታዊ ውዳበ ምረፅ~" +'</option>');
                        $.each(data, function(key, value) {
                            $('select[name="proposerWidabe"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });

                    }
                });
            }else{
                $('select[name="proposerWidabe"]').empty();
            }
        });
		$('select[name="proposerWidabe"]').on('change', function() {
            var stateID = $(this).val();

               if(stateID) {
                $.ajax({
                    url: 'myform2/ajax/wahio/meseretawi/'+stateID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {

                        
                        $('select[name="proposerWahio"]').empty();
						$('select[name="proposerWahio"]').append('<option value="'+ " " +'" selected disabled>'+ "~ዋህዮ ምረፅ~" +'</option>');
                        $.each(data, function(key, value) {
                            $('select[name="proposerWahio"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });

                    },
		            error: function(xhr,errorType,exception){                        
		              alert(exception);                      
		            }
                });
            }else{
                $('select[name="proposerWahio"]').empty();
            }
        });
		$('select[name="proposerWahio"]').on('change', function() {
            var stateID = $(this).val();

               if(stateID) {
                $.ajax({
                    url: 'myform2/ajax/hitsuy/'+stateID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {

                        
                        $('select[name="members"]').empty();
						$('select[name="members"]').append('<option value="'+ " " +'">'+ "~ኣባል ምረፅ~" +'</option>');
                        $.each(data, function(key, value) {
                            $('select[name="members"]').append('<option value="'+ key +'">'+ value.join(' ') + ' (መለለዩ ቑፅሪ: '+key+' )</option>');
                        });

                    },
		            error: function(xhr,errorType,exception){                        
		              alert(exception);                      
		            }
                });
            }else{
                $('select[name="proposerWahio"]').empty();
            }
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
        $('.modal-title').text('መስተኻኸሊ ዝውውር ኣባል');
        $('.deleteContent').hide();
        $('.searchContent').hide();
        $('.formadder').show();
        var stuff = $(this).data('info').split(',');
        fillmodalData(stuff)
        $('#myModal').modal('show');
    });

    function fillmodalData(details){
    	
      $('#hhID').val(details[12]);	
      $('#hitsuyID').val(details[0]);
      $('#commite').val(details[1]);
      $('#level').val(details[2]);
      $('#place').val(details[3]);
      $('#reason').val(details[4]);
      $('#placement').val(details[5]);
      $('#office').val(details[6]);
      $('#position').val(details[7]);
      $('#transby').val(details[8]);
       $('#approvedby').val(details[9]);
      $('#transStart').val(details[10]);
      $('#transend').val(details[11]);   
      $('#zone').val(details[12]);
      $('#woreda').val(details[13]); 
    }
    $('.modal-footer').on('click', '.edit', function() {
        $.ajax({
            type: 'post',
            url: 'edittransfer',
            data: {
                '_token': $('input[name=_token]').val(),				
               'hitsuyID': $('#hhID').val(),
                'commite': $('#commite').val(),
                'level': $('#level').val(),
                'place': $('#place').val(),
                'zone': $('#zone').val(),
                'woreda': $('#woreda').val(),
                'reason': $('#reason').val(),
                'placement': $('#placement').val(),
                'office': $('#office').val(),
                'position': $('#position').val(),
                'transby': $('#transby').val(),
                'approvedby': $('#approvedby').val(),
                'transStart': $('#transStart').val(),
                'transend': $('#transend').val()
              
            },
			
            success: function(data) {
            	  document.getElementById("hitsuyID").value="";
            	  document.getElementById("hhID").value="";
			      document.getElementById("commite").value="";
			      document.getElementById("level").value="";
			      document.getElementById("place").value="";
			      document.getElementById("reason").value="";
			      document.getElementById("placement").value="";
			      document.getElementById("office").value="";
			      document.getElementById("position").value="";
			      document.getElementById("transby").value="";
			      document.getElementById("approvedby").value="";
			      document.getElementById("transStart").value="";
			      document.getElementById("transend").value="";
			      document.getElementById("zone").value="";
			      document.getElementById("woreda").value="";
			      
            	 },

            error: function(xhr,errorType,exception){
            		
            			alert(exception);
                        
            }
        });
    });
	$(document).on('click', '.delete-modal', function() {
        $('#footer_action_button').text("ሰርዝ");
        $('#footer_action_button').removeClass('glyphicon-check');
        $('#footer_action_button').removeClass('glyphicon-search');
        $('#footer_action_button').addClass('glyphicon-trash');
        $('.actionBtn').removeClass('btn-success');
        $('.actionBtn').addClass('btn-danger');
        $('.actionBtn').removeClass('edit');
        $('.actionBtn').removeClass('search');
        $('.actionBtn').addClass('delete');
        $('.modal-title').text(' መሰረዚ ዝውውር ኣባል');
        $('.deleteContent').show();
        $('.formadder').hide();
        $('.searchContent').hide();
        var stuff = $(this).data('info').split(',');			    
        $('.did').text(stuff[2]);	
        $('.hID').html(stuff[0]);

        $('#myModal').modal('show');
    });
    $('#transend1').calendarsPicker({calendar: $.calendars.instance('ethiopian')});
    $('#transStart1').calendarsPicker({calendar: $.calendars.instance('ethiopian')});
	
  </script>

<link rel="stylesheet" href="css/jquery.dataTables.min.css"></style>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
@endsection

