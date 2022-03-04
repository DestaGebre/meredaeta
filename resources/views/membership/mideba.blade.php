
@section('htmlheader_title')
    ምደባ 
@endsection
@extends('layouts.app')

@section('htmlheader_title')
    ምደባ 
@endsection

@section('contentheader_title')
   ምሕደራ ምደባ ኣባላት
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
	<div class="box box-primary">
        <div class="myswitch pull-right">             
         	<button class="btn switchBtn btn-info"><span class="glyphicon glyphicon-plus"></span> ሓዱሽ መዝግብ </button> 
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
		<div id ="midebadiv" class="form-group hidden">
      		</br> 
        <div style="padding: 0px 0px 10px 385px">
          <button class="btn search-modal"><span class="glyphicon glyphicon-search"></span> ካብ ማህደር ድለ</button> 
        </div>
                        <form id="demo-form2" method="POST" action= "{{URL('mideba')}}" data-parsley-validate class="form-horizontal form-label-left">
                          {{ csrf_field() }}
						</br>
                      <div class="form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12" for="hitsuyID1">መፍለይ ቑፅሪ ኣባል  <span class="required">（*）</span>
                        </label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                          <input type="text" id="hitsuyID1" name="hitsuyID" required="required" class="form-control col-md-7 col-xs-12">
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
	        
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="birkiCommittee1">ዝተመደበሉ ብርኪ ኮሚቴ:<span class="text-danger">*</span></label>
			<div class="col-md-3 col-sm-6 col-xs-12">

			 <select class="form-control" id="birkiCommittee1" name="birkiCommittee" required="required">
			   <option selected disabled>~ምረፅ~</option>
			   <option >መሰረታዊ ውዳበ ኮሚቴ</option>
			   <option >ጣብያ ኮሚቴ</option>
			   <option >ወረዳ/ክፍለከተማ ኮሚቴ</option>
			   <option >ዞባ ኮሚቴ</option>
			   <option >ተራ ኣባል</option>
			   <option >ካልእ</option>
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
	            <label class="control-label col-md-2 col-sm-3 col-xs-12" for="dereja1">ደረጃ ምደባ:<span class="text-danger">*</span></label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			 <select class="form-control" id="dereja1" name="dereja" required="required">
			   <option selected disabled>~ምረፅ~</option>
			   <option >ኣካቢ</option>
			   <option >ም/ኣካቢ</option>
			   <option >ፀሓፊ</option>
			   <option >ኣባል</option>
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
                     <label class="control-label col-md-2 col-sm-3 col-xs-12" for="awekakla1">ኣወኻኽላ:<span class="text-danger">*</span></label>
					<div class="col-md-3 col-sm-6 col-xs-12">
					 <select class="form-control" id="awekakla1" name="awekakla" required="required">
					   <option selected disabled>~ምረፅ~</option>
					   <option >ብመረፃ ዝተወከለ</option>
					   <option >ብምደባ ዝተወከለ</option>
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
					<label class="control-label col-md-2 col-sm-3 col-xs-12" for="type1">ዝተመደበሉ ቦታ:<span class="text-danger">*</span></label>
					<div class="col-md-3 col-sm-6 col-xs-12">
					 <select class="form-control" id="type1" name="type" required="required">
					   <option selected disabled>~ምረፅ~</option>
					   <option >ናይ ውድብ</option>
					   <option >ናይ መንግስቲ</option>
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
		      		 
				<label class="control-label col-md-2 col-sm-3 col-xs-12" for="reason1">ዝተመደበሉ ምኽንያት:<span class="text-danger">*</span></label>
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
          		<div class="col-md-3 col-sm-6 col-xs-12">
						  <input type="hidden" id="oldzone" name="oldzone" required="required" class="form-control col-md-7 col-xs-12">
						  <input type="hidden" id="oldworeda" name="oldworeda" required="required" class="form-control col-md-7 col-xs-12">
						  <input type="hidden" id="oldtabia" name="oldtabia" required="required" class="form-control col-md-7 col-xs-12">
					      <input type="hidden" id="oldproposerWidabe" name="oldproposerWidabe" required="required" class="form-control col-md-7 col-xs-12">
					      <input type="hidden" id="oldassignedWahio" name="oldassignedWahio" required="required" class="form-control col-md-7 col-xs-12">
					</div> 
                </div>
		  
		 <div class="form-group">
			
					
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="proposedBy1">መበገሲ ሓሳብ ዘቕረበ ኣካል<span class="required"></span>
			</label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <input type="text" id="proposedBy1" name="proposedBy" required="required" class="form-control col-md-7 col-xs-12">
			</div>
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="commentedBy1">ርእይቶ ዝሃበ ኣካል<span class="required"></span>
			</label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <input type="text" id="commentedBy1" name="commentedBy" required="required" class="form-control col-md-7 col-xs-12">
			</div>

		 </div>
		 <div class="form-group">
			
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="approvedBy1">ዘፅደቐ ኣካል<span class="required">（*）</span>
			</label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <input type="text" id="approvedBy1" name="approvedBy" required="required" class="form-control col-md-7 col-xs-12">
			</div>
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="startDate1">ምደባ ዝጀመረሉ ዕለት<span class="required">（*）</span>
			</label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <input type="text" id="startDate1" name="startDate" required="required" class="form-control col-md-7 col-xs-12">
			</div>

		 </div>
		 <!--<div class="form-group">
			
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="endDate1">ምደባ ዘብቀዐሉ ዕለት<span class="required">（*）</span>
			</label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <input type="text" id="endDate1" name="endDate" required="required" class="form-control col-md-7 col-xs-12">
			</div>
		</div>-->
		 </br>
		 </br>	
		 <div class="form-group"> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
							<label>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp ናይ ምደባ መረዳእታ ቕድሚ ምምዝጋቡ እዞም ዝስዕቡ ከም ዝተማለኡ አረጋግፅ</label>
							<div class="checkbox">
                                <input type="hidden" name="isProposed" value="0">
								<label> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
									<input type="checkbox" name="isProposed" id="isProposed" value="1" data-parsley-mincheck="2" required class="flat">ናይ መበገሲ ሓሳብ/ፀብፃብ እቲ ውልቀሰብ ኣባል ካብ ዝኾነሉ ውዳበ ናብ ልዕሊኡ ናብ ዘሎ ውዳበ ቐሪቡ እዩ
								</label>
							</div>
							<div class="checkbox">&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
                                <input type="hidden" name="approvedWudabe" value="0">
								<label>&nbsp &nbsp &nbsp &nbsp &nbsp
								   <input type="checkbox" name="approvedWudabe" id="approvedWudabe" value="1" class="flat">መበገሲ ሓሳብ ዝቐረበሉ ውዳበ ነቲ ካብ ብትሕቲኡ ዘሎ ውዳበ ዝቐረበሉ ኣፅዲቕዎ እዩ
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
			
                      
		<div id="midebalist" class="form-group">
		  <div class="col-sm-12">
			<div class="box-header with-border">
			  <p class="text-muted font-13 m-b-30">
			  </p>
		    
        <div class="table-responsive text-center">
          <table class="table table-striped table-borderless" id="table2">
        <thead>
          <tr>
          <th class="text-center"> ሙሉእ ሽም</th>
          <th class="text-center"> ዝተመደበሉ ብርኪ ኮሚቴ</th>
          <th class="text-center">ደረጃ ምደባ </th>
          <th class="text-center">ኣወኻኽላ</th>
          <th class="text-center">ዝተመደበሉ ቦታ</th>
          <th class="text-center">ዝተመደበሉ ምኽንያት</th>
          <th class="text-center">ዝጅምረሉ ዕለት</th>
          <th class="text-center">ተግባር</th>
          
          </tr>
        </thead>
        

        <tbody>
          @foreach ($data as $myassign)
          <tr>
            <input type="hidden" value="{{ $myassign->id }}">
            <input type="hidden" value="{{ $myassign->hitsuyID }}">
            <input type="hidden" value="{{ $myassign->proposedBy }}">
            <input type="hidden" value="{{ $myassign->commentedBy }}">
            <input type="hidden" value="{{ $myassign->approvedBy }}">
            <input type="hidden" value="{{ App\DateConvert::toEthiopian(date('d/m/Y',strtotime($myassign->startDate))) }}">
            <!--<input type="hidden" value="{{ App\DateConvert::toEthiopian(date('d/m/Y',strtotime($myassign->endDate))) }}">-->
            <td>{{ $myassign->hitsuymideba->name }} {{ $myassign->hitsuymideba->fname }} {{ $myassign->hitsuymideba->gfname }}</td>
          <td>{{ $myassign->birkiCommittee }}</td>
          <td>{{ $myassign->deraja }}</td>
          <td>{{ $myassign->awekakla }}</td>
          <td>{{ $myassign->type }}</td>
          <td>{{ $myassign->reason }}</td>
          <td>{{ App\DateConvert::toEthiopian(date('d/m/Y',strtotime($myassign->endDate))) }}</td>
          <td>
            @if (array_search(Auth::user()->usertype, ['admin', 'zoneadmin', 'woredaadmin']) !== false)
            <button class="edit-modal btn btn-info" data-info="{{$myassign->hitsuyID}},{{$myassign->birkiCommittee}},{{$myassign->deraja}},{{$myassign->awekakla}},{{$myassign->type}},{{$myassign->reason}},{{$myassign->proposedBy}},{{$myassign->commentedBy}},{{$myassign->approvedBy}},{{$myassign->startDate}},{{$myassign->id}}">
                    <span class="glyphicon glyphicon-edit"></span></button>
                    <button class="delete-modal btn btn-danger" data-info="{{$myassign->hitsuyID}},{{$myassign->id}}">
                    <span class="glyphicon glyphicon-trash"></span>
                    </button>
            @endif
                    <button class="view-modal btn btn-warning" data-info="{{ $zobadatas[$woredadata[$tabiadata[$myassign->hitsuymideba->tabiaID]]] }},{{ $woredaname[$tabiadata[$myassign->hitsuymideba->tabiaID]] }},{{ $myassign->hitsuymideba->name }} {{ $myassign->hitsuymideba->fname }}{{ $myassign->hitsuymideba->gfname }},{{ $myassign->hitsuymideba->gender }},{{ (date('Y') - date('Y',strtotime($myassign->hitsuymideba->dob))) }},{{ $myassign->hitsuymideba->position }},{{ $myassign->hitsuymideba->approvedhitsuy->membershipDate }},{{ $myassign->hitsuymideba->approvedhitsuy->memberType }},{{ $myassign->birkiCommittee }}">
                    <span class="glyphicon glyphicon-eye-open"></span></button>
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


