@extends('layouts.app')

@section('htmlheader_title')
  ናይ ክልል ሪፖርት
@endsection

@section('contentheader_title')
   ናይ ክልል ሪፖርት  
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
        .hide-print{
            display: none;
        }
    }
</style>
@endsection

@section('main-content')
    
           

<div class="container">
    <form method="get" action="{{ url('regionalreportexcel') }}">
        <input type="hidden" value="{{ $zoneCode }}" id="zoneCode" name="zoneCode">
        <button class="btn btn-success hide-print" type="submit"><span class="fa fa-download"></span>ኤክሴል ኣውርድ</button>
    </form>
    <form method="get" action="{{ url('regionalreport') }}">
        @if (Auth::user()->usertype == 'admin')
            <div class="col-md-6 col-sm-6 col-xs-6">    
                <select name="zone" id="zone" class="form-control hide-print">
                    <option value="" selected disabled>~ዞባ ምረፅ~</option>
                    <option value="all" 
                    @if ($zoneCode == 'all')
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
            
            <button class="btn btn-success hide-print" type="submit">ኣርእይ</button>
            <br><br>
        @endif
    </form>
    <div class="row">
        <div class="col-sm-12">
            <h4 style="text-align: center;">ናይ ዞባታት ገጠርን ከተማን ኣባል ውድብ /ዞባ  {{ $zoneName }}</h4>
            <div class="table-responsive table-condensed">
                <table style="width: 75%;" class="text-center">
                    <thead>
                        <tr>
                            <th rowspan="2">ወረዳ</th>
                            <th colspan="3">ገጠር</th>
                            <th colspan="3">ከተማ</th>
                            <th colspan="3">ጠ/ድምር</th>
                        </tr>
                        <tr>
                            <th>ተባ</th>
                            <th>ኣን</th>
                            <th>ድምር</th>
                            <th>ተባ</th>
                            <th>ኣን</th>
                            <th>ድምር</th>
                            <th>ድምር ተባ</th>
                            <th>ድምር ኣን</th>
                            <th>ጠ/ድምር</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ketemageter as $k)
                        <tr>
                            <td>{{ $k[0] }}</td>
                            <td>{{ $k[1] }}</td>
                            <td>{{ $k[2] }}</td>
                            <td>{{ $k[3] }}</td>
                            <td>{{ $k[4] }}</td>
                            <td>{{ $k[5] }}</td>
                            <td>{{ $k[6] }}</td>
                            <td>{{ $k[7] }}</td>
                            <td>{{ $k[8] }}</td>
                            <td>{{ $k[9] }}</td>
                        </tr>            
                        @endforeach
                    </tbody>
                </table>
            </div>  
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <h4 style="text-align: center;">ገጠርን ከተማ ውዳበ ዞባ {{ $zoneName }}</h4>
            <div class="table-responsive table-condensed">
                <table style="width: 75%;" class="text-center">
                    <thead>
                        <tr>
                            <th rowspan="2">ወረዳ</th>
                            <th colspan="3">ገባር</th>
                            <th colspan="3">ደኣንት</th>
                            <th colspan="3">ሲ/ሰርቫንት</th>
                            <th colspan="3">መምህራን</th>
                            <th colspan="3">ተምሃሮ</th>
                            <th colspan="3">ሸቃሎ</th>
                            <th colspan="3">ጠ/ድምር</th>
                        </tr>
                        <tr>
                            <th>ተባ</th>
                            <th>ኣን</th>
                            <th>ድምር</th>
                            <th>ተባ</th>
                            <th>ኣን</th>
                            <th>ድምር</th>
                            <th>ተባ</th>
                            <th>ኣን</th>
                            <th>ድምር</th>
                            <th>ተባ</th>
                            <th>ኣን</th>
                            <th>ድምር</th>
                            <th>ተባ</th>
                            <th>ኣን</th>
                            <th>ድምር</th>
                            <th>ተባ</th>
                            <th>ኣን</th>
                            <th>ድምር</th>
                            <th>ድምር ተባ</th>
                            <th>ድምር ኣን</th>
                            <th>ጠ/ድምር</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ketemageterwidabe as $k)
                        <tr>
                            <td>{{ $k[0] }}</td>
                            <td>{{ $k[1] }}</td>
                            <td>{{ $k[2] }}</td>
                            <td>{{ $k[3] }}</td>
                            <td>{{ $k[4] }}</td>
                            <td>{{ $k[5] }}</td>
                            <td>{{ $k[6] }}</td>
                            <td>{{ $k[7] }}</td>
                            <td>{{ $k[8] }}</td>
                            <td>{{ $k[9] }}</td>
                            <td>{{ $k[10] }}</td>
                            <td>{{ $k[11] }}</td>
                            <td>{{ $k[12] }}</td>
                            <td>{{ $k[13] }}</td>
                            <td>{{ $k[14] }}</td>
                            <td>{{ $k[15] }}</td>
                            <td>{{ $k[16] }}</td>
                            <td>{{ $k[17] }}</td>
                            <td>{{ $k[18] }}</td>
                            <td>{{ $k[19] }}</td>
                            <td>{{ $k[20] }}</td>
                            <td>{{ $k[21] }}</td>
                        </tr>            
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <h4 style="text-align: center;">ገጠር ውዳበ ዞባ {{ $zoneName }}</h4>
            <div class="table-responsive table-condensed">
                <table style="width: 75%;" class="text-center">
                    <thead>
                        <tr>
                            <th rowspan="2">ወረዳ</th>
                            <th colspan="3">ገባር</th>
                            <th colspan="3">ሲ/ሰርቫንት</th>
                            <th colspan="3">መምህራን</th>
                            <th colspan="3">ተምሃሮ</th>
                            <th colspan="3">ጠ/ድምር</th>
                        </tr>
                        <tr>
                            <th>ተባ</th>
                            <th>ኣን</th>
                            <th>ድምር</th>
                            <th>ተባ</th>
                            <th>ኣን</th>
                            <th>ድምር</th>
                            <th>ተባ</th>
                            <th>ኣን</th>
                            <th>ድምር</th>
                            <th>ተባ</th>
                            <th>ኣን</th>
                            <th>ድምር</th>
                            <th>ድምር ተባ</th>
                            <th>ድምር ኣን</th>
                            <th>ጠ/ድምር</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($geterwidabe as $k)
                        <tr>
                            <td>{{ $k[0] }}</td>
                            <td>{{ $k[1] }}</td>
                            <td>{{ $k[2] }}</td>
                            <td>{{ $k[3] }}</td>
                            <td>{{ $k[4] }}</td>
                            <td>{{ $k[5] }}</td>
                            <td>{{ $k[6] }}</td>
                            <td>{{ $k[7] }}</td>
                            <td>{{ $k[8] }}</td>
                            <td>{{ $k[9] }}</td>
                            <td>{{ $k[10] }}</td>
                            <td>{{ $k[11] }}</td>
                            <td>{{ $k[12] }}</td>
                            <td>{{ $k[13] }}</td>
                            <td>{{ $k[14] }}</td>
                            <td>{{ $k[15] }}</td>
                        </tr>            
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <h4 style="text-align: center;">ከተማ ውዳበ ዞባ {{ $zoneName }}</h4>
            <div class="table-responsive table-condensed">
                <table style="width: 75%;" class="text-center">
                    <thead>
                        <tr>
                            <th rowspan="2">ወረዳ</th>
                            <th colspan="3">ደኣንት</th>
                            <th colspan="3">ሸቃሎ</th>
                            <th colspan="3">ሰብ ሞያ</th>
                            <th colspan="3">መምህራን</th>
                            <th colspan="3">ተምሃሮ</th>
                            <th colspan="3">ጠ/ድምር</th>
                        </tr>
                        <tr>
                            <th>ተባ</th>
                            <th>ኣን</th>
                            <th>ድምር</th>
                            <th>ተባ</th>
                            <th>ኣን</th>
                            <th>ድምር</th>
                            <th>ተባ</th>
                            <th>ኣን</th>
                            <th>ድምር</th>
                            <th>ተባ</th>
                            <th>ኣን</th>
                            <th>ድምር</th>
                            <th>ተባ</th>
                            <th>ኣን</th>
                            <th>ድምር</th>
                            <th>ድምር ተባ</th>
                            <th>ድምር ኣን</th>
                            <th>ጠ/ድምር</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ketemawidabe as $k)
                        <tr>
                            <td>{{ $k[0] }}</td>
                            <td>{{ $k[1] }}</td>
                            <td>{{ $k[2] }}</td>
                            <td>{{ $k[3] }}</td>
                            <td>{{ $k[4] }}</td>
                            <td>{{ $k[5] }}</td>
                            <td>{{ $k[6] }}</td>
                            <td>{{ $k[7] }}</td>
                            <td>{{ $k[8] }}</td>
                            <td>{{ $k[9] }}</td>
                            <td>{{ $k[10] }}</td>
                            <td>{{ $k[11] }}</td>
                            <td>{{ $k[12] }}</td>
                            <td>{{ $k[13] }}</td>
                            <td>{{ $k[14] }}</td>
                            <td>{{ $k[15] }}</td>
                            <td>{{ $k[16] }}</td>
                            <td>{{ $k[17] }}</td>
                            <td>{{ $k[18] }}</td>
                        </tr>            
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
        <h4 style="text-align: center;">ደኣንት ዞባ {{ $zoneName }} ብማሕበራዊ ቦታ</h4>
        <div class="table-responsive table-condensed">
            <table style="width: 75%;" class="text-center">
                <thead>
                    <tr>
                        <th rowspan="2">ወረዳ</th>
                        <th colspan="3">መፍረይቲ</th>
                        <th colspan="3">ከ/ሕርሻ</th>
                        <th colspan="3">ኮንስትራክሽን</th>
                        <th colspan="3">ንግዲ</th>
                        <th colspan="3">ግልጋሎት</th>
                        <th colspan="3">ጠ/ድምር</th>
                    </tr>
                    <tr>
                        <th>ተባ</th>
                        <th>ኣን</th>
                        <th>ድምር</th>
                        <th>ተባ</th>
                        <th>ኣን</th>
                        <th>ድምር</th>
                        <th>ተባ</th>
                        <th>ኣን</th>
                        <th>ድምር</th>
                        <th>ተባ</th>
                        <th>ኣን</th>
                        <th>ድምር</th>
                        <th>ተባ</th>
                        <th>ኣን</th>
                        <th>ድምር</th>
                        <th>ድምር ተባ</th>
                        <th>ድምር ኣን</th>
                        <th>ጠ/ድምር</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($deant as $k)
                    <tr>
                        <td>{{ $k[0] }}</td>
                        <td>{{ $k[1] }}</td>
                        <td>{{ $k[2] }}</td>
                        <td>{{ $k[3] }}</td>
                        <td>{{ $k[4] }}</td>
                        <td>{{ $k[5] }}</td>
                        <td>{{ $k[6] }}</td>
                        <td>{{ $k[7] }}</td>
                        <td>{{ $k[8] }}</td>
                        <td>{{ $k[9] }}</td>
                        <td>{{ $k[10] }}</td>
                        <td>{{ $k[11] }}</td>
                        <td>{{ $k[12] }}</td>
                        <td>{{ $k[13] }}</td>
                        <td>{{ $k[14] }}</td>
                        <td>{{ $k[15] }}</td>
                        <td>{{ $k[16] }}</td>
                        <td>{{ $k[17] }}</td>
                        <td>{{ $k[18] }}</td>
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
@endsection