@extends('layouts.app')

@section('htmlheader_title')
  ናይ መዋጮ ሪፖርት
@endsection

@section('contentheader_title')
   ናይ መዋጮ ሪፖርት  
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
    <form method="get" action="{{ url('paymentmewachoreportexcel') }}">
        <input type="hidden" value="{{ $zoneCode }}" name="zone">
        <input type="hidden" value="{{ $year }}" name="year">
        <button class="btn btn-success" type="submit" id="excelbtn"><span class="fa fa-download"></span>ኤክሴል ኣውርድ</button>
    </form>
    <form method="get" action="">
        @if (Auth::user()->usertype == 'admin')
            <div class="col-md-3 col-sm-4 col-xs-4">    
                <select name="zone" id="zone" class="form-control hide-print" >
                    <option value="" selected disabled>~ዞባ ምረፅ~</option>
                    <!-- <option value="0" 
                        @if ($zoneCode == '0')
                            {{ 'selected' }}
                        @endif 
                        >ኩሎም</option> -->
                    @foreach ($zobadatas as $key => $value)
                        <option value="{{ $key }}" 
                        @if ($zoneCode == $key)
                            {{ 'selected' }}
                        @endif 
                        >{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        @endif
        <div class="col-md-2 col-sm-4 col-xs-4">    
            <select name="year" id="year" class="form-control hide-print" >
                <option value="" selected disabled>~ዓመት~</option>
                <?php $this_year = explode("/", App\DateConvert::toEthiopian(date('d/m/Y')))[2]; ?>
                @foreach (range(2010, $this_year) as $value)
                    <option
                    @if ($value == $year)
                        {{ 'selected' }}
                    @endif 
                    >{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-success hide-print" type="submit">ኣርእይ</button>
        <br><br>
    </form>
    <div class="row">
        <div class="col-sm-12">
            <h4 style="text-align: center;">ናይ {{ $year }} መዋጮ ሪፖርት {{ $zobadatas[$zoneCode] }}</h4>
            <div class="table-responsive table-condensed">
                <table style="width: 75%;" class="text-center">
                    <thead>
                        <tr>
                            <th>ሽም መዋጮ</th>
                            <th>መሰረታዊ ውዳበ</th>
                            <th>ዕላማ</th>
                            <th>ዓይነት ኣባላት</th>
                            <th>በዝሒ ኣባላት</th>
                            <th>ዝኸፈሉ</th>
                            <th>ዘይኸፈሉ</th>
                            <th>ድምር ክፍሊት</th>
                            <th>ዘይተኸፈለ መጠን</th>
                            <th>ሪኢቶ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mewacho as $row)
                        <tr>
                            <td>{{ $row[0] }}</td>
                            <td>{{ $row[1] }}</td>
                            <td>{{ $row[2] }}</td>
                            <td>{{ $row[3] }}</td>
                            <td>{{ $row[4] }}</td>
                            <td>{{ $row[5] }}</td>
                            <td>{{ $row[6] }}</td>
                            <td>{{ round($row[7], 2) }}</td>
                            <td>{{ round($row[8], 2) }}</td>
                            <td>{{ $row[9] }}</td>
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
    <script type="text/javascript">
        $('#excelbtn').on('click', function(e) {
            $('#zoneCode').val($('#zone').val());
        });
        $('#quarter').on('change', function(e) {
            if($(this).val() != 1) {
                $('#month').prop('disabled', true);
                $('#month').prop('selectedIndex', 0);
            }
            else{
                $('#month').prop('disabled', false);
            }
        });
    </script>
@endsection