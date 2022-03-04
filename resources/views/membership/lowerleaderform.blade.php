@extends('layouts.app')

@section('htmlheader_title')
    ታሕተዋይ ኣመራርሓ ኣባላት ህወሓት
@endsection

@section('contentheader_title')
    ናይ ታሕተዋይ ኣመራርሓ ኣባላት ህወሓት መምልኢ ማህደር
@endsection

@section('main-content')
   <div class=""> 

        <form method="GET" action= "{{URL('lowerleaderslist')}}" class="form-inline">                           
            <label>ቕድሚ ኸዚ ዝተመዝገቡ ናይ ታሕተዋይ ኣመራርሓ ኣባላት ህወሓት መምልኢ ማህደር:</label>
            <div class="btn-group" role="group">
                <button class="btn btn-success" id="detailBtn" type="submit"> ዝርዝር ይርኣዩ </button>                
            </div>
        </form>  
        @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                        @endforeach
                    </div>
                    @endif
        <?php if(!$details) {?>
            <div class="form-group col-sm-12 col-md-12">
                <label class="col-md-3 col-sm-3 col-xs-3"> </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <button class="btn search-modal"><span class="glyphicon glyphicon-search"></span> ካብ ማህደር ድለ</button>   
                </div>
            </div>
        <?php } ?>

        <br />
        <form id="demo-form2" method="POST" action= "{{ $details ? URL('editlowleader') : URL('lowleader') }}" data-parsley-validate class="form-horizontal form-label-left">
                          {{ csrf_field() }}
                    <div class="form-group col-sm-12 col-md-12">
                        <?php echo $details ? '<input type="hidden" name="id" id="evaluationId" value="'. $details->id .'">' : '' ?>
                        <label class="col-md-3 col-sm-3 col-xs-3" for="hitsuyID">መፍለይ ቑፅሪ ታሕተዋይ ኣመራርሓ:</label>
                        <div class="col-md-3 col-sm-3 col-xs-3">
                            <input type="text" id="hitsuyID" name="hitsuyID" class="form-control" <?php echo $details ? 'value='. $details->hitsuyID . ' readonly' : '' ?>>
                        </div>
                       
                    </div>
                    <div class="form-group col-sm-12 col-md-12">
                           <label class="col-md-2 col-sm-2 col-xs-2" for="model">1. ዓይነት ኣባል :</label>
                                    <div class="col-md-10 col-sm-10 col-xs-10">                           
                            <label  class="radio-inline">
                                <input type="radio" name="model" id="yes" value="ሞዴል" required {{ $details && $details->model=='ሞዴል' ? 'checked' : '' }}>ሞዴል
                            </label>
                            <label  class="radio-inline">
                                <input type="radio" name="model" id="no" value="ዘይሞዴል" required {{ $details && $details->model=='ዘይሞዴል' ? 'checked' : '' }}>ዘይሞዴል
                            </label>
                        </div>                        
                    </div>
                    <div class="form-group col-sm-12 col-md-12">                     
                        <label class="col-md-2 col-sm-2 col-xs-2" for="evaluation">2. ውፅኢት ገምጋም :</label>
                        <div class="col-md-10 col-sm-10 col-xs-10">
                        <label  class="radio-inline">
                            <input type="radio" name="evaluation" id="a" value="A" required {{ $details && $details->evaluation=='A' ? 'checked' : '' }}>A
                        </label>
                        <label  class="radio-inline">
                            <input type="radio" name="evaluation" id="b" value="B" required {{ $details && $details->evaluation=='B' ? 'checked' : '' }}>B
                        </label>
                        <label  class="radio-inline">
                            <input type="radio" name="evaluation" id="c" value="C" required {{ $details && $details->evaluation=='C' ? 'checked' : '' }}>C
                        </label>
                                
                        </div>                        
                    </div>
                    <div class="form-group col-sm-12 col-md-12">
                        <label class="col-md-12 col-sm-12 col-xs-12" for="year">3. ናይ በዓል ዋና ሪኢቶ</label>
                        <div class="col-sm-12 col-md-12">
                            <textarea rows="4" class="form-control" id="remark" name="remark" required>{{ $details ? $details->remark : ''}}</textarea>
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
                    <div class="form-group col-sm-12 col-md-12">
                    <label class="col-md-3 col-sm-3 col-xs-3"> </label>
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <button type="submit" class="btn btn-success">መዝግብ</button>
                    </div>
                    <div>
                        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                    <p style="text-align:center">***ናይ ታሕተዋይ ኣመራርሓ ኣባላት ህወሓት መምልኢ ማህደር***</p>
                    </div>
                    </div>
                </form>
                <br>
                    
                
                
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
                                        <option selected disabled>~ታሕተዋይ ኣመራርሓ ምረፅ~</option>
                                    </select>
                              </div>                                
                        </div>
                      
                      
                          <p class="fname_error error text-center alert alert-danger hidden"></p>
                          
                          
                                              
                    </div><!-- searchContent  -->
                    <div class="deleteContent">
                        መፍለይ ቑፅሩ "<span class="hID text-danger"></span>" ዝኾነ ታሕተዋይ ኣመራርሓ ብትክክል ክጠፍአ ይድለ ድዩ  ? <span
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

<script type="text/javascript">
$(document).ready(function(){
    
    // Step show event 
    
    
    // Toolbar extra buttons
    var btnFinish = $('<button></button>').text('Finish')
                                     .addClass('btn btn-info sw-btn-finish')
                                     .on('click', function(){ 
                                       $.ajax({
                                        type: 'post',
                                        url: {!! $details ? "'editlowleader'" : "'lowleader'" !!},
                                        data: {
                                            'id': $('#evaluationId').val(),
                                            '_token': $('input[name=_token]').val(),                
                                            'hitsuyID': $("#hitsuyID").val(),
                                            'model': $('#model').val(),
                                            'evaluation': $('#evaluation').val(),
                                            'remark': $('#remark').val()                                                  
                                        },
                                        
                                        success: function(data) {
                                              document.getElementById("hitsuyID").value="";
                                              document.getElementById("model").value="";
                                              document.getElementById("evaluation").value="";
                                              document.getElementById("remark").value="";
                                              
                                              alert("Success");
                                              
                                             },

                                        error: function(xhr,errorType,exception){
                                                    
                                                    alert(exception);
                                                    
                                        }
                                    });

                                        
                                });
                        
    
    //detail button
    $("#detailBtns").on("click", function() {
          $.ajax({
            type:'GET',
            url:'lowerleaderslist',                            
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
        $('.modal-title').text('ታሕተዋይ ኣመራርሓ ካብ ማህደር መድለይ');
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
                    url: 'myform2/ajax/lowleader/'+stateID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {

                        
                        $('select[name="members"]').empty();
                        $('select[name="members"]').append('<option value="'+ " " +'">'+ "~ታሕተዋይ ኣመራርሓ ምረፅ~" +'</option>');
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


                                                        
                
});   
</script>  
@endsection
