@extends('layouts.app')

@section('htmlheader_title')
  ዶክመንታት
@endsection

@section('contentheader_title')
   ዶክመንታት  
@endsection

@section('header-extra')
@endsection

@section('main-content')
    
           

<div>
<div class="box box-primary">
    <div class="box-header with-border">
        <div class="">
            {{ csrf_field() }}
            <div class="table-responsive text-center">
                <table class="table table-borderless" id="table2">
                    <thead>
                        <tr>                       
                            <th class="text-center">ሽም ፋይል</th>
                            <th class="text-center">መብርሂ</th>
                            <th class="text-center">ፋይል ኣውርድ</th>
                        </tr>
                    </thead>
                <tbody  id="products-list" name="products-list">
                    @foreach($data as $item)
                    <tr>                       
                        <td> {{ $item->title }} </td>
                        <td> {{ $item->description }} </td>
                        <td> <a href="download/{{ $item->title }}"> <button class="btn btn-primary">ኣውርድ</button> </a> </td>
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
    
<script>
  $(document).ready(function() {
        $('#table2').DataTable({
            @include("layouts.partials.lang"),
            "order": []
        });
    });
</script>
<link rel="stylesheet" href="css/jquery.dataTables.min.css"></style>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
    
@endsection


