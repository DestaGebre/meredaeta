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
    <hr style="border:groove 1px #79D57E;"/>
<div class="row">
        <div class="col-md-8 col-sm-8 col-xs-8">                 
                <div class="form-group col-md-12 col-sm-12 col-xs-12">
                  <form method="GET" action= "{{URL('mewachodetail')}}">                           
                    <div class="form-group">                                    
                    <label class="control-label col-sm-2" for="mewacho">ዓይነት መዋጮ:</label>                    
                    <div class="col-md-4 col-sm-4 col-xs-4">                            
                        <select name="mewacho" id="mewacho" class="form-control" required>
                            <option value=""selected disabled>~ዓይነት መዋጮ ምረፅ~</option>                            
                            @foreach ($mewachodata as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>                            
                            @endforeach
                        </select>
                    </div>                                            
                    <div class="col-md-4 col-sm-4 col-xs-4">                     
                        <button class="btn btn-success" style="padding-left:40px;padding-right:40px" id="detailBtn" type="submit"> ምረፅ </button>                                    
                    </div>
                    </div>
                 </form>
                    <div class="col-md-2 col-sm-2 col-xs-2">                            
                    </div>
                </div>                       
            </div>
            <div class="col-md-4 col-sm-4 col-xs-4">                
            </div>              
    </div> 
    <hr style="border:groove 1px #79D57E;"/>   

  </div>
  </div>
@endsection

    @section('scripts-extra')
    <script>
     
         // $('select[name="mewacho"]').on('change', function() {
         //        var stateID = $(this).val();    
         //        $('.mewacholist').removeClass('hidden');
         //        var temp=$(this).find('option:selected').attr('data-othervalue');            
         //        // document.getElementById("rslt").innerHTML="<?php $_SESSION['mymewvalue']='"+temp+"'; echo $_SESSION['mymewvalue'];?>";
         //        $('#table2').DataTable().column(4).search(stateID,true,false).draw();
                
         // });
       $("#detailBtns").on("click", function() {
          // var mewachoname=$("#mewacho").val();
          var mewachoname=12;
          // alert(mewachoname);
          if(mewachoname) {
            $.ajax({
                url: 'mewachodetail/'+mewachoname,
                type: "GET",
                dataType: "json",
                success:function(data) {

                },
                error:function(xhr,err,exception){
                    alert(exception);
                }

           });
        }else{
            alert("ዝተመረፀ መዋጮ የለን!! በይዘኦም ይምረፁ");
        }
    }); 
    
</script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css"></style>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
@endsection
