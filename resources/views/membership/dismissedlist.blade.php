
@extends('layouts.app')

@section('htmlheader_title')
ማህደር
@endsection

@section('contentheader_title')
ማህደር ዝተባረሩ
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


	<!-- <div class="row ">
		<div class="col-md-6 col-sm-6 col-xs-6">
				<div class="form-group col-md-12 col-sm-12 col-xs-12">			                
					<div class="col-md-6 col-sm-6 col-xs-6">    
						<select name="zone" id="zone" class="form-control" >
							<option value=""selected disabled>~ዞባ ምረፅ~</option>
							@foreach ($zobadatas as $key => $value)
							<option value="{{ $key }}">{{ $value }}</option>
							@endforeach
						</select>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-6">    
						<select name="woreda" id="woreda" class="form-control">
							<option value="">~ወረዳ ምረፅ~</option>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-6">
			</div>	
	</div> -->

    @include('layouts.partials.filter_html', ['address' => 'dismissedlist'])
    
	<form method="get" action="{{ url('dismissedlistexcel') }}">
        <button class="btn btn-success" type="submit" id="excelbtn"><span class="fa fa-download"></span>ኤክሴል ኣውርድ</button>
    </form>
	<div class="box box-primary">
		<div id="tableofContents">
		<div class="box-header with-border">			
			
				{{ csrf_field() }}
				<div class="table-responsive text-center">
					<table class="table table-borderless" id="table2">
						<thead>
							<tr>
								<th class="text-center hidden">መ.ቑ</th>
								<th class="text-center">መ.ቑ</th>
								<th class="text-center">ሽም ኣባል</th>
								<th class="text-center">ፆታ</th>
								<th class="text-center">ዕድመ</th>
								<th class="text-center">ትውልዲ ቦታ</th>
								<th class="text-center">ኣባልነት ዘመን</th>								
								<th class="text-center">ማሕበራዊ መሰረት</th>
								<th class="text-center">ደራጃ ት/ቲ</th>
								<th class="text-center">ዝተወደበሉ ማሕበር</th>
								<th class="text-center">ዓይነት ኣባል</th>
								<th class="text-center">መሃያ</th>
								<!-- <th class="text-center">ወርሓዊ ኣባልነት ክፍሊት</th> 
                                @if (Auth::user() && Auth::user()->usertype != 'management') 
								<th class="text-center">ትምህርቲ</th>
								<th class="text-center">ስራሕ ልምዲ</th>	
                                <th class="text-center">ኣባል ኣስተኻኽል</th>-->
                                							<!-- <th class="text-center">ተግባር</th> -->
                                @endif
								
							</tr>					
						</thead>
						<tbody>
							@foreach ($data as $mydata)										
							<tr>
                                <input type="hidden" value="{{ $mydata->grossSalary}}">
                                <input type="hidden" value="{{ $mydata->fileNumber}}">
								<td class="hidden">{{ $mydata->hitsuyID }}</td>	
								<td><a href="{{ url('memberhistory') }}/{{ str_replace('/', '_', $mydata->hitsuyID) }}" class="btn btn-success">{{ $mydata->hitsuyID }}</a></td>	
								<td>{{ $mydata->hitsuy->name }} {{ $mydata->hitsuy->fname }} {{ $mydata->hitsuy->gfname }}</td>
								<td>{{ $mydata->hitsuy->gender }}</td>
								<td>{{ (date('Y') - date('Y',strtotime($mydata->hitsuy->dob))) }}</td>
								<td>{{ $mydata->hitsuy->birthPlace }}</td>
								<td>{{ App\DateConvert::toEthiopian(date('d/m/Y',strtotime($mydata->membershipDate))) }}</td>
								<td>{{ $mydata->hitsuy->occupation }}</td>
								<td>{{ App\DateConvert::toEthiopian(date('d/m/Y',strtotime($mydata->hitsuy->dob))) }}</td>
								<td>{{ str_replace(',', '፣', $mydata->assignedAssoc) }}</td>
								<td>{{ $mydata->membershipType }}</td>
								<td>{{ $mydata->netSalary }}</td>
								<!-- <td>{{ floatval($mydata->netSalary)*0.015 }}</td> 
                                @if (Auth::user() && Auth::user()->usertype != 'management') 
								<td><button class="addEducation-modal btn btn-success" data-info="{{ $mydata->hitsuyID }},{{ $mydata->hitsuy->name }} {{ $mydata->hitsuy->fname }} {{ $mydata->hitsuy->gfname }}">
									<span class="glyphicon glyphicon-plus"></span></button>
								</td>
								<td><button class="addExprience-modal btn btn-success" data-info="{{ $mydata->hitsuyID }},{{ $mydata->hitsuy->name }} {{ $mydata->hitsuy->fname }} {{ $mydata->hitsuy->gfname }}">
									<span class="glyphicon glyphicon-plus"></span></button>
								</td>
                                <td>
                                    <button class="btn btn-primary modify"><span class="glyphicon glyphicon-edit"></span></button>
                                </td>
                                @endif-->
								<!--<td>
									<button class="addPolitics-modal btn btn-success" data-info="{{ $mydata->hitsuyID }},{{ $mydata->hitsuy->name }} {{ $mydata->hitsuy->fname }} {{ $mydata->hitsuy->gfname }}">
									<span class="glyphicon glyphicon-plus"></span></button>
								</td>			-->					
						   </tr>
							@endforeach
							</tbody>
						</table>
						</div>
            {{ $data->links() }}
	   </div>
	 </div>
     <div id="modifyMember" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">ምፅዳቕ ኣባልነት</h4>

                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" role="form"> 
                            <!-- We don't need name but id, b/se we are using ajax post -->
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="hidden" class="form-control" id="hitsuyID">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fullName">መለለዪ ኣባል
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="fullName" required="required" class="form-control col-md-7 col-xs-12" readonly>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">ሽም
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="name" required="required" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fname">ሽም ኣቦ
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="fname" required="required" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="gfname">ሽም ኣቦ ሓጎ
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="gfname" required="required" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="gender">ፆታ<span class="text-danger">(*)</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="form-control" id="gender" required="required">
                                        <option selected disabled>~ፆታ~</option>
                                        <option>ተባ</option>
                                        <option>ኣን</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dob">ዝተወለደሉ ዕለት
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="dob" required="required" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="membershipDate">ኣባል ዝኾነሉ ዕለት<span class="text-danger">（*）</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="membershipDate" required="required" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>       
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="membershipType">ዓይነት ኣባል:<span class="text-danger">(*)</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="form-control" id="membershipType" required="required">
                                        <option selected disabled>~ዓይነት ኣባል ምረፅ~</option>
                                        <option value="ተጋዳላይ">ተጋዳላይ</option>
                                        <option value="ሲቪል">ሲቪል</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="grossSalary">ጠቕላላ ደሞዝ
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="grossSalary" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="netSalary">ዝተፃረየ ደሞዝ<span class="text-danger">（*）</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="netSalary" required="required" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div> 
                            <!-- <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="assignedWudabe">ዝተወደበሉ መሰረታዊ ውዳበ<span class="text-danger">（*）</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">                               
                                    <select class="form-control" id="assignedWudabe" name="assignedWudabe" required="required">
                                            <option selected disabled>~ዝተወደበሉ መሰረታዊ ውዳበ ምረፅ~</option>
                                    </select>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="assignedWahio">ዝተወደበሉ ዋህዮ<span class="text-danger">（*）</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">                               
                                    <select class="form-control" id="assignedWahio" name="assignedWahio" required="required">
                                            <option selected disabled>~ዝተወደበሉ ዋህዮ ምረፅ~</option>
                                    </select>
                                </div>
                            </div>                       -->
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="assignedAssoc">ዝተወደበሉ ማሕበር:</label>
                                <div class="col-sm-6">
                                    <select class="form-control" id="assignedAssoc" multiple="true">
                                        <option selected disabled>~ዝተወደበሉ ማሕበር ምረፅ~</option>
                                        <option>ደቂ ኣንስትዮ</option>
                                        <option>ሓረስታይ</option>
                                        <option>መንእሰይ</option>
                                        <option>ጉድኣት ኩናት</option>
                                        <option>ተጋደልቲ</option>
                                        <option>ደቂ ስውኣት</option>
                                        <option>ሊግ መንእሰይ</option>
                                        <option>ሊግ ደቂ ኣነስትዮ</option>
                                        <option>መምህራን</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fileNumber">ቁፅሪ ሰነድ
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="fileNumber" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>                        
                            <!-- <div class="form-group">&nbsp &nbsp &nbsp &nbsp &nbsp
                                <label>&nbsp &nbsp ቅድሚ ኣባልነት ምፅዳቕ እዞም ቅድመ ኩነታት የረጋግፁ</label>
                                <div class="checkbox">
                                    <label>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
                                        <input type="checkbox" id="isReported" value="1">ናይ መልማላይ ወይድማ ዋህዮ ኣቦ ወንበር ርእይቶ ዝሓዘ ፀብፃብ ምስ ናይቲ ውልቀሰብ ርኢቶ <br>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbspናብ መ/ውዲበ ኮሚቴ ቐሪቡ እዩ
                                    </label>
                                </div>
                                <div class="checkbox">&nbsp &nbsp
                                    <label>&nbsp &nbsp &nbsp &nbsp &nbsp
                                        <input type="checkbox" id="hasRequested" value="1">ሕፁይ ናብ ኣባልነት ክሰጋገር ዝሓተተ ምዃኑ ዝገልፅ ዯብዲበ ቐሪቡ እዩ
                                    </label>
                                </div>
                                <div class="checkbox">&nbsp &nbsp &nbsp &nbsp &nbsp
                                    <label>&nbsp &nbsp
                                        <input type="checkbox" id="isApproved" value="1">ናብ ኣባልነት ይሰጋገር ዝብል ናይ ዋህዮ ውሳነ ኣብ ናይ መሰረታዊ ውዲበ ኮሚቴ ፀዱቑ እዩ
                                    </label>
                                </div>
                                <p class="fname_error error text-center alert alert-danger hidden"></p>
                            </div> -->
                            <div class="modal-footer">
                                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                <button type="button" class="btn actionBtn btn-success add" id="editMember">
                                    <span class='glyphicon glypicon-check'>ኣስተኻኽል</span>
                                </button>
                                <button type="button" class="btn btn-warning" data-dismiss="modal">
                                    <span class='glyphicon glyphicon-remove'></span> ዕፀው
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>	 
<!---     -->
<div id="addEdu" class="hidden">
          <div class="alert alert-danger hidden" id="eduErr">
          </div>
		<!-- Button ይመለሱ -->
		<div class="pull-right">					  
			<button class="btn switchBtn btn-info"><span class="glyphicon glyphicon-arrow-up"></span></button> 				  
		</div>
		<form id="demo-form2" data-parsley-validate class="form-horizontal formadder" role="form">
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
                <select id="educationLevel" name="educationLevel" class="form-control">
                    <option selected="" disabled="">~ምረፅ~</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    <option>6</option>
                    <option>7</option>
                    <option>8</option>
                    <option>9</option>
                    <option>10</option>
                    <option>11</option>
                    <option>12</option>
                    <option>ሰርቲፊኬት</option>
                    <option>ዲፕሎማ</option>
                    <option>ዲግሪ</option>
                    <option>ማስተርስ</option>
                    <option>ፒ.ኤች.ዲ</option>
                </select>
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
            
                          <button type="button" id="addEduBtn" class="btn btn-success">መዝግብ</button>
                        </div>
                      </div>

	</form>
	</div>  
		<!--    -->
		<div id="addExp" class="hidden">
		<div class="alert alert-danger hidden" id="expErr">
        </div>
		<div class="pull-right">					  
			<button class="btn switchBtn btn-info"><span class="glyphicon glyphicon-arrow-up"></span></button> 				  
		</div>
		<form id="demo-form2"  data-parsley-validate class="form-horizontal formadder" role="form">
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
        </div>
        <div class="form-group col-sm-12 col-md-12">
            <label class="control-label col-md-1 col-sm-1" for="startDate">ዝጀመረሉ/ትሉ:</label>
            <div class="col-md-4 col-sm-4 col-xs-4">
                <input type="text" id="startDate" name="startDate" class="form-control">
            </div>
            <label class="control-label col-md-1 col-sm-1" for="endDate">ዝወድአሉ/ትሉ:</label>
            <div class="col-md-4 col-sm-4 col-xs-4">
                <input type="text" id="endDate" name="endDate" class="form-control">
            </div>
        </div>
        <div class="form-group col-sm-12 col-md-12"> 
        	
            <label class="control-label col-md-1 col-sm-1" for="institute2">ትካል:</label>
            <div class="col-md-4 col-sm-4 col-xs-4">
                <input type="text" id="institute2" name="institute" class="form-control">
            </div><label class="control-label col-md-1 col-sm-1" for="address">ኣድራሻ:</label>
            <div class="col-md-4 col-sm-4 col-xs-4">
                <input type="text" id="address" name="address" class="form-control">
            </div>
		</div> 
        <div class="form-group col-sm-12 col-md-12"> 
            
            <label class="control-label col-md-1 col-sm-1" for="salary">ደሞዝ:</label>
            <div class="col-md-4 col-sm-4 col-xs-4">
                <input type="text" id="salary" name="salary" class="form-control">
        </div>
        </div> 
		
		<div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">                         
            
                          <button type="button" id="addExpBtn" class="btn btn-success">መዝግብ</button>
                        </div>
                      </div>

	</form>
	</div>  
		<!--    -->

    
	
