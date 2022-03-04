@extends('layouts.auth')

@section('htmlheader_title')
    ዝተኸልከለ ገፅ
@endsection

@section('contentheader_title')
    403 Forbidden
@endsection

@section('$contentheader_description')
@endsection

@section('content')

    <div class="error-page">
        <h2 class="headline text-red">403</h2>
        <div class="error-content">
            <h3><i class="fa fa-warning text-red"></i> ዝተኸልከለ ገፅ!</h3>
            <p>
                እዚ ገፅ ንኽሪኡ እኹል ፍቓድ የብሎምን። ናብ ዳሽ ቦርድ ንምኻድ <a href='{{ url('/') }}'>ነዙይ ይንክኡ</a>
            </p>
        </div>
    </div><!-- /.error-page -->
    <style type="text/css">
    a:hover{
        background-color: #a4d1ec;
        color: #fff;
    }
    </style>
@endsection