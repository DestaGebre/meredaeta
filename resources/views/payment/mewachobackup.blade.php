@extends('layouts.app')

@section('htmlheader_title')
      መዋጮ
@endsection

@section('contentheader_title')
 ምሕደራ ኣባላት መዋጮ
@endsection

@section('header-extra')


@endsection
@section('main-content')

<body>
<div class="row">
        <div class="col-md-8 col-sm-8 col-xs-8">
                <div class="form-group col-md-12 col-sm-12 col-xs-12">                          
                    <div class="col-md-4 col-sm-4 col-xs-4">    
                        <select name="mewacho" id="mewacho" class="form-control" >
                            <option value=""selected disabled>~ዓይነት መዋጮ ምረፅ~</option>                            
                            @foreach ($mewachodata as $key => $value)
                            <option value="{{ $value }}" data-othervalue="{{ $key }}">{{ $key }}</option>                            
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-4">    
                        <select name="zone" id="zone" class="form-control" >
                            <option value=""selected disabled>~ዞባ ምረፅ~</option>
                            @foreach ($zobadatas as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                        <?php $_SESSION['mymewvalue']=0; ?>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-4">    
                        <select name="woreda" id="woreda" class="form-control">
                            <option value="">~ወረዳ ምረፅ~</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-4" id="rslt">                
            </div>  
    </div>    
<div class="box box-primary row">
    <div class="box-header with-border">
        
        <div class="container ">
            {{ csrf_field() }}
            <div class="table-responsive text-center">
                <table class="table table-borderless" id="table2">
                <thead>
                    <tr>
                        <th class="text-center">መ.ቑ</th>
                        <th class="text-center">ሽም ኣባል</th>                     
                        <th class="text-center">መሰረታዊ ውዳበ</th>
                        <th class="text-center">ዋህዮ</th>
                        <th class="text-center">ስራሕ ዘርፊ</th>      
                        <th class="text-center">መዋጮ</th>                
                        <th class="text-center">ኹነታት</th>                                        
                        <th class="text-center">ዓይነት</th>                                        
                        <td><input type="checkbox" id="select_all" value="">ኩሎም ምረፅ<td>
                    </tr>
                </thead>
            <tbody class="mewacholist hidden">

                         @foreach ($data as $mymewacho)                           
                          <tr>
                            <td>{{ $mymewacho->hitsuyID }}</td>  
                            <td>{{ $mymewacho->hitsuy->name }} {{ $mymewacho->hitsuy->fname }} {{ $mymewacho->hitsuy->gfname }}</td>                                                      
                            <td>{{ $mwidabedata[$mymewacho->assignedWudabe] }}</td>
                            <td>{{ $wahiodata[$mymewacho->assignedWahio] }}</td> 
                            <td>{{ $mymewacho->hitsuy->occupation }}</td>                             
                            @if (isset($mewachoname[$mymewacho->hitsuy->occupation])&&isset($mewachoamount[$mewachoname[$mymewacho->hitsuy->occupation]]))         
                                <td>{{ $mewachoamount[$mewachoname[$mymewacho->hitsuy->occupation]] }}</td>                                                   
                            @else
                                <td>{{ 0.00 }}</td>
                            @endif     
                            @if (isset($mewachoname[$mymewacho->hitsuy->occupation])&&isset($mewachoamount[$mewachoname[$mymewacho->hitsuy->occupation]]))                                                            
                            @if (isset($collectionmewacho[$mewachoname[$mymewacho->hitsuy->occupation]][$mymewacho->hitsuyID]))         
                                <td>ዝተኸፈለ</td>                                                   
                            @else
                                <td>ዘይተኸፈለ</td>
                            @endif 
                            @else
                                <td></td>
                            @endif 
                             <td><?php echo $_SESSION['mymewvalue'];?></td>                                                                 
                            <td><input type="checkbox" class="checkbox" name="check[]" value="{{{ $mymewacho->hitsuyID }}}"><td>
                          </tr>                           
                          @endforeach
                    </tbody>
                </table>
            </div>            
            <div class="pull-right">
                <button class="add-modal btn btn-success"
                    data-info="">
                    <span class="glyphicon glyphicon-tick"></span> መዋጮ መዝግብ
                </button>
            </div>
    <div id="myModaladd" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>

                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form">
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="memeberID">መፍለይ ቑፅሪ ኣባላት  <span class="required">（*）</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="memeberID" required="required" class="form-control col-md-7 col-xs-12" readonly>
                          </div>
                      </div>  
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payday">ዝኸፈለሉ ዕለት<span class="required"></span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="payday" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>                       
              
                        <p class="fname_error error text-center alert alert-danger hidden"></p>
                                
                                            
                    
                    </form>
                    
                    <div class="modal-footer">
                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                        <button type="button" class="btn actionBtn" data-dismiss="modal">
                            <span id="footer_action_button2" class='glyphicon'> </span>
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
   </div>
   </div>
  </div>
  </div>
    </body>
@endsection

    @section('scripts-extra')
    <script>
 
     
     $(document).ready(function() {
      $('#table2').DataTable();
        } );
     $(document).ready(function(){

        //select all checkboxes
        $('#select_all').change(function(){
          var status=this.checked;
          $('.checkbox').each(function(){
            this.checked=status;
          });
        });
        //
        $('.checkbox').change(function(){
          if(this.checked==false){
            $('#select_all')[0].checked=false;
          }

          if($('.checkbox:checked').length==$('.checkbox').length){
            $('#select_all')[0].checked=true;
          }
          });

    }); 
     $('select[name="mewacho"]').on('change', function() {
            var stateID = $(this).val();    
            $('.mewacholist').removeClass('hidden');
            var temp=$(this).find('option:selected').attr('data-othervalue');            
            document.getElementById("rslt").innerHTML="<?php $_SESSION['mymewvalue']='"+temp+"'; echo $_SESSION['mymewvalue'];?>";
            $('#table2').DataTable().column(4).search(stateID,true,false).draw();
            
        });
     $('select[name="zone"]').on('change', function() {
            var stateID = $(this).val();                
            //instead of ዞባ ምረፅ => ኩለን ዞባታት value="" selected,
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
            $('#table2').DataTable().column(0).search('^'+stateID,true,false).draw();
        });
     $('select[name="woreda"]').on('change', function() {
            var stateID = $(this).val();
            $('#table2').DataTable().column(0).search('^[0-9]{2}'+stateID,true,false).draw();   
        });


    $(document).on('click', '.edit-modal', function() {
        $('#footer_action_button').text(" Update");
        $('#footer_action_button').addClass('glyphicon-check');
        $('#footer_action_button').removeClass('glyphicon-trash');
        $('.actionBtn').addClass('btn-success');
        $('.actionBtn').removeClass('btn-danger');
        $('.actionBtn').removeClass('delete');
        $('.actionBtn').addClass('edit');
        $('.modal-title').text('Edit');
        $('.deleteContent').hide();
        $('.form-horizontal').show();
        var stuff = $(this).data('info').split(',');
        fillmodalData(stuff)
        $('#myModal').modal('show');
    });
    
    $(document).on('click', '.add-modal', function() {
       if($('.checkbox:checked').length==0){
            alert("ዝተመረፀ ነገር የለን!! በይዘኦም ይምረፁ");
      }else{
            $('#footer_action_button2').text(" ኣቕምጥ");
            $('#footer_action_button2').addClass('glyphicon-check');
            $('#footer_action_button2').removeClass('glyphicon-trash');
            $('.actionBtn').addClass('btn-success');
            $('.actionBtn').removeClass('btn-danger');
            $('.actionBtn').removeClass('delete');
            $('.actionBtn').addClass('add');
            $('.modal-title').text('ወርሓዊ ክፍሊት መመዝገቢ ቕጥዒ');
            $('.deleteContent').hide();
            $('.form-horizontal').show();

            var idVals=[];

            $('.checkbox').each(function(){
                if(this.checked){
                  var myVal=$(this).val();
                  idVals.push(myVal);            
                }
            });

            $('#memeberID').val(JSON.stringify(idVals));        
            $('#myModaladd').modal('show');
      }  
    });
    $('.modal-footer').on('click', '.add', function() {
        var jsmew=$('#mewacho').find('option:selected').attr('data-othervalue');        
      $.ajax({
        type: 'post',
        url: 'storemewacho',
        data: {
          '_token': $('input[name=_token]').val(),        
          'memeberID': $('#memeberID').val(),
          'mewacho': jsmew,
          'payday': $('#payday').val()
        },

        success: function(data) {      
           // alert(data);

        },
        error:function(xhr,err,exception){
            alert(exception);
        }
      });
    });

    $(document).on('click', '.delete-modal', function() {
        $('#footer_action_button').text("Delete");
        $('#footer_action_button').removeClass('glyphicon-check');
        $('#footer_action_button').addClass('glyphicon-trash');
        $('.actionBtn').removeClass('btn-success');
        $('.actionBtn').addClass('btn-danger');
        $('.actionBtn').removeClass('edit');
        $('.actionBtn').addClass('delete');
        $('.modal-title').text('Delete');
        $('.deleteContent').show();
        $('.form-horizontal').hide();
        var stuff = $(this).data('info').split(',');
        
         
        $('.did').text(stuff[0]);
        
    
        $('.dname').html(stuff[1]);
        $('#myModal').modal('show');
    });

   function fillmodalData(details){
         $('#fid').val(details[0]);
        $('#fname').val(details[1]);
        
    }

    $('.modal-footer').on('click', '.edit', function() {
        $.ajax({
            type: 'post',
            url: 'zoneedit',
            data: {
                '_token': $('input[name=_token]').val(),                
                'id': $("#iid").val(),
                'fname': $('#fid').val(),
                'lname': $('#fname').val()
              
            },
            
            success: function(data) {
                if (data.errors){
                    $('#myModal').modal('show');
                    if(data.errors.fname) {
                        $('.fname_error').removeClass('hidden');
                        $('.fname_error').text("Code can't be empty !");
                    }
                    if(data.errors.lname) {
                        $('.lname_error').removeClass('hidden');
                        $('.lname_error').text("Name can't  be empty !");
                    }
                    
                    
                }
                 else {
                     
                     $('.error').addClass('hidden');
                $('.item' + data.zoneCode).replaceWith("<tr class='item" + data.zoneCode + "'> <td>" + data.zoneCode +
                        "</td><td>" + data.zoneName + "</td><td><button class='edit-modal btn btn-info' data-info='" + data.zoneCode+","+data.zoneName+"'><span class='glyphicon glyphicon-edit'></span> Edit</button> <button class='delete-modal btn btn-danger' data-info='" + data.zoneCode+","+data.zoneName+"' ><span class='glyphicon glyphicon-trash'></span> Delete</button></td></tr>");

                 }}
        });
    });
    
    $('.modal-footer').on('click', '.delete', function() {
        $.ajax({
            type: 'post',
            url: 'zonedelete',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('.did').text()
                
            },
            
            success: function(data) {
              
                 $('.item' + $('.did').text()).remove();
                 
                  
            }
        });
    });
