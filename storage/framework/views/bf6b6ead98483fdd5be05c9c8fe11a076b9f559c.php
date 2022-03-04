<?php $__env->startSection('htmlheader_title'); ?>
    ናይ ኣባላት ስንብት 
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheader_title'); ?>
   ናይ ኣባላት ስንብት 
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
          <div class="alert alert-danger">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
            <p><?php echo e($error); ?></p>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
          </div>
          <?php endif; ?>
		<!--Dismiss -->
    <div id ="dismissdiv" class="form-group hidden">
        <div style="padding: 0px 0px 10px 385px">
          <button class="btn search-modal"><span class="glyphicon glyphicon-search"></span> ካብ ማህደር ድለ</button> 
        </div>
                        <form id="demo-form2" method="POST" action= "<?php echo e(URL('dismiss')); ?>" data-parsley-validate class="form-horizontal form-label-left">
                          <?php echo e(csrf_field()); ?>

            
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="hitsuyID1">መፍለይ ቑፅሪ ኣባል  <span class="required">（*）</span>
              </label>
              <div class="col-md-4 col-sm-6 col-xs-12">
                <input type="text" id="hitsuyID1" name="hitsuyID" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo e($cnt ? Request::old('hitsuyID') : ''); ?>">
              </div>
              
            </div>

              <div class="form-group">
              <label for="dismissReason" class="control-label col-md-3 col-sm-3 col-xs-12">ዝተሳነበተሉ ምኽንያት</label>
              <div class="col-md-4 col-sm-6 col-xs-12">
                <select id="dismissReason" name="dismissreason" class="form-control">
                  <option selected disabled>~ምረፅ~</option>
                  <option>ናይ ውልቀ ሰብ ሕቶ</option>
                  <option>ብኽብሪ</option>
                  <option>ብሞት</option>
                  <option>ካሊእ</option>
                </select>
              </div>
            </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="detailReason">ዝተሰናበተሉ/ዝተባረረሉ ዝርዝር ምኽንያት<span class="required"></span>
              </label>
               <div class="col-md-4 col-sm-6 col-xs-12">
                            <textarea rows="4" class="form-control" id="detailReason" name="detailReason" value="<?php echo e($cnt ? Request::old('detailReason') : ''); ?>" required></textarea>
                        </div>
              </div>
      <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="proposedBy1">ናይ ስንብት መበገሲ ሓሳብ ዘቕረበ ኣካል<span class="required">（*）</span>
          </label>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <input type="text" id="proposedBy1" name="proposedBy" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo e($cnt ? Request::old('proposedBy') : ''); ?>">
          </div>
        </div> 
                                    
          <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="approvedBy1">ዘፅደቐ ኣካል   <span class="required"></span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input type="text" id="approvedBy1" name="approvedBy" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo e($cnt ? Request::old('approvedBy') : ''); ?>">
                        </div>
                      </div>      
            <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="dateDismiss"> ዕለት ስንብት<span class="required"></span>
                        </label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                          <input type="text" id="dateDismiss" name="datedismiss" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo e($cnt ? Request::old('datedismiss') : ''); ?>">
                        </div>
                      </div> 
                            
                      <input type="hidden" name="isReported" value="0"/>
                      <p style="padding: 0px;">&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp  &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp <b> ቕድሚ ምምዝጋቡ እዞም ዝስዕቡ ከም ዝተማለኡ አረጋግፅ </b>
                      <p style="padding: 5px;">&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp  &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 
                        <input type="checkbox" name="isReported" id="isReported" value="1" class="flat" /> ናይ ስንብት መበገሲ ሓሳብ እቲ ውልቀሰብ ኣባል ካብ ዝኾነሉ ውዳበ ናብ ልዕሊኡ ናብ ዘሎ ውዳበ ቐሪቡ እዩ 
                        <br />
                        <input type="hidden" name="isApproved" value="0"/>
                        &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 
                        <input type="checkbox" name="isApproved" id="isApproved" value="1" class="flat" />   መበገሲ ሓሳብ ዝቐረበሉ ውዳበ ነቲ ካብ ብትሕቲኡ ዘሎ ውዳበ ዝቐረበሉ ኣፅዲቕዎ እዩ 
                        

                        
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">                         
            
                          <button type="submit" class="btn btn-success">ኣቐምጥ</button>
                        </div>
                      </div>

                    </form>
          </div>
      </div>	        
	<!--end of Dismiss div -->
    <div id="dismisslist" class="form-group">
      <div class="box-header with-border">
      <div class="col-sm-12">
      <div class="card-box table-responsive">
        <p class="text-muted font-13 m-b-30">
        </p>        
        <?php echo e(csrf_field()); ?>     
        <div class="table-responsive text-center">
          <table class="table table-striped table-borderless" id="table2">
            <thead>
              <tr>
                <th class="text-center">ቑፅሪ ኣባል</th>
                <th class="text-center">ሽም</th>
                <th class="text-center">ምኽንያት ስንብት</th>
                <th class="text-center">ዕለት ስንብት</th>
                <th class="text-center" colsapn="2">ተግባር</th>
                
              </tr>         
            </thead>
            <tbody>
              <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mydis): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>              
              <tr>
                <input type="hidden" value="<?php echo e($mydis->id); ?>">
                <input type="hidden" value="<?php echo e($mydis->detailReason); ?>">
                <input type="hidden" value="<?php echo e($mydis->proposedBy); ?>">
                <input type="hidden" value="<?php echo e($mydis->approvedBy); ?>">
                <td><?php echo e($mydis->hitsuyID); ?></td>
                <td><?php echo e($mydis->hitsuydis->name); ?> <?php echo e($mydis->hitsuydis->fname); ?></td> 
                <td><?php echo e($mydis->dismissReason); ?></td>                          
                <td><?php echo e(App\DateConvert::toEthiopian(date('d/m/Y',strtotime($mydis->dismissDate)))); ?></td>
                <td>
                  <?php if(array_search(Auth::user()->usertype, ['admin', 'zoneadmin', 'woredaadmin']) !== false): ?>
                    <button class="edit-modal btn btn-primary" data-info="<?php echo e($mydis->hitsuyID); ?>,<?php echo e($mydis->dismissReason); ?>,<?php echo e($mydis->detailReason); ?>,<?php echo e($mydis->proposedBy); ?>,<?php echo e($mydis->approvedBy); ?>,<?php echo e($mydis->dismissDate); ?>,<?php echo e($mydis->id); ?>">
                    <span class="glyphicon glyphicon-edit"></span></button>
                    <button class="delete-modal btn btn-warning" data-info="<?php echo e($mydis->hitsuyID); ?>,<?php echo e($mydis->dismissDate); ?>,<?php echo e($mydis->id); ?>">
                    <span class="glyphicon glyphicon-trash"></span></button>
                  <?php endif; ?>
                  <?php if($mydis->dismissReason=='ብቅፅዓት'): ?>
                    <button class="viewDismiss-detail btn btn-danger" data-info="<?php echo e($mydis->hitsuydis->name); ?> <?php echo e($mydis->hitsuydis->fname); ?>,<?php echo e($mydis->hitsuydis->gender); ?>,<?php echo e((date('Y') - date('Y',strtotime($mydis->hitsuydis->dob)))); ?>,<?php echo e($zobadatas[$woredadata[$tabiadata[$mydis->hitsuydis->tabiaID]]]); ?>,<?php echo e($woredaname[$tabiadata[$mydis->hitsuydis->tabiaID]]); ?>,<?php echo e($tabianame[$mydis->hitsuydis->tabiaID]); ?>,<?php echo e($mydis->hitsuydis->occupation); ?>,<?php echo e($mydis->hitsuydis->approvedhitsuy->membershipType); ?>,<?php echo e($mydis->detailReason); ?>,<?php echo e($mydis->hitsuydis->penalty->chargeType); ?> <?php echo e($mydis->hitsuydis->penalty->penaltyGiven); ?>">
                    <span class="glyphicon glyphicon-eye-open">ሀ/09</span></button>
                  <?php else: ?>                 
                    <button class="viewSent-detail btn btn-success" data-info="<?php echo e($mydis->hitsuydis->name); ?> <?php echo e($mydis->hitsuydis->fname); ?> <?php echo e($mydis->hitsuydis->gfname); ?>,<?php echo e($mydis->hitsuydis->gender); ?>,<?php echo e((date('Y') - date('Y',strtotime($mydis->hitsuydis->dob)))); ?>,<?php echo e($zobadatas[$woredadata[$tabiadata[$mydis->hitsuydis->tabiaID]]]); ?>,<?php echo e($woredaname[$tabiadata[$mydis->hitsuydis->tabiaID]]); ?>,<?php echo e($tabianame[$mydis->hitsuydis->tabiaID]); ?>,<?php echo e($mydis->hitsuydis->occupation); ?>,<?php echo e($mydis->hitsuydis->approvedhitsuy->membershipType); ?>,<?php echo e($mydis->detailReason); ?>">
                    <span class="glyphicon glyphicon-eye-open">ሀ/08</span></button>                   
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

    <!---     -->
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
              <label for="dismissreason" class="control-label col-md-3 col-sm-3 col-xs-12">ዝተሳነበተሉ ምኽንያት</label>
              <div class="col-md-8 col-sm-8 col-xs-12">
                <select id="dismissreason" name="dismissreason" class="form-control">
                  <option selected disabled>~ምረፅ~</option>
                  <option>ናይ ውልቀ ሰብ ሕቶ</option>
                  <option>ብቕፅዓት</option>
                  <option>ብኽብሪ</option>
                  <option>ብሞት</option>
                  <option>ካሊእ</option>  
                </select>
              </div>
            </div> 
            <div class="form-group">                     
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="detailreason">ዝተሳነበተሉ ዝርዝር ምኽንያት</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <textarea rows="4" class="form-control" id="detailreason" name="detailReason" required></textarea>
                        </div>
                                               
                    </div>
        <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="proposedBy">ናይ ስንብት መበገሲ ሓሳብ ዘቕረበ ኣካል<span class="required">（*）</span>
          </label>
          <div class="col-md-8 col-sm-8 col-xs-12">
            <input type="text" id="proposedBy" name="proposedBy" required="required" class="form-control col-md-7 col-xs-12">
          </div>
        </div> 
            
            <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="approvedBy">ዘፅደቐ ኣካል   <span class="required"></span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" id="approvedBy" name="approvedBy" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>      
            <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="datedismiss"> ዕለት ስንብት<span class="required"></span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" id="datedismiss" name="datedismiss" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
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
             ስንብት ናይ ኣባል መፍለይ ቑፅሪ "<span class="hID text-danger"></span>" ብትክክል ክስረዝ ተወሲኑ ድዩ  ? <span
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



