
@extends('layouts.app')

@section('htmlheader_title')
ዝርዝር ስርርዕ ዋህዮ
@endsection

@section('contentheader_title')
ዝርዝር ስርርዕ ዋህዮ
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
            <div class="pull-right">                      
            <a class="btn switchBtn btn-info" href="{{ URL::previous() }}"><span class="glyphicon glyphicon-arrow-up"></span></a>
            </div>
            <div class="myTable">
                <?php $show_zone = $show_woreda = $hide_wahio = $show_year = $show_rank = true; ?>
                @include('layouts.partials.filter_html', ['address' => 'rankwahiolist'])
                <div class="table-responsive text-center">
                    <table class="table table-borderless" id="table2">
                        <thead>
                            <tr>
                                <th class="text-center">መ.ቑ</th>
                                <th class="text-center">ዋህዮ</th>
                                <th class="text-center">ዓይነት</th>
                                <th class="text-center">ዓመት</th>
                                <th class="text-center">ወቕቲ</th>
                                <th class="text-center">ደረጃ</th>
                                <th class="text-center">ተግባር</th>
                            </tr>                   
                        </thead>
                        <tbody>
                            @foreach ($data as $mywahio)
                              <tr>
                                <td>{{ $mywahio->code }}</td>                                                      
                                <td>{{ $mywahio->wahioName }}</td>
                                <td>{{ $mywahio->type }}</td>
                                <td>{{ $mywahio->year }}</td>
                                <td>{{ $mywahio->half }}</td>
                                <td>{{ $mywahio->result }}</td>
                                <input type="hidden" value="{{$mywahio->id}}">
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
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="memeberID">መፍለይ ቑፅሪ ዋህዮ<span class="required">（*）</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="memeberID" required="required" class="form-control col-md-7 col-xs-12" readonly>
                          </div>
                      </div>  
                      <input type="hidden" id="type" value="ዋህዮ" class="form-control col-md-7 col-xs-12">
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
            url: 'deleterankwahio',
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
            url: 'editrankwahio',
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

