<?php
    use Carbon\Carbon;
?>
@extends('layouts.app')

@section('htmlheader_title')
ማህደር ኣባል: {{ $member->hitsuy->name . ' ' .$member->hitsuy->fname}}
@endsection

@section('contentheader_title')
ማህደር ኣባል: {{ $member->hitsuy->name . ' ' .$member->hitsuy->fname  . ' ' .$member->hitsuy->gfname}} <i> {{ ' [መለለዪ ቑፅሪ: ' .$member->hitsuy->hitsuyID . ']' }} </i>
@endsection

@section('header-extra')
<!-- <link rel="stylesheet" href="css/jquery.dataTables.min.css"></style> -->
<style type="text/css">
    .heading{
        border-bottom: 1px solid #f4f4f4;
        text-align: center;
    }
</style>
@endsection
@section('main-content')
    <div class="box box-primary">
        <div id="tableofContents">
            <div class="box-header with-border heading">
                <div class="pull-right">                      
                    <a class="btn switchBtn btn-info" href="{{ URL::previous() }}"><span class="glyphicon glyphicon-arrow-up"></span></a>
                    <a class="btn switchBtn btn-info" href="{{ url('memberlist') }}"><span class="glyphicon glyphicon-home"></span></a>
                </div>
                <h1 class="box-title" style="font-size: 25px;">ዝውውራት</h1>
            </div>
            <div class="table-responsive text-center">
                <table class="table table-borderless" id="table2">
                    <thead>
                        <tr>
                            <th class="text-center">ካብ</th>
                            <th class="text-center">ናብ</th>
                            <th class="text-center">ዝጀመረሉ ዕለት</th>
                            <th class="text-center">ደረጃ</th>
                            <th class="text-center">ኮሚቴ</th>
                            <th class="text-center">ቦታ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = false; ?>
                        @foreach ($transfers as $transfer)
                        <tr>
                            <?php
                                $oldWahio = App\Wahio::where('id', $transfer->oldassignedWahio)->first();
                                $wahio = App\Wahio::where('id', $transfer->assignedWahio)->first();
                            ?>
                            <td> {{ $oldWahio->wahiosmw->widabes->tabiatat->zonat->zoneName . '/' . $oldWahio->wahiosmw->widabes->tabiatat->name . '/' . $oldWahio->wahiosmw->widabes->tabiaName . '/' . $oldWahio->wahiosmw->widabeName . '/' . $oldWahio ->wahioName }} </td>
                            <td
                            @if(!$i)
                             <?php $i = true; ?>
                             style="background-color: #f2f2f2"
                            @endif
                            > {{ $wahio->wahiosmw->widabes->tabiatat->zonat->zoneName . '/' . $wahio->wahiosmw->widabes->tabiatat->name . '/' . $wahio->wahiosmw->widabes->tabiaName . '/' . $wahio->wahiosmw->widabeName . '/' . $wahio ->wahioName }} </td>
                            <td> {{ App\DateConvert::toEthiopian(date('d/m/Y',strtotime($transfer->startDate))) }} </td>
                            <td> {{ $transfer->dereja }} </td>
                            <td> {{ $transfer->committee }} </td>
                            <td> {{ $transfer->place }} </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="box box-primary">
        <div id="tableofContents">
            <div class="box-header with-border heading">
                <h1 class="box-title" style="font-size: 25px;">ምደባታት</h1>
            </div>
            <div class="table-responsive text-center">
                <table class="table table-borderless" id="table2">
                    <thead>
                        <tr>
                            <th class="text-center">ካብ</th>
                            <th class="text-center">ናብ</th>
                            <th class="text-center">ዝጀመረሉ ዕለት</th>
                            <th class="text-center">ደረጃ</th>
                            <th class="text-center">ኮሚቴ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = false; ?>
                        @foreach ($midebas as $mideba)
                        <tr>
                            <?php
                                $oldWahio = App\Wahio::where('id', $mideba->oldassignedWahio)->first();
                                $wahio = App\Wahio::where('id', $mideba->assignedWahio)->first();
                            ?>
                            <td> {{ $oldWahio->wahiosmw->widabes->tabiatat->zonat->zoneName . '/' . $oldWahio->wahiosmw->widabes->tabiatat->name . '/' . $oldWahio->wahiosmw->widabes->tabiaName . '/' . $oldWahio->wahiosmw->widabeName . '/' . $oldWahio ->wahioName }} </td>
                            <td
                            @if(!$i)
                             <?php $i = true; ?>
                             style="background-color: #f2f2f2"
                            @endif
                            > {{ $wahio->wahiosmw->widabes->tabiatat->zonat->zoneName . '/' . $wahio->wahiosmw->widabes->tabiatat->name . '/' . $wahio->wahiosmw->widabes->tabiaName . '/' . $wahio->wahiosmw->widabeName . '/' . $wahio ->wahioName }} </td>
                            <td> {{ App\DateConvert::toEthiopian(date('d/m/Y',strtotime($mideba->startDate))) }} </td>
                            <td> {{ $mideba->deraja }} </td>
                            <td> {{ $mideba->birkiCommittee }} </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="box box-primary">
        <div id="tableofContents">
            <div class="box-header with-border heading">
                <h1 class="box-title" style="font-size: 25px;">ስልጠናታት</h1>
            </div>
            <div class="table-responsive text-center">
                <table class="table table-borderless" id="table2">
                    <thead>
                        <tr>
                            <th class="text-center">ደረጃ ስልጠና</th>
                            <th class="text-center">ዓይነት ስልጠና</th>
                            <th class="text-center">መሰልጠኒ</th>
                            <th class="text-center">ዝጀመረሉ ዕለት</th>
                            <th class="text-center">ዝተወድአሉ ዕለት</th>
                            <th class="text-center">ቦታ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($siltenas as $siltena)
                        <tr>
                            <td>{{ $siltena->trainingLevel }}</td>
                            <td>{{ $siltena->trainingType }}</td>
                            <td>{{ $siltena->trainer }}</td>
                            <td>{{ App\DateConvert::toEthiopian(date('d/m/Y',strtotime($siltena->startDate))) }}</td>
                            <td>{{ App\DateConvert::toEthiopian(date('d/m/Y',strtotime($siltena->endDate))) }}</td>
                            <td>{{ $siltena->trainingPlace }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="box box-primary">
        <div id="tableofContents">
            <div class="box-header with-border heading">
                <h1 class="box-title" style="font-size: 25px;">ቕፅዓታት</h1>
            </div>
            <div class="table-responsive text-center">
                <table class="table table-borderless" id="table2">
                    <thead>
                        <tr>
                            <th class="text-center">ዓይነት ጥፍኣት</th>
                            <th class="text-center">ደረጃ ጥፍኣት</th>
                            <th class="text-center">ዝተውሃበ ቕፅዓት</th>
                            <th class="text-center">ቕፅዓት ዝተውሃበሉ ዕለት</th>
                            <th class="text-center">ቕፅዓት ዝፀንሐሉ ጊዜ</th>
                            <th class="text-center">መበገሲ ሓሳብ ዘቕረበ ኣካል</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penalties as $penalty)
                        <tr>
                            <td>{{ $penalty->chargeType }}</td>
                            <td>{{ $penalty->chargeLevel }}</td>
                            <td>{{ $penalty->penaltyGiven }}</td>
                            <td>{{ App\DateConvert::toEthiopian(date('d/m/Y',strtotime($penalty->startDate))) }}</td>
                            <td>{{ $penalty->duration }}</td>
                            <td>{{ $penalty->proposedBy }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="box box-primary">
        <div id="tableofContents">
            <div class="box-header with-border heading">
                <h1 class="box-title" style="font-size: 25px;">ገምጋማት</h1>
            </div>
            <div class="table-responsive text-center">
                <table class="table table-borderless" id="table2">
                    <thead>
                        <tr>
                            <th class="text-center">ብርኪ ሓላፍነት</th>
                            <th class="text-center">ዓመት</th>
                            <th class="text-center">ወቕቲ</th>
                            
                            <th class="text-center">ሞዴል ምዃን</th>
                            <th class="text-center">ሚዛን</th>
                            <th class="text-center">ውፅኢት</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($gemgams_super)
                            @foreach ($gemgams_super as $gemgam)
                            <tr>
                                <td>ላዕለዋይ ኣመራርሓ</td>
                                <td>{{ $gemgam->year }}</td>
                                <td>{{ $gemgam->half }}</td>
                                @if($gemgam->model)
                                    <td>{{ $gemgam->model }}</td>
                                @else
                                    <td>-</td>
                                @endif
                                @if($gemgam->evaluation)
                                    <td>{{ $gemgam->evaluation }}</td>
                                @else
                                    @if($gemgam->sum >= 80)
                                        <td>A</td>
                                    @elseif($gemgam->sum >= 65)
                                        <td>B</td>
                                    @else
                                        <td>C</td>
                                    @endif
                                @endif
                                @if($gemgam->sum)
                                    <td>{{ $gemgam->sum }} / 100</td>
                                @else
                                    <td>-</td>
                                @endif
                                <td><a href="{{ url('topleaderdetails') }}?id={{ str_replace('/', '_', $member->hitsuy->hitsuyID) }}&year={{$gemgam->year}}&period={{$gemgam->half}}" class="btn btn-success">ዝርዝር ርኣይ</a></td>
                            </tr>
                            @endforeach
                        @endif

                        @if($gemgams_middle)
                            @foreach ($gemgams_middle as $gemgam)
                            <tr>
                                <td>ማእኸላይ ኣመራርሓ</td>
                                <td>{{ $gemgam->year }}</td>
                                <td>{{ $gemgam->half }}</td>
                                @if($gemgam->model)
                                    <td>{{ $gemgam->model }}</td>
                                @else
                                    <td>-</td>
                                @endif
                                @if($gemgam->evaluation)
                                    <td>{{ $gemgam->evaluation }}</td>
                                @else
                                    @if($gemgam->sum >= 80)
                                        <td>A</td>
                                    @elseif($gemgam->sum >= 65)
                                        <td>B</td>
                                    @else
                                        <td>C</td>
                                    @endif
                                @endif
                                @if($gemgam->sum)
                                    <td>{{ $gemgam->sum }} / 100</td>
                                @else
                                    <td>-</td>
                                @endif
                                <td><a href="{{ url('mediumleaderdetails') }}?id={{ str_replace('/', '_', $member->hitsuy->hitsuyID) }}&year={{$gemgam->year}}&period={{$gemgam->half}}" class="btn btn-success">ዝርዝር ርኣይ</a></td>
                            </tr>
                            @endforeach
                        @endif

                        @if($gemgams_lower)
                            @foreach ($gemgams_lower as $gemgam)
                            <tr>
                                <td>ጀማሪ ኣመራርሓ</td>
                                <td>{{ $gemgam->year }}</td>
                                <td>{{ $gemgam->half }}</td>
                                @if($gemgam->model)
                                    <td>{{ $gemgam->model }}</td>
                                @else
                                    <td>-</td>
                                @endif
                                @if($gemgam->evaluation)
                                    <td>{{ $gemgam->evaluation }}</td>
                                @else
                                    @if($gemgam->sum >= 80)
                                        <td>A</td>
                                    @elseif($gemgam->sum >= 65)
                                        <td>B</td>
                                    @else
                                        <td>C</td>
                                    @endif
                                @endif
                                @if($gemgam->sum)
                                    <td>{{ $gemgam->sum }} / 100</td>
                                @else
                                    <td>-</td>
                                @endif
                                <td><a href="{{ url('lowleaderdetails') }}?id={{ str_replace('/', '_', $member->hitsuy->hitsuyID) }}&year={{$gemgam->year}}&period={{$gemgam->half}}" class="btn btn-success">ዝርዝር ርኣይ</a></td>
                            </tr>
                            @endforeach
                        @endif

                        @if($gemgams_first)
                            @foreach ($gemgams_first as $gemgam)
                            <tr>
                                <td>ታሕተዋይ ኣመራርሓ</td>
                                <td>{{ $gemgam->year }}</td>
                                <td>{{ $gemgam->half }}</td>
                                @if($gemgam->model)
                                    <td>{{ $gemgam->model }}</td>
                                @else
                                    <td>-</td>
                                @endif
                                @if($gemgam->evaluation)
                                    <td>{{ $gemgam->evaluation }}</td>
                                @else
                                    @if($gemgam->sum >= 80)
                                        <td>A</td>
                                    @elseif($gemgam->sum >= 65)
                                        <td>B</td>
                                    @else
                                        <td>C</td>
                                    @endif
                                @endif
                                @if($gemgam->sum)
                                    <td>{{ $gemgam->sum }} / 100</td>
                                @else
                                    <td>-</td>
                                @endif
                                <td><a href="{{ url('firstinstantleaderdetails') }}?id={{ str_replace('/', '_', $member->hitsuy->hitsuyID) }}&year={{$gemgam->year}}&period={{$gemgam->half}}" class="btn btn-success">ዝርዝር ርኣይ</a></td>
                            </tr>
                            @endforeach
                        @endif

                        @if($gemgams_expert)
                            @foreach ($gemgams_expert as $gemgam)
                            <tr>
                                <td>ሲቪል ሰርቫንት</td>
                                <td>{{ $gemgam->year }}</td>
                                <td>{{ $gemgam->half }}</td>
                                @if($gemgam->model)
                                    <td>{{ $gemgam->model }}</td>
                                @else
                                    <td>-</td>
                                @endif
                                @if($gemgam->evaluation)
                                    <td>{{ $gemgam->evaluation }}</td>
                                @else
                                    @if($gemgam->sum >= 80)
                                        <td>A</td>
                                    @elseif($gemgam->sum >= 65)
                                        <td>B</td>
                                    @else
                                        <td>C</td>
                                    @endif
                                @endif
                                @if($gemgam->sum)
                                    <td>{{ $gemgam->sum }} / 100</td>
                                @else
                                    <td>-</td>
                                @endif
                                <td><a href="{{ url('expertdetails') }}?id={{ str_replace('/', '_', $member->hitsuy->hitsuyID) }}&year={{$gemgam->year}}&period={{$gemgam->half}}" class="btn btn-success">ዝርዝር ርኣይ</a></td>
                            </tr>
                            @endforeach
                        @endif

                        @if($gemgams_tara)
                            @foreach ($gemgams_tara as $gemgam)
                            <tr>
                                <td>ተራ ኣባል</td>
                                <td>{{ $gemgam->year }}</td>
                                <td>{{ $gemgam->half }}</td>
                                @if($gemgam->model)
                                    <td>{{ $gemgam->model }}</td>
                                @else
                                    <td>-</td>
                                @endif
                                @if($gemgam->evaluation)
                                    <td>{{ $gemgam->evaluation }}</td>
                                @else
                                    @if($gemgam->sum >= 80)
                                        <td>A</td>
                                    @elseif($gemgam->sum >= 65)
                                        <td>B</td>
                                    @else
                                        <td>C</td>
                                    @endif
                                @endif
                                @if($gemgam->sum)
                                    <td>{{ $gemgam->sum }} / 100</td>
                                @else
                                    <td>-</td>
                                @endif
                                <td><a href="{{ url('teramemberdetails') }}?id={{ str_replace('/', '_', $member->hitsuy->hitsuyID) }}&year={{$gemgam->year}}&period={{$gemgam->half}}" class="btn btn-success">ዝርዝር ርኣይ</a></td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="box box-primary">
        <div id="tableofContents">
            <div class="box-header with-border heading">
                <h1 class="box-title" style="font-size: 25px;">ትምህርቲ</h1>
            </div>
            <div class="table-responsive text-center">
                <table class="table table-borderless" id="table2">
                    <thead>
                        <tr>
                            <th class="text-center">ዓይነት ትምህርቲ</th>
                            <th class="text-center">ደረጃ ትምህርቲ</th>
                            <th class="text-center">ዝሃቦ ትካል</th>
                            <th class="text-center">ዝተመረቐሉ ዓመት</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = false; ?>
                        @foreach ($educations as $education)
                        <tr>
                            <td>{{ $education->educationType }}</td>                               
                            <td>{{ $education->educationLevel }}</td>
                            <td>{{ $education->institute }}</td>
                            <td>{{ $education->graduationDate }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="box box-primary">
        <div id="tableofContents">
            <div class="box-header with-border heading">
                <h1 class="box-title" style="font-size: 25px;">ልምዲ ስራሕ</h1>
            </div>
            <div class="table-responsive text-center">
                <table class="table table-borderless" id="table2">
                    <thead>
                        <tr>
                            <th class="text-center">ስራሕ መደብ</th>
                            <th class="text-center">ዓይነት</th>
                            <th class="text-center">ትካል</th>
                            <th class="text-center">ሓላፍነት</th>
                            <th class="text-center">ዝጀመረሉ/ትሉ ዕለት</th>
                            <th class="text-center">ዝወድአሉ/ትሉ ዕለት</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = false; ?>
                        @foreach ($expriences as $exprience)
                        <tr>
                            <td>{{ $exprience->position }}</td>                               
                            <td>{{ $exprience->exprienceType }}</td>
                            <td>{{ $exprience->institute }}</td>
                            <td>{{ $exprience->position }}</td>
                            <td>{{ App\DateConvert::toEthiopian(date('d/m/Y',strtotime($exprience->startDate))) }}</td>
                            <td>{{ $exprience->endDate ? App\DateConvert::toEthiopian(date('d/m/Y',strtotime($exprience->endDate))) : '' }}</td>
                            <?php $startCarbon = \Carbon\Carbon::createFromTimeStamp(strtotime($exprience->startDate))?>
                            <td>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($exprience->endDate))->diff($startCarbon)->format('%y ዓመት፣ %m ወርሒን %d መዓልቲ')}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts-extra')
    <script type="text/javascript" src="js/jquery.calendars.js"></script> 
    <script type="text/javascript" src="js/jquery.calendars.plus.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/jquery.calendars.picker.css"> 
    <script type="text/javascript" src="js/jquery.plugin.min.js"></script> 
    <script type="text/javascript" src="js/jquery.calendars.picker.js"></script>
    <script type="text/javascript" src="js/jquery.calendars.ethiopian.min.js"></script>

    <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
@endsection