<!---     -->

<div id="myDismissDetails" class="form-group hidden">
  <form id="dismissdetail-form">   
  <div class="form-group">
    <h3><center><u>ካብ ኣባልነት ህወሓት ናይ ዝተባረሩ ኣባላት</u></center></h3>
  </div>   
    <div class="form-group col-sm-12 col-md-12">                     
            <label class="control-label col-md-1 col-sm-1" for="fullName2">1. ሙሉእ ሽም:</label>
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
            <label class="control-label col-md-1 col-sm-1" for="educationLevel2">ት/ደ:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="educationLevel2" name="educationLevel" class="form-control">
            </div>          
        </div>
        <div class="form-group col-sm-12 col-md-12"> 
          <label class="control-label col-md-1 col-sm-1" for="woreda2">2. ዝነብረሉ ወረዳ:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="woreda2" name="woreda" class="form-control">
            </div>
            <label class="control-label col-md-1 col-sm-1" for="tabia2">ዝነብረሉ ጣብያ/ቀበሌ:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="tabia2" name="tabia" class="form-control">
            </div>
            <label class="control-label col-md-1 col-sm-1" for="occupation2">ዘለዎ ስራሕ:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="occupation2" name="occupation" class="form-control">
            </div>
          </div>
          <div class="form-group col-sm-6 col-md-6">
            <label class="control-label col-md-1 col-sm-1" for="punishmentType">ዓይነት ቅፅዓት:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="punishmentType" name="punishmentType" class="form-control">
            </div>
            <label class="control-label col-md-1 col-sm-1" for="membershipType2">ዓይነት ኣባልነት:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="membershipType2" name="membershipType" class="form-control">
            </div>
            </div>
              
        <div class="form-group col-sm-12 col-md-12"> 
            <label class="control-label" for="detailReason3">4. ካብ ኣባልነት ዝተባረርሉ ዝርዝር ምኽንያት ፤ </label>
            <div class="col-sm-12 col-md-12">
                <textarea rows="4" class="form-control" id="detailReason3" name="detailReason" required></textarea>
            </div>
        </div>
        <div class="form-group col-sm-12 col-md-12"> 
            <label class="control-label" for="punishment">5. ቅድሚ ሕዚ ተቀፂዑ እንተኔሩ ዓይነቱን ምኽንያቱን ይገለፅ ፤ </label>
            <div class="col-sm-12 col-md-12">
                <textarea rows="4" class="form-control" id="punishment" name="punishment" required></textarea>
            </div>
        </div>
        <div class="form-group col-sm-12 col-md-12"> 
          <label class="control-label">5. በብደረጅኡ ዝተወሃበ ሪኢቶ ፤</label>
          <div>
            <label class="control-label" >1. ዋህዮ  _____________________________________________________________________________________________________________________________________</label>
             <label class="control-label" >____________________________________________________________________________________________________________________________________________</label>
              <label class="control-label" >______________________________________________________________________ፊርማ ___________________________ ዕለት _________________________</label>
              <label class="control-label" >2. መ/ውዳበ _________________________________________________________________________________________________________________________________</label>
              <label class="control-label" >____________________________________________________________________________________________________________________________________________</label>
              <label class="control-label" >_________________________________________________________________ ፊርማ __________________________ ዕለት ________________________</label>
              <label class="control-label" >3. ወረዳ _________________________________________________________________________________________________________________________________</label>
              <label class="control-label" >____________________________________________________________________________________________________________________________________________</label>
              <label class="control-label" > ሽም___________________________________________________ሓላፍነት____________________________________ፊርማ _______________ ዕለት_________________</label>
            </div>
        </div>
        <div class="form-group col-sm-12 col-md-12"> 
          <label class="control-label">6. ክባረር ዝወሰነ ኣካል/ዞባ ፤</label>
          <div>
            <label class="control-label" >ሽም_________________________________________________________________________ፊርማ ________________________ ዕለት_______________________________</label>
           <label class="control-label" >ሽም__________________________________________________________________________ፊርማ ________________________ ዕለት______________________________</label>
            <label class="control-label" >ሽም_________________________________________________________________________ፊርማ ________________________ ዕለት_______________________________</label>
            </div>
              
        </div>



    <hr style="border:groove 1px #79D57E;"/>       
      </form>
      <div class="text-center">           
      <button  id="" class="btn printerBtn btn-info">Print </button>          
    </div>
      </div>

