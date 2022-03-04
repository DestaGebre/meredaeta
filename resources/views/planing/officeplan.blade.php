@extends('layouts.app')

@section('htmlheader_title')
     ትልሚ
@endsection

@section('contentheader_title')
 ናይ ቤት ፅሕፈት ትልሚ
@endsection

@section('header-extra')


@endsection
@section('main-content')
<div>
<div class="box box-primary">
<div class="box-header with-border">
<div class="" style="height: 50px;">
    <button class="pull-right add-modal btn btn-success" data-info=""><span class="glyphicon glyphicon-plus"></span> ሓዱሽ መዝግብ</button>
</div>
  <div class="">
    {{ csrf_field() }}
    <div class="table-responsive text-center">
      <table class="table table-borderless" id="table2">
        <thead>
          <tr>
            <th class="text-center">ተ.ቑ</th>            
            <th class="text-center">ዓመት ትልሚ </th>
            <th class="text-center">ዓይነት ትልሚ</th>
            <th class="text-center">በዝሒ</th>
            <th class="text-center">መብረሂ</th>            
            <th class="text-center"></th>
          </tr>
        </thead>
        <tbody  id="products-list" name="products-list">
          @foreach($data as $item)
          <tr class="item{{$item->id}}" >
            <td>{{$item->id}}</td>
            <td>{{$item->planyear}}</td>
            <td>{{$item->plantype}}</td>
            <td>{{$item->amount}}</td>           
            <td>{{$item->descrpt}}</td>            
            
            <td><button class="edit-modal btn btn-info"
                data-info="{{$item->id}},{{$item->amount}}">
                <span class="glyphicon glyphicon-edit"></span> ኣስተኻኽል
              </button>
              <button class="delete-modal btn btn-danger"
                data-info="{{$item->id}},{{$item->amount}}">
                <span class="glyphicon glyphicon-trash"></span> ሰርዝ
              </button></td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  </div>
  </div>
  <div id="myModal" class="modal fade" role="dialog">
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
              <input type="hidden" id="fid">
              <label class="control-label col-sm-2" for="planyear1">ዓመት ትልሚ</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control" id="planyear1">
              </div>
            </div>
            
            <div class="form-group">
                  <label class="control-label col-md-2 col-sm-2 col-xs-2"for="plantype1">ዓይነት ትልሚ</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="form-control col-md-6 col-sm-6 col-xs-12" id="plantype1">
                      <option selected disabled>~ዓይነት ትልሚ ምረፅ~</option>              
                      <option>ነበርቲ ተራ ኣባላት</option>
                      <option>ጠርነፍቲ መ/ውዳበ ዋህዮ</option>
                      <option>ኣባላት ተመሃሮ</option>
                      <option>ናይ ሰብ ሞያ</option>
                      <option>ጀማሪ ኣመራርሓ</option>
                      <option>ማእኸላይ ኣመራርሓ</option>
                      <option>ላዕለዋይ ኣመራርሓ</option>
                      </select>
                  </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="amount1">በዝሒ</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control" id="amount1">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="descrpt1">መብረሂ</label>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <textarea class="form-control" id="descrpt1" rows="10"></textarea>
              </div>
            </div>
            </div>
            <p class="fname_error error text-center alert alert-danger hidden"></p>
                
                      
          
          </form>
          <div class="deleteContent">
            ብትክክል ክጠፍአ ይድለ ድዩ <span class="dname"></span> ? <span
              class="hidden did"></span>
              <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
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
              <label class="control-label col-sm-2" for="planyear">ዓመት ትልሚ</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control" id="planyear">
              </div>
            </div>
            
            <div class="form-group">
                  <label class="control-label col-md-2 col-sm-2 col-xs-2"for="plantype">ዓይነት ትልሚ</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="form-control col-md-6 col-sm-6 col-xs-12" id="plantype">
                      <option selected disabled>~ዓይነት ትልሚ ምረፅ~</option>              
                      <option>ነበርቲ ተራ ኣባላት</option>
                      <option>ጠርነፍቲ መ/ውዳበ ዋህዮ</option>
                      <option>ኣባላት ተመሃሮ</option>
                      <option>ናይ ሰብ ሞያ</option>
                      <option>ጀማሪ ኣመራርሓ</option>
                      <option>ማእኸላይ ኣመራርሓ</option>
                      <option>ላዕለዋይ ኣመራርሓ</option>
                    </select>
                  </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="amount">በዝሒ</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control" id="amount">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="descrpt">መብረሂ</label>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <textarea class="form-control" id="descrpt" rows="10"></textarea>
              </div>
            </div>
            </div>
            <p class="fname_error error text-center alert alert-danger hidden"></p>
                
                      
          
          </form>
          
          <div class="modal-footer">
          <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
            <button type="button" class="btn actionBtn">
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
@endsection

  @section('scripts-extra')
  <script>
 
 
   $(document).ready(function() {
      $('#table2').DataTable({
        @include('layouts.partials.lang'),
        "order": []
      });
        } );
   var row, stuff;
    $(document).on('click', '.edit-modal', function() {
        $('#footer_action_button').text(" ኣስተኻኽል");
        $('#footer_action_button').addClass('glyphicon-check');
        $('#footer_action_button').removeClass('glyphicon-trash');
        $('.actionBtn').addClass('btn-success');
        $('.actionBtn').removeClass('btn-danger');
        $('.actionBtn').removeClass('delete');
        $('.actionBtn').addClass('edit');
        $('.modal-title').text('ኣስተኻኽል');
        $('.deleteContent').hide();
        $('.form-horizontal').show();
        row = $($($(this).parent()).parent()).children();
        stuff = [$(row[0]).html(),$(row[1]).html(),$(row[2]).html(),$(row[3]).html(),$(row[4]).html()];
        fillmodalData(stuff);
        $('#myModal').modal('show');
    });
  $(document).on('click', '.add-modal', function() {
        $('#footer_action_button2').text("ኣቀምጥ");
        $('#footer_action_button2').addClass('glyphicon-check');
        $('#footer_action_button2').removeClass('glyphicon-trash');
        $('.actionBtn').addClass('btn-success');
        $('.actionBtn').removeClass('btn-danger');
        $('.actionBtn').removeClass('delete');
        $('.actionBtn').addClass('add');
        $('.modal-title').text('ናይ ቤት ፅሕፈት ትልሚ');
        $('.deleteContent').hide();
        $('.form-horizontal').show();
        $('#myModaladd').modal('show');
    });
    $(document).on('click', '.delete-modal', function() {
        $('#footer_action_button').text("ሰርዝ");
        $('#footer_action_button').removeClass('glyphicon-check');
        $('#footer_action_button').addClass('glyphicon-trash');
        $('.actionBtn').removeClass('btn-success');
        $('.actionBtn').addClass('btn-danger');
        $('.actionBtn').removeClass('edit');
        $('.actionBtn').addClass('delete');
        $('.modal-title').text('ሰርዝ');
        $('.deleteContent').show();
        $('.form-horizontal').hide();
        row = $($($(this).parent()).parent()).children();
        $('.did').text($(row[0]).html());
        $('#myModal').modal('show');
    });

