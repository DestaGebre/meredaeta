
@extends('layouts.app')

@section('htmlheader_title')
ዝርዝር ስርርዕ ወረዳ 
@endsection

@section('contentheader_title')
ዝርዝር ስርርዕ ወረዳ 
@endsection

@section('header-extra')
<style type="text/css">
    .form-control:read-only {
        background-color: #fff;
        cursor: default;
    }
    @media print {
      #print,.switchBtn {
        display: none;
      }
    }
</style>

@endsection
@section('main-content')
    <div class="box box-primary">
        <div class="box-header with-border">
            
            <div class="myTable">
                <?php $show_zone = $hide_woreda = $hide_tabia = $hide_widabe = $hide_wahio = $show_year = $show_rank = true; ?>
                @include('layouts.partials.filter_html', ['address' => 'rankworedalist'])
                <div class="table-responsive text-center">
                    <table class="table table-borderless" id="table2">
                        <thead>
                            <tr>
                                <th class="text-center">መ.ቑ</th>
                                <th class="text-center">ወረዳ</th>
                                <th class="text-center">ዓይነት</th>
                                <th class="text-center">ዓመት</th>
                                <th class="text-center">ወቕቲ</th>
                                <th class="text-center">ደረጃ</th>
                                <th class="text-center">ተግባር</th>
                            </tr>                   
                        </thead>
                        <tbody>
                            @foreach ($data as $myworeda)
                              <tr>
                                <td>{{ $myworeda->woredacode }}</td>                                                      
                                <td>{{ $myworeda->name }}</td>
                                <td>{{ $myworeda->isUrban }}</td>
                                <td>{{ $myworeda->year }}</td>
                                <td>{{ $myworeda->half }}</td>
                                <td>{{ $myworeda->result }}</td>
                                <input type="hidden" value="{{$myworeda->id}}">
                                <td><button class="edit-button btn btn-info" data-info="">
                                <span class="glyphicon glyphicon-edit"></span></button>
                                <button class="delete-button btn btn-danger" data-info="">
                                <span class="glyphicon glyphicon-trash"></span></button></td>
                              </tr>                       
                            @endforeach    
                        </tbody>
                        </table>
                        </div>
                        {{ $data->links() }}
                        </div>                      
    

        
    <div id="myModaledit" class="modal fade" role="dialog">
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
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="memeberID">መፍለይ ቑፅሪ ወረዳ<span class="required">（*）</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="memeberID" required="required" class="form-control col-md-7 col-xs-12" readonly>
                          </div>
                      </div>  
                      <input type="hidden" id="type" value="ወረዳ" class="form-control col-md-7 col-xs-12">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ryear">ዓመት<span class="required"></span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="ryear" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                  </div> 
                  <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="half">እዋን ገምጋም</label>
                  <div class="col-md-6 col-sm-6 col-xs-12" >
                    <select class="form-control" id="half" name="half">
                            <option selected disabled>~እዋን ገምጋም~</option>
                            <option>6 ወርሒ</option>
                            <option>ዓመት</option>      
                    </select>
                  </div>
                </div>
                           <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="result">ውፅኢት ስርርዕ</label>
                        <div class="col-md-6 col-sm-6 col-xs-12" >
                          <select class="form-control" id="result">
                            <option selected disabled>~ውፅኢት ስርርዕ ይምረፁ~</option>
                              <option>ቅድሚት</option>
                            <option>ማእኸላይ</option>
                            <option>ድሕሪት</option>                   
                          </select>
                        </div>
                      </div>
              
                        <p class="fname_error error text-center alert alert-danger hidden"></p>
                                
                                            
                    
                    </form>
                    
                    <div class="modal-footer">
                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                        <button type="button" class="btn btn-info actionBtn" id="update">
                            <span id="footer_action_button2" class='glyphicon'> </span>ኣስተኻኽል
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
@endsection

