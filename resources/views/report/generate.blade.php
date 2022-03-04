@extends('layouts.app')

@section('htmlheader_title')
  ረፖርት ስራሕ
@endsection

@section('contentheader_title')
   ረፖርት ስራሕ  
@endsection

@section('header-extra')
<style type="text/css">
    th, td {
        border: 1px solid black;
    }
</style>
@endsection

@section('main-content')
    
           

<div class="container">
    <form method="get" action="{{ url('sixmonthsexcel') }}">
    </form>
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <h4>ናይ {{ $year }} ዓመተምህረት ናይ {{ $this_quarter }} ሪፖርት ናይ መጨረሻ ቅዳሕ ይሰራሕ?</h4>
            <form method="post" action="{{ url('generatereportpost') }}">
                {{ csrf_field() }}
                <input type="hidden" value="{{ $year }}" id="year" name="year">
                <input type="hidden" value="{{ $this_quarter }}" id="quarter" name="quarter">
                <button class="btn btn-success pull-right" type="submit" onclick="return confirm('እዚ ተግባር ሓደ ግዜ ጥራሕ እዩ ክፍፀም ዝኽእል። ንምቕፃል እርግፀኛ ድዮም?')">እወ</button>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts-extra')
@endsection