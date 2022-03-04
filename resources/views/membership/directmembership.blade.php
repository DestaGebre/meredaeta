@extends('layouts.app')

@section('htmlheader_title')
ምሉእ ኣባላት
@endsection

@section('contentheader_title')
ምሕደራ መረዳእታ ኣባላት
@endsection

@section('header-extra')

@endsection

@section('main-content')
<div class="box">
<div id="myTabContent" class="main_container" >
<?php $cnt = (count($errors) > 0); ?>
@if (count($errors) > 0)
          <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
            @endforeach
          </div>
          @endif
    <form id="profile-form" method="POST" action= "{{URL('directmembership')}}" data-parsley-validate class="form-horizontal form-label-left">
        <div class="col-md-5">
        <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">ውልቃዊ መረዳእታ ሙሉእ ኣባል</h3>
        </div>
        <div class="box-body">
          {{ csrf_field() }}        
          <div class="form-group">
            <label class="col-md-2 control-label" for="name">ሽም<span class="text-danger">*</span></label>
            <div class="col-md-4">
              <input id="name" name="name" type="text" placeholder="" class="form-control" required value="{{ $cnt ? Request::old('name') : '' }}"></div>

              <label class="col-md-2 control-label" for="fname">ሽም ኣቦ<span class="text-danger">*</span></label>
              <div class="col-md-4">
                <input id="fname" name="fname" type="text" placeholder="" class="form-control" required value="{{ $cnt ? Request::old('fname') : '' }}"></div>
              </div>      
              <div class="form-group">
                <label class="col-md-2 control-label" for="gfname">ሽም ኣቦሓጎ<span class="text-danger">*</span></label>
                <div class="col-md-4">
                  <input id="gfname" name="gfname" type="text" placeholder="" class="form-control" required value="{{ $cnt ? Request::old('gfname') : '' }}"></div>

                  <label class="control-label col-md-2 col5sm-2 col-xs-12">ፆታ<span class="text-danger">*</span></label>
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
              <label class="col-md-2 control-label" for="birthPlace">ትውልዲ ወረዳ</label>
              <div class="col-md-4">
                <input id="birthPlace" name="birthPlace" type="text" placeholder="" class="form-control" value="{{ $cnt ? Request::old('birthPlace') : '' }}"></div>

                <label class="col-md-2 control-label" for="dob">ዕለት ትውልዲ<span class="text-danger">*</span></label>
                <div class="col-md-4">
                  <input id="dob" name="dob" type="text" placeholder="" class="form-control" value="{{ $cnt ? Request::old('dob') : '' }}"></div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="occupation">ማሕበራዊ መሰረት:<span class="text-danger">*</span></label>
                  <div class="col-sm-4">
                    <select class="form-control" name="occupation" required="required">
                        <option selected disabled>~ምረፅ~</option>
                        <option>መምህር</option>
                        <option>ተምሃራይ</option>
                        <option>ሲቪል ሰርቫንት</option>
                        <option>መፍረዪ</option>
                        <option>ንግዲ</option>
                        <option>ግልጋሎት</option>
                        <option>ኮስንትራክሽን</option>
                        <option>ከተማ ሕርሻ</option>
                        <option>ሸቃላይ</option>
                    </select>
                  </div>
                  <!-- <label class="col-md-2 control-label" for="position">ሓላፍነት:</label>
                  <div class="col-md-4">
                    <input id="position" name="position" type="text" placeholder="" class="form-control" value="{{ $cnt ? Request::old('position') : '' }}"></div> -->
                  </div>
                  <div class="form-group">
                  <div id="daant" class="hidden">
                    <label class="control-label col-sm-2 " for="sme">ደኣንት:<span class="text-danger">*</span></label>
                    <div class="col-sm-4">

                      <select class="form-control" name="sme">
                        <option selected disabled>~ምረፅ~</option>
                        <option >ጀማሪ</option>
                        <option >ማእኸላይ</option>
                        <option >መምረቲ</option>
                      </select>
                    </div>  
                    </div>  
                    <label class="col-md-2 control-label" for="regDate">ኣባልነት ዘመን:<span class="text-danger">*</span></label>
                    <div class="col-md-4">
                      <input id="regDate" name="regDate" type="text" placeholder="" class="form-control" value="{{ $cnt ? Request::old('regDate') : '' }}"></div>
                    </div>

                    <div class="form-group">
                          <label class="control-label col-md-2 col-sm-4" for="educationlevel">ደረጃ ትምህርቲ:</label>
                          <div class="col-md-4 col-sm-4 col-xs-4">
                              <select id="educationlevel" name="educationlevel" class="form-control">
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
                            <label class="col-md-2 control-label" for="skill">ዘለዎ ሞያ<span class="text-danger">*</span></label>
                          <div class="col-md-4">
                            <input id="skill" name="skill" type="text" placeholder="" class="form-control" value="{{ $cnt ? Request::old('skill') : '' }}"></div>
                        </div>
                    
                        <div class="form-group">
                          <label class="col-md-2 control-label" for="proposerMem">ዝመልመሎ ውልቀ ሰብ</label>
                          <div class="col-md-4">
                            <input id="proposerMem" name="proposerMem" type="text" placeholder="" class="form-control" value="{{ $cnt ? Request::old('proposerMem') : '' }}"></div>
                            <label class="col-md-2 control-label" for="leadership">ኩነታት መሪሕነት</label>
                            <div class="col-md-4">
                              <select id="leadership" name="leadership" type="text" placeholder="" class="form-control" value="{{ $cnt ? Request::old('leadership') : '' }}">
                                <option>ተራ ኣባል</option>
                                <option>መ/ዉ/አመራርሓ</option>
                                <option>ዋህዮ አመራርሓ</option>
                                <option>ጀማሪ አመራርሓ</option>
                                <option>ማእኸላይ አመራርሓ</option>
                                <option>ላዕለዋይ አመራርሓ</option>
                                <option>ታሕተዋይ አመራርሓ</option>
                              </select>
                            </div>
                        </div>
                        <div class="form-group">
                          <label class="col-md-2 control-label" for="netsalary">ዝተፃረየ ደሞዝ<span class="text-danger">*</span></label>
                          <div class="col-md-4">
                            <input id="netsalary" name="netsalary" type="text" placeholder="" class="form-control" value="{{ $cnt ? Request::old('netsalary') : '' }}"></div>
                            <label class="col-md-2 control-label" for="mahber">ዝተወደበሉ ማሕበር</label>
                            <div class="col-md-4">
                              <select id="mahber" name="mahber" type="text" placeholder="" class="form-control" value="{{ $cnt ? Request::old('mahber') : '' }}">
                                <option value=" " selected="" disabled="">~መሰረታዊ ውዳበ ምረፅ~</option>
                                <option>ደቂ ኣንስትዮ</option>
                                <option>መናእሰይ</option>
                                <option>ገባር</option>
                                <option>መምህራን</option>
                              </select>
                            </div>
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
                        <!-- <label> ዝነብርሉ ክልል*:</label>
            <label  class="radio-inline">
                    <input type="radio" name="region" id="Tigrai" value="ትግራይ" checked="checked" required>
                    ትግራይ/ኣዲስኣበባ/ዩንቨርስቲ
            </label>
            <label  class="radio-inline">
                    <input type="radio" name="region" id="nonTigrai" value="ካልእ" required>
                    ካልእ
            </label> -->
                            <!-- ትግራይ/ኣዲስኣበባ/ዩንቨርስቲ:
                            <input type="radio" class="flat" name="region" id="Tigrai" value="ትግራይ" checked="" required /> ካልእ:
                            <input type="radio" class="flat" name="region" id="nonTigrai" value="ካልእ" /> -->
                            <br><br>
                            <div class="form-group zoneworeda">
                                <label class="control-label col-sm-2" for="zone">ዞባ:<span class="text-danger">*</span></label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="zone" required="required">
                                        <option selected disabled>~ዞባ ምረፅ~</option>
                                        @foreach ($zobadatas as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
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
                                <label class="col-md-2 control-label" for="proposerWidabe">መሰረታዊ ውዳበ</label>
                                <div class="col-md-4">
                                <select class="form-control" id="proposerWidabe" name="proposerWidabe" required="required">
                                        <option selected disabled>~መሰረታዊ ውዳበ ምረፅ~</option>
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
                                    <input id="address" name="address" type="text" placeholder="ካብ ትግራይ ወፃኢ ንዝኮነ ጥራሕ" class="form-control" value="{{ $cnt ? Request::old('address') : '' }}"></div><br><br><br>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="tell">ቑፅሪ ስልኪ</label>
                                    <div class="col-md-4">
                                        <input id="tell" name="tell" type="text" placeholder="" class="form-control" value="{{ $cnt ? Request::old('tell') : '' }}"></div>
                                        <label class="col-md-1 control-label" for="email">ኢሜል</label>
                                        <div class="col-md-5">
                                            <input id="email" name="email" type="email" placeholder="" class="form-control" value="{{ $cnt ? Request::old('email') : '' }}"></div>
                                </div>  
                                

                                        <!-- <div class="form-group">&nbsp &nbsp &nbsp &nbsp
                                            <label>ናይ ሕፁይ መረዲእታ ቕድሚ ምምዝጋቡ እዞም ዝስዕቡ ከም ዝተማለኡ አረጋግፅ</label>
                                            <div class="checkbox">
                      <input type="hidden" name="isRequested" value="0">
                                                <label>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
                                                    <input type="checkbox" name="isRequested" value="1">ነቲ ዝሕፀ ሰብ ዝምልከት ፀብፃብ ብመልማላይ ኣቢሉ ናብ ዝምልከቶ ውዲበ ቐሪቡ እዩ

                                                </label>
                                            </div>
                                            <div class="checkbox">&nbsp &nbsp &nbsp &nbsp &nbsp
                        <input type="hidden" name="hasPermission" value="0">
                                                <label>&nbsp &nbsp &nbsp <input type="checkbox" name="hasPermission" value="1">ሕፁይ ንምዃን ካብ ዝምልከቶ ውዲበ ሓላፊ ፍቓድ ረኺቡ እዩ
                                                </label>
                                            </div>
                                            <div class="checkbox">&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
                        <input type="hidden" name="isWilling" value="0">
                                                <label>
                                                    <input type="checkbox" name="isWilling" value="1">ተመልማላይ ሕፁይ ክኸውን ከም ዝዯሊ ሕቶኡ ብፅሑፍ ኣቕሪቡ እዩ
                                                </label>
                                            </div>
                                            <div class="checkbox">&nbsp &nbsp &nbsp &nbsp &nbsp
                        <input type="hidden" name="isReportedWahioHalafi" value="0">
                                                <label>&nbsp &nbsp &nbsp
                                                    <input type="checkbox" name="isReportedWahioHalafi" value="1">ናይ መልማላይ ወይድማ ዋህዮ ኣቦ ወንበር ርእይቶ ዝሓዘ ፀብፃብ ቐሪቡ እዩ

                                                </label>
                                            </div>
                                            <div class="checkbox">&nbsp &nbsp &nbsp &nbsp &nbsp
                        <input type="hidden" name="isReportedWahioMem" value="0">
                                                <label>&nbsp &nbsp &nbsp
                                                    <input type="checkbox" name="isReportedWahioMem" value="1">ናይ ዋህዮ ኣባላት ውሳነ ዝሓዘ ፀብፃብ ቐሪቡ እዩ 
                                                </label>
                                            </div>
                                        </div> -->

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
        </div>

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
            
            // Ethiopian Calender Date picker
            $('#dob').calendarsPicker({calendar: $.calendars.instance('ethiopian')});
            $('#regDate').calendarsPicker({calendar: $.calendars.instance('ethiopian')});
            

        
            </script>
        

@endsection