<!-- -->
<div id="myDetails" class="form-group hidden">
  <form id="detail-form">   
  <div class="form-group">
    <h3><center><u>ካብ ኣባልነት ህወሓት ናይ ዝሰናበቱ ኣባላት</u></center></h3>
  </div>   
    <div class="form-group col-sm-12 col-md-12">                     
            <label class="control-label col-md-1 col-sm-1" for="fullName">1. ሙሉእ ሽም:</label>
            <div class="col-md-4 col-sm-4 col-xs-4">
                <input type="text" id="fullName" name="fullName" class="form-control" readonly>
            </div>
            <label class="control-label col-md-1 col-sm-1" for="gender">ፆታ:</label>
            <div class="col-md-1 col-sm-1 col-xs-1">
                <input type="text" id="gender" name="gender" class="form-control" readonly>
            </div>
            <label class="control-label col-md-1 col-sm-1" for="dob">ዕድመ:</label>
            <div class="col-md-1 col-sm-1 col-xs-1">
                <input type="text" id="dob" name="dob" class="form-control" readonly>
            </div>   
            <label class="control-label col-md-1 col-sm-1" for="educationLevel">ት/ደ:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="educationLevel" name="educationLevel" class="form-control" readonly>
            </div>          
        </div>
        <div class="form-group col-sm-12 col-md-12"> 
          <label class="control-label col-md-1 col-sm-1" for="woreda1">2. ዝነብረሉ ወረዳ:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="woreda1" name="woreda" class="form-control" readonly>
            </div>
            <label class="control-label col-md-1 col-sm-1" for="tabia">ዝነብረሉ ጣብያ/ቀበሌ:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="tabia" name="tabia" class="form-control" readonly>
            </div>
            <label class="control-label col-md-1 col-sm-1" for="occupation">ዘለዎ ስራሕ:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="occupation" name="occupation" class="form-control" readonly>
            </div>
            <label class="control-label col-md-1 col-sm-1" for="membershipType">ዓይነት ኣባልነት:</label>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="membershipType" name="membershipType" class="form-control" readonly>
            </div>
    </div>          
        <div class="form-group col-sm-12 col-md-12"> 
            <label class="control-label" for="detailReason2">4. ካብ ኣባልነት ዝተሰናበተሉ ዝርዝር ምኽንያት ፤ </label>
            <div class="col-sm-12 col-md-12">
                <textarea rows="4" class="form-control" id="detailReason2" name="detailReason" required readonly></textarea>
            </div>
        </div>
        <div class="form-group col-sm-12 col-md-12"> 
          <label class="control-label">5. በብደረጅኡ ዝተወሃበ ሪኢቶ ፤</label>
          <div>
            <label class="control-label" >1. ዋህዮ  _____________________________________________________________________________________________________________________________________</label>
             <label class="control-label" >____________________________________________________________________________________________________________________________________________</label>
              <label class="control-label" >______________________________________________________________________ፊርማ ___________________________ ዕለት _________________________</label>
              <label class="control-label" >2. መ/ውዳበ _________________________________________________________________________________________________________________________________</label>
              <label class="control-label" >____________________________________________________________________________________________________________________________________________</label>
              <label class="control-label" >     ሽም ___________________________________________________________ ፊርማ __________________________ ዕለት ________________________</label>
            </div>
        </div>
        <div class="form-group col-sm-12 col-md-12"> 
          <label class="control-label">6. ናይ ወረዳ ውሳነ ፤</label>
          <div>
            <label class="control-label" >____________________________________________________________________________________________________________________________________________</label>
           <label class="control-label" >____________________________________________________________________________________________________________________________________________</label>
            <label class="control-label" >ሽም___________________________________________________ሓላፍነት____________________________________ፊርማ _______________ ዕለት_________________</label>
            </div>
              
        </div>



    <hr style="border:groove 1px #79D57E;"/>       
      </form>
      <div class="text-center">           
      <button  id="" class="btn printerBtn btn-info">Print </button>          
    </div>
      </div>
 
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts-extra'); ?>
<script type="text/javascript" src="js/jquery.calendars.js"></script> 
<script type="text/javascript" src="js/jquery.calendars.plus.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.calendars.picker.css"> 
<script type="text/javascript" src="js/jquery.plugin.min.js"></script> 
<script type="text/javascript" src="js/jquery.calendars.picker.js"></script>
<script type="text/javascript" src="js/jquery.calendars.ethiopian.min.js"></script>
  <script>