@endsection

@section('scripts-extra')
    <script type="text/javascript" src="js/jquery.calendars.js"></script> 
    <script type="text/javascript" src="js/jquery.calendars.plus.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/jquery.calendars.picker.css"> 
    <script type="text/javascript" src="js/jquery.plugin.min.js"></script> 
    <script type="text/javascript" src="js/jquery.calendars.picker.js"></script>
    <script type="text/javascript" src="js/jquery.calendars.ethiopian.min.js"></script>
    @include('layouts.partials.filter_js')
	<script>
 
 
	 $(document).ready(function() {
      $('#table2').DataTable({
        @include('layouts.partials.lang'),
        "order": []
      });
     });
     var row,stuff;
     $(document).on('click', '.modify', function() {
        row = $($($(this).parent()).parent()).children();
        stuff = [$(row[0]).val(), $(row[1]).val(), $(row[2]).html(), $(row[3]).html(), $(row[4]).html(), $(row[5]).html(), $(row[6]).html(), $(row[7]).html(), $(row[8]).html(), $(row[9]).html(), $(row[10]).html(), $(row[11]).html(), $(row[12]).html(), $(row[13]).html(), $(row[14]).html()];
        $('#fullName').val(stuff[2]);
        $('#name').val(stuff[4].split(' ')[0]);
        $('#fname').val(stuff[4].split(' ')[1]);
        $('#gfname').val(stuff[4].split(' ')[2]);
        $('#gender').val(stuff[5]);
        $('#membershipDate').val(stuff[8]);
        $('#dob').val(stuff[10]);
        $('#membershipType').val(stuff[12]);
        $('#grossSalary').val(stuff[0]);
        $('#netSalary').val(stuff[13]);
        $('#assignedAssoc').val(stuff[11].split('፣'));
        $('#fileNumber').val(stuff[1]);

        $('#modifyMember').modal('show');
    });
     $(document).on('click', '#editMember', function(){
        $.ajax({
            type: 'post',
            url: 'editmember',
            data: {
                '_token': $('input[name=_token]').val(),
                'hitsuyID': $('#fullName').val(),
                'name': $('#name').val(),
                'fname': $('#fname').val(),
                'gfname': $('#gfname').val(),
                'dob': $('#dob').val(),
                'gender': $('#gender').val(),
                'membershipDate': $('#membershipDate').val(),
                'membershipType': $('#membershipType').val(),
                'grossSalary': $('#grossSalary').val(),
                'netSalary': $('#netSalary').val(),
                'assignedAssoc': $('#assignedAssoc').val(),
                'fileNumber': $('#fileNumber').val()
            },
      
            success: function(data) {
              if(data[0] == true){
                    $(row[4]).html($('#name').val()+' '+$('#fname').val()+' '+$('#gfname').val()),
                    $(row[5]).html($('#gender').val()),
                    $(row[10]).html($('#dob').val()),
                    $(row[8]).html($("#membershipDate").val());
                    $(row[12]).html($("#membershipType").val());
                    $(row[0]).val($("#grossSalary").val());
                    $(row[13]).html($("#netSalary").val());
                    $(row[11]).html($("#assignedAssoc").val().join('፣'));
                    $(row[1]).html($("#fileNumber").val());
                    $("#hitsuyID").val('');
                    $("#hhID").val('');
                    $("#educationType").val('');
                    $("#educationLevel").val('');
                    $("#institute").val('');
                    $("#graduationDate").val('');
                    $('#modifyMember').modal('hide');
                  }
                  else{
                    if(Array.isArray(data[2]))
                        data[2] = data[2].join('<br>');
                  }
                
                  toastr.clear();
                  toastr[data[1]](data[2]);
               },

            error: function(xhr,errorType,exception){
                
                  alert(exception);
                        
            }
        });
     });
     $(document).on('click', '.switchBtn', function() {
     	$('#addExp').addClass('hidden');
      	$('#addEdu').addClass('hidden');
        $('#eduErr').html('');
        $('#expErr').html('');
        $('#eduErr').addClass('hidden');
        $('#expErr').addClass('hidden');
      	$('#tableofContents').removeClass('hidden');	
     });
	 $(document).on('click', '.addEducation-modal', function() {
	 	$('#addExp').addClass('hidden');
        $('#addEdu').removeClass('hidden');
        $('#eduErr').html('');
        $('#expErr').html('');
        $('#eduErr').addClass('hidden');
        $('#expErr').addClass('hidden');
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
        $('#eduErr').html('');
        $('#expErr').html('');
        $('#eduErr').addClass('hidden');
        $('#expErr').addClass('hidden');
        $('#tableofContents').addClass('hidden');        
        var stuff = $(this).data('info').split(',');
        fillExpData(stuff)
    });
  function fillExpData(details){
      $('#hitsuyID2').val(details[0]);   
      $('#fullname2').val(details[1]);      
  }
  $('#addEduBtn').on('click', '', function() {
        data = {
            '_token': $('input[name=_token]').val(),                
                'hitsuyID': $('#hitsuyID').val(),
                'educationLevel': $('#educationLevel').val(),
                'educationType': $('#educationType').val(),
                'graduationDate': $('#graduationDate').val(),
                'institute': $('#institute').val() };
        $.ajax({
            type: 'post',
            url: 'education',
            data: data,
            
            success: function(data) {
                  if(data[0] == false){
                    $("#eduErr").html(data[1].join('<br>'));
                    $("#eduErr").removeClass('hidden');
                  }
                  else{
                    toastr.clear();
                    toastr.info(data[1]);
                    $("#eduErr").addClass('hidden');
                  }
                },

            error: function(xhr,errorType,exception){
                    
                        alert(exception);
                        
            }
        });
    });

    $('#addExpBtn').on('click', '', function() {
        data = {
            '_token': $('input[name=_token]').val(),                
            'hitsuyID': $('#hitsuyID2').val(),
            'career': $('#career').val(),
            'exprienceType': $('#exprienceType').val(),
            'position': $('#position').val(),
            'startDate': $('#startDate').val(),
            'endDate': $('#endDate').val(),
            'institute': $('#institute2').val(),
            'address': $('#address').val(),
            'salary': $('#salary').val(),
            };
        $.ajax({
            type: 'post',
            url: 'exprience',
            data: data,
            
            success: function(data) {
                  if(data[0] == false){
                    $("#expErr").html(data[1].join('<br>'));
                    $("#expErr").removeClass('hidden');
                  }
                  else{
                    toastr.clear();
                    toastr.info(data[1]);
                    $("#expErr").addClass('hidden');
                  }
                },

            error: function(xhr,errorType,exception){
                    
                        alert(exception);
                        
            }
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
            // $('#table2').DataTable().column(0).search('^'+stateID,true,false).draw();
        });
     $('select[name="woreda"]').on('change', function() {
            var stateID = $(this).val();
			// $('#table2').DataTable().column(0).search('^[0-9]{2}'+stateID,true,false).draw();	
        });
    //
    $('#startDate').calendarsPicker({calendar: $.calendars.instance('ethiopian')});	
    $('#endDate').calendarsPicker({calendar: $.calendars.instance('ethiopian')}); 
    $('#membershipDate').calendarsPicker({calendar: $.calendars.instance('ethiopian')});
    $('#dob').calendarsPicker({calendar: $.calendars.instance('ethiopian')});
</script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css"></style>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>

@endsection

