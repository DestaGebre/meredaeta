@extends('layouts.app')

@section('htmlheader_title')
    ዋህዮ ኣመራርሓ ህወሓት
@endsection

@section('contentheader_title')
    ዋህዮ ኣመራርሓ መምልኢ
@endsection

@section('main-content')
   <div class=""> 
                   
        <hr style="border:groove 1px #79D57E;"/>
        </br> 
        <div style="padding: 0px 0px 10px 355px">
          <button class="btn search-modal"><span class="glyphicon glyphicon-search"></span> ዋህዮ ኣመራርሓ ካብ ማህደር ድለ</button> 
        </div>                
        <form id="demo-form2" method="POST" action= "{{URL('wahioleaders')}}" data-parsley-validate class="form-horizontal form-label-left">
                          {{ csrf_field() }}
                    <div class="form-group col-sm-12 col-md-12">                     
                        <label class="control-label col-md-3 col-sm-3" for="hitsuyID">ዝተመረፀ ኣመራርሓ ዋህዮ:</label>
                        <div class="col-md-3 col-sm-3 col-xs-3">
                            <input type="text" id="hitsuyID" name="hitsuyID" class="form-control" required readonly>
                        </div>                                                
                    </div>
                    <div class="form-group col-sm-12 col-md-12">
                        <label class="control-label col-md-3 col-sm-3" for="hitsuyID1">ዝተቐየረ ኣመራርሓ ዋህዮ:</label>
                        <div class="col-md-3 col-sm-3 col-xs-3">
                            <input type="text" id="hitsuyID1" name="hitsuyID1" class="form-control" required readonly>
                        </div>
                    </div>
                    <div class="form-group col-sm-12 col-md-12">
                        <label class="control-label col-md-3 col-sm-3" for="leadertype">ዋህዮ ኣመራርሓ ዓይነት:</label>
                        <div class="col-md-3 col-sm-3 col-xs-3">
                            <input type="text" id="leadertype" name="leadertype" class="form-control" required readonly>
                        </div>
                    </div>
                    <div class="form-group col-sm-12 col-md-12">
                        <label class="control-label col-md-3 col-sm-3" for="decisiondate">ዝተመረፀሉ/ዝተቐየረሉ ዕለት:</label>
                        <div class="col-md-3 col-sm-3 col-xs-3">
                            <input type="text" id="decisiondate" name="decisiondate" class="form-control" required>
                        </div>
                        <input type="hidden" id="woredaID" name="woredaID" class="form-control">
                        <input type="hidden" id="wahioID" name="wahioID" class="form-control">
                    </div>
                    <div class="form-group col-sm-12 col-md-12">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">                         
                            <button type="submit" class="btn btn-success">ኣቐምጥ</button>
                        </div>
                    </div>
                </form>
                <br>
                    <div>                                           
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
                        <div class="col-md-8 col-sm-8 col-xs-8">
                        <label class="control-label col-md-4 col-sm-4 sr-only" for="wahioposition">ዋህዮ ኣመራርሓ ዓይነት</label>
                         <select class="form-control" id="wahioposition" name="wahioposition" required="required">
                           <option selected disabled>~ዋህዮ ኣመራርሓ ዓይነት ምረፅ~</option>
                           <option >ኣቦ ወንበር ዋህዮ</option>
                           <option >ፕሮፖጋንዳ</option>
                           <option >ውዳበ</option>
                           <option >ፋይናንስ</option>
                         </select>
                        </div>
                        </div>                       
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">                        
                            <div class="col-md-8 col-sm-8 col-xs-8">
                                <label class="control-label col-md-4 col-sm-4 sr-only" for="members">ዝተመረፀ ዋህዮ ኣመራርሓ</label>
                                  <select class="form-control" id="members" name="members" required="required">
                                        <option selected disabled>~ዝተመረፀ ዋህዮ ኣመራርሓ ምረፅ~</option>
                                    </select>
                              </div>                                
                        </div>
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">                        
                            <div class="col-md-8 col-sm-8 col-xs-8">
                                  <select class="form-control" id="members1" name="members1" required="required">
                                        <option selected disabled>~ዝተቐየረ ዋህዮ ኣመራርሓ ምረፅ~</option>
                                    </select>
                                <label class="control-label col-md-4 col-sm-4 sr-only" for="members1">ዝተቐየረ ዋህዮ ኣመራርሓ</label>
                              </div>    
                        </div>                        
                      
                      
                          <p class="fname_error error text-center alert alert-danger hidden"></p>
                          
                          
                                              
                    </div><!-- searchContent  -->
                    <div class="deleteContent">
                        መፍለይ ቑፅሩ "<span class="hID text-danger"></span>" ዝኾነ ዋህዮ ኣመራርሓ ብትክክል ክጠፍአ ይድለ ድዩ  ? <span
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
<script type="text/javascript" src="js/jquery.calendars.js"></script> 
<script type="text/javascript" src="js/jquery.calendars.plus.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.calendars.picker.css"> 
<script type="text/javascript" src="js/jquery.plugin.min.js"></script> 
<script type="text/javascript" src="js/jquery.calendars.picker.js"></script>
<script type="text/javascript" src="js/jquery.calendars.ethiopian.min.js"></script>

