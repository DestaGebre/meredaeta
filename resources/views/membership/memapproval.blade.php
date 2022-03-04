@extends('layouts.app')

@section('htmlheader_title')
    ኣባልነት ምፅዳቕ
@endsection

@section('contentheader_title')
   ኣባል ምፅዳቕ
@endsection

@section('header-extra')

@endsection

@section('main-content')
    
            <!-- Profile Image -->

  <div class="box box-primary" role="tabpanel" data-example-id="togglable-tabs">
	 <div id="myTabContent2" class="tab-content">
		<div role="tabpanel" class="tab-pane fade active in" id="tab_content11" aria-labelledby="add-tab">
		 <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ሕፁይ<span class="required">（*）</span>
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
			  <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
			</div>
		 </div>                

			<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ዕለት<span class="required">（*）</span>
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
			  <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
			</div>
		 </div> 
       			  
	  </div> 			  
		  <div class="ln_solid"></div>
		  <div class="ln_solid"></div>
		   <div class="form-group">
			<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">                         
			
			  <button type="submit" class="btn btn-success">ኣፅድቕ</button>
			</div>
		  </div>

	   </form>
</div>
 </div>

@endsection
@section('scripts-extra')

@endsection