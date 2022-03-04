<?php $__env->startSection('htmlheader_title'); ?>
    ቅፅዓት 
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheader_title'); ?>
   ምሕደራ ቅፅዓት ኣባላት
<?php $__env->stopSection(); ?>

<?php $__env->startSection('header-extra'); ?>
<style type="text/css">
    .form-control:read-only {
        background-color: #fff;
        cursor: default;
    }
    @media  print {
      #print,.switchBtn {
        display: none;
      }
    }
</style>  
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>
    
            <!-- Profile Image -->
	<div class="box box-primary">
        <div class="myswitch pull-right">			        
			   <button class="btn switchBtn btn-info"><span class="glyphicon glyphicon-plus"></span> ሓዱሽ መዝግብ </button> 
	   </div>		
	   <div class="mytoggle hidden pull-right">					  
			<button class="btn toggleBtn btn-info"><span class="glyphicon glyphicon-arrow-up"></span></button> 				  
		</div>
		<?php $cnt = (count($errors) > 0); ?>
		<?php if(count($errors) > 0): ?>
	         <div class = "alert alert-danger">
	            <ul>
	               <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
	                  <li><?php echo e($error); ?></li>
	               <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
	            </ul>
	         </div>
	      <?php endif; ?>
		<div id ="penaltydiv" class="form-group hidden">
		  </br>	
		  	<div style="padding: 0px 0px 10px 385px">
		    	<button class="btn search-modal"><span class="glyphicon glyphicon-search"></span> ካብ ማህደር ድለ</button>	
		  	</div>
                         <form id="demo-form2" method="POST" action= "<?php echo e(URL('penalty')); ?>" data-parsley-validate class="form-horizontal form-label-left">
                         	<?php echo e(csrf_field()); ?>				
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="hitsuyID1">መፍለይ ቑፅሪ ኣባል  <span class="required">（*）</span>
							</label>
							<div class="col-md-2 col-sm-6 col-xs-12">
								<input type="text" id="hitsuyID1" name="hitsuyID" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo e($cnt ? Request::old('hitsuyID') : ''); ?>">
							</div>
							<!-- <button class="btn search-modal"><span class="glyphicon glyphicon-search"></span> ካብ ማህደር ድለ</button>					 -->
						</div>   
						<div class="form-group">
							<label for="chargeType1" class="control-label col-md-3 col-sm-3 col-xs-">ዓይነት ጥፍኣት <span class="required">（*）</span></label>
							<div class="col-md-3 col-sm-6 col-xs-12">
								<select id="chargeType1" name="chargeType" class="form-control" required="required">
									<option selected disabled>~ምረፅ~</option>
									<option>ቀሊል ናይ ስነምግባር ጉድለት  </option>
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
							<label for="chargeLevel1" class="control-label col-md-3 col-sm-3 col-xs-">ደረጃ ጥፍኣት <span class="required">（*）</span></label>
							<div class="col-md-3 col-sm-6 col-xs-12">
								<select id="chargeLevel1" name="chargeLevel" class="form-control" required>
									<option selected disabled>~ምረፅ~</option>
									<option>ቀሊል</option>
									<option>ኸቢድ</option>
								</select>
							</div>
						</div>	

						<div class="form-group">
							<label for="penaltyGiven1" class="control-label col-md-3 col-sm-3 col-xs-">ዝተውሃቦ ቅፅዓት <span class="required">（*）</span></label>
							<div class="col-md-3 col-sm-6 col-xs-12">
								<select id="penaltyGiven1" name="penaltyGiven" class="form-control" required>
									<option selected disabled>~ምረፅ~</option>
									<option>መጠንቀቕታ</option>
									<option>ናይ ሕፀ እዋን ምንዋሕ</option>
									<option>ካብ ሕፁይነት ምብራር</option>
									<option>ካብ ሙሉእ ናብ ሕፁይ ኣባልነት ምውራድ</option>
									<option>ካብ ሓላፍነት ንውሱን ጊዜ ምእጋድ</option>
									<option>ካብ ሓላፍነት ምውራድ</option>
									<option>ካብ ኣባልነት ንውሱን ጊዜ ምእጋድ</option>
									<option>ካብ ኣባልነት ምብራር</option>
								</select>
							</div>
						</div>			
						<div class="form-group">

							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="proposedBy1">መበገሲ ሓሳብ ዘቕረበ ኣካል<span class="required">（*）</span>
							</label>
							<div class="col-md-3 col-sm-6 col-xs-12">
								<input type="text" id="proposedBy1" name="proposedBy" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo e($cnt ? Request::old('proposedBy') : ''); ?>">
							</div>
						</div> 
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="approvedBy1">ዘፅደቐ (ዝወሰነ) ኣካል<span class="required"></span>
							</label>
							<div class="col-md-3 col-sm-6 col-xs-12">
								<input type="text" id="approvedBy1" name="approvedBy" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo e($cnt ? Request::old('approvedBy') : ''); ?>">
							</div>
						</div>   		
						<!-- <div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="duration1">ቕፅዓት ዝፀንሐሉ እዋን    <span class="required"></span>
							</label>
							<div class="col-md-3 col-sm-6 col-xs-12">
								<input type="text" id="duration1" name="duration" required="required" class="form-control col-md-7 col-xs-12">
							</div>
						</div> -->
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="startDate1">ቕፅዓት ዝተውሃበሉ ዕለት <span class="required">（*）</span>
							</label>
							<div class="col-md-3 col-sm-6 col-xs-12">
								<input type="text" id="startDate1" name="startDate" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo e($cnt ? Request::old('startDate') : ''); ?>">
							</div>
						</div>
					  <br/>
						<br/>
	                    <p style="padding: 0px;">&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp <b> ቕድሚ ምምዝጋቡ እዞም ዝስዕቡ ከም ዝተማለኡ አረጋግፅ </b></p>
                      <div class="checkbox">
                      <input type="hidden" name="isReported" value="0"/>
                      <label>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
                        <input type="checkbox" name="isReported" id="isReported" value="1" class="flat" /> ናይ ስንብት መበገሲ ሓሳብ እቲ ውልቀሰብ ኣባል ካብ ዝኾነሉ ውዳበ ናብ ልዕሊኡ ናብ ዘሎ ውዳበ ቐሪቡ እዩ </label></div> 
                        <br /><div class="checkbox">
                        <input type="hidden" name="isApproved" value="0"/>
                        <label>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
                        <input type="checkbox" name="isApproved" id="isApproved" value="1" class="flat" />   መበገሲ ሓሳብ ዝቐረበሉ ውዳበ ነቲ ካብ ብትሕቲኡ ዘሎ ውዳበ ዝቐረበሉ ኣፅዲቕዎ እዩ</label> </div>
                        <br/>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">                         
						
                          <button type="submit" class="btn btn-success">ኣቐምጥ</button>
                        </div>
                      </div>

                    </form>
                </div>			
                      
		<div id="penaltylist" class="form-group">
		  <div class="col-sm-12">
			<div class="card-box table-responsive">
			  <p class="text-muted font-13 m-b-30">
			  </p>			  
			  <div class="">				
				<div class="table-responsive text-center">
					<table class="table table-striped table-borderless" id="table2">
						<thead>
							<tr>
								<th class="text-center">መ.ቑ</th>
								<th class="text-center">ዓይነት ጥፍኣት</th>
								<th class="text-center">ደረጃ ጥፍኣት</th>
								<th class="text-center">ዝተውሃቦ ቅፅዓት</th>
								<th class="text-center">መበገሲ ሓሳብ ዘቕረበ</th>
								<th class="text-center">ዘፅደቐ ኣካል</th>
								<th class="text-center">ቕ/ት ዝፀንሐሉ እዋን</th>								
								<th class="text-center">ቕ/ት ዝተውሃቦ ዕለት</th>
								<th class="text-center">ተግባር</th>
								
							</tr>					
						</thead>
						<tbody>
							<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mypen): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>						  
							<tr>
								<input type="hidden" value="<?php echo e($mypen->id); ?>">
								<td><?php echo e($mypen->hitsuyID); ?></td>	
								<td><?php echo e($mypen->chargeType); ?></td>                          
								<td><?php echo e($mypen->chargeLevel); ?></td>
								<td><?php echo e($mypen->penaltyGiven); ?></td>
								<td><?php echo e($mypen->proposedBy); ?></td>
								<td><?php echo e($mypen->approvedBy); ?></td>
								<td><?php echo e($mypen->duration); ?></td>
								<td><?php echo e(App\DateConvert::toEthiopian(date('d/m/Y',strtotime($mypen->startDate)))); ?></td>
								<td>
									<?php if(array_search(Auth::user()->usertype, ['admin', 'zoneadmin', 'woredaadmin']) !== false): ?>
									<button class="edit-modal btn btn-info" data-info="<?php echo e($mypen->hitsuyID); ?>,<?php echo e($mypen->chargeType); ?>,<?php echo e($mypen->chargeLevel); ?>,<?php echo e($mypen->penaltyGiven); ?>,<?php echo e($mypen->proposedBy); ?>,<?php echo e($mypen->approvedBy); ?>,<?php echo e($mypen->duration); ?>,<?php echo e($mypen->startDate); ?>,<?php echo e($mypen->id); ?>">
									<span class="glyphicon glyphicon-edit"></span>ኣመሓይሽ</button>
									<button class="delete-modal btn btn-danger" data-info="<?php echo e($mypen->hitsuyID); ?>,<?php echo e($mypen->startDate); ?>,<?php echo e($mypen->id); ?>">
									<span class="glyphicon glyphicon-trash"></span>ሰርዝ</button>
									<?php endif; ?>
								</td>  						  
						   </tr>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
							</tbody>
						</table>
						</div>
						<?php echo e($data->links()); ?>

						</div>			
			</div>
		  </div>
		</div>
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
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="hitsuyID">መፍለይ ቑፅሪ ኣባል  <span class="required">（*）</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="hitsuyID" name="hitsuyID" readonly class="form-control col-md-7 col-xs-12">
								<input type="hidden" id="hhID" name="hhID" >
							</div>							
						</div>   
						<div class="form-group">
							<label for="chargeType" class="control-label col-md-3 col-sm-3 col-xs-">ዓይነት ጥፍኣት </label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select id="chargeType" name="chargeType" class="form-control">
									<option selected disabled>~ምረፅ~</option>
									<option>ቀሊል ናይ ስነምግባር ጉድለት  </option>
									<option>ወርሓዊ ወፈያ  ንልዕሊ ሓደ ወርሒ ምሕላፍ</option>
									<option>ንናይ ህወሓት ፕሮግራምን ሕገ ደንቢን ዘይምቕባል</option>
									<option>ብኸቢድ ገበን ተኸሲሱ ገበነኛ ዝተብሃለ</option>
									<option>ናይ ጉጅለ ምንቅስቓስ ምክያድ</option>
									<option>ናይ ስነምግባር መጠንቐቕታ ተዋሂብዎ ዝደገመ</option>
									<option>ናይ ኣባልነት ወፈያ ብእዋኑ ዘይምኽፋልን ልዕሊ ክልተ ጊዜ መጠንቐቕታ ዝተውሃቦ</option>
									<option> መሰል ኣባል እንትግሃስ ብተደጋጋሚ እናገጠሞን እናፈለጠን ብዝግባእ ዘይተቓለሰ</option>
									<option>ገምጋምን ምንቅቓፍን ብተደጋጋሚ ንሰብ መጥቕዒ ወይ መጥቀሚ ክጥቀም ዝሃቀነን</option>
								</select>
							</div>
						</div>	
						<div class="form-group">
							<label for="chargeLevel" class="control-label col-md-3 col-sm-3 col-xs-">ደረጃ ጥፍኣት </label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select id="chargeLevel" name="chargeLevel" class="form-control">
									<option selected disabled>~ምረፅ~</option>
									<option>ቀሊል</option>
									<option>ኸቢድ</option>
								</select>
							</div>
						</div>	
						
						<div class="form-group">
							<label for="penaltyGiven" class="control-label col-md-3 col-sm-3 col-xs-">ዝተውሃቦ ቅፅዓት </label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select id="penaltyGiven" name="penaltyGiven" class="form-control">
									<option selected disabled>~ምረፅ~</option>
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
							
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="proposedBy">መበገሲ ሓሳብ ዘቕረበ ኣካል<span class="required">（*）</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="proposedBy" name="proposedBy" required="required" class="form-control col-md-7 col-xs-12">
							</div>
						</div> 
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="approvedBy">ዘፅደቐ (ዝወሰነ) ኣካል<span class="required"></span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="approvedBy" name="approvedBy" required="required" class="form-control col-md-7 col-xs-12">
							</div>
						</div>   		
						<!-- <div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="duration">ቕፅዓት ዝፀንሐሉ እዋን    <span class="required"></span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="duration" name="duration" required="required" class="form-control col-md-7 col-xs-12">
							</div>
						</div> -->
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="startDate">ቕፅዓት ዝተውሃበሉ ዕለት     <span class="required"></span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="startDate" name="startDate" required="required" class="form-control col-md-7 col-xs-12">
							</div>
						</div>
						
						
						<div class="col-md-6 col-sm-6 col-xs-12">
                         
                        </div>
						
					</form>
					<div class="searchContent">
					
		      
			            <div class="form-group col-md-12 col-sm-12 col-xs-12">			                
			                <div class="col-md-6 col-sm-6 col-xs-6">    
			                <select name="zone" id="zone" class="form-control" >
			                    <option value=""selected disabled>~ዞባ ምረፅ~</option>
			                    <?php $__currentLoopData = $zobadatas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
			                        <option value="<?php echo e($key); ?>"><?php echo e($value); ?></option>
			                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
			                </select>
			                </div>
			                <div class="col-md-6 col-sm-6 col-xs-6">    
			                <select name="woreda" id="woreda" class="form-control">
							<option value="">~ወረዳ ምረፅ~</option>
			                </select>
			                </div>
			            </div>
			            <div class="form-group col-md-12 col-sm-12 col-xs-12">
			                <div class="col-md-6 col-sm-6 col-xs-6">    
			                <select name="tabiaID" id="tabiaID" class="form-control" >
							<option value=""selected disabled>~ጣብያ ምረፅ~</option>
			                </select>
			                </div>
			                <div class="col-md-6 col-sm-6 col-xs-6">    
		                        <select name="proposerWidabe" id="proposerWidabe" class="form-control">
		                            <option value=""selected disabled>~መሰረታዊ ውዳበ ምረፅ~</option>
		                        </select>
			                 </div>
			            </div>
						<div class="form-group col-md-12 col-sm-12 col-xs-12">			              
							<div class="col-md-6 col-sm-6 col-xs-6">
			                      <select class="form-control" id="proposerWahio" name="proposerWahio" required="required">
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
						ቕፅዓት ናይ ኣባል መፍለይ ቑፅሪ "<span class="hID text-danger"></span>" ብትክክል ክጠፍአ ይድለ ድዩ  ? <span
							class="hidden did"></span>
							<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
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
           
 
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts-extra'); ?>
<!-- For Ethiopian Calender Date picker -->
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
      	<?php echo $__env->make('layouts.partials.lang', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>,
      	"order": []
      });
     });
  	$(document).on('click', '.switchBtn', function() {
    	$('#penaltylist').addClass('hidden');
    	$('.myswitch').addClass('hidden');
        $('#penaltydiv').removeClass('hidden');                 
        $('.mytoggle').removeClass('hidden');                 
    });	
    $(document).on('click', '.toggleBtn', function() {
    	$('.alert-danger').remove();
    	$('#penaltydiv').addClass('hidden');
    	$('.mytoggle').addClass('hidden');
        $('#penaltylist').removeClass('hidden');                 
        $('.myswitch').removeClass('hidden');                 
    });	
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
                    url: 'myform2/ajax/allhitsuy/'+stateID,
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
        $('.modal-title').text('መስተኻኸሊ ቕፅዓት ኣባል');
        $('.deleteContent').hide();
        $('.searchContent').hide();
        $('.formadder').show();
        row = $($($(this).parent()).parent()).children();
        stuff = [$(row[0]).val(),$(row[1]).html(),$(row[2]).html(),$(row[3]).html(),$(row[4]).html(),$(row[5]).html(),$(row[6]).html(),$(row[7]).html(),$(row[8]).html()];
        fillmodalData(stuff)
        $('#myModal').modal('show');
    });

    function fillmodalData(details){
      $('#hitsuyID').val(details[1]);
      $('#chargeType').val(details[2]);
      $('#chargeLevel').val(details[3]);
      $('#penaltyGiven').val(details[4]);
      $('#proposedBy').val(details[5]);
      $('#approvedBy').val(details[6]);
      $('#duration').val(details[7]);
      $('#startDate').val(details[8]);    
    }
    $('.modal-footer').on('click', '.edit', function() {
        $.ajax({
            type: 'post',
            url: 'editpenalty',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': stuff[0],
                'hitsuyID': $("#hitsuyID").val(),
                'chargeType': $('#chargeType').val(),
                'chargeLevel': $('#chargeLevel').val(),
                'penaltyGiven': $("#penaltyGiven").val(),
                'proposedBy': $('#proposedBy').val(),
                'approvedBy': $('#approvedBy').val(),
                'duration': $("#duration").val(),
                'startDate': $('#startDate').val()
            },
			
            success: function(data) {
	            if(data[0] == true){
	                    $(row[2]).html($('#chargeType').val());
	                    $(row[3]).html($('#chargeLevel').val());
	                    $(row[4]).html($('#penaltyGiven').val());
	                    $(row[5]).html($('#proposedBy').val());
	                    $(row[6]).html($('#approvedBy').val());
	                    $(row[7]).html($('#duration').val());
	                    $(row[8]).html($('#startDate').val());
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
        $('.modal-title').text(' መሰረዚ ቅፅዓት ኣባል');
        $('.deleteContent').show();
        $('.formadder').hide();
        $('.searchContent').hide();
        row = $($($(this).parent()).parent()).children();
        var stuff = $(this).data('info').split(',');			    
        $('.did').text($(row[0]).val());	
        $('.hID').html($(row[1]).val());

        $('#myModal').modal('show');
    });

	$('.modal-footer').on('click', '.delete', function() {
        $.ajax({
            type: 'post',
            url: 'deletepenalty',
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
            },

            error: function(xhr,errorType,exception){
            		
            			alert(exception);
                        
            }
        });
    });
    $('#startDate1').calendarsPicker({calendar: $.calendars.instance('ethiopian')});
    <?php if(count($errors) > 0): ?>
        $('.switchBtn').click();
    <?php endif; ?>
  </script>
 
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>