<div id="myDetails" class="hidden">
  <form id="detail-form">   
  <div class="form-group">
    <h3><center><u>ናይ ምደባታት ቅጥዒ</u></center></h3>
  </div> 
    <div class="form-group col-sm-12 col-md-12"> 
    	<label class="control-label col-md-1 col-sm-1" for="zone">ዞባ:</label>
            <div class="col-md-1 col-sm-1 col-xs-1">
                <input type="text" id="zone" name="zone" required class="form-control" readonly>
            </div>
            <label class="control-label col-md-1 col-sm-1" for="woreda">ወረዳ:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="woreda" name="woreda" required class="form-control" readonly>
            </div>
            <label class="control-label col-md-1 col-sm-1" for="formerOffice">ዝነበሮ ቤ/ፅሕፈት:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="formerOffice" required name="formerOffice" class="form-control" readonly>
            </div>   
            <label class="control-label col-md-1 col-sm-1" for="currentOffice">ሕዚ ዝምደበሉ ቤት ፅሕፈት:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="currentOffice" required name="currentOffice" class="form-control" readonly>
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
            <label class="control-label col-md-1 col-sm-1" for="formerPosition">ዝነበሮ/ራ ሓላፍነት:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="formerPosition" name="formerPosition" class="form-control" readonly>
            </div> 
                     
        </div>
        <div class="form-group col-sm-12 col-md-12"> 
        	<label class="control-label col-md-1 col-sm-1" for="formerLeadership">ዝነበሮ/ራ ብርኪ መሪሕነት:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="formerLeadership" name="formerLeadership" class="form-control" readonly>
            </div> 
          <label class="control-label col-md-2 col-sm-2" for="currentLeadership">ሕዚ ዝተመልመለሉ መሪሕነት:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="currentLeadership" name="currentLeadership" class="form-control" readonly>
            </div>
            <label class="control-label col-md-2 col-sm-2" for="where">ዝነበሮ/ቶ ናበይ ከይዳ/ዱ:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="where" name="where" class="form-control" readonly>
            </div>
        </div>
              
        <div class="form-group col-sm-12 col-md-12"> 
            <label class="control-label" >1.2 ድሕረ ባይትኡ ብዝምልከት ፤ </label>
        <div>
            <label class="control-label" >ኩነታት ድሕረ ባይታ ብሓፂሩ ____________________________________________________________________________________________________________________________________________</label>
              <label class="control-label" >______________________________________________________________________________________________________________________________________________________________________</label>
        </div>
        </div>
        <div class="form-group col-sm-12 col-md-12"> 
            <label class="control-label" >1.3 ልምዲ ስራሕ ብዝምልከት ፤ </label>
             <div>
             <label class="control-label" >ብሞያ _____________________________________________________________________________________________________________________________________________________________</label>
              <label class="control-label" >______________________________________________________________________________________________________________________________________________________________________</label>
              </div>
              <div>
              <label class="control-label" >ብፖለቲካ ሓላፍነት ____________________________________________________________________________________________________________________________________________________</label>
              <label class="control-label" >______________________________________________________________________________________________________________________________________________________________________</label>
          	</div>
          </div>
          <div class="form-group col-sm-12 col-md-12"> 
            <label class="control-label" >1.4 ኣጠቃላሊ ገምጋም ፤ </label>
            <div>
             <label class="control-label" >1.4.1 ጠ/ጎኒ _____________________________________________________________________________________________________________________________________________________</label>
              <label class="control-label" >______________________________________________________________________________________________________________________________________________________________________</label>
              </div>
              <div>
              <label class="control-label" for="strongFeature"> መ/ጠ/ጎኒ ፤ </label>
            <div class="col-sm-12 col-md-12">
                <textarea rows="4" class="form-control" id="strongFeature" name="strongFeature" required></textarea>
            </div>  
            </div>        
            <div>
             <label class="control-label" >1.4.1 ደ/ጎኒ ________________________________________________________________________________________________________________________________________________________________</label>
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
          <label class="control-label">1.5 ሚዛን /ማርክን ስርርዕ/ _______________________________________ ፤</label>
      </div>
        <div class="form-group col-sm-12 col-md-12"> 
          <label class="control-label">1.6 ናይ ውዳበታት ሪኢቶ ፤</label>
          <div>
            <label class="control-label" >1.6.1 ናይ ወረዳ ሪኢቶ  _____________________________________________________________________________________________________________________________________</label>
             <label class="control-label" >____________________________________________________________________________________________________________________________________________</label>
              <div>
              <label class="control-label" >ፊርማ ___________________________ ዕለት _________________________</label>
              </div>
              <label class="control-label" >1.6.2 ናይ ዞባ ውዳበ ሪኢቶ _________________________________________________________________________________________________________________________________</label>
              <label class="control-label" >____________________________________________________________________________________________________________________________________________</label>
              <div>
              <label class="control-label" >ፊርማ __________________________ ዕለት ________________________</label>
              </div>
              <label class="control-label" >1.6.3 ናይ ክልል ውዳበ ውሳነ _________________________________________________________________________________________________________________________________</label>
              <label class="control-label" >____________________________________________________________________________________________________________________________________________</label>
              <div>
              <label class="control-label" > ፊርማ _______________________ ዕለት_________________</label>
          </div>
            </div>
        </div>


    <hr style="border:groove 1px #79D57E;"/>       
      </form>
      <div class="text-center">           
      <button  id="" class="btn printerBtn btn-info">Print </button>          
    </div>
      </div>