</script>
<link href="css/bootstrap.min.css" rel="stylesheet">   
<script src="js/jquery.min.js"></script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css"></style>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
@endsection




@extends('layouts.app')

@section('htmlheader_title')
      መዋጮ
@endsection

@section('contentheader_title')
 ምሕደራ ኣባላት መዋጮ
@endsection

@section('header-extra')


@endsection
@section('main-content')

<body>
<div class="row">
        <div class="col-md-8 col-sm-8 col-xs-8">
                <div class="form-group col-md-12 col-sm-12 col-xs-12">                          
                   
                    <div class="col-md-4 col-sm-4 col-xs-4">    
                        <select name="zone" id="zone" class="form-control" >
                            <option value=""selected disabled>~ዞባ ምረፅ~</option>
                            @foreach ($zobadatas as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>                        
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-4">    
                        <select name="woreda" id="woreda" class="form-control">
                            <option value="">~ወረዳ ምረፅ~</option>
                        </select>
                    </div>
                     <div class="col-md-4 col-sm-4 col-xs-4">    
                       <label>ዓይነት መዋጮ: {{$mwname}}</label>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-4">                
            </div>  
    </div>    
<div class="box box-primary row">
    <div class="box-header with-border">
        
        <div class="container ">
            {{ csrf_field() }}
            <div class="table-responsive text-center">
                <table class="table table-borderless" id="table2">
                <thead>
                    <tr>
                        <th class="text-center">መ.ቑ</th>
                        <th class="text-center">ሽም ኣባል</th>                     
                        <th class="text-center">መሰረታዊ ውዳበ</th>
                        <th class="text-center">ዋህዮ</th>
                        <th class="text-center">ስራሕ ዘርፊ</th>      
                        <th class="text-center">ክፍሊት መዋጮ</th>                
                        <th class="text-center">ኹነታት</th>                                                                                                      
                        <td><input type="checkbox" id="select_all" value="">ኩሎም ምረፅ<td>
                    </tr>
                </thead>
            <tbody>

                         @foreach ($data as $mymewacho)                           
                          <tr>
                            <td>{{ $mymewacho->hitsuyID }}</td>  
                            <td>{{ $mymewacho->hitsuy->name }} {{ $mymewacho->hitsuy->fname }} {{ $mymewacho->hitsuy->gfname }}</td>                                                      
                            <td>{{ $mwidabedata[$mymewacho->assignedWudabe] }}</td>
                            <td>{{ $wahiodata[$mymewacho->assignedWahio] }}</td> 
                            <td>{{ $mymewacho->hitsuy->occupation }}</td>                             
                            <td>{{ $mewachoamount }}</td>                                                       
                            @if (isset($collectionmewacho[$mymewacho->hitsuyID]))         
                                <td>ዝተኸፈለ</td>                                                   
                            @else
                                <td>ዘይተኸፈለ</td>
                            @endif                                                                                                                 
                            <td><input type="checkbox" class="checkbox" name="check[]" value="{{{ $mymewacho->hitsuyID }}}"><td>
                          </tr>                           
                          @endforeach
                    </tbody>
                </table>
            </div>            
            <div class="pull-right">
                <button class="add-modal btn btn-success"
                    data-info="">
                    <span class="glyphicon glyphicon-tick"></span> መዋጮ መዝግብ
                </button>
            </div>
        </div>
    <div id="myModaladd" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>

                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form">
                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="memeberID">መፍለይ ቑፅሪ ኣባላት  <span class="required">（*）</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="memeberID" required="required" class="form-control col-md-7 col-xs-12" readonly>
                          </div>
                      </div>  
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payday">ዝኸፈለሉ ዕለት<span class="required"></span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="payday" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>                       
              
                        <p class="fname_error error text-center alert alert-danger hidden"></p>
                                
                                            
                    
                    </form>
                    
                    <div class="modal-footer">
                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                        <button type="button" class="btn actionBtn" data-dismiss="modal">
                            <span id="footer_action_button2" class='glyphicon'> </span>
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
   </div>
    </body>
@endsection

    @section('scripts-extra')
    <script>
 
     
     $(document).ready(function() {
      $('#table2').DataTable();
        } );
     $(document).ready(function(){

        //select all checkboxes
        $('#select_all').change(function(){
          var status=this.checked;
          $('.checkbox').each(function(){
            this.checked=status;
          });
        });
        //
        $('.checkbox').change(function(){
          if(this.checked==false){
            $('#select_all')[0].checked=false;
          }

          if($('.checkbox:checked').length==$('.checkbox').length){
            $('#select_all')[0].checked=true;
          }
          });

    }); 
     // $('select[name="mewacho"]').on('change', function() {
     //        var stateID = $(this).val();    
     //        $('.mewacholist').removeClass('hidden');
     //        var temp=$(this).find('option:selected').attr('data-othervalue');            
     //        // document.getElementById("rslt").innerHTML="<?php $_SESSION['mymewvalue']='"+temp+"'; echo $_SESSION['mymewvalue'];?>";
     //        $('#table2').DataTable().column(4).search(stateID,true,false).draw();
            
     //    });
     $('select[name="zone"]').on('change', function() {
            var stateID = $(this).val();                
            //instead of ዞባ ምረፅ => ኩለን ዞባታት value="" selected,
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
            $('#table2').DataTable().column(0).search('^'+stateID,true,false).draw();
        });
     $('select[name="woreda"]').on('change', function() {
            var stateID = $(this).val();
            $('#table2').DataTable().column(0).search('^[0-9]{2}'+stateID,true,false).draw();   
        });


    $(document).on('click', '.edit-modal', function() {
        $('#footer_action_button').text(" Update");
        $('#footer_action_button').addClass('glyphicon-check');
        $('#footer_action_button').removeClass('glyphicon-trash');
        $('.actionBtn').addClass('btn-success');
        $('.actionBtn').removeClass('btn-danger');
        $('.actionBtn').removeClass('delete');
        $('.actionBtn').addClass('edit');
        $('.modal-title').text('Edit');
        $('.deleteContent').hide();
        $('.form-horizontal').show();
        var stuff = $(this).data('info').split(',');
        fillmodalData(stuff)
        $('#myModal').modal('show');
    });
    
    $(document).on('click', '.add-modal', function() {
       if($('.checkbox:checked').length==0){
            alert("ዝተመረፀ ነገር የለን!! በይዘኦም ይምረፁ");
      }else{
            $('#footer_action_button2').text(" ኣቕምጥ");
            $('#footer_action_button2').addClass('glyphicon-check');
            $('#footer_action_button2').removeClass('glyphicon-trash');
            $('.actionBtn').addClass('btn-success');
            $('.actionBtn').removeClass('btn-danger');
            $('.actionBtn').removeClass('delete');
            $('.actionBtn').addClass('add');
            $('.modal-title').text('ወርሓዊ ክፍሊት መመዝገቢ ቕጥዒ');
            $('.deleteContent').hide();
            $('.form-horizontal').show();

            var idVals=[];

            $('.checkbox').each(function(){
                if(this.checked){
                  var myVal=$(this).val();
                  idVals.push(myVal);            
                }
            });

            $('#memeberID').val(JSON.stringify(idVals));        
            $('#myModaladd').modal('show');
      }  
    });
    $('.modal-footer').on('click', '.add', function() {
        var jsmew=$('#mewacho').find('option:selected').attr('data-othervalue');        
      $.ajax({
        type: 'post',
        url: 'storemewacho',
        data: {
          '_token': $('input[name=_token]').val(),        
          'memeberID': $('#memeberID').val(),
          'mewacho': jsmew,
          'payday': $('#payday').val()
        },

        success: function(data) {      
           // alert(data);

        },
        error:function(xhr,err,exception){
            alert(exception);
        }
      });
    });

    $(document).on('click', '.delete-modal', function() {
        $('#footer_action_button').text("Delete");
        $('#footer_action_button').removeClass('glyphicon-check');
        $('#footer_action_button').addClass('glyphicon-trash');
        $('.actionBtn').removeClass('btn-success');
        $('.actionBtn').addClass('btn-danger');
        $('.actionBtn').removeClass('edit');
        $('.actionBtn').addClass('delete');
        $('.modal-title').text('Delete');
        $('.deleteContent').show();
        $('.form-horizontal').hide();
        var stuff = $(this).data('info').split(',');
        
         
        $('.did').text(stuff[0]);
        
    
        $('.dname').html(stuff[1]);
        $('#myModal').modal('show');
    });

   function fillmodalData(details){
         $('#fid').val(details[0]);
        $('#fname').val(details[1]);
        
    }

    $('.modal-footer').on('click', '.edit', function() {
        $.ajax({
            type: 'post',
            url: 'zoneedit',
            data: {
                '_token': $('input[name=_token]').val(),                
                'id': $("#iid").val(),
                'fname': $('#fid').val(),
                'lname': $('#fname').val()
              
            },
            
            success: function(data) {
                if (data.errors){
                    $('#myModal').modal('show');
                    if(data.errors.fname) {
                        $('.fname_error').removeClass('hidden');
                        $('.fname_error').text("Code can't be empty !");
                    }
                    if(data.errors.lname) {
                        $('.lname_error').removeClass('hidden');
                        $('.lname_error').text("Name can't  be empty !");
                    }
                    
                    
                }
                 else {
                     
                     $('.error').addClass('hidden');
                $('.item' + data.zoneCode).replaceWith("<tr class='item" + data.zoneCode + "'> <td>" + data.zoneCode +
                        "</td><td>" + data.zoneName + "</td><td><button class='edit-modal btn btn-info' data-info='" + data.zoneCode+","+data.zoneName+"'><span class='glyphicon glyphicon-edit'></span> Edit</button> <button class='delete-modal btn btn-danger' data-info='" + data.zoneCode+","+data.zoneName+"' ><span class='glyphicon glyphicon-trash'></span> Delete</button></td></tr>");

                 }}
        });
    });
    
    $('.modal-footer').on('click', '.delete', function() {
        $.ajax({
            type: 'post',
            url: 'zonedelete',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('.did').text()
                
            },
            
            success: function(data) {
              
                 $('.item' + $('.did').text()).remove();
                 
                  
            }
        });
    });
</script>
<link href="css/bootstrap.min.css" rel="stylesheet">   
<script type="text/javascript" src="js/jquery.min.js"></script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css"></style>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
@endsection
