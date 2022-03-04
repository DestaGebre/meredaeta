@extends('layouts.app')

@section('htmlheader_title')
ማህደር ቀወምቲ ደገፍቲ
@endsection

@section('contentheader_title')
    @if(array_search(Auth::user()->usertype, ['admin', 'zoneadmin', 'woredaadmin']) !== false)
      <div class="pull-right">
        <a href="{{ url('register') }}"><button name="newuser" id="newuser" class="btn btn-info"><span class="glyphicon glyphicon-plus"></span>ሓዱሽ መዝግብ</button></a>
      </div>
    @endif
@endsection

@section('header-extra')
<!-- <script src="//code.jquery.com/jquery-1.12.3.js"></script>
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
 -->
<link rel="stylesheet" href="css/jquery.dataTables.min.css"></style>
<style type="text/css">
    @media print{
        #excelbtn{
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

                <div class="table-responsive text-center">
					<table class="table table-borderless" id="table2">
						<thead>
							<tr>
								<th class="text-center">መ.ቑ</th>
								<th class="text-center">ሽም</th>
								<th class="text-center">ኢሜይል</th>
								<th class="text-center">ዓይነት</th>
								<th class="text-center">ከባቢ</th>	
								<th class="text-center">ተግባር</th>
							</tr>					
						</thead>
						<tbody>
						    <input type="hidden" name="_token" value="{{ csrf_token() }}">
							@foreach ($data as $mydata)										
							<tr>
								<td>{{ $mydata->id }}</td>	
								<td>{{ $mydata->firstname }} {{ $mydata->lastname }}</td>                          
								<td>{{ $mydata->email }}</td>
								<td>{{ $mydata->usertype }}</td>
								<td>{{ $mydata->area }}</td>
								<input type="hidden" value="{{$mydata->id}}">
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
                     
                
                <div class="form-group has-feedback">
                    <input type="email" id="email" required="required" class="form-control col-md-7 col-xs-12" readonly>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Password" name="password"/>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Password" name="password_confirmation"/>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>

                <div class="row">
                    <div class="col-xs-2">
                    </div><!-- /.col -->
                    <div class="col-xs-8">
                        <button type="button" class="btn btn-primary btn-block btn-flat" id="Reset">ይሕለፍ ቃል ቀይር</button>
                    </div><!-- /.col -->
                    <div class="col-xs-2">
                    </div><!-- /.col -->
                </div>
            </form>
                    
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
    $(document).on('click', '.delete-button', function() {
      row = $($($(this).parent()).parent());
        var id = $(row.children()[0]).html();
        var firstname = $(row.children()[1]).html();
        var lastname = $(row.children()[2]).html();
        if(confirm(name+ ' '+lastname+' ንምስራዝ ርግፀኛ ድዮም?')){
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
        $('#id').val($(row.children()[0]).html());
        $('#name').val($(row.children()[1]).html());
        $('#email').val($(row.children()[2]).html());
        id = $(row.children()[7]).val();
        $('#myModaledit').modal('show');
                
    });
    $(document).on('click', '#Reset', function() {
        $.ajax({
            type: 'post',
            url: 'reset',
            data: {
                //'_token': $('input[name=_token]').val(),
                'email': $('#email').val(),
                'id': id,
                'name':name,
                'password': $('#password').val(),
              
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


</script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css"></style>
    <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
@endsection

