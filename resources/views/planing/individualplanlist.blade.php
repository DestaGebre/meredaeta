
@extends('layouts.app')

@section('htmlheader_title')
ትልሚ
@endsection

@section('contentheader_title')
ዝርዝር ትልሚ ውልቀ ሰብ
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
           <div class="mytoggle hidden pull-right">           
      <button class="btn toggleBtn btn-info"><span class="glyphicon glyphicon-arrow-up"></span></button>          
    </div> 
            <div class="myTable">
                <?php $show_zone = $show_woreda = $hide_widabe = $hide_wahio = $show_year = true; ?>
                @include('layouts.partials.filter_html', ['address' => 'individualplanlist'])
                <div class="table-responsive text-center">
                    <table class="table table-borderless" id="table2">
                        <thead>
                            <tr>
                                <th class="text-center">መ.ቑ</th>
                                <th class="text-center">ሽም</th>
                                <th class="text-center">ዓመት</th>
                                <th class="text-center">ሰርዝ</th>
                            </tr>                   
                        </thead>
                        <tbody>
                            @foreach ($data as $indv)
                              <tr>
                                <td>{{ $indv->hitsuyID }}</td>                                                      
                                <td>{{ $indv->name }} {{ $indv->fname }} {{ $indv->gfname }}</td>
                                <td>{{ $indv->year }}</td>
                                <td><button class="delete-button btn btn-danger" data-info="">
                                    <span class="glyphicon glyphicon-trash"></span></button></td>
                              </tr>
                            @endforeach    
                        </tbody>
                        </table>
                        </div>
                        {{ $data->links() }}
                        </div>                      
        
     </div>
    </div>
@endsection

@section('scripts-extra')
    @include('layouts.partials.filter_js')
    <script>

    var row, id, year;
 
     $(document).ready(function() {
      $('#table2').DataTable({
        @include('layouts.partials.lang'),
        "order": []
      });
     });

    
    $(document).on('click', '.delete-button', function() {
        var row = $($($(this).parent()).parent());
        var id = $(row.children()[0]).html();
        var year = $(row.children()[2]).html();
        if(confirm('ትልሚ '+id+ ' '+year+' ንምስራዝ ርግፀኛ ድዮም?')){
            $.ajax({
            type: 'post',
            url: 'deleteindividualplan',
            data: {
                '_token': $('input[name=_token]').val(),  
                'id': id,      
                'year': year,
            },
      
            success: function(data) {
                if(data[0] === true){
                  toastr.clear();
                  toastr.warning('ትልሚ '+id+ ' ዓመት '+year+' ተሰሪዙ ኣሎ');
                  row.remove();
                }
                else{
                   toastr.error('ትልሚ '+id+ ' '+year+' ኣይተረኽበን');
                }
               },

            error: function(xhr,errorType,exception){
                
                  alert(exception);
                        
            }
        });
        }
                
    });

    

   

</script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css"></style>
    <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
@endsection

