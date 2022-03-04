
@extends('layouts.app')

@section('htmlheader_title')
ዝርዝር ተግባር
@endsection

@section('contentheader_title')
ዝርዝር ተግባር
@endsection

@section('header-extra')
<style type="text/css">
    .form-control:read-only {
        background-color: #fdfdfd;
        cursor: default;
    }
    input,p {

    }
    p {
        word-break: break-word;
        background: #fdfdfd;
        padding: 15px;
        border: 1px solid #999;
    }
    @media print{
      #print,.switchBtn {
        display: none;
      }
    }
</style>

@endsection
@section('main-content')
<div class="box box-primary">
        <div class="box-header with-border">
    <div id="myDetails">
        <div class="pull-right">                      
            <a class="btn switchBtn btn-info" href="{{ URL::previous() }}"><span class="glyphicon glyphicon-arrow-up"></span></a>
        </div>
            <!-- Button ይመለሱ -->
            <form id="detail-form">
                <!-- Step 1 -->
            <div class="form-group col-sm-12 col-md-12">                     
                <!-- <label class="control-label col-md-1 col-sm-1" for="hitsuyID">መ.ቑ:</label> -->
                <div class="col-md-3 col-sm-4 col-xs-4">
                    <label>ሽም:</label> <input class="form-control" value="{{ $action->user->firstname }} {{ $action->user->lastname }}" ቦ ውፅኢት ካብ 10" name="Result2"  required="required" readonly>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-4">
                    <label>ከባቢ ተጠቃሚ:</label> <input class="form-control" value="{{ $areaDetail }}" ቦ ውፅኢት ካብ 10" name="Result2"  required="required" readonly>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-4">
                    <?php $role_names = ['admin' => 'ኣድሚንስትሬተር', 'zoneadmin' => 'ዞባ ኣድሚንስትሬተር', 'woredaadmin' => 'ወረዳ ኣድሚንስትሬተር', 'zone' => 'ዞባ ስታፍ', 'woreda' => 'ወረዳ ስታፍ']; ?>
                    <label>ሓላፍነት ተጠቃሚ:</label> <input class="form-control" value="{{ $role_names[$role] }}" ቦ ውፅኢት ካብ 10" name="Result2"  required="required" readonly>
                </div>
            </div>
            <div class="form-group col-sm-12 col-md-12">                     
                <!-- <label class="control-label col-md-1 col-sm-1" for="hitsuyID">መ.ቑ:</label> -->
                @if(!$action->bulk)
                    <div class="col-md-3 col-sm-4 col-xs-4">
                        <label>መለለዪ መረዳእታ</label> <input class="form-control" value="{{ $action->recordid }}" ቦ ውፅኢት ካብ 10" name="Result2"  required="required" readonly>
                    </div>
                @endif
                <div class="col-md-3 col-sm-4 col-xs-4">
                    <?php $general_actions = [App\Constant::CREATE => 'ምዝገባ', App\Constant::UPDATE => 'ምምሕያሽ', App\Constant::DELETE => 'ምስራዝ'] ?>
                    <?php $act = explode('_', $action->action); ?>
                    <label>ተግባር:</label> <input class="form-control" value="{{ $general_actions[$act[0]] }} {{ App\Constant::ACTION_MAP[$act[1]] }}"  required="required" readonly>
                </div>
            </div>
            <div class="form-group col-sm-12 col-md-12">
                <label>ዝርዝር መረዳእታ</label><br>
                @foreach(explode(';', $action->data) as $mydata)
                    {{explode('|', $mydata)[0]}}:  <textarea class="form-control" readonly>{{explode('|', $mydata)[1]}}</textarea><br>
                @endforeach
                @if($action->bulk)
                    <label>ዝርዝር መለለዪ</label><br>
                    @foreach(explode(';', $action->bulkdata) as $mydata)
                        <div class="form-group col-sm-12 col-md-4">
                            <input class="form-control" readonly value="{{ $mydata }}"><br>
                        </div>
                    @endforeach
                @endif
            </div>
            <hr style="border:groove 1px #79D57E;"/>       
          </form>
             <div class="text-center">                    
                <button  id="print" class="btn printerBtn btn-info" onclick="window.print();return false;"><span class="fa fa-print"></span>ፕሪንት </button>                
            </div>
        </div>
    </div>

@endsection

@section('scripts-extra')
@endsection