<link rel="stylesheet" href="css/jquery.dataTables.min.css"></style>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
    
    // Step show event 
    
    
    // Toolbar extra buttons
    // var btnFinish = $('<button></button>').text('Finish')
    //                                  .addClass('btn btn-info sw-btn-finish')
    //                                  .on('click', function(){ 
    //                                    $.ajax({
    //                                     type: 'post',
    //                                     url: 'lowleader',
    //                                     data: {
    //                                         '_token': $('input[name=_token]').val(),                
    //                                         'hitsuyID': $("#hitsuyID").val(),
    //                                         'model': $('#model').val(),
    //                                         'evaluation': $('#evaluation').val(),
    //                                         'remark': $('#remark').val()                                                  
    //                                     },
                                        
    //                                     success: function(data) {
    //                                           document.getElementById("hitsuyID").value="";
    //                                           document.getElementById("model").value="";
    //                                           document.getElementById("evaluation").value="";
    //                                           document.getElementById("remark").value="";
                                              
    //                                           // alert("Success");
                                              
    //                                          },

    //                                     error: function(xhr,errorType,exception){
                                                    
    //                                                 alert(exception);
                                                    
    //                                     }
    //                                 });

                                        
    //                             });
                        
       

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
        $('.modal-title').text('ዋህዮ ኣመራርሓ ካብ ማህደር መድለይ');
        $('.deleteContent').hide();
        $('.searchContent').show();
        $('.formadder').hide();
        $('#myModal').modal('show');
    });
    $('.modal-footer').on('click', '.search', function() {
        var hID=$('#members').val();
        var hID1=$('#members1').val();
        var wPOS=$('#wahioposition').val();
        var propWahio=$('#proposerWahio').val();
        var propWoreda=$('#woreda').val();
        $('#hitsuyID').val(hID);
        $('#hitsuyID1').val(hID1);
        $('#leadertype').val(wPOS);
        $('#wahioID').val(propWahio);
        $('#woredaID').val(propWoreda);

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
                        $('select[name="proposerWahio"]').append('<option value="'+ " " +'"selected disabled>'+ "~ዋህዮ ምረፅ~" +'</option>');
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
                        $('select[name="members"]').append('<option value="'+ " " +'"selected disabled>'+ "~ዝተመረፀ ዋህዮ ኣመራርሓ ምረፅ~" +'</option>');
                        $.each(data, function(key, value) {
                            $('select[name="members"]').append('<option value="'+ key +'">'+key+': '+value +'</option>');
                        });

                        $('select[name="members1"]').empty();
                        $('select[name="members1"]').append('<option value="'+ " " +'"selected disabled>'+ "~ዝተቐየረ ዋህዮ ኣመራርሓ ምረፅ~" +'</option>'+'<option value="'+ "የለን" +'">'+ " ቕድሚ ኸዚ ዋህዮ ኣመራርሓ ኣይነበረን" +'</option>');
                        $.each(data, function(key, value) {
                            $('select[name="members1"]').append('<option value="'+ key +'">'+key+': '+value +'</option>');
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
$('#decisiondate').calendarsPicker({calendar: $.calendars.instance('ethiopian')});
</script>  
@endsection
