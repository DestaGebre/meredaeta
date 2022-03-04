@extends('layouts.app')

@section('htmlheader_title')
    ዝውውር 
@endsection

@section('contentheader_title')
   ምሕደራ ዝውውር ኣባላት
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

            <!-- Profile Image -->
<body>
	<div class="box box-primary">
        <div class="myswitch pull-right">             
         	<button class="btn switchBtn btn-primary"><span class="glyphicon glyphicon-plus"></span> ሓዱሽ መዝግብ </button> 
     	</div>  
     <div class="mytoggle hidden pull-right">           
      <button class="btn toggleBtn btn-info"><span class="glyphicon glyphicon-arrow-up"></span></button>          
    </div>        
		<div id ="transferdiv" class="form-group hidden">
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
                <input type="text" id="hitsuyID1" name="hitsuyID" required="required" class="form-control col-md-7 col-xs-12" value="{{ $cnt ? Request::old('hitsuyID') : '' }}">
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
		 	<label class="control-label col-md-2 col-sm-3 col-xs-12" for="zone1">ዝተዛወረሉ ዞባ:<span class="text-danger">*</span></label>
	          <div class="col-md-3 col-sm-6 col-xs-12">
		          <select name="zone" id="zone1" class="form-control" required="required">
		              <option value=""selected disabled>~ዞባ ምረፅ~</option>
		              @foreach ($zobadatas as $key => $value)
		                  <option value="{{ $key }}">{{ $value }}</option>
		              @endforeach
		          </select>
	          </div>
	          
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="level1">ደረጃ ዝውውር:<span class="text-danger">*</span></label>
			<div class="col-md-3 col-sm-6 col-xs-12">

			 <select class="form-control" id="level1" name="level" required="required">
			   <option selected disabled>~ምረፅ~</option>
			   <option >ኣባል</option>
			   <option >ፀሓፊ</option>
			   <option >ሓላፊ</option>
			 </select>
			</div>	
	     
				
		</div>
		<div class="form-group">		            
	          
	          <label class="control-label col-md-2 col-sm-3 col-xs-12" for="woreda1">ዝተዛወረሉ ወረዳ:<span class="text-danger">*</span></label>
	              <div class="col-md-3 col-sm-6 col-xs-12">   
	              <select name="woreda" id="woreda1" class="form-control" required="required">
	      				<option value="">~ወረዳ ምረፅ~</option>
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
      		
          	<div class="form-group">

      			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="tabiaID1">ዝተዛወረሉ ጣብያ:<span class="text-danger">*</span></label>
	              <div class="col-md-3 col-sm-6 col-xs-12">   
	                    <select name="tabiaID" id="tabiaID1" class="form-control" required="required">
             				<option value=""selected disabled>~ጣብያ ምረፅ~</option>
                      	</select>
                    </div>
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
            </div>
            <div class="form-group">
				
		     	<label class="control-label col-md-2 col-sm-3 col-xs-12" for="proposerWidabe1">ዝተዛወረሉ መሰረታዊ ውዳበ:<span class="text-danger">*</span></label>
	              <div class="col-md-3 col-sm-6 col-xs-12">  
                            <select name="proposerWidabe" id="proposerWidabe1" class="form-control" required="required">
                                <option value=""selected disabled>~መሰረታዊ ውዳበ ምረፅ~</option>
                            </select>
                       </div>
				<label class="control-label col-md-2 col-sm-3 col-xs-12" for="placement1">ምድብ ስራሕ<span class="required">（*）</span>
				</label>
				<div class="col-md-3 col-sm-6 col-xs-12">
				  <input type="text" id="placement1" name="placement" required="required" class="form-control col-md-7 col-xs-12" value="{{ $cnt ? Request::old('placement') : '' }}">
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
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="office1">ቤ/ፅሕፈት(ትካል)<span class="required">（*）</span>
			</label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <input type="text" id="office1" name="office" required="required" class="form-control col-md-7 col-xs-12" value="{{ $cnt ? Request::old('office') : '' }}">
			</div>
		
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="position1">ሓላፍነት<span class="required">（*）</span>
			</label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <input type="text" id="position1" name="position" required="required" class="form-control col-md-7 col-xs-12" value="{{ $cnt ? Request::old('position') : '' }}">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="transby1">ዘዛወረ ኣካል<span class="required">（*）</span>
			</label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <input type="text" id="transby1" name="transby" required="required" class="form-control col-md-7 col-xs-12" value="{{ $cnt ? Request::old('transby') : '' }}">
			</div>
		
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="approvedby1">ዘፅደቐ ኣካል<span class="required">（*）</span>
			</label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <input type="text" id="approvedby1" name="approvedby" required="required" class="form-control col-md-7 col-xs-12" value="{{ $cnt ? Request::old('approvedby') : '' }}">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="transStart1">ዝውውር ዝጀመረሉ ዕለት<span class="required">（*）</span>
			</label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <input type="text" id="transStart1" name="transStart" required="required" class="form-control col-md-7 col-xs-12" value="{{ $cnt ? Request::old('transStart') : '' }}">
			</div>
		 
			<!-- <label class="control-label col-md-2 col-sm-3 col-xs-12" for="transend1">ዝውውር ዘብቀዐሉ ዕለት<span class="required">（*）</span>
			</label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <input type="text" id="transend1" name="transend" required="required" class="form-control col-md-7 col-xs-12" value="{{ $cnt ? Request::old('transend') : '' }}">
			</div> -->
		 </div> 	

		 <div class="form-group">&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
							<label>&nbsp &nbsp ናይ ዝውውር መረዳእታ ቕድሚ ምምዝጋቡ እዞም ዝስዕቡ ከም ዝተማለኡ አረጋግፅ </label>
							<div class="checkbox" >
								<label>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
                                <input type="hidden" name="isReported" value="0">
									<input type="checkbox" name="isReported" id="isReported" value="1" data-parsley-mincheck="2" class="flat">ናይ መበገሲ ሓሳብ እቲ ውልቀሰብ ኣባል ካብ ዝኾነሉ ውዳበ ናብ ልዕሊኡ ናብ ዘሎ ውዳበ ቐሪቡ እዩ
								</label>
							</div>
							<div class="checkbox">&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
								<label>&nbsp &nbsp &nbsp &nbsp &nbsp
                                <input type="hidden" name="isApproved" value="0">
								   <input type="checkbox" name="isApproved" id="isApproved" value="1" class="flat">መበገሲ ሓሳብ ዝቐረበሉ ውዳበ ነቲ ካብ ብትሕቲኡ ዘሎ ውዳበ ዝቐረበሉ ኣፅዲቕዎ እዩ
								</label>
							</div>
							<div class="checkbox">&nbsp &nbsp &nbsp &nbsp &nbsp
								<label>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
                                    <input type="hidden" name="isApproved2" value="0">
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
                    <th class="text-center">ካብ</th>
                    <th class="text-center">ናብ</th>
					<!-- <th class="text-center">ዘብቀዐሉ ዕለት</th> -->
					<th class="text-center">ተግባር</th>
					
				  </tr>
				</thead>
				

				<tbody>
					@foreach ($data as $mytrans)
				  <tr>
                    <input type="hidden" value="{{ $mytrans->id }}">
                    <input type="hidden" value="{{ $mytrans->position }}">
                    <input type="hidden" value="{{ $mytrans->transferedBy }}">
                    <input type="hidden" value="{{ $mytrans->approvedBy }}">
                    <input type="hidden" value="{{ $mytrans->zone }}">
                    <input type="hidden" value="{{ $mytrans->woreda }}">
                    <input type="hidden" value="{{ $mytrans->tabia }}">
                    <input type="hidden" value="{{ $mytrans->assignedWudabe }}">
                    <input type="hidden" value="{{ $mytrans->assignedWahio }}">
				  	<td>{{ $mytrans->hitsuyID }} </td>
					<td>{{ $mytrans->hitsuytrans->name }} {{ $mytrans->hitsuytrans->fname }} {{ $mytrans->hitsuytrans->gfname }}</td>
					<td>{{ $mytrans->committee }}</td>
					<td>{{ $mytrans->dereja }}</td>
					<td>{{ $mytrans->place }}</td>
					<td>{{ $mytrans->reason }}</td>
					<td>{{ $mytrans->assignment }}</td>
					<td>{{ $mytrans->office }}</td>
					<!-- <td>{{ $mytrans->position }} </td>	 -->
					<td>{{ App\DateConvert::toEthiopian(date('d/m/Y',strtotime($mytrans->startDate))) }}</td>
					<!-- <td>{{ $mytrans->endDate }} </td> -->
                    <?php
                        $oldWahio = App\Wahio::where('id', $mytrans->oldassignedWahio)->first();
                        $wahio = App\Wahio::where('id', $mytrans->assignedWahio)->first();
                    ?>
                    <td> {{ $oldWahio->wahiosmw->widabes->tabiatat->zonat->zoneName . '/' . $oldWahio->wahiosmw->widabes->tabiatat->name . '/' . $oldWahio->wahiosmw->widabes->tabiaName . '/' . $oldWahio->wahiosmw->widabeName . '/' . $oldWahio ->wahioName }} </td>
                    <td> {{ $wahio->wahiosmw->widabes->tabiatat->zonat->zoneName . '/' . $wahio->wahiosmw->widabes->tabiatat->name . '/' . $wahio->wahiosmw->widabes->tabiaName . '/' . $wahio->wahiosmw->widabeName . '/' . $wahio ->wahioName }} </td>
					<td>
                    @if (array_search(Auth::user()->usertype, ['admin', 'zoneadmin', 'woredaadmin']) !== false)
                    <button class="edit-modal btn btn-info btn-xs" data-info="">
	                  <span class="glyphicon glyphicon-edit"></span></button>
	                  <button class="delete-modal btn btn-danger btn-xs" data-info="">
	                  <span class="glyphicon glyphicon-trash"></span></button>
                    @endif
	                 <!-- if($mytrans->dereja=='ሓላፊ') -->
                    <button class="view-detail btn btn-warning btn-xs" data-info="{{ $mytrans->hitsuytrans->name }} {{ $mytrans->hitsuytrans->fname }} {{ $mytrans->hitsuytrans->gfname }},{{ $mytrans->hitsuytrans->gender }},{{ (date('Y') - date('Y',strtotime($mytrans->hitsuytrans->dob))) }},{{ $zobadatas[$woredadata[$tabiadata[$mytrans->hitsuytrans->tabiaID]]] }},{{ $woredaname[$tabiadata[$mytrans->hitsuytrans->tabiaID]] }},{{ $tabianame[$mytrans->hitsuytrans->tabiaID] }},{{ $mytrans->hitsuytrans->position }},{{ $mytrans->hitsuytrans->approvedhitsuy->membershipType }},{{ $mytrans->hitsuytrans->approvedhitsuy->membershipDate }}">
                    <span class="glyphicon glyphicon-eye-open"></span></button>
                  <!-- endif -->
                	</td>
				  </tr>
				 @endforeach
				   
				</tbody>
			  </table>
		
		</div>
        {{ $data->links() }}
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
                <input type="text" id="zone" name="zone" class="form-control" readonly>
            </div>
            <label class="control-label col-md-1 col-sm-1" for="woreda">ወረዳ:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="woreda" name="woreda" class="form-control" readonly>
            </div>
            <label class="control-label col-md-1 col-sm-1" for="position">ሓላፍነት:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="position" name="position" class="form-control" readonly>
            </div>   
            
    </div>
    <div class="form-group col-sm-12 col-md-12"> 
    	<label class="control-label col-md-1 col-sm-1" for="zone1">ናብ ዞባ:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="zone1" name="zone" class="form-control" readonly>
            </div>
            <label class="control-label col-md-1 col-sm-1" for="woreda1">ወረዳ:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="woreda1" name="woreda" class="form-control" readonly>
            </div>
            <label class="control-label col-md-1 col-sm-1" for="position1">ሓላፍነት:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="position1" name="position" class="form-control" readonly>
            </div>   
            
    </div>
    <div class="form-group col-sm-12 col-md-12">           
    		<label class="control-label col-md-12 col-sm-12">1. ጥረ ሓቅታት ብዝምልከት:</label> 
    	</div>
    <div class="form-group col-sm-12 col-md-12">            
            <label class="control-label col-md-2 col-sm-2" for="fullName2">1.1 ሙሉእ ሽም:</label>
            <div class="col-md-4 col-sm-4 col-xs-4">
                <input type="text" id="fullName2" name="fullName" class="form-control" readonly>
            </div>
            <label class="control-label col-md-1 col-sm-1" for="gender2">ፆታ:</label>
            <div class="col-md-1 col-sm-1 col-xs-1">
                <input type="text" id="gender2" name="gender" class="form-control" readonly>
            </div>
            <label class="control-label col-md-1 col-sm-1" for="dob2">ዕድመ:</label>
            <div class="col-md-1 col-sm-1 col-xs-1">
                <input type="text" id="dob2" name="dob" class="form-control" readonly>
            </div>   
        </div>
            <div class="form-group col-sm-12 col-md-12"> 
            
            <label class="control-label col-md-1 col-sm-1" for="educationLevel2">ት/ደ:</label>
            <div class="col-md-1 col-sm-1 col-xs-1">
                <input type="text" id="educationLevel2" name="educationLevel" class="form-control" readonly>
            </div>  
            <label class="control-label col-md-1 col-sm-1" for="educationType">ዓ/ት/ቲ:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="educationType" name="educationType" class="form-control" readonly>
            </div> 
            <label class="control-label col-md-1 col-sm-1" for="membershipDate">ናይ ኣ/ዘመን:</label>
            <div class="col-md-1 col-sm-1 col-xs-1">
                <input type="text" id="membershipDate" name="membershipDate" class="form-control" readonly>
            </div>                       
        </div>
        <div class="form-group col-sm-12 col-md-12"> 
        	<label class="control-label col-md-1 col-sm-1" for="typeofmember">ዓይነት ኣባል:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="typeofmember" name="typeofmember" class="form-control" readonly>
            </div> 
          <label class="control-label col-md-2 col-sm-2" for="numberofyears">ፃኒሒት ግዜ ኣብ ኣመራርሓ:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="numberofyears" name="numberofyears" class="form-control" readonly>
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
			   @foreach ($zobadatas as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
			 </select>
			</div>	
	     
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="woreda5">ዝተዛወረሉ ወረዳ:<span class="text-danger">*</span></label>
              <div class="col-md-3 col-sm-6 col-xs-12">   
              <select name="woreda" id="woreda5" class="form-control" required="required">
                    <option value="">~ወረዳ ምረፅ~</option>
              </select>
            </div>
		</div>
        <div class="form-group">

                <label class="control-label col-md-2 col-sm-3 col-xs-12" for="tabiaID5">ዝተዛወረሉ ጣብያ:<span class="text-danger">*</span></label>
                  <div class="col-md-3 col-sm-6 col-xs-12">   
                        <select name="tabiaID" id="tabiaID5" class="form-control" required="required">
                            <option value=""selected disabled>~ጣብያ ምረፅ~</option>
                        </select>
                    </div>
                    <label class="control-label col-md-2 col-sm-3 col-xs-12" for="proposerWidabe5">ዝተዛወረሉ መሰረታዊ ውዳበ:<span class="text-danger">*</span></label>
                  <div class="col-md-3 col-sm-6 col-xs-12">  
                            <select name="proposerWidabe" id="proposerWidabe5" class="form-control" required="required">
                                <option value=""selected disabled>~መሰረታዊ ውዳበ ምረፅ~</option>
                            </select>
                       </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-2 col-sm-3 col-xs-12" for="proposerWahio5">ዝተዛወረሉ ዋህዮ:<span class="text-danger">*</span></label>
                    <div class="col-md-3 col-sm-6 col-xs-12">  
                        <select class="form-control" id="proposerWahio5" name="proposerWahio" required="required">
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
             ዝውውር "<span class="hID text-danger"></span>" ብትክክል ክስረዝ ተወሲኑ ድዩ  ? <span
              class="hidden did"></span>
              <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
          </div>
          <div class="modal-footer">
            <button type="button" class="btn actionBtn">
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
        $('.alert-danger').remove();
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


        $('select[id="zone5"]').on('change', function() {
                var stateID = $(this).val();                

               if(stateID) {
                $.ajax({
                    url: 'myform/ajax/'+stateID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {

                        
                        $('select[id="woreda5"]').empty();
                        $('select[id="woreda5"]').append('<option value="'+ " " +'" selected disabled>'+ "~ወረዳ ምረፅ~" +'</option>');
                        $.each(data, function(key, value) {
                            $('select[id="woreda5"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                        if(update){
                            $('#woreda5').val(stuff[5]);
                            $('#woreda5').change();
                        }

                    }
                });
            }else{
                $('select[id="woreda5"]').empty();
            }
        });
                $('select[id="woreda5"]').on('change', function() {
            var stateID = $(this).val();
                
        

               if(stateID) {
                $.ajax({
                    url: 'myform2/ajax/'+stateID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {

                        
                        $('select[id="tabiaID5"]').empty();
                        $('select[id="tabiaID5"]').append('<option value="'+ " " +'" selected disabled>'+ "~ጣብያ ምረፅ~" +'</option>');
                        $.each(data, function(key, value) {
                            $('select[id="tabiaID5"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                        if(update){
                            $('#tabiaID5').val(stuff[6]);
                            $('#tabiaID5').change();
                        }

                    }
                });
            }else{
                $('select[id="tabiaID5"]').empty();
            }
        });
        $('select[id="tabiaID5"]').on('change', function() {
            var stateID = $(this).val();
            

               if(stateID) {
                $.ajax({
                    url: 'myform2/ajax/wahio/'+stateID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {

                        
                        $('select[id="proposerWidabe5"]').empty();
                        $('select[id="proposerWidabe5"]').append('<option value="'+ " " +'" selected disabled >'+ "~መሰረታዊ ውዳበ ምረፅ~" +'</option>');
                        $.each(data, function(key, value) {
                            $('select[id="proposerWidabe5"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });

                        if(update){
                            $('#proposerWidabe5').val(stuff[7]);
                            $('#proposerWidabe5').change();
                        }

                    }
                });
            }else{
                $('select[id="proposerWidabe5"]').empty();
            }
        });
        $('select[id="proposerWidabe5"]').on('change', function() {
            var stateID = $(this).val();

               if(stateID) {
                $.ajax({
                    url: 'myform2/ajax/wahio/meseretawi/'+stateID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {

                        
                        $('select[id="proposerWahio5"]').empty();
                        $('select[id="proposerWahio5"]').append('<option value="'+ " " +'" selected disabled>'+ "~ዋህዮ ምረፅ~" +'</option>');
                        $.each(data, function(key, value) {
                            $('select[id="proposerWahio5"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                        if(update){
                            $('#proposerWahio5').val(stuff[8]);
                            $('#myModal').modal('show');
                            update = false;
                        }

                    },
                    error: function(xhr,errorType,exception){                        
                      alert(exception);                      
                    }
                });
            }else{
                $('select[id="proposerWahio5"]').empty();
            }
        });
    var row,stuff,update=false;
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
        row = $($($(this).parent()).parent()).children();
        stuff = [$(row[0]).val(),$(row[1]).val(),$(row[2]).val(),$(row[3]).val(),$(row[4]).val(),$(row[5]).val(),$(row[6]).val(),$(row[7]).val(),$(row[8]).val(),$(row[9]).html(),$(row[10]).html(),$(row[11]).html(),$(row[12]).html(),$(row[13]).html(),$(row[14]).html(),$(row[15]).html(),$(row[16]).html(),$(row[17]).html()];
        update = true;
        fillmodalData(stuff);
    });

    function fillmodalData(details){
      $('#position').val(details[1]);
      $('#transby').val(details[2]);
      $('#approvedby').val(details[3]);
      $('#zone5').val(details[4]);
      $('#zone5').change();
      $('#hitsuyID').val(details[9]);
      $('#commite').val(details[11]);
      $('#level').val(details[12]);
      $('#place').val(details[13]);
      $('#reason').val(details[14]);
      $('#placement').val(details[15]);
      $('#office').val(details[16]);
      $('#transStart').val(details[17]);
    }
    $('.modal-footer').on('click', '.edit', function() {
        $.ajax({
            type: 'post',
            url: 'edittransfer',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': stuff[0],
                'hitsuyID': $('#hitsuyID').val(),
                'commite': $('#commite').val(),
                'level': $('#level').val(),
                'place': $('#place').val(),
                'zone': $('#zone5').val(),
                'woreda': $('#woreda5').val(),
                'tabiaID': $('#tabiaID5').val(),
                'proposerWidabe': $('#proposerWidabe5').val(),
                'proposerWahio': $('#proposerWahio5').val(),
                'reason': $('#reason').val(),
                'placement': $('#placement').val(),
                'office': $('#office').val(),
                'position': $('#position').val(),
                'transby': $('#transby').val(),
                'approvedby': $('#approvedby').val(),
                'transStart': $('#transStart').val(),
              
            },
			
            success: function(data) {
            	  if(data[0] == true){
                    $(row[1]).val($('#position').val());
                    $(row[2]).val($('#transby').val());
                    $(row[3]).val($('#approvedby').val());
                    $(row[4]).val($('#zone5').val());
                    $(row[5]).val($('#woreda5').val());
                    $(row[6]).val($('#tabiaID5').val());
                    $(row[7]).val($('#proposerWidabe5').val());
                    $(row[8]).val($('#proposerWahio5').val());
                    $(row[11]).html($('#commite').val());
                    $(row[12]).html($('#level').val());
                    $(row[13]).html($('#place').val());
                    $(row[14]).html($('#reason').val());
                    $(row[15]).html($('#placement').val());
                    $(row[16]).html($('#office').val());
                    $(row[17]).html($('#transStart').val());
                    $('#myModal').modal('hide');
                }
                else{
                    if(Array.isArray(data[2]))
                        data[2] = data[2].join('<br>');
                }
            
              toastr.clear();
              toastr[data[1]](data[2]);
              if(data[0] == true){
              }
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
        row = $($($(this).parent()).parent()).children();
        $('.did').text($(row[0]).val());
        $('.hID').text($(row[10]).html()+'('+$(row[9]).html()+')');

        $('#myModal').modal('show');
    });
    $('.modal-footer').on('click', '.delete', function() {
        $.ajax({
            type: 'post',
            url: 'deletetransfer',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('.did').text()
                
            },
            
            success: function(data) {
                if(data[0] == true){
                    $('#myModal').modal('hide');
                    toastr.clear();
                    toastr['warning'](data[1]);
                    setTimeout(function() {row.remove();}, 1000);
                } 
            }
        });
    });
    $('#transStart1').calendarsPicker({calendar: $.calendars.instance('ethiopian')});
    $('#transStart').calendarsPicker({calendar: $.calendars.instance('ethiopian')});
    @if (count($errors) > 0)
        $('.switchBtn').click();
    @endif
	
  </script>

<link rel="stylesheet" href="css/jquery.dataTables.min.css"></style>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
@endsection

