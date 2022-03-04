@extends('layouts.app')

@section('htmlheader_title')
    ሰብ ሞያ ኣባላት ህወሓት
@endsection

@section('contentheader_title')
    ናይ ሰብ ሞያ ኣባላት ህወሓት መምልኢ ማህደር
@endsection

@section('main-content')
   <div class=""> 

        <form method="GET" action= "{{URL('expertslist')}}" class="form-inline">                           
            <label>ቕድሚ ኸዚ ዝተመዝገቡ ናይ ሰብ ሞያ ኣባላት ህወሓት መምልኢ ማህደር:</label>
            <div class="btn-group navbar-btn" role="group">
                <button class="btn btn-success" id="detailBtn" type="submit"> ዝርዝር ይርኣዩ </button>                
            </div>
            <hr style="border:groove 1px #79D57E;"/>
        </form>           

        <br />                       
        <!-- SmartWizard html -->
        <div id="smartwizard">
            <ul>
                <li><a href="#step-1">ቅጥዒ 1<br /><small>ካብ ቁፅሪ 1 ክሳብ ቁፅሪ 4...</small></a></li>
                <li><a href="#step-2">ቅጥዒ 2<br /><small>ካብ ቁፅሪ 5 ክሳብ ቁፅሪ 8...</small></a></li>
                <li><a href="#step-3">ቅጥዒ 3<br /><small>ካብ ቁፅሪ 9 ክሳብ ቁፅሪ 13</small></a></li>
                
            </ul>
            
            <div>               
                <div id="step-1" class="">
                   
                    <!-- sm=small screen,md=medium, xs=extra small, lg=large screen -->
                    <div class="form-group col-sm-12 col-md-12">                     
                        <?php echo $details ? '<input type="hidden" id="evaluationId" value="'. $details->id .'">' : '' ?>
                        <label class="control-label col-md-3 col-sm-3" for="hitsuyID">መፍለይ ቑፅሪ ላዕለዋይ ኣመራርሓ:</label>
                        <div class="col-md-3 col-sm-3 col-xs-3">
                            <input type="text" id="hitsuyID" name="hitsuyID" class="form-control" <?php echo $details ? 'value='. $details->hitsuyID . ' readonly' : '' ?>>
                        </div>
                        <?php if(!$details) {?>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <button class="btn search-modal"><span class="glyphicon glyphicon-search"></span> ካብ ማህደር ድለ</button>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="form-group col-sm-12 col-md-12"> 
                        <label class="control-label" for="answer1">1 ካብ ኣተሓሳስባን ተግባርን ክራይ ኣካብነት ንባዕልኻ ነፃ ኣብ ምኻንን ኣብ ካልኦት ንዝረኣዩ ፀገማት ብትረት ኣብ ምቅላስን ፤ </label>
                        <div class="col-sm-12 col-md-12">
                            <textarea rows="2" class="form-control" id="answer1" name="answer1" required>{{$details ? $details->answer1 : ''}}</textarea>
                        </div><br/>
                        <label class="col-sm-12 col-md-12 control-label" for="result1"></label>
                        <div class="col-sm-12 col-md-3">
                            <input class="form-control" id="result1" type="number" min="0" max="10" placeholder="ዝረኸቦ ውፅኢት ካብ 10" name="Result1"  required="required" value="{{$details ? $details->result1 : ''}}">
                        </div>
                    </div>

                    <div class="form-group col-sm-12 col-md-12"> 
                        <label class="control-label" for="answer2">2 ብቁዕ በዓል ሞያ ሰራሕተኛ ኣብ ምኻንን ውፅኢታዊ ስራሕ ኣብ ምስራሕን ፤ ካብቲ ዝርከብ ለውጢ ፍትሓዊ ብዝኾነ ኣብ ምጥቃምን ፤</label>
                        <div class="col-sm-12 col-md-12">
                            <textarea rows="2" class="form-control" id="answer2" name="Answer2" required>{{$details ? $details->answer2 : ''}}</textarea>
                        </div><br/>
                        <label class="col-sm-12 col-md-12 control-label" for="result2"></label>
                        <div class="col-sm-12 col-md-3">
                            <input class="form-control" id="result2" type="number" min="0" max="10" placeholder="ዝረኸቦ ውፅኢት ካብ 10" name="Result2"  required="required" value="{{$details ? $details->result2 : ''}}">
                        </div>
                    </div>

                    <div class="form-group col-sm-12 col-md-12">
                                        
                        <label class="control-label" for="answer3">3 ኣብ ዝተዋፈረሉ ዓውደ ስራሕ ጉብእኻ ኣብ ምፍፃምን መርኣያ ኮይንካ ኣብ ምስራሕን ምምራሕን ፤</label>
                        <div class="col-sm-12 col-md-12">
                            <textarea rows="2" class="form-control" id="answer3" name="Answer3" required>{{$details ? $details->answer3 : ''}}</textarea>
                        </div><br/>
                        <label class="col-sm-12 col-md-12 control-label" for="result3"></label>
                        <div class="col-sm-12 col-md-3">
                            <input class="form-control" id="result3" type="number" min="0" max="10" placeholder="ዝረኸቦ ውፅኢት ካብ 10" name="Result3"  required="required" value="{{$details ? $details->result3 : ''}}">
                        </div>
                    </div>

                    <div class="form-group col-sm-12 col-md-12">                     
                        <label class="col-sm-12 col-md-12 control-label" for="answer4">4 ሰናይ ምምሕዳር ኣብ ምርጋፅን ቁልጡፍን ፅሬትን ዘለዎ ግልጋሎት ኣብ ምሃብን ዘለዎ ኩነታት ፤</label>
                        <div class="col-sm-12 col-md-12">
                            <textarea rows="2" class="form-control" id="answer4" name="Answer4" required>{{$details ? $details->answer4 : ''}}</textarea>
                        </div><br/>
                        <label class="col-sm-12 col-md-12 control-label" for="result4"></label>
                        <div class="col-sm-12 col-md-3">
                            <input class="form-control" id="result4" type="number" min="0" max="10" placeholder="ዝረኸቦ ውፅኢት ካብ 10" name="Result4"  required="required" value="{{$details ? $details->result4 : ''}}">
                        </div>
                    </div>

                    <div>                        
                    <p style="text-align:center">***ናይ ሰብ ሞያ ኣባላት ህወሓት መምልኢ ማህደር***</p>
                    </div>

                </div>
                <div id="step-2" class="">
                    <h3>ካብ ቁፅሪ 5 ክሳብ ቁፅሪ 8...</h3>
                    <div class="form-group col-sm-12 col-md-12">                     
                        <label class="col-sm-12 col-md-12 control-label" for="answer5">5 ንልምዓትን ህንፀት ዲሞክራሲን ዘዐንቁፉ ድሑራት ኣተሓሳስባ ፊት ንፊት ብፅንዓት ኣብ ምቅላስን ፤</label>
                        <div class="col-sm-12 col-md-12">
                            <textarea rows="2" class="form-control" id="answer5" name="Answer5" required>{{$details ? $details->answer5 : ''}}</textarea>
                        </div><br/>
                        <label class="col-sm-12 col-md-12 control-label" for="result5"></label>
                        <div class="col-sm-12 col-md-3">
                            <input class="form-control" id="result5" type="number" min="0" max="10" placeholder="ዝረኸቦ ውፅኢት ካብ 10" name="Result5"  required="required" value="{{$details ? $details->result5 : ''}}">
                        </div>
                    </div>               
                   <div class="form-group col-sm-12 col-md-12">                     
                        <label class="control-label" for="answer6">6 ኣብ ዝተዋፈረሉ ቤት ፅሕፈት ወይ ቀበሌ ቅልጡፍን ኩለ መዳያዊ ለውጢ ንምምፃእ ዝመፁ ሓደሽቲ ቴክኖሎጂ ወይ እታወት ንባዕልኻ ኣብ ምእማንን ንኻልኦት ንምእማን ዘለዎ ዓቅምን ድልውነትን ፤</label>
                        <div class="col-sm-12 col-md-12">
                            <textarea rows="2" class="form-control" id="answer6" name="Answer6" required>{{$details ? $details->answer6 : ''}}</textarea>
                        </div><br/>
                        <label class="col-sm-12 col-md-12 control-label" for="result6"></label>
                        <div class="col-sm-12 col-md-3">
                            <input class="form-control" id="result6" type="number" min="0" max="10" placeholder="ዝረኸቦ ውፅኢት ካብ 10" name="Result6"  required="required" value="{{$details ? $details->result6 : ''}}">
                        </div>
                    </div>
                    <div class="form-group col-sm-12 col-md-12"> 
                        <label class="control-label" for="answer7">7 ሕግታትን ደንብታትን ውድብን መንግስትን ኣብ ምኽባርን ምትግባርን ዘለዎ ኩነታት ፤</label>
                        <div class="col-sm-12 col-md-12">
                            <textarea rows="2" class="form-control" id="answer7" name="Answer7" required>{{$details ? $details->answer7 : ''}}</textarea>
                        </div><br/>
                        <label class="col-sm-12 col-md-12 control-label" for="result7"></label>
                        <div class="col-sm-12 col-md-3">
                            <input class="form-control" id="result7" type="number" min="0" max="10" placeholder="ዝረኸቦ ውፅኢት ካብ 10" name="Result7"  required="required" value="{{$details ? $details->result7 : ''}}">
                        </div>
                    </div>
                    
                    <div class="form-group col-sm-12 col-md-12">                     
                        <label class="control-label" for="answer8">8 ብሕገ ደንቢ ውድብ ሓደሽቲ ኣባላት ብፅሬት ኣብ ምምልማልን ልኡኽ እናሃብካ ብቀፃልነት ኣብ ምህናፅን ፤</label>
                        <div class="col-sm-12 col-md-12">
                            <textarea rows="2" class="form-control" id="answer8" name="Answer8" required>{{$details ? $details->answer8 : ''}}</textarea>
                        </div><br/>
                        <label class="col-sm-12 col-md-12 control-label" for="result8"></label>
                        <div class="col-sm-12 col-md-3">
                            <input class="form-control" id="result8" type="number" min="0" max="10" placeholder="ዝረኸቦ ውፅኢት ካብ 10" name="Result8"  required="required" value="{{$details ? $details->result8 : ''}}">
                        </div>
                    </div>                    

                    

                    

                    <div>
                    <p style="text-align:center">***ናይ ሰብ ሞያ ኣባላት ህወሓት መምልኢ ማህደር***</p>
                    </div>

                    
                </div>
                <div id="step-3" class="">
                    <h3>ካብ ቑፅሪ 9 ክሳብ ቑፅሪ 13</h3>

                    
                    

                    <div class="form-group col-sm-12 col-md-12">                     
                        <label class="control-label" for="answer9">9. መለለይ ጠንካራ ጎኒ</label>
                        <div class="col-sm-12 col-md-12">
                            <textarea rows="2" class="form-control" id="answer9" name="Answer9" required>{{$details ? $details->answer9 : ''}}</textarea>
                        </div>                        
                    </div>

                    <div class="form-group col-sm-12 col-md-12">                     
                        <label class="control-label" for="answer10">10. መለለይ ደካማ ጎኒ</label>
                        <div class="col-sm-12 col-md-12">
                            <textarea rows="2" class="form-control" id="answer10" name="Answer10" required>{{$details ? $details->answer10 : ''}}</textarea>
                        </div>                        
                    </div>

                    <div class="form-group col-sm-12 col-md-12">                     
                        <label class="control-label" for="remark">8. ናይ በዓል ዋና ሪኢቶ</label>
                        <div class="col-sm-12 col-md-12">
                            <textarea rows="2" class="form-control" id="remark" name="Remark" required>{{$details ? $details->remark : ''}}</textarea>
                        </div>                        
                    </div>
                    <div class="form-group col-sm-12 col-md-12">
                        <div class="col-sm-12 col-md-3">
                            <input type="year" class="form-control" id="year" name="year" placeholder="ዓመተምህረት" required value="{{$details ? $details->year : ''}}">
                        </div>                        
                    </div>

                    <!-- <div class="form-group col-sm-12 col-md-12">
                        <div class="col-sm-12 col-md-3">
                            <select type="half" class="form-control" id="half" name="half" required>
                                <option selected="" disabled="">~እዋን ገምጋም ምረፅ~</option>
                                <option>6 ወርሒ</option>
                                <option>ዓመት</option>
                            </select>
                        </div>
                    </div> -->

                    <div>
                        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                    <p style="text-align:center">***ናይ ሰብ ሞያ ኣባላት ህወሓት መምልኢ ማህደር***</p>
                    </div>
                </div>

            </div>

        </div>
                
    </div> <!-- Container  -->


    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>

                </div>
                <div class="modal-body">       

                    <div class="searchContent">              
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
                                        <option selected disabled>~ሰብ ሞያ ኣመራርሓ ምረፅ~</option>
                                    </select>
                              </div>                                
                        </div>
                      
                      
                          <p class="fname_error error text-center alert alert-danger hidden"></p>
                          
                          
                                              
                    </div><!-- searchContent  -->
                    <div class="deleteContent">
                        መፍለይ ቑፅሩ "<span class="hID text-danger"></span>" ዝኾነ ሰብ ሞያ ብትክክል ክጠፍአ ይድለ ድዩ  ? <span
                            class="hidden did"></span>
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn actionBtn" data-dismiss="modal">
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

@endsection
@section('scripts-extra')
<link rel="stylesheet" href="css/jquery.dataTables.min.css"></style>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<!-- SmartWizard 4.0 -->
<link href="css/smart_wizard.css" rel="stylesheet" type="text/css" />
<link href="css/smart_wizard_theme_arrows.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.smartWizard.js"></script>       

<script type="text/javascript">
$(document).ready(function(){
    
    // Step show event 
    
    
    // Toolbar extra buttons
    var btnFinish = $('<button></button>').text('ዛዝም')
                                     .addClass('btn btn-info sw-btn-finish')
                                     .on('click', function(){ 
                                       $.ajax({
                                        type: 'post',
                                        url: {!! $details ? "'editexpert'" : "'expert'" !!},
                                        data: {
                                            'id': $('#evaluationId').val(),
                                            '_token': $('input[name=_token]').val(),                
                                            'hitsuyID': $("#hitsuyID").val(),
                                            'answer1': $('#answer1').val(),
                                            'answer2': $('#answer2').val(),
                                            'answer3': $("#answer3").val(),
                                            'answer4': $('#answer4').val(),
                                            'answer5': $('#answer5').val(),
                                            'answer6': $("#answer6").val(),
                                            'answer7': $('#answer7').val(),
                                            'answer8': $('#answer8').val(),
                                            'answer9': $('#answer9').val(),
                                            'answer10': $("#answer10").val(),
                                            //'answer11': $('#answer11').val(),
                                            //'answer12': $('#answer12').val(),
                                            //'answer13': $("#answer13").val(),
                                            //'answer14': $('#answer14').val(),
                                            //'answer15': $('#answer15').val(),
                                            //'answer16': $('#answer16').val(),
                                            'result1': $("#result1").val(),
                                            'result2': $('#result2').val(),
                                            'result3': $('#result3').val(),
                                            'result4': $("#result4").val(),
                                            'result5': $('#result5').val(),
                                            'result6': $('#result6').val(),
                                            'result7': $('#result7').val(),
                                            'result8': $("#result8").val(),
                                            //'result9': $('#result9').val(),
                                            //'result10': $('#result10').val(),
                                            //'result11': $("#result11").val(),
                                            //'result12': $('#result12').val(),
                                            //'result13': $('#result13').val(),
                                            //'result14': $("#result14").val(),
                                            'remark': $('#remark').val(),
                                            'year': $('#year').val(),
                                            // 'half': $('#half').val()
                                        },
                                        
                                        success: function(data) {
                                            toastr.options.positionClass='toast-bottom-left';
                                            toastr.clear();
                                            for(i = 0; i < 11; i++){
                                                $('#result'+i).parent().removeClass('has-error');
                                                $('#answer'+i).parent().removeClass('has-error');
                                            }
                                            $('#remark').parent().removeClass('has-error');
                                            $('#year').parent().removeClass('has-error');
                                            // $('#half').parent().removeClass('has-error');
                                            var disp = "";
                                            var invalid = false;
                                            if(data[0] == false){
                                                data[1].forEach(function(v){
                                                    if(v[0]=='*'){
                                                        $('#'+v.slice(1)).parent().addClass('has-error');
                                                        invalid = true;
                                                    }
                                                    else
                                                        disp += v+'<br>';
                                                });
                                              disp = (invalid?'ዘይተመልኡ/ትኽክል ዘይኾኑ ዓውድታት ኣለው!<br>':'')+disp;
                                              toastr.error(disp);
                                            }
                                            else{
                                                  toastr.info(data[1]);
                                                  if(!$('#evaluationId').val()){
                                                      document.getElementById("hitsuyID").value="";
                                                      document.getElementById("answer1").value="";
                                                      document.getElementById("answer2").value="";
                                                      document.getElementById("answer3").value="";
                                                      document.getElementById("answer4").value="";
                                                      document.getElementById("answer5").value="";
                                                      document.getElementById("answer6").value="";
                                                      document.getElementById("answer7").value="";
                                                      document.getElementById("answer8").value="";
                                                      document.getElementById("answer9").value="";
                                                      document.getElementById("answer10").value="";
                                                      //document.getElementById("answer11").value="";
                                                      //document.getElementById("answer12").value="";
                                                     // document.getElementById("answer13").value="";
                                                      //document.getElementById("answer14").value="";
                                                      //document.getElementById("answer15").value="";
                                                      //document.getElementById("answer16").value="";
                                                      document.getElementById("result1").value="";
                                                      document.getElementById("result2").value="";
                                                      document.getElementById("result3").value="";
                                                      document.getElementById("result4").value="";
                                                      document.getElementById("result5").value="";
                                                      document.getElementById("result6").value="";
                                                      document.getElementById("result7").value="";
                                                      document.getElementById("result8").value="";
                                                      //document.getElementById("result9").value="";
                                                      //document.getElementById("result10").value="";
                                                      //document.getElementById("result11").value="";
                                                      //document.getElementById("result12").value="";
                                                      //document.getElementById("result13").value="";
                                                      //document.getElementById("result14").value="";
                                                      document.getElementById("remark").value="";
                                                      document.getElementById("year").value="";
                                                      // $("#half").prop('selectedIndex', 0);
                                                  }
                                              }
                                              
                                             },

                                        error: function(xhr,errorType,exception){
                                                    
                                                    alert(exception);
                                                    
                                        }
                                    });

                                        
                                });
    var btnCancel = $('<button></button>').text('ሰርዝ')
                                     .addClass('btn btn-danger')
                                     .on('click', function(){ $('#smartwizard').smartWizard("reset"); });                         
    
    //detail button
    $("#detailBtns").on("click", function() {
          $.ajax({
            type:'GET',
            url:'expertslist',                            
            success:function(data){
              alert("Success");                    
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
        $('.actionBtn').addClass('search');
        $('.modal-title').text('ሰብ ሞያ ካብ ማህደር መድለይ');
        $('.deleteContent').hide();
        $('.searchContent').show();
        $('.formadder').hide();
        $('#myModal').modal('show');
    });
    $('.modal-footer').on('click', '.search', function() {
        var hID=$('#members').val();
        $('#hitsuyID').val(hID);
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
                    url: 'myform2/ajax/expert/'+stateID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {

                        
                        $('select[name="members"]').empty();
                        $('select[name="members"]').append('<option value="'+ " " +'">'+ "~ሰብ ሞያ ምረፅ~" +'</option>');
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

    // Smart Wizard
    $('#smartwizard').smartWizard({ 
            selected: 0, 
            theme: 'arrows',
            transitionEffect:'fade',
            autoAdjustHeight:true,
            showStepURLhash: true,
            toolbarSettings: {toolbarPosition: 'bottom',
                              toolbarExtraButtons: [btnFinish, btnCancel]
                            },
            lang: { 
              next: 'ቀፃሊ',
              previous: 'ሕሉፍ',
            },
    });
                                                        
                
});   
</script>  
@endsection