$(document).ready(function() {
      $('#table2').DataTable({
        <?php echo $__env->make('layouts.partials.lang', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>,
        "order": []
      });
     });
    $(document).on('click', '.switchBtn', function() {
        $('#dismisslist').addClass('hidden');
        $('.myswitch').addClass('hidden');
        $('#dismissdiv').removeClass('hidden');                 
        $('.mytoggle').removeClass('hidden');
        $('#myDetails').addClass('hidden');  
        $('#myDismissDetails').addClass('hidden');                  
    }); 
    $(document).on('click', '.toggleBtn', function() {
        $('.alert-danger').remove();
        $('#dismissdiv').addClass('hidden');
        $('.mytoggle').addClass('hidden');
        $('#dismisslist').removeClass('hidden');                 
        $('.myswitch').removeClass('hidden'); 
        $('#myDetails').addClass('hidden'); 
        $('#myDismissDetails').addClass('hidden');                
    }); 
    $(document).on('click', '.viewSent-detail', function() {
        $('#myDetails').removeClass('hidden');
        $('#myDismissDetails').addClass('hidden');
        $('#dismissdiv').addClass('hidden');
        $('.mytoggle').removeClass('hidden');
        $('#dismisslist').addClass('hidden');
        $('.myswitch').addClass('hidden');
        var stuff = $(this).data('info').split(',');
        fillComradesData(stuff)
    });
    function fillComradesData(details){
    
      $('#fullName').val(details[0]);   
      $('#gender').val(details[1]);
      $('#dob').val(details[2]);   
      $('#woreda1').val(details[4]); 
      $('#tabia').val(details[5]);
      $('#occupation').val(details[6]); 
      $('#membershipType').val(details[7]); 
      $('#detailReason2').val(details[8]); 
  }
    $(document).on('click', '.viewDismiss-detail', function() {
        $('#myDetails').addClass('hidden');
        $('#myDismissDetails').removeClass('hidden');
        $('#dismissdiv').addClass('hidden');
        $('.mytoggle').removeClass('hidden');
        $('#dismisslist').addClass('hidden');
        $('.myswitch').addClass('hidden');
        var stuff = $(this).data('info').split(',');
        fillDismissData(stuff)
    });
    function fillDismissData(details){
    
      $('#fullName2').val(details[0]);   
      $('#gender2').val(details[1]);
      $('#dob2').val(details[2]);   
      $('#woreda2').val(details[4]); 
      $('#tabia2').val(details[5]);
      $('#occupation2').val(details[6]); 
      $('#membershipType2').val(details[7]); 
      $('#detailReason3').val(details[8]);
      $('#punishment').val(details[9]); 
  }
  var row, stuff;
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
        $('.modal-title').text('መስተኻኸሊ ስንብት ኣባል');
        $('.deleteContent').hide();
        $('.searchContent').hide();
        $('.detail-form').hide();
        $('.dismissdetail-form').hide();
        $('.formadder').show();
        $('#myModal').modal('show');
        row = $($($(this).parent()).parent()).children();
        stuff = [$(row[0]).val(),$(row[1]).val(),$(row[2]).val(),$(row[3]).val(),$(row[4]).html(),$(row[5]).html(),$(row[6]).html(),$(row[7]).html()];
        fillData(stuff)
        
    });
  function fillData(details){ 
      $('#hitsuyID').val(details[4]);
      $('#dismissreason').val(details[6]);
      $('#detailreason').val(details[1]);
      $('#proposedBy').val(details[2]);
      $('#approvedBy').val(details[3]);
      $('#datedismiss').val(details[7]); 
         
    } 
    $('.modal-footer').on('click', '.edit', function() {
        $.ajax({
            type: 'post',
            url: 'editdismiss',
            data: {
                '_token': $('input[name=_token]').val(),       
                'id': stuff[0], 
                'hitsuyID': $('#hitsuyID').val(),
                'dismissreason': $('#dismissreason').val(),
                'detailReason': $('#detailreason').val(),
                'proposedBy': $('#proposedBy').val(),
                'approvedBy': $('#approvedBy').val(),
                'datedismiss': $('#datedismiss').val()
              
            },
      
            success: function(data) {
               if(data[0] == true){
                      $(row[1]).val($('#detailreason').val());
                      $(row[2]).val($('#proposedBy').val());
                      $(row[3]).val($('#approvedBy').val());
                      $(row[4]).html($('#hitsuyID').val());
                      $(row[6]).html($('#dismissreason').val());
                      $(row[7]).html($('#datedismiss').val());
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
        $('.hID').html($(row[4]).html());

        $('#myModal').modal('show');
    });

    $('.modal-footer').on('click', '.delete', function() {
        $.ajax({
            type: 'post',
            url: 'deletedismiss',
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

  $(document).on('click', '.search-modal', function() {
        $('#footer_action_button').text(" ምረፅ");
        $('#footer_action_button').addClass('glyphicon-search');
        $('#footer_action_button').removeClass('glyphicon-trash');
        $('#footer_action_button').removeClass('glyphicon-check');
        $('.actionBtn').addClass('btn-success');
        $('.actionBtn').removeClass('btn-danger');
        $('.actionBtn').removeClass('delete');
        $('.actionBtn').removeClass('edit');
        $('.actionBtn').removeClass('view');
        $('.actionBtn').addClass('search');
        $('.modal-title').text('ኣባል ካብ ማህደር መድለይ');
        $('.deleteContent').hide();
        $('.searchContent').show();
        $('.formadder').hide();
        $('.detail-form').hide();
        $('.dismissdetail-form').hide();

        $('#myModal').modal('show');
    });
    $('.modal-footer').on('click', '.search', function() {
      var hID=$('#members').val();
    $('#hitsuyID1').val(hID);
    });
    
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
    $('#dateDismiss').calendarsPicker({calendar: $.calendars.instance('ethiopian')});
    $('#datedismiss').calendarsPicker({calendar: $.calendars.instance('ethiopian')});
    <?php if(count($errors) > 0): ?>
        $('.switchBtn').click();
    <?php endif; ?>
  </script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css"></style>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>