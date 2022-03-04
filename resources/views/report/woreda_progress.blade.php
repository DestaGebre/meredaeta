@extends('layouts.app')

@section('htmlheader_title')
  ወረዳታት ዝመዝገብኦ በዝሒ ኣባል
@endsection

@section('contentheader_title')
   ወረዳታት ዝመዝገብኦ በዝሒ ኣባል  
@endsection

@section('header-extra')
<style type="text/css">
    th, td {
        border: 1px solid black;
    }
    @media print{
        #excelbtn{
            display: none;
        }
    }
</style>
@endsection

@section('main-content')
    
           

<div class="container">
    <form method="get" action="{{ url('woredaprogress') }}">
        @if (Auth::user()->usertype == 'admin')
            <div class="col-md-6 col-sm-6 col-xs-6">    
                <select name="zone" id="zone" class="form-control" >
                    <option value="" selected disabled>~ዞባ ምረፅ~</option>
                    <option value="00"
                    @if ($zoneCode == '00')
                            {{ 'selected' }}
                        @endif 
                    >ኩሎም</option>
                    @foreach ($zobadatas as $key => $value)
                        <option value="{{ $key }}" 
                        @if ($zoneCode == $key)
                            {{ 'selected' }}
                        @endif 
                        >{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            
            <button class="btn btn-success" type="submit">ኣርእይ</button>
            <br><br>
        @endif
    </form>
    <div class="row">
        <div class="col-sm-12">
            <!-- <h4 style="text-align: center;">ወረዳታት ዝመዝገብኦ በዝሒ ኣባል</h4> -->
            <div class="table-responsive table-condensed">
                <table style="width: 75%;" class="text-center">
                    <thead>
                        <tr>
                            <th>ወረዳ</th>
                            <th>በዝሒ ዝተመዝገበ ኣባል</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($progress as $data)
                            <tr>
                                <td>{{ $data[0] }}</td>
                                <td>{{ $data[1] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>  
        </div>
    </div>
</div>

    
</div>
@endsection
@section('scripts-extra')
@endsection