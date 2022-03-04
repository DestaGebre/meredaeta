<?php
    use Carbon\Carbon;
?>


<?php $__env->startSection('htmlheader_title'); ?>
ምሕደራ ሕፁይነት
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheader_title'); ?>
ምሕደራ ሕፁይነት
<?php $__env->stopSection(); ?>

<?php $__env->startSection('header-extra'); ?>

<link rel="stylesheet" href="css/jquery.dataTables.min.css"></style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('main-content'); ?>
    
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
		<div id ="hitsuydiv" class="form-group hidden">
		  </br>	
            <form id="profile-form" method="POST" action= "<?php echo e(URL('hitsuy')); ?>" data-parsley-validate class="form-horizontal form-label-left">
				<div class="col-md-5">
				<div class="box box-primary">
				<div class="box-header with-border">
				  <h3 class="box-title">ውልቃዊ መረዳእታ</h3>
				</div>
				<div class="box-body">
				  <?php echo e(csrf_field()); ?>        
				  <div class="form-group">
					<label class="col-md-2 control-label" for="name">ሽም ሕፁይ</label>
					<div class="col-md-4">
					  <input id="name" name="name" type="text" placeholder="" class="form-control" required value="<?php echo e($cnt ? Request::old('name') : ''); ?>"></div>

					  <label class="col-md-2 control-label" for="fname">ሽም ኣቦ</label>
					  <div class="col-md-4">
						<input id="fname" name="fname" type="text" placeholder="" class="form-control" required value="<?php echo e($cnt ? Request::old('fname') : ''); ?>"></div>
					  </div>      
					  <div class="form-group">
						<label class="col-md-2 control-label" for="gfname">ሽም ኣባሕጎ</label>
						<div class="col-md-4">
						  <input id="gfname" name="gfname" type="text" placeholder="" class="form-control" required value="<?php echo e($cnt ? Request::old('gfname') : ''); ?>"></div>

						  <label class="control-label col-md-2 col5sm-2 col-xs-12">ፆታ</label>
						  <div class="col-md-4 col-sm-7 col-xs-12">
						  <label  class="radio-inline">
							<input type="radio" name="gender" id="male" value="ተባ" checked="checked" required>
							ተባ
						  </label>
						  <label  class="radio-inline">
							<input type="radio" name="gender" id="female" value="ኣን" required>
							ኣን
						  </label>
						<!-- ተባ:<input type="radio" class="flat" name="gender" id="male" value="ተባ" checked="" required />
						ኣን:<input type="radio" class="flat" name="gender" id="female" value="ኣን" /> -->

					  </div>
					</div>
					<div class="form-group">
					  <label class="col-md-2 control-label" for="birthPlace">ትውልዲ ቦታ</label>
					  <div class="col-md-4">
						<input id="birthPlace" name="birthPlace" type="text" placeholder="" class="form-control" value="<?php echo e($cnt ? Request::old('birthPlace') : ''); ?>"></div>

						<label class="col-md-2 control-label" for="dob">ዕለት ትውልዲ</label>
						<div class="col-md-4">
						  <input id="dob" name="dob" type="text" placeholder="" class="form-control" value="<?php echo e($cnt ? Request::old('dob') : ''); ?>"></div>
						</div>
						<div class="form-group">
						  <label class="control-label col-sm-2" for="occupation">ማሕበራዊ መሰረት:<span class="text-danger">*</span></label>
						  <div class="col-sm-4">
							<select class="form-control" name="occupation" required="required">
							  <option selected disabled>~ምረፅ~</option>
							  <option>ገባር</option>
							  <option>ተምሃሮ</option>
							  <option>መምህራን</option>
							 <option>ሰብ ሞያ</option>
							  <option>ሸቃሎ</option>
							  <option>ደኣንት</option>
							</select>
						  </div>
						  <label class="col-md-2 control-label" for="position">ሓላፍነት:</label>
						  <div class="col-md-4">
							<input id="position" name="position" type="text" placeholder="" class="form-control" value="<?php echo e($cnt ? Request::old('position') : ''); ?>"></div>
						  </div>
						  <div class="form-group">
						  <div id="daant" class="hidden">
							<label class="control-label col-sm-2 " for="sme">ደኣንት:<span class="text-danger">*</span></label>
							<div class="col-sm-4">

							  <select class="form-control" name="sme">
								<option selected disabled>~ምረፅ~</option>
								<option>መፍረይቲ</option>
								<option>ከተማ ሕርሻ</option>
								<option>ኮንስትራክሽን</option>
								<option>ንግዲ</option>
								<option>ግልጋሎት</option>
							  </select>
							</div>  
							</div>  
							<label class="col-md-2 control-label" for="regDate">ዝተመልመልሉ ዕለት:</label>
							<div class="col-md-4">
							  <input id="regDate" name="regDate" type="text" placeholder="" class="form-control" value="<?php echo e($cnt ? Request::old('regDate') : ''); ?>"></div>
							</div>
							<div class="form-group">
							  <label class="control-label col-md-2 col-sm-4" for="educationlevel">ደረጃ ትምህርቲ:</label>
							  <div class="col-md-4 col-sm-4 col-xs-4">
								  <select id="educationlevel" name="educationlevel" class="form-control">
									  <option selected="" disabled="">~ምረፅ~</option>
									  <option>ዘይተምሃረ</option>
									  <option value="1">1ይ</option>
									  <option value="2">2ይ</option>
									  <option value="3">3ይ</option>
									  <option value="4">4ይ</option>
									  <option value="5">5ይ</option>
									  <option value="6">6ይ</option>
									  <option value="7">7ይ</option>
									  <option value="8">8ይ</option>
									  <option value="9">9ይ</option>
									  <option value="10">10ይ</option>
									  <option value="11">11</option>
									  <option value="12">12</option>
									  <option value="ሰርቲፊኬት">ሰርቲፊኬት</option>
									  <option value="ዲፕሎማ">ዲፕሎማ</option>
									  <option value="ዲግሪ">ዲግሪ</option>
									  <option value="ማስተርስ">ማስተርስ</option>
									  <option value="ፒ.ኤች.ዲ">ፒ.ኤች.ዲ</option>
								  </select>
							  </div>
								  <label class="col-md-2 control-label" for="skill">ዘለዎ ሞያ<span class="text-danger">*</span></label>
								<div class="col-md-4">
								  <input id="skill" name="skill" type="text" placeholder="" class="form-control" value="<?php echo e($cnt ? Request::old('skill') : ''); ?>"></div>
							  </div>
							
								<div class="form-group">
								  <label class="col-md-2 control-label" for="proposerMem">ዝመልመሎ ውልቀ ሰብ</label>
								  <div class="col-md-4">
									<input id="proposerMem" name="proposerMem" type="text" placeholder="" class="form-control" value="<?php echo e($cnt ? Request::old('proposerMem') : ''); ?>"></div>
									<label class="col-md-2 control-label" for="fileNumber">ቑፅሪ ፋይል</label>
									<div class="col-md-4">
									  <input id="fileNumber" name="fileNumber" type="text" placeholder="" class="form-control" value="<?php echo e($cnt ? Request::old('fileNumber') : ''); ?>"></div>
									</div>
								  </div>
				</div>
			</div>
					<div class="col-md-5 col-md-offset-1">
						<div class="box box-primary">
							<div class="box-header with-border">
								<h3 class="box-title">መረዳእታ ኣድራሻ</h3>
							</div>
							<div class="box-body">
								<label> ዝነብርሉ ክልል*:</label>
					<label  class="radio-inline">
							<input type="radio" name="region" id="Tigrai" value="ትግራይ" checked="checked" required>
							ትግራይ/ኣዲስኣበባ/ዩንቨርስቲ
					</label>
					<label  class="radio-inline">
							<input type="radio" name="region" id="nonTigrai" value="ካልእ" required>
							ካልእ
					</label>
									<!-- ትግራይ/ኣዲስኣበባ/ዩንቨርስቲ:
									<input type="radio" class="flat" name="region" id="Tigrai" value="ትግራይ" checked="" required /> ካልእ:
									<input type="radio" class="flat" name="region" id="nonTigrai" value="ካልእ" /> -->
									<br><br>
									<div class="form-group zoneworeda">
										<label class="control-label col-sm-2" for="zone">ዞባ:<span class="text-danger">*</span></label>
										<div class="col-sm-4">
											<select class="form-control" name="zone" required="required">
												<option selected disabled>~ዞባ ምረፅ~</option>
												<?php $__currentLoopData = $zobadatas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
													<option value="<?php echo e($key); ?>"><?php echo e($value); ?></option>
												<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
											</select>
										</div>	
										<label class="control-label col-sm-2" for="woreda">ወረዳ:<span class="text-danger">*</span></label>
										<div class="col-sm-4">
											<select class="form-control" name="woreda" required="required">
												<option selected disabled>~ወረዳ ምረፅ~</option>
											</select>
										</div>	
									</div>
									<div class="form-group tabia">
										<label class="control-label col-sm-2" for="tabiaID">ጣብያ:<span class="text-danger">*</span></label>
										<div class="col-sm-7">
											<select class="form-control" name="tabiaID" required="required">
												<option selected disabled>~ጣብያ ምረፅ~</option>
											</select>
										</div>	
									</div>
									<div class="form-group tabia">
										<label class="col-md-2 control-label" for="proposerWidabe">መ.ውዳበ.</label>
										<div class="col-md-4">
										<select class="form-control" id="proposerWidabe" name="proposerWidabe" required="required">
												<option selected disabled>~ውዳበ ምረፅ~</option>
										</select>
										</div>																	
										<label class="col-md-2 control-label" for="proposerWahio">ዋህዮ</label>
										<div class="col-md-4">
											<select class="form-control" id="proposerWahio" name="proposerWahio" required="required">
												<option selected disabled>~ዋህዮ ምረፅ~</option>
											</select>									
										</div>	
									</div>
									<div id="otherType" class="hidden">
										<label class="col-md-2 control-label" for="address">ኣድራሻ：</label>
										<div class="col-md-8">
											<input id="address" name="address" type="text" placeholder="ካብ ትግራይ ወፃኢ ንዝኮነ ጥራሕ" class="form-control" value="<?php echo e($cnt ? Request::old('address') : ''); ?>"></div><br><br><br>
										</div>
										<div class="form-group">
											<label class="col-md-2 control-label" for="tell">ቑፅሪ ስልኪ</label>
											<div class="col-md-4">
												<input id="tell" name="tell" type="text" placeholder="" class="form-control" value="<?php echo e($cnt ? Request::old('tell') : ''); ?>"></div>
												<label class="col-md-1 control-label" for="email">ኢሜይል</label>
												<div class="col-md-5">
													<input id="email" name="email" type="email" placeholder="" class="form-control" value="<?php echo e($cnt ? Request::old('email') : ''); ?>"></div>
										</div>	
										

												<div class="form-group">&nbsp &nbsp 
													<label>መረዲእታ ሕፁይ ቕድሚ ምምዝጋቡ እዞም ዝስዕቡ ከም ዝተማለኡ አረጋግፅ</label>
													<div class="checkbox">
							  <input type="hidden" name="isRequested" value="0">
														<label>&nbsp &nbsp
															<input type="checkbox" name="isRequested" value="1">ሕፁይ ዝምልከት ፀብፃብ ብመልማላይ ኣቢሉ ናብ ዝምልከቶ ውዲበ ቐሪቡ እዩ

														</label>
													</div>
													<div class="checkbox">&nbsp &nbsp 
								<input type="hidden" name="hasPermission" value="0">
														<label> <input type="checkbox" name="hasPermission" value="1">ሕፁይ ንምዃን ካብ ዝምልከቶ ውዲበ ሓላፊ ፍቓድ ረኺቡ እዩ
														</label>
													</div>
													<div class="checkbox">&nbsp &nbsp
								<input type="hidden" name="isWilling" value="0">
														<label>
															<input type="checkbox" name="isWilling" value="1">ተመልማላይ ሕፁይ ክኸውን ከም ዝደሊ ብፊርማኡ ኣረጋጊፁ እዩ
														</label>
													</div>
													<div class="checkbox">&nbsp &nbsp 
								<input type="hidden" name="isReportedWahioHalafi" value="0">
														<label>
															<input type="checkbox" name="isReportedWahioHalafi" value="1">ናይ መልማላይ ዋህዮ ኣቦ ወንበር ርእይቶ ዝሓዘ ፀብፃብ ቐሪቡ እዩ

														</label>
													</div>
													<div class="checkbox">&nbsp &nbsp 
								<input type="hidden" name="isReportedWahioMem" value="0">
														<label>
															<input type="checkbox" name="isReportedWahioMem" value="1">ናይ ዋህዮ ኣባላት ውሳነ ዝሓዘ ፀብፃብ ቐሪቡ እዩ 
														</label>
													</div>
												</div>

											</div>
										</div>
									</div>
									<div class="ln_solid"></div>
									<div class="form-group">
										<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
											<button type="submit" class="btn btn-block btn-success">ኣቐምጥ</button>
										</div>
									</div>
								</form>
                </div>
		<div id="hitsuylist" class="form-group">
		<?php echo $__env->make('layouts.partials.filter_html', ['address' => 'membership'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
			<div class="">
				<?php echo e(csrf_field()); ?>

				<div class="table-responsive text-center">
					<table class="table table-hover" id="table2">
						<thead>
							<tr>
								<th class="text-center">መ.ቑ</th>
								<th class="text-center">ሽም ህፁይ</th>
								<th class="text-center">ፆታ</th>
								<th class="text-center">ዝተመልመለሉ ዕለት</th>
								<th class="text-center">ዝመለመሎ ዋህዮ</th>
								<th class="text-center">ዝተዋፈርሉ ስራሕ</th>
								<th class="text-center">ኩነታት ሕፁይነት</th>
								<th class="text-center">ተግባር</th>
								
							</tr>					
						</thead>
						<tbody>
							<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mydata): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                            <?php 
                                $d = explode('-', $mydata->regDate);
                                $bg_color = '';
                                if(Carbon::createFromDate($d[0], $d[1], $d[2]) < Carbon::now()->subMonths(6)){
                                    $bg_color = '#6ee9a7';
                                }
                            ?>
							<tr style="background-color: <?php echo e($bg_color); ?>">
								<td><?php echo e($mydata->hitsuyID); ?></td>	
								<td><?php echo e($mydata->name); ?> <?php echo e($mydata->fname); ?> </td>
								<td><?php echo e($mydata->gender); ?></td>
								<td><?php echo e(App\DateConvert::toEthiopian(date('d/m/Y',strtotime($mydata->regDate)))); ?></td>
								<td><?php echo e($mydata->proposerWahio); ?></td>
								<td><?php echo e($mydata->occupation); ?></td>
								<td><?php echo e($mydata->hitsuy_status); ?></td>
								<td><button class="add-modal btn btn-success btn-xs" data-info="<?php echo e($mydata->hitsuyID); ?>,<?php echo e($mydata->name); ?> <?php echo e($mydata->fname); ?> <?php echo e($mydata->gfname); ?>,<?php echo e($mydata->tabiaID); ?>" title="ኣባልነት ይፅደቕ">
									<span class="fa fa-check-circle"></span>ኣባልነት ይፅደቕ</button>
									<?php if($mydata->hitsuy_status=='ሕፁይ'): ?>
									<button class="edit-modal btn btn-success btn-xs" data-info="<?php echo e($mydata->hitsuyID); ?>,<?php echo e($mydata->name); ?> <?php echo e($mydata->fname); ?> <?php echo e($mydata->gfname); ?>,<?php echo e($mydata->tabiaID); ?>" title="ይናዋሕ">
									<span class="fa fa-plus-circle"></span>ይናዋሕ</button>
									<?php endif; ?>
                                    <?php if($mydata->hitsuy_status!='ሕፁይነት ተሰሪዙ'): ?>
									<button class="delete-modal btn btn-warning btn-xs" data-info="<?php echo e($mydata->hitsuyID); ?>,<?php echo e($mydata->name); ?> <?php echo e($mydata->fname); ?> <?php echo e($mydata->gfname); ?>,<?php echo e($mydata->tabiaID); ?>" title="ይሰረዝ">
									<span class="fa fa-times-circle"></span>ይሰረዝ</button>
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
    	<div id="myModaladd" class="modal fade" role="dialog">
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fullName">ሽም ሕፁይ
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="fullName" required="required" class="form-control col-md-7 col-xs-12" readonly>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="membershipDate">ኣባል ዝኾነሉ ዕለት<span class="text-danger">（*）</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="membershipDate" required="required" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>       
                            <!-- <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="membershipType">ዓይነት ኣባል:<span class="text-danger">(*)</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="form-control" id="membershipType" required="required">
                                        <option selected disabled>~ዓይነት ኣባል ምረፅ~</option>
                                        <option value="ተጋዳላይ">ተጋዳላይ</option>
                                        <option value="ሲቪል">ሲቪል</option>
                                    </select>
                                </div>
                            </div> -->
                            <!-- <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="grossSalary">ጠቕላላ ደሞዝ
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="grossSalary" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>  -->
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="netSalary">ዝተፃረየ ደሞዝ<span class="text-danger">（*）</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="netSalary" required="required" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div> 
                            <div class="form-group">
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
                            </div>                      
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
                            <!-- <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fileNumber">ቁፅሪ ሰነድ
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="fileNumber" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>                         -->
                            <div class="form-group">&nbsp &nbsp &nbsp &nbsp &nbsp
                                <label>&nbsp &nbsp ቅድሚ ኣባልነት ምፅዳቕ እዞም ቅድመ ኩነታት የረጋግፁ</label>
                                <div class="checkbox">
                                    <label>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
                                        <input type="checkbox" id="isReported" value="1">ናይ መልማላይ ወይድማ ዋህዮ ኣቦ ወንበር ርእይቶ ዝሓዘ ፀብፃብ ምስ ናይቲ ውልቀሰብ ርኢቶ <br>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbspናብ መ/ውዲበ ኮሚቴ ቐሪቡ እዩ
                                    </label>
                                </div>
                                <div class="checkbox">&nbsp &nbsp
                                    <label>&nbsp &nbsp &nbsp &nbsp &nbsp
                                        <input type="checkbox" id="hasRequested" value="1">ሕፁይ ናብ ሙሉእ ኣባልነት ክሰጋገር ፈቓደኛ ምኻኑ ተረጋጊፁ እዩ
                                    </label>
                                </div>
                                <div class="checkbox">&nbsp &nbsp &nbsp &nbsp &nbsp
                                    <label>&nbsp &nbsp
                                        <input type="checkbox" id="isApproved" value="1">ናብ ኣባልነት ይሰጋገር ዝብል ናይ ዋህዮ ውሳነ ኣብ ናይ መሰረታዊ ውዲበ ኮሚቴ ፀዱቑ እዩ
                                    </label>
                                </div>
                                <p class="fname_error error text-center alert alert-danger hidden"></p>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
                                <button type="button" class="btn actionBtn btn-success add">
                                    <span id="footer_action_button2" class='glyphicon glypicon-check'>ኣፅድቕ</span>
                                </button>
                                <button type="button" class="btn btn-warning" data-dismiss="modal">
                                    <span class='glyphicon glyphicon-remove'></span> ዕፀው
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!-- Modal Add -->

    	<div id="myModalEdit" class="modal fade" role="dialog">
             <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">ሕፁይነት መናውሒ ቅጥዒ</h4>

                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="hidden" class="form-control" id="hitsuyID1">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fullName">ሽም ሕፁይ
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="fullName1" required="required" class="form-control col-md-7 col-xs-12" readonly>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="postponedDate">ዝተናወሐሉ ዕለት<span class="text-danger">（*）</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="postponedDate" required="required" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>
                            <p class="fname_error error text-center alert alert-danger hidden"></p>
                        </form>
                        <div class="modal-footer">
                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
                            <button type="button" class="btn actionBtn btn-success edit">
                                <span id="footer_action_button" class='glyphicon glyphicon-check'>ሕፁይነት ይናዋሕ</span>
                            </button>
                            <button type="button" class="btn btn-warning" data-dismiss="modal">
                                <span class='glyphicon glyphicon-remove'></span> ዕፀው
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    	<div id="myModalDelete" class="modal fade" role="dialog">
             <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">ሕፁይነት መሰረዚ ቕጥዒ</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="hidden" class="form-control" id="hitsuyID2">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fullName">ሽም ሕፁይ
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="fullName2" required="required" class="form-control col-md-7 col-xs-12" readonly>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="rejectionReason">ዝተሰረዘሉ ምኽንያት<span class="text-danger">（*）</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="rejectionReason" required="required" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="rejectionDate">ዝተሰረዘሉ ዕለት<span class="text-danger">（*）</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="rejectionDate" required="required" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>
                            
                            <p class="fname_error error text-center alert alert-danger hidden"></p>
                        </form>
                        
                        <div class="modal-footer">
                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                            <button type="button" class="btn actionBtn1 btn-success delete">
                                <span id="footer_action_button1" class='glyphicon glyphicon-check'>ሕፁይነት ይሰረዝ</span>
                            </button>
                            <button type="button" class="btn btn-warning" data-dismiss="modal">
                                <span class='glyphicon glyphicon-remove'></span> ዕፀው
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- Modal Delete -->
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts-extra'); ?>
    <script type="text/javascript" src="js/jquery.calendars.js"></script> 
    <script type="text/javascript" src="js/jquery.calendars.plus.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/jquery.calendars.picker.css"> 
    <script type="text/javascript" src="js/jquery.plugin.min.js"></script> 
    <script type="text/javascript" src="js/jquery.calendars.picker.js"></script>
    <script type="text/javascript" src="js/jquery.calendars.ethiopian.min.js"></script>
    <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
    <?php echo $__env->make('layouts.partials.filter_js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<script>
    var selectedRow;
 
 
	 $(document).ready(function() {
      $('#table2').DataTable({
        <?php echo $__env->make('layouts.partials.lang', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>,
        "order": []
      });
	  $('#Tigrai').on('change', function() {
		 		$('#otherType').addClass('hidden');
		 		$('.zoneworeda').removeClass('hidden');
		 		$('.tabia').removeClass('hidden');
		 	});
		 	$('#nonTigrai').on('change', function() {
		 		$('.zoneworeda').addClass('hidden');
		 		$('.tabia').addClass('hidden');
        		$('#otherType').removeClass('hidden');
		 	});

		 	$('select[name="occupation"]').on('change', function() {
		 		var occup = $(this).val();				
               if(occup=="ደኣንት"){               	
		 			$('#daant').removeClass('hidden');
               }else{
               		$('#daant').addClass('hidden');
               }
		 	});
		 	//search
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
     });
    //
	$(document).on('click', '.add-modal', function() {
        $('#membershipDate').val("");
        $('#membershipType').val("");
        $('#grossSalary').val("");
        $('#netSalary').val("");
        $('#assignedWudabe').val("");
        $('#assignedWahio').val("");
        $('#assignedAssoc').val("");
        $('#fileNumber').val("");
        $('#isReported').prop("checked",false);
        $('#hasRequested').prop("checked",false);
        $('#isApproved').prop("checked",false);

        selectedRow = $($(this).parent().parent()[0]);
        var stuff = $(this).data('info').split(',');
        fillmodalData(stuff);
        $('#myModaladd').modal('show');
    });

    function fillmodalData(details){
	     $('#hitsuyID').val(details[0]);
	    $('#fullName').val(details[1]);
	    $.ajax({
                    url: 'myform2/ajax/wahio/'+details[2],
                    type: "GET",
                    dataType: "json",
                    success:function(data) {

                        
                        $('select[name="assignedWudabe"]').empty();
						$('select[name="assignedWudabe"]').append('<option value="'+ " " +'" selected disabled >'+ "~መሰረታዊ ውዳበ ምረፅ~" +'</option>');
                        $.each(data, function(key, value) {
                            $('select[name="assignedWudabe"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });

                    }
                });
	    
	}
	$('select[name="assignedWudabe"]').on('change', function() {
            var stateID = $(this).val();
                        	
               if(stateID) {
                $.ajax({
                    url: 'myform2/ajax/wahio/meseretawi/'+stateID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {

                        
                        $('select[name="assignedWahio"]').empty();
						$('select[name="assignedWahio"]').append('<option value="'+ " " +'">'+ "~ዝተወደበሉ ዋህዮ ምረፅ~" +'</option>');
                        $.each(data, function(key, value) {
                            $('select[name="assignedWahio"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });

                    },
		            error: function(xhr,errorType,exception){                        
		              alert(exception);                      
		            }
                });
            }else{
                $('select[name="assignedWahio"]').empty();
            }
        });

	$('.modal-footer').on('click', '.add', function() {
        $.ajax({
            type: 'post',
            url: 'membership',
            data: {
                '_token': $('input[name=_token]').val(),				
                'hitsuyID': $('#hitsuyID').val(),
                'membershipDate': $('#membershipDate').val(),
                'membershipType': $('#membershipType').val(),
                'grossSalary': $('#grossSalary').val(),
                'netSalary': $('#netSalary').val(),
                'assignedWudabe': $('#assignedWudabe').val(),
                'assignedWahio': $('#assignedWahio').val(),
                'assignedAssoc': $('#assignedAssoc').val(),                
                'fileNumber': $('#fileNumber').val(),
                'isReported': ($('#isReported').prop("checked")?1:0),
                'hasRequested': ($('#hasRequested').prop("checked")?1:0),
                'isApproved': ($('#isApproved').prop("checked")?1:0)
              
            },
			
            success: function(data) {
                  if(data[0] == true){
                    document.getElementById("hitsuyID").value="";
                    document.getElementById("fullName").value="";
                    $('#myModaladd').modal('hide');
                  }
                  else{
                    if(Array.isArray(data[2]))
                        data[2] = data[2].join('<br>');
                  }
                
                  toastr.clear();
                  toastr[data[1]](data[2]);
                  if(data[0]==true){
                      setTimeout(function() {selectedRow.fadeOut(1000, function() {selectedRow.remove();})}, 250);
                  }
            	},

            error: function(xhr,errorType,exception){
            		
            			alert(exception);
                        
            }
        });
    }); 
	$(document).on('click', '.edit-modal', function() {
        $('#postponedDate').val("");

        selectedRow = $($(this).parent().parent()[0]);
        var stuff = $(this).data('info').split(',');
        fillmodalEdit(stuff)
        $('#myModalEdit').modal('show');
    });
	$(document).on('click', '.switchBtn', function() {
    	$('#hitsuylist').addClass('hidden');
    	$('.myswitch').addClass('hidden');
        $('#hitsuydiv').removeClass('hidden');                 
        $('.mytoggle').removeClass('hidden');                 
    });	
    $(document).on('click', '.toggleBtn', function() {
    	$('.alert-danger').remove();
    	$('#hitsuydiv').addClass('hidden');
    	$('.mytoggle').addClass('hidden');
        $('#hitsuylist').removeClass('hidden');                 
        $('.myswitch').removeClass('hidden');                 
    });	

     function fillmodalEdit(details){
	     $('#hitsuyID1').val(details[0]);
	    $('#fullName1').val(details[1]);
	    
	}
	
   
    $('.modal-footer').on('click', '.edit', function() {
        $.ajax({
            type: 'post',
            url: 'hitsuypostpone',
            data: {
                '_token': $('input[name=_token]').val(),				
                'hitsuyID': $("#hitsuyID1").val(),
                'postponedDate': $('#postponedDate').val()
              
            },
			
             success: function(data) {
                if(data[0] == true){
                    document.getElementById("hitsuyID1").value="";
                    document.getElementById("fullName1").value="";
                    $('#myModalEdit').modal('hide');
                }
                else{
                    if(Array.isArray(data[2]))
                        data[2] = data[2].join('<br>');
                }
            
              toastr.clear();
                toastr[data[1]](data[2]);
                if(data[0] == true){
                    setTimeout(function() {$(selectedRow.children()[6]).html("ሕፁይነት ተናዊሑ");
                        $($(selectedRow.children()[7]).children()[1]).remove();}, 1000);
                  }
            	},

            error: function(xhr,errorType,exception){
            		
            			alert(exception);
                        
            }
        });
    });
	
    $(document).on('click', '.delete-modal', function() {
        $("#rejectionReason").val("");
        $('#rejectionDate').val("");

        selectedRow = $($(this).parent().parent()[0]);
        var stuff = $(this).data('info').split(',');
        fillmodalDelete(stuff);
        $('#myModalDelete').modal('show');
    });

    function fillmodalDelete(details){
	     $('#hitsuyID2').val(details[0]);
	    $('#fullName2').val(details[1]);
	    
	}
     
    $('.modal-footer').on('click', '.delete', function() {
        $.ajax({
            type: 'post',
            url: 'hitsuyreject',
            data: {
                '_token': $('input[name=_token]').val(),				
                'hitsuyID': $("#hitsuyID2").val(),
                'rejectionReason': $("#rejectionReason").val(),
                'rejectionDate': $('#rejectionDate').val()
				
            },
			
            success: function(data) {
                  if(data[0] == true) {
                    document.getElementById("hitsuyID2").value="";
                    document.getElementById("fullName2").value="";
                    $('#myModalDelete').modal('hide');
                  }
                  else{
                      if(Array.isArray(data[2]))
                        data[2] = data[2].join('<br>');
                  }
                    toastr.clear();
                  toastr[data[1]](data[2]);
                  if(data[0] == true){
                     setTimeout(function() {selectedRow.fadeOut(1000, function() {selectedRow.remove();})}, 250);
                  }
            	},

            error: function(xhr,errorType,exception){
            		
            			alert(exception);
                        
            }
        });
    });
    $('#membershipDate').calendarsPicker({calendar: $.calendars.instance('ethiopian')});
    $('#postponedDate').calendarsPicker({calendar: $.calendars.instance('ethiopian')});
    $('#rejectionDate').calendarsPicker({calendar: $.calendars.instance('ethiopian')});
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>