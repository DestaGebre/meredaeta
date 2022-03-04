@extends('layouts.app')

@section('htmlheader_title')
     ዓመታዊ ገምጋም
@endsection

@section('contentheader_title')
    ዓመታዊ ገምጋም
@endsection

@section('header-extra')
  <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- Datatables -->
    <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
@endsection

@section('main-content')
    
            <!-- Profile Image -->

			<div class="box box-primary" role="tabpanel" data-example-id="togglable-tabs">
                      <ul id="myTab1" class="nav nav-tabs bar_tabs right" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content11" id="home-tabb" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">ላዕለዋይ አመራርሓ</a>
                        </li>
						 <li role="presentation" ><a href="#tab_content12" id="home-tabb2" role="tab" data-toggle="tab" aria-controls="home2" aria-expanded="">ማእኸላይ አመራርሓ</a>
                        </li>
						 <li role="presentation" ><a href="#tab_content13" id="home-tabb3" role="tab" data-toggle="tab" aria-controls="home3" aria-expanded="true">ታሕተዋይ አመራርሓ</a>
                        </li>
						 <li role="presentation" ><a href="#tab_content14" id="home-tabb4" role="tab" data-toggle="tab" aria-controls="home4" aria-expanded="true">ጀማሪ አመራርሓ</a>
                        </li>
						
						 <li role="presentation" ><a href="#tab_content16" id="home-tabb6" role="tab" data-toggle="tab" aria-controls="home6" aria-expanded="true">በዓል ሞያ</a>
                        </li>
						 <li role="presentation"><a href="#tab_content17" id="home-tabb7" role="tab" data-toggle="tab" aria-controls="home7" aria-expanded="true">ተራ ኣባል</a>
                        </li>
						
                       
                        
                      </ul>
                      <div id="myTabContent2" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content11" aria-labelledby="home-tab">
                         <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">መፍለይ ቑፅሪ ኣባል  <span class="required">（*）</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>   
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-">ዝምላእ ማህደር </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control">
                            <option>ምረፅ</option>
                            <option> ሰብ ሙያ ኣባል   </option>
                            <option>  ሓረስታይ ኣባል    </option>
                            <option> ሸቓላይ ኣባል </option>
							 <option>  ምሁር ኣባል    </option>
                            <option> ተምሃራይ ኣባል  </option>
                          
                            
                          </select>
                        </div>
                      </div>	
					       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-">ብርኪ ኣመራርሓ </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control">
                            <option>ምረፅ</option>
                            <option> ታሕተዋይ    </option>
                            <option>  ጀማሪ     </option>
                            <option> ማእኸላይ  </option>
							 <option>  ላዕለዋይ    </option>
                            
                          
                            
                          </select>
                        </div>
                      </div>	
					  <div class="form-group">
                       
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ድምር ሚዛን/ስርርዕ     <span class="required">（*）</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div> 
                       						  
 <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ነዚ ማህደር ዘቕረበ ውዳበ    <span class="required"></span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>   		
 <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">ነዚ ማህደር ዘፅደቐ ውዳበ    <span class="required"></span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>					  
                        <div class="col-md-5">
                        ናይ ገምጋም እዋን 
                        <form class=="form-group">
                          <fieldset>
                            <div class="control-group">
                              <div class="controls">
                                <div class="input-prepend input-group">
                                  <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                                  <input type="text" name="reservation-time" id="reservation-time" class="form-control" value="01/01/2016" />
                                </div>
                              </div>
                            </div>
                          </fieldset>
                        </form>
                      </div>					  

					   <div class=="form-group">
                        ዝፀደቐሉ ዕለት 
                        <form class="form-horizontal">
                          <fieldset>
                            <div class="control-group">
                              <div class="controls">
                                <div class="input-prepend input-group">
                                  <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                                  <input type="text" name="reservation-time" id="reservation-time" class="form-control" value="01/01/2016" />
                                </div>
                              </div>
                            </div>
                          </fieldset>
                        </form>
                      </div>	
					  
	<br>

 <label>ቕድሚ ምምዝጋቡ እዞም ዝስዕቡ ከም ዝተማለኡ አረጋግፅ</label>
                      <p style="padding: 5px;">
                        <input type="checkbox" name="hobbies[]" id="hobby1" value="ski" data-parsley-mincheck="2" required class="flat" /> እቲ ዝግምገም ውልቀሰብ ኣባል ካብ ዝኾነሉ ውዳበ ዓመታዊ ገምጋም ናብ ልዕሊኡ ናብ ዘሎ ውዳበ ቐሪቡ እዩ 
                        <br />

                        <input type="checkbox" name="hobbies[]" id="hobby2" value="run" class="flat" />   ዝምልከቶ ውዳበ ኣፅዲቕዎ እዩ 
እዩ 
                        <br />

                        
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">                         
						
                          <button type="submit" class="btn btn-success">ኣቐምጥ</button>
                        </div>
                      </div>

                    </form>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content22" aria-labelledby="profile-tab">
                         <div class="x_content">
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="card-box table-responsive">
                          <p class="text-muted font-13 m-b-30">
                           ዝርዝር ገምጋም 
                          </p>

                          <table id="datatable-keytable" class="table table-striped table-bordered">
                            <thead>
                              <tr>
                                <th> ገምጋም</th>
                                <th>ተግባር</th>
                                
                                
                              </tr>
                            </thead>


                            <tbody>
                              <tr>
                                <td>ገምጋም1 </td>
								 <td>ገምጋም2 </td>								 
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
                </div>
              </div>
                        </div>
                        
                      </div>
                    </div>
@endsection
@section('scripts-extra')
  <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- iCheck -->
    <script src="../vendors/iCheck/icheck.min.js"></script>
    <!-- Datatables -->
    <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="../vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="../vendors/jszip/dist/jszip.min.js"></script>
    <script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../vendors/pdfmake/build/vfs_fonts.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>

@endsection