function fillmodalData(details){
     $('#fid').val(details[0]);
    $('#planyear1').val(details[1]);
    $('#plantype1').val(details[2]);
    $('#amount1').val(details[3]);
    $('#descrpt1').val(details[4]);
    
}

    $('.modal-footer').on('click', '.edit', function() {
        $.ajax({
            type: 'post',
            url: 'officeplanedit',
            data: {
                '_token': $('input[name=_token]').val(),        
                'id': $('#fid').val(),
                'planyear': $('#planyear1').val(),
                'plantype': $('#plantype1').val(),
                'amount': $('#amount1').val(),
                'descrpt': $('#descrpt1').val()
              
            },
      
            success: function(data) {
                if(data[0] == true){
                      $(row[1]).html($('#planyear1').val());
                      $(row[2]).html($('#plantype1').val());
                      $(row[3]).html($('#amount1').val());
                      $(row[4]).html($('#descrpt1').val());
                      $('#planyear1').val('');
                      $('#plantype1').prop('selectedIndex',0);
                      $('#amount1').val('');
                      $('#descrpt1').val('');
                      $('#myModal').modal('hide');
                    }
                    else{
                      if(Array.isArray(data[2]))
                          data[2] = data[2].join('<br>');
                    }
                  
                    toastr.clear();
                    toastr[data[1]](data[2]);
            }
        });
    });
  $('.modal-footer').on('click', '.add', function() {
        $.ajax({
            type: 'post',
            url: 'officeplan',
            data: {
                '_token': $('input[name=_token]').val(),        
                'planyear': $('#planyear').val(),
                'plantype': $('#plantype').val(),
                'amount': $('#amount').val(),
                'descrpt': $('#descrpt').val()
              
            },
      
            success: function(data) {
              if(data[0] == true){
                    var temp = '<tr class="item'+data[3]+'" >\
            <td>'+data[3]+'</td>\
            <td>'+$('#planyear').val()+'</td>\
            <td>'+$('#plantype').val()+'</td>\
            <td>'+$('#amount').val()+'</td>\
            <td>'+$('#descrpt').val()+'</td>\
            <td><button class="edit-modal btn btn-info" data-info="'+data[3]+','+$('#amount').val()+'"><span class="glyphicon glyphicon-edit"></span> ኣስተኻኽል</button><button class="delete-modal btn btn-danger" data-info="'+data[3]+','+$('#amount').val()+'"><span class="glyphicon glyphicon-trash"></span> ሰርዝ</button></td>\
          </tr>';
          setTimeout(function() {$($('table')[0]).append(temp);}, 1000);
                    $('#planyear').val(''),
                    $('#plantype').prop('selectedIndex',0),
                    $('#amount').val(''),
                    $('#descrpt').val(''),
                    $('#myModaladd').modal('hide');
                  }
                  else{
                    if(Array.isArray(data[2]))
                        data[2] = data[2].join('<br>');
                  }
                
                  toastr.clear();
                  toastr[data[1]](data[2]);
              },

        error:function(xhr,err,exception){
            alert(exception);
        }
        });
    });
    $('.modal-footer').on('click', '.delete', function() {
        $.ajax({
            type: 'post',
            url: 'officeplandelete',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('.did').text()
        
            },
      
            success: function(data) {
              if(data[0] == true){
                $('#myModal').modal('hide');
                toastr.clear();
                toastr['warning'](data[1]);
                setTimeout(function() {row.remove()}, 1000);
              }
            }
        });
    });
</script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css"></style>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
@endsection

