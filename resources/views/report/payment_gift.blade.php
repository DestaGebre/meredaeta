@extends('layouts.app')

@section('htmlheader_title')
  ናይ ውህብቶ ሪፖርት
@endsection

@section('contentheader_title')
   ናይ ውህብቶ ሪፖርት  
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
    <form method="get" action="{{ url('paymentgiftreportexcel') }}">
        <input type="hidden" value="{{ $year }}" name="year">
        <button class="btn btn-success" type="submit" id="excelbtn"><span class="fa fa-download"></span>ኤክሴል ኣውርድ</button>
    </form>
    <form method="get" action="">
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
            <h4 style="text-align: center;">ናይ {{ $year }} ውህብቶ ሪፖርት</h4>
            <div class="table-responsive table-condensed">
                <table style="width: 75%;" class="text-center">
                    <thead>
                        <tr>
                            <th>ሽም ወሃቢ</th>
                            <th>ኣድራሻ</th>
                            <th>ዓይነት ውህብቶ</th>
                            <th>ኩነታት</th>
                            <th>ዝተኸፈለሉ ዕለት</th>
                            <th>ግምት</th>
                            <th>ርኢቶ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($gifts as $gift)
                        <tr>
                            <td>{{ $gift->donor->donorName }}</td>
                            <td>{{ $gift->donor->address }}</td>
                            <td>{{ $gift->giftType }}</td>
                            <td>{{ $gift->status }}</td>
                            <td>{{ App\DateConvert::toEthiopian(date('d/m/Y',strtotime($gift->donationDate))) }}</td>
                            <td>{{ $gift->valuation }}</td>
                            <td></td>
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