@extends('layouts.app')

@section('htmlheader_title')
    ኣባል
@endsection

@section('contentheader_title')
  ምሕደራ መረዳእታ ኣባል
@endsection

@section('header-extra')

@endsection

@section('main-content')
    
<div class="box box-primary" role="tabpanel" data-example-id="togglable-tabs">
	  <div id="myTabContent2" class="tab-content">
	    <div role="tabpanel" class="tab-pane fade active in" id="tab_content11" aria-labelledby="add-tab">
			  <div class="col-md-5">
				<div class="box box-primary">
				   <div class="box-header with-border">
					 <h3 class="box-title">ውልቃዊ መረዳእታ</h3>
				   </div>
				   <div class="box-body">
					  @if (count($errors) > 0)
						<div class="alert alert-danger">
						   @foreach ($errors->all() as $error)
						   <p>{{ $error }}</p>
						   @endforeach
						 </div>
					  @endif
					 <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
						{{ csrf_field() }}				
						 <div class="form-group">
								 <label class="col-md-3 control-label" for="name1">መለለዪ ቁፅሪ ኣባል</label>
								 <div class="col-md-9">
								 <input id="name1" name="name" type="text" placeholder="መለለዪ ቁፅሪ ሁፁይ ኣእቱ" class="form-control"></div>
						  </div>
						  <div class="form-group">
							 <label class="col-md-3 control-label" for="name1">ስም ኣባል</label>
							 <div class="col-md-9">
							 <input id="name1" name="name" type="text" placeholder="ስም ሕፁይ ኣእቱ" class="form-control"></div>
						   </div>
							<div class="form-group">
								 <label class="col-md-3 control-label" for="name1">ስም ኣቦ</label>
								 <div class="col-md-9">
								 <input id="name1" name="name" type="text" placeholder="ስም ኣቦ ኣእቱ" class="form-control"></div>
						   </div>		  
							<div class="form-group">
								 <label class="col-md-3 control-label" for="name1">ስም ኣባሕጎ</label>
								 <div class="col-md-9">
								 <input id="name1" name="name" type="text" placeholder="ስም ኣባሕጎ ኣእቱ" class="form-control"></div>
							</div>	
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">ፆታ</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <div id="gender" class="btn-group" data-toggle="buttons">
									<label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
									  <input type="radio" name="gender" value="male"> &nbsp; ተባ &nbsp;
									</label>
									<label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
									  <input type="radio" name="gender" value="female"> ኣነ
									</label>
								  </div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-3">ዕለት ትውልዲ</label>
								<div class="col-md-9 col-sm-9 col-xs-9">
								  <input type="text" class="form-control" data-inputmask="'mask': '99/99/9999'">
								  <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
								</div>
							</div>
							<div class="form-group">
								 <label class="col-md-3 control-label" for="name1">ዝተዋፈርሉ ስራሕ ዘርፍ</label>
								 <div class="col-md-9">
								 <input id="name1" name="name" type="text" placeholder="ስም ኣባሕጎ ኣእቱ" class="form-control"></div>
							  </div>
							  <div class="form-group">
									<label class="col-md-3 control-label" for="postion">ሓላፍነት:</label>
									<div class="col-md-9">
								 <input id="name1" name="name" type="text" placeholder="ስም ኣባሕጎ ኣእቱ" class="form-control"></div>
							  </div>
							  <div class="form-group">
									<label class="control-label col-sm-4" for="postion">ደኣንት:<span class="text-danger">*</span></label>
									<div class="col-sm-8">

									 <select class="form-control" name="position" required="required">
									   <option selected disabled>~ምረፅ~</option>
									   <option >ጀማሪ</option>
									   <option >ማእኸላይ</option>
									   <option >መምረቲ</option>
									   </select>
									</div>	
							   </div>
						  
							  <div class="form-group">
								 <label class="col-md-3 control-label" for="name1">ትውልዲ ቦታ</label>
								 <div class="col-md-9">
								 <input id="name1" name="name" type="text" placeholder="ስም ኣባሕጎ ኣእቱ" class="form-control"></div>
							  </div>
								<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ኣባልነት ዝፀደቐሉ ዕለት<span class="required">（*）</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
								</div>
							 </div> 		 
							  <div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ዓይነት ኣባል:<span class="required">*</span></label>
									<div class="col-sm-6">
										<select class="col-md-6 col-sm-6 col-xs-12" name="parentAccount" id="parentAccount" required="required">
											<option selected disabled>~ምረፅ~</option>
											<option value="Asset">ተጋዳላይ</option>
											<option value="Liability">ሲቪል</option>
										</select>
									</div>
								  </div>
							
						</div> 						   
					</form>
				  </div>
			   </div>
		   </div>
		</div>
		<div class="col-md-7">
		  <div class="box box-primary">
			 <div class="box-header with-border">
				<h3 class="box-title">ተወሰኽቲ መረዳእታታት</h3>
			</div>
		   <div class="box-body">
		     <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
							{{ csrf_field() }}
							{{ csrf_field() }}
				<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ግሮስ ደመወዝ<span class="required">（*）</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
								</div>
							 </div> 
							<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ዝተፃረየ ደመወዝ<span class="required">（*）</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							  <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
							</div>
						 </div> 
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ዝተመደቦ ዋህዮ<span class="required">（*）</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
					</div>
				 </div> 
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ዝተመደቦ መሰረታዊ ውዳበ<span class="required">（*）</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
					</div>
				 </div> 
				 <div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ቁፅሪ ሰነድ<span class="required">（*）</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
					</div>
				 </div> 
				 <div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ዝተመልመልሉ ቦታ<span class="required">（*）</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
					</div>
				 </div>
					<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ዝተመልመልሉ ዕለት<span class="required">（*）</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
					</div>
				 </div>

					<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ዝመልመሎ ኣካል<span class="required">（*）</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
					</div>
				 </div>
					<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ዝተመልመልሉ ዋህዮ<span class="required">（*）</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
					</div>
				 </div>
					<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ዝተመልመልሉ መሰረታዊ ውዳበ<span class="required">（*）</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
					</div>
				 </div>

					<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ቁፅሪ ፋይል<span class="required">（*）</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
					</div>
				 </div>
			   
				 </div>	  
			   </form>
			</div>
		  </div>
			  </div>
				<div class="ln_solid"></div>
				  <div class="form-group">
					<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">                         
					
					  <button type="submit" class="btn btn-success">ኣቐምጥ</button>
					</div>
				  </div>
		 </div>
			
 </div>
</div>
@endsection
@section('scripts-extra')

@endsection