<!--   -->
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
                        <label class="control-label col-md-2 col-sm-2" for="hitsuyID">መፍለይ ቑፅሪ ኣባል  <span class="required">（*）</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input type="text" id="hitsuyID" name="hitsuyID" required="required" readonly class="form-control col-md-7 col-xs-12">
                          <input type="hidden" id="hhID" name="hhID" >
                        </div>
                      </div>   
                       <div class="form-group">
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="birkiCommittee">ዝተመደበሉ ብርኪ ኮሚቴ:<span class="text-danger">*</span></label>
			<div class="col-md-3 col-sm-6 col-xs-12">

			 <select class="form-control" id="birkiCommittee" name="birkiCommittee" required="required">
			   <option selected disabled>~ምረፅ~</option>
			   <option >መሰረታዊ ውዳበ ኮሚቴ</option>
			   <option >ከተማ ጣብያ ኮሚቴ</option>
			   <option >ገጠር ወረዳ/ክፍለከተማ ኮሚቴ</option>
			   <option >ዞባ ኮሚቴ</option>
			   <option >ክልል ኮሚቴ</option>
			   <option >ገጠር ወረዳ/ክፍለከተማ ኮሚቴ</option>
			 </select>
			</div>	
	     
			<label class="control-label col-md-1 col-sm-3 col-xs-12" for="dereja">ደረጃ ምደባ:<span class="text-danger">*</span></label>
			<div class="col-md-3 col-sm-6 col-xs-12">

			 <select class="form-control" id="dereja" name="dereja" required="required">
			   <option selected disabled>~ምረፅ~</option>
			   <option >ኣካቢ</option>
			   <option >ም/ኣካቢ</option>
			   <option >ፀሓፊ</option>
			   <option >ኣባል</option>
			 </select>
			</div>	
	     </div>
		  <div class="form-group">
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="awekakla">ኣወኻኽላ:<span class="text-danger">*</span></label>
			<div class="col-md-3 col-sm-6 col-xs-12">

			 <select class="form-control" id="awekakla" name="awekakla" required="required">
			   <option selected disabled>~ምረፅ~</option>
			   <option >ብመረፃ ዝተወከለ</option>
			   <option >ብምደባ ዝተወከለ</option>
			 </select>
			</div>	

			<label class="control-label col-md-1 col-sm-3 col-xs-12" for="type">ዝተመደበሉ ቦታ:<span class="text-danger">*</span></label>
			<div class="col-md-3 col-sm-6 col-xs-12">

			 <select class="form-control" id="type" name="type" required="required">
			   <option selected disabled>~ምረፅ~</option>
			   <option >ናይ ውድብ</option>
			   <option >ናይ መንግስቲ</option>
			 </select>
			</div>	
	     </div>
		 <div class="form-group">
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="reason">ዝተመደበሉ ምኽንያት<span class="required">（*）</span>
			</label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <input type="text" id="reason" name="reason" required="required" class="form-control col-md-7 col-xs-12">
			</div>

			<label class="control-label col-md-1 col-sm-3 col-xs-12" for="proposedBy">መበገሲ ሓሳብ ዘቕረበ ኣካል<span class="required">（*）</span>
			</label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <input type="text" id="proposedBy" name="proposedBy" required="required" class="form-control col-md-7 col-xs-12">
			</div>
		 </div>
		 <div class="form-group">
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="commentedBy">ርእይቶ ዝሃበ ኣካል<span class="required">（*）</span>
			</label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <input type="text" id="commentedBy" name="commentedBy" required="required" class="form-control col-md-7 col-xs-12">
			</div>

			<label class="control-label col-md-1 col-sm-3 col-xs-12" for="approvedBy">ዘፅደቐ ኣካል<span class="required">（*）</span>
			</label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <input type="text" id="approvedBy" name="approvedBy" required="required" class="form-control col-md-7 col-xs-12">
			</div>
		 </div>
		 <div class="form-group">
			<label class="control-label col-md-2 col-sm-3 col-xs-12" for="startDate">ምደባ ዝጀመረሉ ዕለት<span class="required">（*）</span>
			</label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <input type="text" id="startDate" name="startDate" required="required" class="form-control col-md-7 col-xs-12">
			</div>

			<!--<label class="control-label col-md-1 col-sm-3 col-xs-12" for="endDate">ምደባ ዘብቀዏሉ ዕለት<span class="required">（*）</span>
			</label>
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <input type="text" id="endDate" name="endDate" required="required" class="form-control col-md-7 col-xs-12">
			</div>-->
		</div>

          	<div class="col-md-6 col-sm-6 col-xs-12">
                         
        </div>
            
          </form> 

