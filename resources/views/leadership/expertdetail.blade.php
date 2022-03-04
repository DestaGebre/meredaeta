
@extends('layouts.app')

@section('htmlheader_title')
ናይ ሲቪል ሰርቫንት {{ $name }}[መለለዪ ቑፅሪ፥ {{ $id }}] ገምጋም {{ $year }} [{{ $period }}]
@endsection

@section('contentheader_title')
ናይ ሲቪል ሰርቫንት {{ $name }}[መለለዪ ቑፅሪ፥ {{ $id }}] ገምጋም {{ $year }} [{{ $period }}]
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
    @media print {
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
        <div class="pull-left">
                <a class="btn switchBtn btn-info" href="{{ url('expert') }}?id={{ str_replace('/', '_', $data->hitsuyID) }}&year={{$data->year}}&period={{$data->half}}"><span class="glyphicon glyphicon-edit"></span>ኣስተኻኽል</a>
                <button class="delete-button btn btn-danger" data-info="">
                <span class="glyphicon glyphicon-trash"></span>ሰርዝ</button></td>
            </div>
            <div class="pull-right">                      
                <a class="btn switchBtn btn-info" href="{{ URL::previous() }}"><span class="glyphicon glyphicon-arrow-up"></span></a>
            </div>
            <!-- Button ይመለሱ -->
            <form id="detail-form">
                <!-- Step 1 -->
            <div class="form-group col-sm-12 col-md-12">                     
                <!-- <label class="control-label col-md-1 col-sm-1" for="hitsuyID">መ.ቑ:</label> -->
                <div class="col-md-3 col-sm-4 col-xs-4">
                    መ.ቑ: <span style="text-decoration: underline;"> {{$id}}</span>
                    <!-- <input type="text" id="hitsuyID" name="hitsuyID" class="form-control" value="{{$id}}" readonly> -->
                </div>
                <!-- <label class="control-label col-md-1 col-sm-1" for="fullName">ሽም:</label> -->
                <div class="col-md-3 col-sm-4 col-xs-4">
                    ሽም: <span style="text-decoration: underline;"> {{$name}}</span>
                    <!-- <input type="text" id="fullName" name="fullName" class="form-control" value="{{$name}}" readonly> -->
                </div>
                <!-- <label class="control-label col-md-1 col-sm-1" for="gender">ፆታ:</label> -->
                <div class="col-md-3 col-sm-4 col-xs-4">
                    ፆታ: <span style="text-decoration: underline;"> {{$member->hitsuy->gender}}</span>
                    <!-- <input type="text" id="gender" name="gender" class="form-control" value="{{$member->hitsuy->gender}}" readonly> -->
                </div>
            </div>
            <div class="form-group col-sm-12 col-md-12"> 
                <!-- <label class="control-label col-md-1 col-sm-1" for="occupation">ሞያ:</label> -->
                <div class="col-md-3 col-sm-4 col-xs-4">
                    ሞያ: <span style="text-decoration: underline;"> {{$member->hitsuy->occupation}}</span>
                    <!-- <input type="text" id="occupation" name="occupation" class="form-control" value="{{$member->hitsuy->occupation}}" readonly> -->
                </div>          
                <!-- <label class="control-label col-md-1 col-sm-1" for="position">ሓላፍነት:</label> -->
                <div class="col-md-3 col-sm-4 col-xs-4">
                    ሓላፍነት: <span style="text-decoration: underline;"> {{$member->hitsuy->position}}</span>
                    <!-- <input type="text" id="position" name="position" class="form-control" value="{{$member->hitsuy->position}}" readonly> -->
                </div>
                <!-- <label class="control-label col-md-1 col-sm-1" for="zone">ኣድራሻ ዞባ:</label> -->
                <div class="col-md-3 col-sm-4 col-xs-4">
                    ኣድራሻ ዞባ: <span style="text-decoration: underline;"> {{$zoneName}}</span>
                    <!-- <input type="text" id="zone" name="zone" class="form-control" value="{{$zoneName}}" readonly> -->
                </div>
                <!-- <label class="control-label col-md-1 col-sm-1" for="woreda">ወረዳ:</label> -->
                <div class="col-md-3 col-sm-4 col-xs-4">
                    ወረዳ: <span style="text-decoration: underline;"> {{$woredaName}}</span>
                    <!-- <input type="text" id="woreda" name="woreda" class="form-control" value="{{$woredaName}}" readonly> -->
                </div>
            </div> 
            <div class="form-group col-sm-12 col-md-12">
                <!-- <label class="control-label col-md-1 col-sm-1" for="office">ቤ/ፅሕፈት:</label> -->
                <div class="col-md-3 col-sm-4 col-xs-4">
                    ቤ/ፅሕፈት: <span style="text-decoration: underline;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    <!-- <input type="text" id="office" name="office" class="form-control" readonly> -->
                </div>
                <!-- <label class="control-label col-md-1 col-sm-1" for="membershipDate">ናይ ኣባልነት ዘመን:</label> -->
                <div class="col-md-3 col-sm-4 col-xs-4">
                    ናይ ኣባልነት ዘመን: <span style="text-decoration: underline;">{{ App\DateConvert::toEthiopian(date('d/m/Y',strtotime($member->membershipDate))) }}</span>
                    <!-- <input type="text" id="membershipDate" name="membershipDate" class="form-control" value="{{ \App\DateConvert::toEthiopian(date('d/m/Y',strtotime($member->membershipDate))) }}" readonly> -->
                </div>
            </div>          
            <div class="form-group col-sm-12 col-md-12"> 
                        <label class="control-label" for="answer1">1 ካብ ኣተሓሳስባን ተግባርን ክራይ ኣካብነት ንባዕልኻ ነፃ ኣብ ምኻንን ኣብ ካልኦት ንዝረኣዩ ፀገማት ብትረት ኣብ ምቅላስን ፤ </label>
                        <div class="col-sm-12 col-md-12">
                            <p> {{ $data->answer1}} </p>
                        </div><br/>
                        <label class="col-sm-12 col-md-12 control-label" for="result1"></label>
                        <div class="col-sm-2 col-md-2">
                            <input class="form-control" id="result1" value="{{$data->result1}}" type="number" min="0" max="10" placeholder="ዝረኸቦ ውፅኢት ካብ 10" name="Result1"  required="required" readonly>
                        </div>
                    </div>

                    <div class="form-group col-sm-12 col-md-12"> 
                        <label class="control-label" for="answer2">2 ብቁዕ በዓል ሞያ ሰራሕተኛ ኣብ ምኻንን ውፅኢታዊ ስራሕ ኣብ ምስራሕን ፤ ካብቲ ዝርከብ ለውጢ ፍትሓዊ ብዝኾነ ኣብ ምጥቃምን ፤</label>
                        <div class="col-sm-12 col-md-12">
                            <p> {{ $data->answer2}} </p>
                        </div><br/>
                        <label class="col-sm-12 col-md-12 control-label" for="result2"></label>
                        <div class="col-sm-2 col-md-2">
                            <input class="form-control" id="result2" value="{{$data->result2}}" type="number" min="0" max="10" placeholder="ዝረኸቦ ውፅኢት ካብ 10" name="Result2"  required="required" readonly>
                        </div>
                    </div>

                    <div class="form-group col-sm-12 col-md-12">
                                        
                        <label class="control-label" for="answer3">3 ኣብ ዝተዋፈረሉ ዓውደ ስራሕ ጉብእኻ ኣብ ምፍፃምን መርኣያ ኮይንካ ኣብ ምስራሕን ምምራሕን ፤</label>
                        <div class="col-sm-12 col-md-12">
                            <p> {{ $data->answer3}} </p>
                        </div><br/>
                        <label class="col-sm-12 col-md-12 control-label" for="result3"></label>
                        <div class="col-sm-2 col-md-2">
                            <input class="form-control" id="result3" value="{{$data->result3}}" type="number" min="0" max="10" placeholder="ዝረኸቦ ውፅኢት ካብ 10" name="Result3"  required="required" readonly>
                        </div>
                    </div>

                    <div class="form-group col-sm-12 col-md-12">                     
                        <label class="col-sm-12 col-md-12 control-label" for="answer4">4 ሰናይ ምምሕዳር ኣብ ምርጋፅን ቁልጡፍን ፅሬትን ዘለዎ ግልጋሎት ኣብ ምሃብን ዘለዎ ኩነታት ፤</label>
                        <div class="col-sm-12 col-md-12">
                            <p> {{ $data->answer4}} </p>
                        </div><br/>
                        <label class="col-sm-12 col-md-12 control-label" for="result4"></label>
                        <div class="col-sm-2 col-md-2">
                            <input class="form-control" id="result4" value="{{$data->result4}}" type="number" min="0" max="10" placeholder="ዝረኸቦ ውፅኢት ካብ 10" name="Result4"  required="required" readonly>
                        </div>
                    </div>
        <!-- Step 2 -->
         <div class="form-group col-sm-12 col-md-12">                     
                        <label class="col-sm-12 col-md-12 control-label" for="answer5">5 ንልምዓትን ህንፀት ዲሞክራሲን ዘዐንቁፉ ድሑራት ኣተሓሳስባ ፊት ንፊት ብፅንዓት ኣብ ምቅላስን ፤</label>
                        <div class="col-sm-12 col-md-12">
                            <p> {{ $data->answer5}} </p>
                        </div><br/>
                        <label class="col-sm-12 col-md-12 control-label" for="result5"></label>
                        <div class="col-sm-2 col-md-2">
                            <input class="form-control" id="result5" value="{{$data->result5}}" type="number" min="0" max="10" placeholder="ዝረኸቦ ውፅኢት ካብ 10" name="Result5"  required="required" readonly>
                        </div>
                    </div>               
                   <div class="form-group col-sm-12 col-md-12">                     
                        <label class="control-label" for="answer6">6 ኣብ ዝተዋፈረሉ ቤት ፅሕፈት ወይ ቀበሌ ቅልጡፍን ኩለ መዳያዊ ለውጢ ንምምፃእ ዝመፁ ሓደሽቲ ቴክኖሎጂ ወይ እታወት ንባዕልኻ ኣብ ምእማንን ንኻልኦት ንምእማን ዘለዎ ዓቅምን ድልውነትን ፤</label>
                        <div class="col-sm-12 col-md-12">
                            <p> {{ $data->answer6}} </p>
                        </div><br/>
                        <label class="col-sm-12 col-md-12 control-label" for="result6"></label>
                        <div class="col-sm-2 col-md-2">
                            <input class="form-control" id="result6" value="{{$data->result6}}" type="number" min="0" max="10" placeholder="ዝረኸቦ ውፅኢት ካብ 10" name="Result6"  required="required" readonly>
                        </div>
                    </div>
                    <div class="form-group col-sm-12 col-md-12"> 
                        <label class="control-label" for="answer7">7 ሕግታትን ደንብታትን ውድብን መንግስትን ኣብ ምኽባርን ምትግባርን ዘለዎ ኩነታት ፤</label>
                        <div class="col-sm-12 col-md-12">
                            <p> {{ $data->answer7}} </p>
                        </div><br/>
                        <label class="col-sm-12 col-md-12 control-label" for="result7"></label>
                        <div class="col-sm-2 col-md-2">
                            <input class="form-control" id="result7" value="{{$data->result7}}" type="number" min="0" max="10" placeholder="ዝረኸቦ ውፅኢት ካብ 10" name="Result7"  required="required" readonly>
                        </div>
                    </div>
                    
                    <div class="form-group col-sm-12 col-md-12">                     
                        <label class="control-label" for="answer8">8 ብሕገ ደንቢ ውድብ ሓደሽቲ ኣባላት ብፅሬት ኣብ ምምልማልን ልኡኽ እናሃብካ ብቀፃልነት ኣብ ምህናፅን ፤</label>
                        <div class="col-sm-12 col-md-12">
                            <p> {{ $data->answer8}} </p>
                        </div><br/>
                        <label class="col-sm-12 col-md-12 control-label" for="result8"></label>
                        <div class="col-sm-2 col-md-2">
                            <input class="form-control" id="result8" value="{{$data->result8}}" type="number" min="0" max="10" placeholder="ዝረኸቦ ውፅኢት ካብ 10" name="Result8"  required="required" readonly>
                        </div>
                    </div> 

        
        <!-- Step 3 -->                   

                <div class="form-group col-sm-12 col-md-12">                     
                        <label class="control-label" for="answer9">9. መለለይ ጠንካራ ጎኒ</label>
                        <div class="col-sm-12 col-md-12">
                            <p> {{ $data->answer9}} </p>
                        </div>                        
                    </div>

                    <div class="form-group col-sm-12 col-md-12">                     
                        <label class="control-label" for="answer10">10. መለለይ ደካማ ጎኒ</label>
                        <div class="col-sm-12 col-md-12">
                            <p> {{ $data->answer10}} </p>
                        </div>                        
                    </div>

        <div class="form-group col-sm-12 col-md-12">                     
            <label class="control-label" >11. ድምር ዝረኸቦ ማርኪ: (<span id="totalResult">{{ $data->sum }}</span>/100)</label><br/>
            <label class="control-label" >&nbsp &nbsp ድምር ሚዛን/ስርርዕ: <span id="totalWeight"></span></label>
        </div>

        <div class="form-group col-sm-12 col-md-12">                     
            <label class="control-label" for="remark">13. ናይ በዓል ዋና ሪኢቶን</label>
            <div class="col-sm-12 col-md-12">
                <p> {{ $data->remark }} </p>
            </div>  
            <label class="col-sm-2 col-md-12 control-label">ፌርማ:______________________</label>                                 
        </div>
         <div class="form-group col-sm-12 col-md-12">                     
            <label class="control-label" >14. ነዚ ማህደር ዘረጋገፀ ውዳበ ሓላፊ:_______________________________________ ፌርማ:____________________ ዕለት:________________</label><br/>            
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
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '.delete-button', function() {
        if(confirm('ገምጋም '+"{{ $data->hitsuyID }}"+ ' ዓመት '+"{{$data->year}}"+' ንምስራዝ ርግፀኛ ድዮም?')){
            $.ajax({
            type: 'post',
            url: 'deleteexpert',
            data: {
                '_token': $('input[name=_token]').val(),  
                'id': "{{$data->id}}",      
                'hitsuyID': "{{$data->hitsuyID}}",
                'year': "{{$data->year}}",
            },
      
            success: function(data) {
                if(data[0] === true){
                  toastr.clear();
                  toastr.warning('ገምጋም '+"{{ $data->hitsuyID }}"+ ' ዓመት '+"{{$data->year}}"+' ተሰሪዙ ኣሎ');
                  setTimeout(function(){
                    window.location.replace('{{url("expertslist")}}');
                  }, 3000);
                }
                else{
                   toastr.error('ገምጋም '+"{{ $data->hitsuyID }}"+ ' ዓመት '+"{{$data->year}}"+' ኣይተረኽበን');
                }
               },

            error: function(xhr,errorType,exception){
                
                  alert(exception);
                        
            }
        });
        }
                
    });
    });
</script>
@endsection