@section('scripts-extra')
    @include('layouts.partials.filter_js')
    <script>
    var row,id;
 
     $(document).ready(function() {
      $('#table2').DataTable({
        @include('layouts.partials.lang'),
        "order": []
      });
     });

    $(document).on('click', '.show-detail', function() {

        $('#myDetails').removeClass('hidden');
        $('.myTable').addClass('hidden');        
        var stuff = $(this).data('info').split(',');
        fillmodalData(stuff);

        // flexible textarea
        $('textarea').each(function(textarea){
            $(this).height($(this)[0].scrollHeight);
        });
                
    });
    $(document).on('click', '.switchBtn', function() {
        $('#myDetails').addClass('hidden');
        $('.myTable').removeClass('hidden');        
                
    });
    $(document).on('click', '.delete-button', function() {
      row = $($($(this).parent()).parent());
        var id = $(row.children()[0]).html();
        var name = $(row.children()[1]).html();
        var year = $(row.children()[3]).html();
        var half = $(row.children()[4]).html();
        if(confirm('ስርርዕ '+name+ '('+id+') ዓመት '+year+' ወቕቲ '+half+' ንምስራዝ ርግፀኛ ድዮም?')){
            $.ajax({
            type: 'post',
            url: 'deleterankworeda',
            data: {
                '_token': $('input[name=_token]').val(),  
                'id': id,      
                'year': year,
                'half': half
            },
      
            success: function(data) {
                if(data[0] === true){
                  toastr.clear();
                  toastr.warning('ስርርዕ '+name+ '('+id+') ዓመት '+year+' ወቕቲ '+half+' ተሰሪዙ ኣሎ');
                  row.remove();
                }
                else{
                   toastr.error('ስርርዕ '+name+ '('+id+') ዓመት '+year+' ወቕቲ '+half+' ኣይተረኽበን');
                }
               },

            error: function(xhr,errorType,exception){
                
                  alert(exception);
                        
            }
        });
        }
    });
    $(document).on('click', '.edit-button', function() {
        row = $($($(this).parent()).parent());
        $('#memeberID').val($(row.children()[0]).html());
        $('#ryear').val($(row.children()[3]).html());
        $('#half').val($(row.children()[4]).html());
        $('#result').val($(row.children()[5]).html());
        id = $(row.children()[6]).val();
        $('#myModaledit').modal('show');
                
    });
    $(document).on('click', '#update', function() {
        $.ajax({
            type: 'post',
            url: 'editrankworeda',
            data: {
                '_token': $('input[name=_token]').val(),  
                'memeberID': $('#memeberID').val(),
                'id': id,
                'year': $('#ryear').val(),
                'type': 'መሰረታዊ ውዳበ',
                'half': $('#half').val(),
                'result': $('#result').val(),
              
            },
      
            success: function(data) {
            if(data[0] == true){
                $(row.children()[0]).html($('#memeberID').val());
                $(row.children()[3]).html($('#ryear').val());
                $(row.children()[4]).html($('#half').val());
                $(row.children()[5]).html($('#result').val());
                $('#memeberID').val('');
                $('#ryear').val('');
                $('#half').val('');
                $('#result').val('');
                $('#myModaledit').modal('hide');
                  }
                  else{
                    if(Array.isArray(data[2]))
                        data[2] = data[2].join('<br>');
                  }
                
                  toastr.clear();
                  toastr[data[1]](data[2]);
               },

            error: function(xhr,errorType,exception){
                
                  alert(exception);
                        
            }
        });
    });

    function fillmodalData(details){
        $('#hitsuyID').val(details[0]);
        $('#fullName').val(details[1]);   
        $('#gender').val(details[2]);
        $('#occupation').val(details[3]);
        $('#position').val(details[4]);
        $('#answer1').val(details[5]);
        $('#answer2').val(details[6]);
        $('#answer3').val(details[7]);
        $('#answer4').val(details[8]);
        $('#answer5').val(details[9]);
        $('#answer6').val(details[10]);
        $('#answer7').val(details[11]);
        $('#answer8').val(details[12]);
        $('#answer9').val(details[13]);
        $('#answer10').val(details[14]);
        $('#answer11').val(details[15]);
        $('#answer12').val(details[16]);
        $('#answer13').val(details[17]);
        $('#answer14').val(details[18]);
        $('#answer15').val(details[19]);
        //$('#answer16').val(details[20]);
        $('#result1').val(details[20]);
        $('#result2').val(details[21]);
        $('#result3').val(details[22]);
        $('#result4').val(details[23]);
        $('#result5').val(details[24]);
        $('#result6').val(details[25]);
        $('#result7').val(details[26]);
        $('#result8').val(details[27]);
        $('#result9').val(details[28]);
        $('#result10').val(details[29]);
        $('#result11').val(details[30]);
        $('#result12').val(details[31]);
        $('#result13').val(details[32]);
        //$('#result14').val(details[34]);
        $('#remark').val(details[33]);
         $('#zone').val(details[34]);
        $('#woreda').val(details[35]);
        $('#membershipDate').val(details[36]);    
        var summ1=parseInt(details[20])+parseInt(details[21])+parseInt(details[22])+parseInt(details[23])+parseInt(details[24])+parseInt(details[25])+parseInt(details[26])+parseInt(details[27]);              
        $('#sum1').text(summ1);   
        var summ1p2=parseInt(details[21])+parseInt(details[22]);                
        $('#sum1p2').text(summ1p2); 
        var summ1p3=parseInt(details[23])+parseInt(details[24])+parseInt(details[25])+parseInt(details[26])+parseInt(details[27]);              
        $('#sum1p3').text(summ1p3);  
        var summ2=parseInt(details[28])+parseInt(details[29])+parseInt(details[30]);                
        $('#sum2').text(summ2);  
        var sumtotal=summ1+summ2+parseInt(details[31])+parseInt(details[32]);
        $('#totalResult').text(sumtotal);  
    }
    $(document).on('click', '.delete-modal', function() {
        $('#footer_action_button1').text("ሕፁይነት ይሰረዝ");
        $('#footer_action_button1').addClass('glyphicon-check');
        $('#footer_action_button1').removeClass('glyphicon-trash');
        $('.actionBtn1').addClass('btn-success');
        $('.actionBtn1').removeClass('btn-danger');
        $('.actionBtn1').removeClass('edit');
        $('.actionBtn1').addClass('delete');
        $('.modal-title').text('ሕፁይነት መሰረዚ ቕጥዒ');
        $('.deleteContent').hide();
        $('.form-horizontal').show();
        var stuff = $(this).data('info').split(',');
        fillmodalDelete(stuff)
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
                  document.getElementById("hitsuyID2").value="";
                  document.getElementById("fullName2").value="";
                },

            error: function(xhr,errorType,exception){
                    
                        alert(exception);
                        
            }
        });
    });

</script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css"></style>
    <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
@endsection

