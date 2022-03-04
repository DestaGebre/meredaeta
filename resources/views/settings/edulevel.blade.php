@extends('layouts.app')

@section('htmlheader_title')
    ዞባ
@endsection

@section('contentheader_title')
   ዞባ
@endsection

@section('header-extra')

@endsection

@section('main-content')
    
            <!-- Profile Image -->

  <div class="box box-primary" role="tabpanel" data-example-id="togglable-tabs">
	  <ul id="myTab1" class="nav nav-tabs bar_tabs right" role="tablist">
		<li role="presentation" class="active"><a href="#tab_content11" id="add-tabb" role="tab" data-toggle="tab" aria-controls="add" aria-expanded="true">ሓዱሽ</a>
		</li>
		<li role="presentation" class=""><a href="#tab_content22" role="tab" id="view-tabb" data-toggle="tab" aria-controls="view" aria-expanded="false">ዝርዝር</a>
		</li>
		
	  </ul>
	 <div id="myTabContent2" class="tab-content">
		<div role="tabpanel" class="tab-pane fade active in" id="tab_content11" aria-labelledby="add-tab">
		 <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ሽም ዞባ  <span class="required">（*）</span>
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
			  <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
			</div>
		 </div>               
				   
		  <div class="ln_solid"></div>
		   <div class="form-group">
			<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">                         
			
			  <button type="submit" class="btn btn-success">Member Name</button>
			</div>
		  </div>
		  <div class="ln_solid"></div>
		   <div class="form-group">
			<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">                         
			
			  <button type="submit" class="btn btn-success">Field of Study</button>
			</div>
		  </div>
		  <div class="ln_solid"></div>
		   <div class="form-group">
			<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">                         
			
			  <button type="submit" class="btn btn-success">Level</button>
			</div>
		  </div>
		  <div class="ln_solid"></div>
		   <div class="form-group">
			<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">                         
			
			  <button type="submit" class="btn btn-success">Institution</button>
			</div>
		  </div>
			<div class="ln_solid"></div>
		   <div class="form-group">
			<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">                         
			
			  <button type="submit" class="btn btn-success">Completion year</button>
			</div>
		  </div>
	   </form>
	</div>
		<div role="tabpanel" class="tab-pane fade" id="tab_content22" aria-labelledby="view-tab">
		  <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo
			booth letterpress, commodo enim craft beer mlkshk aliquip</p>
		</div>
		
	  </div>
	</div>
@endsection
@section('scripts-extra')

@endsection