<!--   -->
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
             ምደባ ናይ ኣባል መፍለይ ቑፅሪ "<span class="hID text-danger"></span>" ብትክክል ክስረዝ ተወሲኑ ድዩ  ? <span
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
  $(document).ready(function() {
      $('#table2').DataTable({
        @include('layouts.partials.lang'),
        "order": []
      });
     });
  	$(document).on('click', '.switchBtn', function() {
    	$('#midebalist').addClass('hidden');
    	$('.myswitch').addClass('hidden');
        $('#midebadiv').removeClass('hidden');                 
        $('.mytoggle').removeClass('hidden'); 
        $('#myDetails').addClass('hidden');                
    });	
    $(document).on('click', '.toggleBtn', function() {
    	$('#midebadiv').addClass('hidden');
    	$('.mytoggle').addClass('hidden');
        $('#midebalist').removeClass('hidden');                 
        $('.myswitch').removeClass('hidden'); 
        $('#myDetails').addClass('hidden');                
    });	
    $(document).on('click', '.view-modal', function() {
        $('#myDetails').removeClass('hidden');
        $('#midebadiv').addClass('hidden');
        $('.mytoggle').removeClass('hidden');
        $('#midebalist').addClass('hidden');
        $('.myswitch').addClass('hidden');
         var stuff = $(this).data('info').split(',');
        fillmidebaData(stuff)
    });
    function fillmidebaData(details){
    $('#zone').val(details[0]); 
    $('#woreda').val(details[1]); 
      $('#fullName2').val(details[2]);   
      $('#gender2').val(details[3]);
      $('#dob2').val(details[4]);      
      $('#formerPosition').val(details[5]); 
      $('#membershipDate').val(details[6]);
      $('#formerLeadership').val(details[7]); 
      $('#currentLeadership').val(details[8]); 
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
						$('select[name="proposerWahio"]').append('<option value="'+ " " +'">'+ "~ዋህዮ ምረፅ~" +'</option>');
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
                            $('select[name="members"]').append('<option value="'+ key +'">'+key+': '+value +'</option>');
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

	var row,stuff;
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
        $('.modal-title').text('መስተኻኸሊ ምደባ ኣባል');
        $('.deleteContent').hide();
        $('.searchContent').hide();
        $('.formadder').show();
        row = $($($(this).parent()).parent()).children();
        stuff = [$(row[0]).val(),$(row[1]).val(),$(row[2]).val(),$(row[3]).val(),$(row[4]).val(),$(row[5]).val(),$(row[6]).val(),$(row[7]).html(),$(row[8]).html(),$(row[9]).html(),$(row[10]).html(),$(row[11]).html(),$(row[12]).html()];
        fillmodalData(stuff);
        $('#myModal').modal('show');
    });

    function fillmodalData(details){
      // $('#hhID').val(details[11]);	
      $('#hitsuyID').val(details[1]);
      $('#birkiCommittee').val(details[8]);
      $('#dereja').val(details[9]);
      $('#awekakla').val(details[10]);
      $('#type').val(details[11]);
      $('#reason').val(details[12]);
      $('#proposedBy').val(details[2]);
      $('#commentedBy').val(details[3]);
      $('#approvedBy').val(details[4]);
       $('#startDate').val(details[5]);
      //$('#endDate').val(details[6]);
          
    }
    $('.modal-footer').on('click', '.edit', function() {
        $.ajax({
            type: 'post',
            url: 'editmideba',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': stuff[0],
                'hitsuyID': $('#hitsuyID').val(),
                'birkiCommittee': $('#birkiCommittee').val(),
                'dereja': $('#dereja').val(),
                'awekakla': $('#awekakla').val(),
                'type': $('#type').val(),
                'reason': $('#reason').val(),
                'proposedBy': $('#proposedBy').val(),
                'commentedBy': $('#commentedBy').val(),
                'approvedBy': $('#approvedBy').val(),
                'startDate': $('#startDate').val()
                //'endDate': $('#endDate').val()
                
              
            },
			
            success: function(data) {
            	  if(data[0] == true){
                    $(row[2]).val($('#proposedBy').val());
                    $(row[3]).val($('#commentedBy').val());
                    $(row[4]).val($('#approvedBy').val());
                    $(row[5]).val($('#startDate').val());
                    //$(row[6]).val($('#endDate').val());
                    $(row[8]).html($('#birkiCommittee').val());
                    $(row[9]).html($('#dereja').val());
                    $(row[10]).html($('#awekakla').val());
                    $(row[11]).html($('#type').val());
                    $(row[12]).html($('#reason').val());
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
        $('.modal-title').text(' መሰረዚ ምደባ ኣባል');
        $('.deleteContent').show();
        $('.formadder').hide();
        $('.searchContent').hide();
        row = $($($(this).parent()).parent()).children();
        $('.did').text($(row[0]).val());
        $('.hID').html($(row[7]).html()+'('+$(row[1]).val()+')');

        $('#myModal').modal('show');
    });
    $('.modal-footer').on('click', '.delete', function() {
        $.ajax({
            type: 'post',
            url: 'deletemideba',
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
    $('#startDate1').calendarsPicker({calendar: $.calendars.instance('ethiopian')});
    //$('#endDate1').calendarsPicker({calendar: $.calendars.instance('ethiopian')});
    $('#startDate').calendarsPicker({calendar: $.calendars.instance('ethiopian')});
    //$('#endDate').calendarsPicker({calendar: $.calendars.instance('ethiopian')});
    @if (count($errors) > 0)
        $('.switchBtn').click();
    @endif
	
  </script>
@endsection

