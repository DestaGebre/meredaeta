@extends('layouts.auth')

@section('htmlheader_title')
    ገፅ ኣይተረኽበን
@endsection

@section('contentheader_title')
    404 Error Page
@endsection

@section('$contentheader_description')
@endsection

@section('content')

<div class="error-page">
    <h2 class="headline text-yellow"> 404</h2>
    <div class="error-content">
        <h3><i class="fa fa-warning text-yellow"></i>ይቕረታ! እቲ ገፅ ኣይተረኸበን።</h3>
        <p>
            እቲ ዝሓተትዎ ገፅ ክንረኽቦ ኣይከኣልናን። ናብ ዳሽ ቦርድ ንምኻድ <a href='{{ url('/') }}'>ነዙይ ይንክኡ</a>
        </p>
    </div><!-- /.error-content -->
</div><!-- /.error-page -->
<style type="text/css">
    a:hover{
        background-color: #a4d1ec;
        color: #fff;
    }
    </style>
@endsection