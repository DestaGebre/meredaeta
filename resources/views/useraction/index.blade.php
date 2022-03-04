
@extends('layouts.app')

@section('htmlheader_title')
ተግባራት ተጠቀምቲ
@endsection

@section('contentheader_title')
ተግባራት ተጠቀምቲ
@endsection

@section('header-extra')
<!-- <script src="//code.jquery.com/jquery-1.12.3.js"></script>
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
 -->

@endsection
@section('main-content')
@if(Auth::user()->usertype != 'woredaadmin')
    <?php 
        $hide_widabe = $hide_wahio = $hide_tabia = $show_actions = true;
    ?>
    @include('layouts.partials.filter_html', ['address' => 'actions'])
@endif
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-6">
                <!-- <div class="form-group col-md-12 col-sm-12 col-xs-12">                         
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
                </div> -->
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
            </div>  
    </div>
    <div class="box box-primary">
        <div class="box-header with-border">            
            <div class="">
                {{ csrf_field() }}
                <div class="table-responsive text-center">
                    <table class="table table-borderless" id="table2">
                        <thead>
                            <tr>
                                <th class="text-center">ሽም ተጠቃሚ</th>
                                <th class="text-center">መለለዪ መረዳእታ</th>
                                <th class="text-center">ተግባር</th>
                                <th class="text-center">ዕለት</th>
                            </tr>                   
                        </thead>
                        <tbody>
                            @foreach ($data as $mydata)                                     
                            <tr>
                                <td><a href="{{ url('actiondetails') }}?id={{ $mydata->id }}" class="btn btn-success">ዝርዝር ርአ</a>{{ $mydata->user->firstname }} {{ $mydata->user->lastname }}</td>    
                                <td>{{ $mydata->recordid }}</td>                          
                                <!-- <td>{{ str_limit($mydata->data,50) }}</td> -->
                                <?php $general_actions = [App\Constant::CREATE => 'ምዝገባ', App\Constant::UPDATE => 'ምምሕያሽ', App\Constant::DELETE => 'ምስራዝ'] ?>
                                <?php $action = explode('_', $mydata->action); ?>
                                <td>{{ $general_actions[$action[0]] }} {{ App\Constant::ACTION_MAP[$action[1]] }}</td>
                                <td>{{ App\DateConvert::toEthiopian(date('d/m/Y',strtotime($mydata->created_at))) }}</td>
                           </tr>
                            @endforeach
                            </tbody>
                        </table>
                        </div>
                        </div>                      
    
        
     </div>
    </div>
@endsection

@section('scripts-extra')
@include('layouts.partials.filter_js')
<script>
 
 
     $(document).ready(function() {
      $('#table2').DataTable({
        @include('layouts.partials.lang'),
        "order": []
      });
     });    
</script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css"></style>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>

@endsection

